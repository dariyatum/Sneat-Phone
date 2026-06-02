<?php

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
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{

// public function create()
// {
//     return view('orders.create');
// }


// public function create()
// {
//     $products = Product::all();
//     return view('orders.create', compact('products'));
// }





public function create()
{
    $products = Product::all();

    $cartItems = Cart::with('product')->where('user_id', auth()->id()) ->get();

    return view('orders.create', compact(
        'products',
        'cartItems'
    ));
}

public function store(Request $request)
{
    // all submit order logic here
}

  function __construct()
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
    
    $parameterNames = [];
    if ($request->search) {
        $filters = $request->only(['customer', 'from_date', 'to_date']);

        if (!empty($filters['customer'])) {
            $query->where('customer_id', $filters['customer']);
            $parameterNames['customer'] = $filters['customer'];
        }

        if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
            // Both from_date and to_date are provided
            $query->whereBetween('order_date', [$filters['from_date'], $filters['to_date']]);
            $parameterNames['from_date'] = $filters['from_date'];
            $parameterNames['to_date'] = $filters['to_date'];
        } elseif (!empty($filters['from_date'])) {
            // Only from_date is provided
            $query->where('order_date', '>=', $filters['from_date']);
            $parameterNames['from_date'] = $filters['from_date'];
        } elseif (!empty($filters['to_date'])) {
            // Only to_date is provided
            $query->where('order_date', '<=', $filters['to_date']);
            $parameterNames['to_date'] = $filters['to_date'];
        }
    }
  }

    /**
     * Display a listing of the resource.
     */


    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show(string $lang, Order $order)
    {
        $order = $order->with('orderDetails', 'customer', 'employee')->findOrfail($order->id);
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
        return response()->json(['message' => 'Submiting Order'], 201);
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
        $order = $order->with('orderDetails', 'customer', 'employee')->findOrfail($order->id);
        $order_detals = OrderDetail::where('order_id', $order->id)->with('product')->get();
        return view('orders.invoice', compact('order', 'order_detals'));
    }

    /**
     * Generate PDF invoice.
     */
    public function invoicePdf(Request $request, string $lang, Order $order)
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        $order = $order->with('orderDetails', 'customer', 'employee')->findOrfail($order->id);
        $order_detals = OrderDetail::where('order_id', $order->id)->with('product')->get();
        $file_pdf = 'invoice-' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . '.pdf';
        $type = $request->type ?? 'download';
        return view('orders.invoice-pdf', compact('order', 'order_detals', 'currentDate', 'file_pdf', 'type'));
    }

    
}