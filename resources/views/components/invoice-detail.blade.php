<div class="card p-4" id="invoiceCard">

    {{-- Shop Header --}}
    <div class="text-center mb-4">
        <h5 class="fw-bold mb-0">CMy Phone Shop</h5>
        <p class="mb-0">មានតំលៃស័ក្តិ iPhone មកពីអាមេរិក</p>
    </div>

    {{-- Shop Info & Invoice Meta --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <p class="mb-1"><i class='bx bx-phone'></i> 011 699 952</p>
            <p class="mb-1"><i class='bx bx-map'></i> #44 មហាវិថែម្នូស៊ីអ៊ូ សង្កាតស្រះចក ខណ្ឌដូនពេញ រាជធានីភ្នំពេញ</p>
        </div>
        <div class="col-md-6 text-md-end">
            <p class="mb-1"><strong>Invoice:</strong> #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
            <p class="mb-1"><strong>Issued Date:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</p>
            <p class="mb-1"><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</p>
        </div>
    </div>

    <hr>

    {{-- Customer Info --}}
    <div class="mb-4">
        <p class="mb-1 text-muted">Customer:</p>
        <p class="mb-0 fw-semibold">{{ $order->customer->name ?? 'Walk in Customer' }}</p>
        <p class="mb-0 text-muted">{{ $order->customer->phone ?? '000000000' }}</p>
    </div>

    {{-- Invoice Title --}}
    <div class="text-center mb-3">
        <h5 class="fw-bold">INVOICE</h5>
    </div>

    {{-- Items Table --}}
    <div class="table-responsive mb-3">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>ITEMS</th>
                    <th>DESCRIPTION</th>
                    <th class="text-end">COST</th>
                    <th class="text-center">QTY</th>
                    <th class="text-end">PRICE</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order_detals as $detail)
                <tr>
                    <td>
                        {{ $detail->product->product_name ?? '-' }}
                        @if($detail->product->product_imei ?? false)
                            <br><small class="text-muted">[ IMEI: {{ $detail->product->product_imei }} ]</small>
                        @endif
                    </td>
                    <td>
                        {{ $detail->product->product_name ?? '-' }}
                        {{ $detail->product->storage->name ?? '' }}
                        @if($detail->product->color->name ?? false)
                            , {{ $detail->product->color->name }}
                        @endif
                    </td>
                    <td class="text-end">${{ number_format($detail->unit_price ?? $detail->price, 2) }}</td>
                    <td class="text-center">{{ $detail->qty ?? $detail->quantity ?? 1 }}</td>
                    <td class="text-end">${{ number_format($detail->total ?? $detail->price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <span class="text-muted">The Seller</span>
                    </td>
                    <td colspan="2" class="text-end fw-bold">Total:</td>
                    <td class="text-end fw-bold text-success">
                        ${{ number_format($order->grand_total ?? $order->total_amount, 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>a
    </div>

    {{-- Note --}}
    @if($order->note)
    <div class="mt-2">
        <p class="text-muted mb-0"><strong>Note:</strong> {{ $order->note }}</p>
    </div>
    @endif

</div>