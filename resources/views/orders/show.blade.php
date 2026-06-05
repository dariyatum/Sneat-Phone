@extends('layouts.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">

    {{-- Action Buttons --}}
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <a href="{{ route('orders.index', withLang()) }}" class="btn btn-outline-secondary">
                <i class='bx bx-arrow-back'></i> Back to Orders
            </a>
            <button class="btn btn-primary" onclick="window.print()">
                <i class='bx bx-printer'></i> Print
            </button>
        </div>
    </div>

    {{-- Invoice Detail Component --}}
    @include('components.invoice-detail')

</div>
@endsection

@push('styles')
<style>
    @media print {
        body * { visibility: hidden; }
        #invoiceCard, #invoiceCard * { visibility: visible; }
        #invoiceCard { position: absolute; left: 0; top: 0; width: 100%; }
        .btn { display: none !important; }
    }
</style>
@endpush