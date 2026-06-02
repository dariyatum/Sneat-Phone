@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <form method="POST"
          action="{{ route('sales.store', app()->getLocale()) }}"
          id="saleForm">
        @csrf

        {{-- Sale Date & Customer --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">SALE DATE</label>
                <input type="date"
                       class="form-control"
                       name="sale_date"
                       value="{{ date('Y-m-d') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">CUSTOMER</label>
                <select class="form-select" name="customer_id">
                    <option value="">Walk in Customer</option>
                    @foreach($customers ?? [] as $customer)
                    <option value="{{ $customer->id }}">
                        {{ $customer->name ?? $customer->customer_name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Product Name Dropdown --}}
        <div class="mb-3">
            <label class="form-label">PRODUCT NAME</label>
            <select class="form-select" id="productSelect">
                <option value="">Select Order Product</option>
                @foreach($products ?? [] as $product)
                <option value="{{ $product->id }}"
                        data-id="{{ $product->id }}"
                        data-name="{{ $product->product_name }}"
                        data-imei="{{ $product->product_imei }}"
                        data-color="{{ $product->color->name ?? '' }}"
                        data-storage="{{ $product->storage->name ?? '' }}"
                        data-condition="{{ $product->condition_name ?? '' }}"
                        data-price="{{ $product->selling_price ?? 0 }}">
                    {{ $product->product_name }} — {{ $product->product_imei }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- Cart Table --}}
        <div class="table-responsive mb-2">
            <table class="table table-bordered align-middle" id="cartTable">
                <thead class="table-light">
                    <tr>
                        <th>PRODUCT IMEI</th>
                        <th>PRODUCT NAME</th>
                        <th>PRODUCT DETAIL</th>
                        <th class="text-end">PRICE ($)</th>
                        <th class="text-center">ACTIONS</th>
                    </tr>
                </thead>
                <tbody id="cartBody">
                    <tr id="emptyRow">
                        <td colspan="5" class="text-center text-muted py-4">NO DATA AVAILABLE</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end fw-bold">TOTAL :</td>
                        <td class="text-end fw-bold text-success" id="totalDisplay">$0.00</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Hidden Inputs --}}
        <input type="hidden" name="grand_total" id="grandTotalInput" value="0">
        <input type="hidden" name="discount" value="0">
        <input type="hidden" name="payment_method" value="cash">

        {{-- Note --}}
        <div class="mb-3">
            <label class="form-label">NOTE</label>
            <textarea class="form-control" name="note" rows="4"></textarea>
        </div>

        {{-- Buttons --}}
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4" id="completeSaleBtn">
                Submit Order
            </button>
            <a href="{{ route('sales.index', app()->getLocale()) }}" class="btn btn-outline-secondary px-4">
                Cancel
            </a>
        </div>

    </form>

</div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {

    let cart = [];

    // =========================
    // SUBMIT GUARD
    // =========================
    const saleForm = document.getElementById('saleForm');
    if (saleForm) {
        saleForm.addEventListener('submit', function (e) {
            if (cart.length === 0) {
                e.preventDefault();
                alert('Please add at least one item before submitting.');
                return;
            }
            renderCart();
        });
    }

    // =========================
    // SELECT PRODUCT → ADD TO CART
    // =========================
    const productSelect = document.getElementById('productSelect');
    if (productSelect) {
        productSelect.addEventListener('change', function () {
            const option = this.options[this.selectedIndex];
            if (!option.value) return;

            const id = option.dataset.id;

            // Prevent duplicate
            if (cart.find(item => item.id == id)) {
                alert('This product is already in the cart.');
                this.value = '';
                return;
            }

            cart.push({
                id:        id,
                name:      option.dataset.name,
                imei:      option.dataset.imei,
                color:     option.dataset.color,
                storage:   option.dataset.storage,
                condition: option.dataset.condition,
                price:     parseFloat(option.dataset.price)
            });

            // Hide the selected option so it can't be picked again
            option.disabled = true;
            option.style.display = 'none';

            // Reset dropdown
            this.value = '';

            renderCart();
        });
    }

    // =========================
    // RENDER CART TABLE
    // =========================
    function renderCart() {
        const tbody = document.getElementById('cartBody');
        const emptyRow = document.getElementById('emptyRow');

        // Remove old dynamic rows
        tbody.querySelectorAll('.cart-row').forEach(r => r.remove());

        if (cart.length === 0) {
            emptyRow.style.display = '';
            updateTotal(0);
            return;
        }

        emptyRow.style.display = 'none';

        let total = 0;

        cart.forEach((item, index) => {
            total += item.price;

            const detail = [item.color, item.storage, item.condition]
                .filter(Boolean).join(', ');

            const tr = document.createElement('tr');
            tr.className = 'cart-row';
            tr.innerHTML = `
                <td><code>${item.imei}</code></td>
                <td>${item.name}</td>
                <td>${detail || '-'}</td>
                <td class="text-end text-success fw-bold">$${item.price.toFixed(2)}</td>
                <td class="text-center">
                    <input type="hidden" name="cart[${index}][product_id]" value="${item.id}">
                    <input type="hidden" name="cart[${index}][price]" value="${item.price}">
                    <button type="button" class="btn btn-sm btn-danger remove-item" data-index="${index}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });

        updateTotal(total);
    }

    // =========================
    // UPDATE TOTAL
    // =========================
    function updateTotal(total) {
        document.getElementById('totalDisplay').textContent = '$' + total.toFixed(2);
        document.getElementById('grandTotalInput').value = total;
    }

    // =========================
    // REMOVE ITEM
    // =========================
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.remove-item');
        if (!btn) return;

        const index = parseInt(btn.dataset.index);
        const removedId = cart[index].id;

        // Re-enable the option in the dropdown
        const option = document.querySelector(`#productSelect option[data-id="${removedId}"]`);
        if (option) {
            option.disabled = false;
            option.style.display = '';
        }

        cart.splice(index, 1);
        renderCart();
    });

});
</script>
@endpush