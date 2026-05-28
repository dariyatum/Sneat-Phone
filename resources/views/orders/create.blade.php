@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4><i class="fas fa-cash-register me-2"></i> New Sale</h4>
        <a href="{{ route('orders.index', app()->getLocale()) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Sales List
        </a>
    </div>

    <div class="row g-4">

        {{-- LEFT: Product Search & Table --}}
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-box me-2"></i>Available Products</h6>
                </div>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control form-control-lg border-start-0"
                               placeholder="Search by Name, IMEI, Color, Storage...">
                    </div>

                    <div class="table-responsive" style="max-height: 60vh; overflow-y: auto;">
                        <table class="table table-hover align-middle" id="productsTable">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th>Product Name</th>
                                    <th>IMEI</th>
                                    <th>Color</th>
                                    <th>Storage</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products ?? [] as $product)
                                <tr>
                                    <td class="fw-semibold">{{ $product->product_name }}</td>
                                    <td><code>{{ $product->product_imei }}</code></td>
                                    <td>{{ $product->color }}</td>
                                    <td>{{ $product->storage }}</td>
                                    <td class="text-end fw-bold text-success">
                                        ${{ number_format($product->selling_price ?? 0, 2) }}
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-primary add-to-cart"
                                                data-id="{{ $product->id }}"
                                                data-name="{{ $product->product_name }}"
                                                data-imei="{{ $product->product_imei }}"
                                                data-color="{{ $product->color }}"
                                                data-storage="{{ $product->storage }}"
                                                data-price="{{ $product->selling_price ?? 0 }}">
                                            <i class="fas fa-plus me-1"></i> Add
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">
                                        <i class="fas fa-box-open fa-2x mb-2 d-block"></i>
                                        No products available
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Sale Summary --}}
        <div class="col-lg-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="fas fa-receipt me-2"></i>Sale Summary</h6>
                </div>
                <div class="card-body">

                    {{-- Customer --}}
                    <div class="mb-3">
                        <label class="form-label text-uppercase small fw-bold text-muted">
                            <i class="fas fa-user me-1"></i> Customer
                        </label>
                        <select class="form-select" id="customer_id">
                            <option value="">Walk-in Customer</option>
                            @foreach($customers ?? [] as $customer)
                            <option value="{{ $customer->id }}">
                                {{ $customer->name ?? $customer->customer_name ?? 'No Name' }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Payment Method --}}
                    <div class="mb-3">
                        <label class="form-label text-uppercase small fw-bold text-muted">
                            <i class="fas fa-credit-card me-1"></i> Payment Method
                        </label>
                        <select class="form-select" id="payment_method">
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                            <option value="transfer">Bank Transfer</option>
                        </select>
                    </div>

                    {{-- Sale Date --}}
                    <div class="mb-3">
                        <label class="form-label text-uppercase small fw-bold text-muted">
                            <i class="fas fa-calendar me-1"></i> Sale Date
                        </label>
                        <input type="date" class="form-control" id="sale_date"
                               value="{{ date('Y-m-d') }}">
                    </div>

                    <hr class="my-3">

                    {{-- Cart Items --}}
                    <label class="form-label text-uppercase small fw-bold text-muted">
                        <i class="fas fa-shopping-cart me-1"></i> Items in Cart
                    </label>
                    <div id="cartItems" class="mb-3" style="max-height: 220px; overflow-y: auto;">
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-cart-plus fa-2x mb-2 d-block text-muted"></i>
                            <small>No items added yet</small>
                        </div>
                    </div>

                    <hr class="my-2">

                    {{-- Totals --}}
                    <table class="table table-borderless table-sm mb-2">
                        <tr>
                            <td class="text-muted">Subtotal</td>
                            <td class="text-end fw-semibold" id="subtotal">$0.00</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Discount</td>
                            <td class="text-end">
                                <div class="input-group input-group-sm" style="width: 120px; margin-left: auto;">
                                    <input type="number" class="form-control text-end"
                                           id="discount" value="0" min="0" step="0.01">
                                    <span class="input-group-text">$</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="border-top">
                            <td class="fw-bold">Grand Total</td>
                            <td class="text-end fw-bold text-success fs-5" id="grandTotal">$0.00</td>
                        </tr>
                    </table>

                    {{-- Note --}}
                    <div class="mb-3">
                        <label class="form-label text-uppercase small fw-bold text-muted">
                            <i class="fas fa-sticky-note me-1"></i> Note
                        </label>
                        <textarea class="form-control form-control-sm" id="note"
                                  rows="2" placeholder="Optional note..."></textarea>
                    </div>

                    {{-- Complete Sale Button --}}
                    <button class="btn btn-success btn-lg w-100" id="completeSaleBtn">
                        <i class="fas fa-check-circle me-1"></i> Complete Sale
                    </button>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    let cart = [];

    // ── Search Filter ──────────────────────────────────────────
    document.getElementById('searchInput').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('#productsTable tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(keyword) ? '' : 'none';
        });
    });

    // ── Add to Cart ────────────────────────────────────────────
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function () {
            const id      = this.dataset.id;
            const name    = this.dataset.name;
            const price   = parseFloat(this.dataset.price);
            const imei    = this.dataset.imei;
            const color   = this.dataset.color;
            const storage = this.dataset.storage;

            if (cart.find(item => item.id === id)) {
                showToast('Already in cart', 'warning');
                return;
            }

            cart.push({ id, name, price, imei, color, storage, qty: 1 });

            // Disable the button so same product can't be added twice
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-check me-1"></i> Added';
            this.classList.replace('btn-primary', 'btn-success');

            renderCart();
            showToast(name + ' added to cart', 'success');
        });
    });

    // ── Render Cart ────────────────────────────────────────────
    function renderCart() {
        if (cart.length === 0) {
            document.getElementById('cartItems').innerHTML = `
                <div class="text-center text-muted py-4">
                    <i class="fas fa-cart-plus fa-2x mb-2 d-block"></i>
                    <small>No items added yet</small>
                </div>`;
            updateTotals(0);
            return;
        }

        let html     = '';
        let subtotal = 0;

        cart.forEach((item, index) => {
            subtotal += item.price;
            html += `
                <div class="border rounded p-2 mb-2 bg-light">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fw-semibold small">${item.name}</div>
                            <div class="text-muted" style="font-size: 11px;">
                                <i class="fas fa-barcode me-1"></i>${item.imei}
                            </div>
                            <div class="text-muted" style="font-size: 11px;">
                                <i class="fas fa-palette me-1"></i>${item.color}
                                &nbsp;|&nbsp;
                                <i class="fas fa-hdd me-1"></i>${item.storage}
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-success small">$${item.price.toFixed(2)}</div>
                            <button class="btn btn-sm btn-outline-danger remove-item mt-1" data-index="${index}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>`;
        });

        document.getElementById('cartItems').innerHTML = html;
        updateTotals(subtotal);
    }

    // ── Update Totals ──────────────────────────────────────────
    function updateTotals(subtotal) {
        const discount   = parseFloat(document.getElementById('discount').value) || 0;
        const grandTotal = Math.max(0, subtotal - discount);

        document.getElementById('subtotal').textContent   = '$' + subtotal.toFixed(2);
        document.getElementById('grandTotal').textContent = '$' + grandTotal.toFixed(2);
    }

    document.getElementById('discount').addEventListener('input', function () {
        const subtotal = cart.reduce((sum, item) => sum + item.price, 0);
        updateTotals(subtotal);
    });

    // ── Remove Item ────────────────────────────────────────────
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.remove-item');
        if (!btn) return;

        const index      = parseInt(btn.dataset.index);
        const removedId  = cart[index].id;

        cart.splice(index, 1);
        renderCart();

        // Re-enable the Add button for that product
        const addBtn = document.querySelector(`.add-to-cart[data-id="${removedId}"]`);
        if (addBtn) {
            addBtn.disabled = false;
            addBtn.innerHTML = '<i class="fas fa-plus me-1"></i> Add';
            addBtn.classList.replace('btn-success', 'btn-primary');
        }
    });

    // ── Toast ──────────────────────────────────────────────────
    function showToast(message, type = 'success') {
        const colors = {
            success: { bg: '#198754', text: '#fff' },
            warning: { bg: '#ffc107', text: '#000' },
            danger:  { bg: '#dc3545', text: '#fff' },
        };
        const c     = colors[type] || colors.success;
        const toast = document.createElement('div');
        toast.style.cssText = `
            position: fixed; bottom: 24px; right: 24px;
            background: ${c.bg}; color: ${c.text};
            padding: 12px 20px; border-radius: 6px;
            z-index: 9999; font-weight: 500;
            box-shadow: 0 4px 12px rgba(0,0,0,.2);
            display: flex; align-items: center; gap: 8px;
        `;
        toast.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i> ${message}`;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2500);
    }

    // ── Complete Sale ──────────────────────────────────────────
    document.getElementById('completeSaleBtn').addEventListener('click', async function () {
        if (cart.length === 0) {
            showToast('Please add at least one product!', 'warning');
            return;
        }

        const subtotal   = cart.reduce((sum, item) => sum + item.price, 0);
        const discount   = parseFloat(document.getElementById('discount').value) || 0;
        const grandTotal = Math.max(0, subtotal - discount);

        this.disabled    = true;
        this.innerHTML   = '<i class="fas fa-spinner fa-spin me-1"></i> Processing...';

        try {
            const response = await fetch(`/{{ app()->getLocale() }}/orders`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    customer_id:    document.getElementById('customer_id').value,
                    payment_method: document.getElementById('payment_method').value,
                    sale_date:      document.getElementById('sale_date').value,
                    discount:       discount,
                    grand_total:    grandTotal,
                    note:           document.getElementById('note').value,
                    cart:           cart,
                }),
            });

            const data = await response.json();

            if (data.success) {
                showToast('Sale completed successfully!', 'success');
                setTimeout(() => {
                    window.location.href = `/{{ app()->getLocale() }}/orders`;
                }, 1000);
            } else {
                showToast(data.message || 'Something went wrong.', 'danger');
            }

        } catch (err) {
            showToast('Network error. Please try again.', 'danger');
            console.error(err);
        } finally {
            this.disabled  = false;
            this.innerHTML = '<i class="fas fa-check-circle me-1"></i> Complete Sale';
        }
    });
</script>
@endsection