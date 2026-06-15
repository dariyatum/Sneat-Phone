@extends('layouts.app')
@push('styles')
@endpush

@section('content')

<div class="content-wrapper">
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="pi-card">
            <div class="pi-body">

                <h4 class="pi-heading">Product Information</h4>

                {{-- Product Image --}}
                <div style="margin-bottom:24px;">
                    <img 
                        src="{{ asset('images/product/' . $product->image) }}"
                        alt="Product Image"
                        style="width:90px;height:90px;object-fit:cover;border-radius:10px;border:1px solid #e9ecef;box-shadow:0 2px 10px rgba(0,0,0,.08);display:block;"
                        onerror="this.src='{{ asset('/assets/img/blank-product.svg') }}'"
                    >
                </div>

                {{-- Info Grid --}}
                <div class="pi-grid">

                    {{-- LEFT COLUMN --}}
                    <div class="pi-col">

                        <div class="pi-row">
                            <span class="pi-label">PRODUCT NAME :</span>
                            <span class="pi-value">{{ $product->product_name }}</span>
                        </div>
                        <div class="pi-row">
                            <span class="pi-label">PRODUCT CODE :</span>
                            <span class="pi-value">{{ $product->product_code }}</span>
                        </div>
                        <div class="pi-row">
                            <span class="pi-label">BRAND :</span>
                            <span class="pi-value">{{ $product->brand->name ?? '' }}</span>
                        </div>
                        <div class="pi-row">
                            <span class="pi-label">COLOR :</span>
                            <span class="pi-value">{{ $product->color->name ?? '' }}</span>
                        </div>
                        <div class="pi-row">
                            <span class="pi-label">STORAGE :</span>
                            <span class="pi-value">{{ $product->storage->name ?? '' }}</span>
                        </div>
                        <div class="pi-row">
                            <span class="pi-label">BATTERY PERCENTAGE :</span>
                            <span class="pi-value">{{ $product->battery_percentage }}</span>
                        </div>
                        <div class="pi-row">
                            <span class="pi-label">PURCHASE DATE :</span>
                            <span class="pi-value">{{ $product->purchase_date }}</span>
                        </div>
                        <div class="pi-row">
                            <span class="pi-label">SELLING PRICE :</span>
                            <span class="pi-value">${{ $product->selling_price }}</span>
                        </div>
                        <div class="pi-row">
                            <span class="pi-label">PRODUCT NOTE :</span>
                            <span class="pi-value">{{ $product->note }}</span>
                        </div>

                    </div>

                    {{-- RIGHT COLUMN --}}
                    <div class="pi-col">

                        <div class="pi-row">
                            <span class="pi-label">PRODUCT IMEI :</span>
                            <span class="pi-value">{{ $product->product_imei }}</span>
                        </div>
                        <div class="pi-row">
                            <span class="pi-label">CONDITION :</span>
                            <span class="pi-value">
                                @if($product->condition == 1)
                                    <span class="badge bg-primary">Used</span>
                                @elseif($product->condition == 2)
                                    <span class="badge bg-secondary">New</span>
                                @elseif($product->condition == 3)
                                    <span class="badge bg-success">Refurbished</span>
                                @else
                                    <span class="badge bg-dark">Unknown</span>
                                @endif
                            </span>
                        </div>
                        <div class="pi-row">
                            <span class="pi-label">SERIES :</span>
                            <span class="pi-value">{{ $product->series->name ?? '' }}</span>
                        </div>
                        <div class="pi-row">
                            <span class="pi-label">MODEL :</span>
                            <span class="pi-value">{{ $product->modelType->name ?? '' }}</span>
                        </div>
                        <div class="pi-row">
                            <span class="pi-label">TYPE OF MACHINE :</span>
                            <span class="pi-value">
                                @if($product->type_of_machine == 1)
                                    <span class="badge bg-info">iCloud</span>
                                @elseif($product->type_of_machine == 2)
                                    <span class="badge bg-warning">Unlock</span>
                                @elseif($product->type_of_machine == 3)
                                    <span class="badge bg-dark">Original</span>
                                @else
                                    <span class="badge bg-secondary">Unknown</span>
                                @endif
                            </span>
                        </div>
                        <div class="pi-row">
                            <span class="pi-label">PRODUCT PERCENTAGE :</span>
                            <span class="pi-value">{{ $product->percentage }}</span>
                        </div>
                        <div class="pi-row">
                            <span class="pi-label">PURCHASE PRICE :</span>
                            <span class="pi-value">${{ $product->purchase_price }}</span>
                        </div>
                        <div class="pi-row">
                            <span class="pi-label">PRODUCT STATUS :</span>
                            <span class="pi-value">
                                @if($product->status == 1)
                                    <span class="badge bg-success px-3 py-2 rounded-pill">Available</span>
                                @elseif($product->status == 2)
                                    <span class="badge bg-danger px-3 py-2 rounded-pill">Sold</span>
                                @elseif($product->status == 3)
                                    <span class="badge bg-warning px-3 py-2 rounded-pill">Pending</span>
                                @else
                                    <span class="badge bg-dark px-3 py-2 rounded-pill">Unknown</span>
                                @endif
                            </span>
                        </div>

                    </div>
                </div>

                {{-- Buttons --}}
                <div style="display:flex;gap:10px;margin-top:28px;">
                    <a href="{{ route('products.index', withLang()) }}"
                    style="display:inline-block;padding:8px 24px;border-radius:8px;font-size:14px;font-weight:600;text-decoration:none;background:#fff;border:1px solid #d6dbe3;color:#6c7a92;">
                        Product Lists
                    </a>
                    <a href="{{ route('products.edit', withLang(['product' => $product->id])) }}"
                    style="display:inline-block;padding:8px 24px;border-radius:8px;font-size:14px;font-weight:600;text-decoration:none;background:#7367f0;border:1px solid #7367f0;color:#fff;">
                        Edit
                    </a>
                </div>

            </div>
        </div>

@endsection
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
.pi-body {
    padding: 30px 35px;

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


