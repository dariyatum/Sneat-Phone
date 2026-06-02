<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:order-list|order-create|order-edit|order-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:order-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:order-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:order-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of sales.
     */
    public function index(Request $request)
    {
        $query = Order::with('customer');
        $customers = Customer::pluck('name', 'id');
        $parameterNames = [];

        if ($request->search) {

            if ($request->customer) {
                $query->where('customer_id', $request->customer);
                $parameterNames['customer'] = $request->customer;
            }

            if ($request->from_date && $request->to_date) {
                $query->whereBetween('order_date', [
                    $request->from_date,
                    $request->to_date
                ]);

                $parameterNames['from_date'] = $request->from_date;
                $parameterNames['to_date'] = $request->to_date;
            }
        }

        $orders = $query->orderBy('order_date', 'desc')->paginate(20);

        session(['printInvoiceId' => null]);

        return view('orders.index', compact(
            'orders',
            'customers',
            'parameterNames'
        ));
    }

    /**
     * Show create sale form.
     */
    public function create()
    {
        $products = Product::with(['color', 'storage'])
            ->whereIn('status', [
                Product::STATUS_ID_AVAILABLE,
                0
            ])
            ->get();

        $customers = Customer::all();

        return view('sale.create', compact(
            'products',
            'customers'
        ));
    }

    /**
     * Store sale.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sale_date' => 'required|date',
            'payment_method' => 'required',
            'grand_total' => 'required|numeric',
            'cart' => 'required|array|min:1',
            'cart.*.product_id' => 'required|exists:products,id',
            'cart.*.price' => 'required|numeric',
        ]);

        // Calculate subtotal
        $subtotal = 0;

        foreach ($request->cart as $item) {
            $subtotal += $item['price'];
        }

        // Create order
        $order = Order::create([
            'customer_id' => $request->customer_id,
            'employee_id' => Auth::id(),
            'order_date' => $request->sale_date,
            'subtotal' => $subtotal,
            'discount' => $request->discount ?? 0,
            'grand_total' => $request->grand_total,
            'total_amount' => $request->grand_total,
            'payment_method' => $request->payment_method,
            'note' => $request->note,
        ]);

        // Save order details + update product status
        foreach ($request->cart as $item) {

            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'unit_price' => $item['price'],
                'price' => $item['price'],
                'qty' => 1,
                'quantity' => 1,
                'total' => $item['price'],
                'sub_total' => $item['price'],
            ]);

            Product::where('id', $item['product_id'])
                ->update([
                    'status' => Product::STATUS_ID_SOLD
                ]);
        }

        return redirect()
            ->route('sales.index', app()->getLocale())
            ->with('success', 'Sale completed successfully.');
    }

    /**
     * Show sale detail.
     */
    public function show(string $lang, Order $order)
    {
        $order = Order::with(
            'orderDetails',
            'customer',
            'employee'
        )->findOrFail($order->id);

        $order_detals = OrderDetail::where(
            'order_id',
            $order->id
        )->with('product')->get();

        return view('sale.show', compact(
            'order',
            'order_detals'
        ));
    }

    /**
     * Check products availability.
     */
    public function checkProductOrder(Request $request)
    {
        foreach ($request->productIds as $productId) {

            $product = Product::available()->find($productId);

            if (!$product) {
                return response()->json([
                    'message' => 'Product not found.'
                ], 404);
            }
        }

        return response()->json([
            'message' => 'Submitting Order'
        ], 201);
    }

    /**
     * Delete sale.
     */
    public function destroy(string $lang, Order $order)
    {
        $orderDetails = OrderDetail::where(
            'order_id',
            $order->id
        )->get();

        foreach ($orderDetails as $detail) {

            Product::where(
                'id',
                $detail->product_id
            )->update([
                'status' => Product::STATUS_ID_AVAILABLE
            ]);

            $detail->delete();
        }

        $order->delete();

        return redirect()
            ->route('sale.index', app()->getLocale())
            ->with('success', 'Sale deleted successfully');
    }

    /**
     * Invoice page.
     */
    public function invoice(string $lang, Order $order)
    {
        $order = Order::with(
            'orderDetails',
            'customer',
            'employee'
        )->findOrFail($order->id);

        $order_detals = OrderDetail::where(
            'order_id',
            $order->id
        )->with('product')->get();

        return view('sale.invoice', compact(
            'order',
            'order_detals'
        ));
    }

    /**
     * Invoice PDF.
     */
    public function invoicePdf(
        Request $request,
        string $lang,
        Order $order
    ) {
        $currentDate = Carbon::now()->format('Y-m-d');

        $order = Order::with(
            'orderDetails',
            'customer',
            'employee'
        )->findOrFail($order->id);

        $order_detals = OrderDetail::where(
            'order_id',
            $order->id
        )->with('product')->get();

        $file_pdf = 'invoice-' .
            str_pad($order->id, 5, '0', STR_PAD_LEFT)
            . '.pdf';

        $type = $request->type ?? 'download';

    return view('sale.invoice-pdf', compact(
            'order',
            'order_detals',
            'currentDate',
            'file_pdf',
            'type'
        ));
    }
}