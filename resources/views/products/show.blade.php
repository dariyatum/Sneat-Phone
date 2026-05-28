<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">

        <h4 class="fw-bold text-secondary mb-4">Product Information</h4>

        <div class="row g-5 align-items-start">

            {{-- LEFT SIDE --}}
            <div class="col-md-6">

                {{-- Product Image --}}
                <div class="mb-4">
                    <img 
                        src="{{ asset('images/product/' . $product->image) }}"
                        alt="Product Image"
                        class="rounded-3 border"
                        style="width: 90px; height: 90px; object-fit: cover;"
                        onerror="this.src='{{ asset('/assets/img/blank-product.svg') }}'"
                    >
                </div>

                <div class="product-info">

                    <p><span>PRODUCT NAME :</span> {{ $product->product_name }}</p>

                    <p><span>PRODUCT CODE :</span> {{ $product->product_code }}</p>

                    <p><span>BRAND :</span> {{ $product->brand->name ?? '' }}</p>

                    <p><span>COLOR :</span> {{ $product->color->name ?? '' }}</p>

                    <p><span>STORAGE :</span> {{ $product->storage->name ?? '' }}</p>

                    <p><span>BATTERY PERCENTAGE :</span> {{ $product->battery_percentage }}</p>

                    <p><span>PURCHASE DATE :</span> {{ $product->purchase_date }}</p>

                    <p><span>SELLING PRICE :</span> ${{ $product->selling_price }}</p>

                    <p><span>PRODUCT NOTE :</span> {{ $product->note }}</p>

                </div>
            </div>

            {{-- RIGHT SIDE --}}
            <div class="col-md-6">

                <div class="product-info mt-md-5">

                    <p><span>PRODUCT IMEI :</span> {{ $product->product_imei }}</p>
                    @if($product->condition == 1)
                    <p><span>CONDITION :</span> Used</p>
                    @elseif($product->condition == 2)
                    <p><span>CONDITION :</span> New</p>
                    @endif
                    <p><span>SERIES :</span> {{ $product->series->name ?? '' }}</p>

                    <p><span>MODEL :</span> {{ $product->modelType->name ?? '' }}</p>
                    @if($product->modelType->name == 1)
                    <p><span>TYPE OF MACHINE :</span>iCloud</p>
                    @elseif($product->modelType-> == 2)
                    <p><span>TYPE OF MACHINE :</span>Unlock</p>
                    @elseif($product->modelType-> == 3)
                    <p><span>TYPE OF MACHINE :</span>Original</p>



                    <p><span>PRODUCT PERCENTAGE :</span> {{ $product->percentage }}</p>

                    <p><span>PURCHASE PRICE :</span> ${{ $product->purchase_price }}</p>

                    <p>
                        <span>PRODUCT STATUS :</span>
                        <span class="badge bg-success px-3 py-2 rounded-pill">
                            {{ $product->status }}
                        </span>
                    </p>

                </div>
            </div>

        </div>

        {{-- Buttons --}}
        <div class="mt-4 d-flex gap-2">

            <a href="{{ route('products.index', withLang()) }}"
               class="btn btn-light border px-4 rounded-3">
                Product Lists
            </a>

            <a href="{{ route('products.edit', withLang(['product' => $product->id])) }}"
               class="btn btn-primary px-4 rounded-3 shadow-sm">
                Edit
            </a>

        </div>

    </div>
</div>

<style>
    .product-info p {
        margin-bottom: 18px;
        font-size: 14px;
        color: #6c757d;
        font-weight: 500;
    }

    .product-info p span {
        font-weight: 700;
        color: #5a6474;
        margin-right: 5px;
    }

    .btn-primary {
        background: #6c63ff;
        border: none;
    }

    .btn-primary:hover {
        background: #5a52e0;
    }
</style>