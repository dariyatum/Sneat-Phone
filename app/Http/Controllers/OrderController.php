<?php
// MAO SREYPOV

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Series;
use App\Models\Color;
use App\Models\ModelType;
use App\Models\Storage;
use App\Models\Customer;
use App\Models\Cart;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Constructor enforcing middleware roles and permissions.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:order-list|order-create|order-edit|order-delete', ['only' => ['index','store']]);
        $this->middleware('permission:order-create', ['only' => ['create','store']]);
        $this->middleware('permission:order-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:order-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::query();
        $parameterNames = [];
        
        if ($request->search) {
            $filters = $request->only(['customer', 'from_date', 'to_date']);

            if (!empty($filters['customer'])) {
                $query->where('customer_id', $filters['customer']);
                $parameterNames['customer'] = $filters['customer'];
            }

            if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
                $query->whereBetween('order_date', [$filters['from_date'], $filters['to_date']]);
                $parameterNames['from_date'] = $filters['from_date'];
                $parameterNames['to_date'] = $filters['to_date'];
            } elseif (!empty($filters['from_date'])) {
                $query->where('order_date', '>=', $filters['from_date']);
                $parameterNames['from_date'] = $filters['from_date'];
            } elseif (!empty($filters['to_date'])) {
                $query->where('order_date', '<=', $filters['to_date']);
                $parameterNames['to_date'] = $filters['to_date'];
            }
        }

        // Fetch paginated results for index if needed, otherwise returns query state
        $orders = $query->latest()->paginate(10);
        return view('orders.index', compact('orders', 'parameterNames'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 1. Fetch products and customers from the database to populate the UI view dropdowns and grids
       $products = Product::where(
            'status',
            Product::STATUS_ID_AVAILABLE
        )->get();
                $customers = Customer::all();
                $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
                return view('orders.create', compact(
                    'products',
                    'customers',
                    'cartItems'
         ));
    }

    //  Store a new created resource in storage
    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'customer_id' => 'required',
            'items'       => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($request) {
            
            // Calculate order total
            $totalAmount = 0;
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $totalAmount += ($product->selling_price * $item['quantity']);
            }

            // Create main order record
            $order = Order::create([
                'customer_id'    => $request->customer_id,
                'employee_id'    => auth()->id() ?? 1, 
                'status'         => Order::STATUS_ACTIVE,
                'total_amount'   => $totalAmount,
                'payment_status' => Order::PAYMENT_STATUS_PAID,
                'payment_type'   => Order::PAYMENT_TYPE_CASH,
                'order_date'     => now(),
                'note'           => $request->note ?? 'Counter POS Terminal Sale',
            ]);

            // Create order items details records
            foreach ($request->items as $item) {

            $product = Product::findOrFail($item['product_id']);

            OrderDetail::create([
                'order_id'   => $order->id,
                'product_id' => $product->id,
                'unit_price' => $product->selling_price,
                'updated_at' => now(),
                'created_at' => now(),
            ]);

            // Mark phone as sold
            $product->status = Product::STATUS_ID_SOLD;
            $product->save();
            }

            // Return success response with redirect path
            return response()->json([
                'status'       => 'success',
                'message'      => 'Order created successfully!',
                'order_id'     => $order->id,
                'redirect_url' => route('sales.index', app()->getLocale())
            ], 200);
        });
    }


    //   Display the specified resource.   
    public function show(string $lang, Order $order)
    {
        $order = $order->with('orderDetails', 'customer', 'employee')->findOrFail($order->id);
        $order_detals = OrderDetail::where('order_id', $order->id)->with('product')->get();
        return view('orders.show', compact('order', 'order_detals'));
    }

    /**
     * Check if products are still available before submitting order.
     */
    public function checkProductOrder(Request $request)
    {
        foreach ($request->productIds as $key => $productId) {
            $product = Product::available()->find($productId);
            if (!$product) {
                return response()->json(['message' => 'Product not found.'], 404);
            }
        }
        return response()->json(['message' => 'Submitting Order'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $lang, Order $order)
    {
        // FIX: Restore product status back to available (1) before deleting
        $orderDetails = OrderDetail::where('order_id', $order->id)->get();
        foreach ($orderDetails as $detail) {
            Product::where('id', $detail->product_id)->update(['status' => Product::STATUS_ID_AVAILABLE]);
            $detail->delete();
        }
        // FIX: Actually delete the order
        $order->delete();
        return redirect()->route('sales.index', app()->getLocale())->with('success', 'Sale deleted successfully');
    }

    /**
     * Display invoice view.
     */
    public function invoice(string $lang, Order $order)
    {
        $order = $order->with('orderDetails', 'customer', 'employee')->findOrFail($order->id);
        $order_detals = OrderDetail::where('order_id', $order->id)->with('product')->get();
        return view('orders.invoice', compact('order', 'order_detals'));
    }

    /**
     * Generate PDF invoice.
     */
    public function invoicePdf(Request $request, string $lang, Order $order)
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        $order = $order->with('orderDetails', 'customer', 'employee')->findOrFail($order->id);
        $order_detals = OrderDetail::where('order_id', $order->id)->with('product')->get();
        $file_pdf = 'invoice-' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . '.pdf';
        $type = $request->type ?? 'download';
        return view('orders.invoice-pdf', compact('order', 'order_detals', 'currentDate', 'file_pdf', 'type'));
    }
}