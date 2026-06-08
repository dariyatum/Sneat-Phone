@extends('layouts.app')

@section('content')

<div class="pi-card">
    <div class="pi-body">

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
.pi-card {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #e9ecef;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    overflow: hidden;
    width: 100%;
    box-sizing: border-box;
}
.pi-body {
    padding: 30px 35px;
    width: 100%;
    box-sizing: border-box;
}
.pi-heading {
    color: #6c7a92 !important;
    font-size: 22px !important;
    font-weight: 700 !important;
    margin-bottom: 24px !important;
}
.pi-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0 48px;
    width: 100%;
}
.pi-col {
    display: flex;
    flex-direction: column;
    min-width: 0;
}
.pi-row {
    display: flex;
    align-items: baseline;
    gap: 6px;
    margin-bottom: 16px;
}
.pi-label {
    font-size: 12px !important;
    font-weight: 700 !important;
    color: #8b9bb4 !important;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
    flex-shrink: 0;
    line-height: 1.6;
}
.pi-value {
    color: #4f5d75 !important;
    font-weight: 600 !important;
    font-size: 14px !important;
    line-height: 1.6;
}
@media (max-width: 768px) {
    .pi-body { padding: 20px; }
    .pi-grid { grid-template-columns: 1fr; }
}
</style>

@endsection
