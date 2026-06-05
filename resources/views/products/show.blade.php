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

                    <p>
                        <span>PRODUCT NAME :</span>
                        {{ $product->product_name }}
                    </p>

                    <p>
                        <span>PRODUCT CODE :</span>
                        {{ $product->product_code }}
                    </p>

                    <p>
                        <span>BRAND :</span>
                        {{ $product->brand->name ?? '' }}
                    </p>

                    <p>
                        <span>COLOR :</span>
                        {{ $product->color->name ?? '' }}
                    </p>

                    <p>
                        <span>STORAGE :</span>
                        {{ $product->storage->name ?? '' }}
                    </p>

                    <p>
                        <span>BATTERY PERCENTAGE :</span>
                        {{ $product->battery_percentage }}
                    </p>

                    <p>
                        <span>PURCHASE DATE :</span>
                        {{ $product->purchase_date }}
                    </p>

                    <p>
                        <span>SELLING PRICE :</span>
                        ${{ $product->selling_price }}
                    </p>

                    <p>
                        <span>PRODUCT NOTE :</span>
                        {{ $product->note }}
                    </p>

                </div>
            </div>

            {{-- RIGHT SIDE --}}
            <div class="col-md-6">

                <div class="product-info mt-md-5">

                    <p>
                        <span>PRODUCT IMEI :</span>
                        {{ $product->product_imei }}
                    </p>

                    {{-- CONDITION --}}
                    <p>
                        <span>CONDITION :</span>

                        @if($product->condition == 1)
                            <span class="badge bg-primary">Used</span>

                        @elseif($product->condition == 2)
                            <span class="badge bg-secondary">New</span>

                        @elseif($product->condition == 3)
                            <span class="badge bg-success">Refurbished</span>

                        @else
                            <span class="badge bg-dark">Unknown</span>
                        @endif
                    </p>

                    <p>
                        <span>SERIES :</span>
                        {{ $product->series->name ?? '' }}
                    </p>

                    <p>
                        <span>MODEL :</span>
                        {{ $product->modelType->name ?? '' }}
                    </p>

                    {{-- TYPE OF MACHINE --}}
                    <p>
                        <span>TYPE OF MACHINE :</span>

                        @if($product->type_of_machine == 1)
                            <span class="badge bg-info">iCloud</span>

                        @elseif($product->type_of_machine == 2)
                            <span class="badge bg-warning">Unlock</span>

                        @elseif($product->type_of_machine == 3)
                            <span class="badge bg-dark">Original</span>

                        @else
                            <span class="badge bg-secondary">Unknown</span>
                        @endif
                    </p>

                    <p>
                        <span>PRODUCT PERCENTAGE :</span>
                        {{ $product->percentage }}
                    </p>

                    <p>
                        <span>PURCHASE PRICE :</span>
                        ${{ $product->purchase_price }}
                    </p>

                    {{-- STATUS --}}
                    <p>
                        <span>PRODUCT STATUS :</span>

                        @if($product->status == 1)
                            <span class="badge bg-success px-3 py-2 rounded-pill">
                                Available
                            </span>

                        @elseif($product->status == 2)
                            <span class="badge bg-danger px-3 py-2 rounded-pill">
                                Sold
                            </span>

                        @elseif($product->status == 3)
                            <span class="badge bg-warning px-3 py-2 rounded-pill">
                                Pending
                            </span>

                        @else
                            <span class="badge bg-dark px-3 py-2 rounded-pill">
                                Unknown
                            </span>
                        @endif
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
.card{
    border-radius:12px;
    border:1px solid #e9ecef;
}

.card-body{
    padding:30px 35px;
}

h4{
    color:#6c7a92;
    font-size:24px;
    font-weight:700;
    margin-bottom:30px;
}

.product-info p{
    margin-bottom:22px;
    font-size:15px;
    color:#6c7a92;
    font-weight:600;
    line-height:1.6;
}

.product-info p span:first-child{
    font-size:13px;
    font-weight:700;
    color:#8b9bb4;
    text-transform:uppercase;
    letter-spacing:.5px;
}

.product-info p:not(:has(span:first-child)){
    color:#4f5d75;
}

.product-info{
    margin-top:10px;
}

.product-info .badge{
    font-size:13px;
    padding:6px 12px;
    border-radius:20px;
    font-weight:600;
}

img{
    box-shadow:0 2px 10px rgba(0,0,0,.08);
}

.btn-light{
    background:#fff;
    border:1px solid #d6dbe3;
    color:#6c7a92;
    font-weight:600;
    min-width:120px;
}

.btn-light:hover{
    background:#f8f9fa;
}

.btn-primary{
    background:#7367f0;
    border:none;
    font-weight:600;
    min-width:80px;
}

.btn-primary:hover{
    background:#5d50e6;
}

.row.g-5{
    --bs-gutter-x: 6rem;
}

@media (max-width:768px){

    .card-body{
        padding:20px;
    }

    .product-info{
        margin-top:0;
    }

    .row.g-5{
        --bs-gutter-x:1.5rem;
    }
}
</style>