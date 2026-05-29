@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="text-center p-2 bg-light">
                            <img src="{{ asset($product->image ?? 'path/to/placeholder.jpg') }}" 
                                 class="card-img-top img-fluid" 
                                 style="height: 150px; object-fit: contain;">
                        </div>

                        <div class="card-body d-flex flex-column justify-content-between p-3">
                            <div>
                                <h6 class="fw-bold mb-1 text-truncate" title="{{ $product->name }}">
                                    {{ $product->name }} [ IMEI: {{ $product->imei ?? 'XXXX' }} ]
                                </h6>
                                <p class="text-muted small mb-2">
                                    Used, {{ $product->model ?? 'iPhone' }}, {{ $product->storage ?? '128GB' }}, {{ $product->color ?? 'Black' }}, Original
                                </p>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">
                                    ${{ number_format($product->price, 2) }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100 d-flex flex-column justify-content-between">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <small class="text-muted">Order: #00953</small>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bx bx-user"></i> </span>
                        <select class="form-select border-start-0 ps-0">
                            <option selected>តាំងសេង</option>
                        </select>
                    </div>

                    <div style="min-height: 350px;">
                        </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted fw-semibold">Total</span>
                        <h4 class="fw-bold text-dark mb-0"><small class="fs-6 fw-normal text-muted">$</small> 0</h4>
                    </div>

                    <div class="row g-2">
                        <div class="col-4">
                            <button class="btn btn-outline-secondary w-100 py-2 d-flex flex-column align-items-center justify-content-center">
                                <i class="bx bx-receipt fs-4 mb-1"></i>
                                <span style="font-size: 11px;">Bill</span>
                            </button>
                        </div>
                        <div class="col-8">
                            <button class="btn btn-primary w-100 h-100 py-2 d-flex flex-column align-items-center justify-content-center">
                                <i class="bx bx-printer fs-4 mb-1"></i>
                                <span style="font-size: 11px; fw-bold">Submit Order</span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection