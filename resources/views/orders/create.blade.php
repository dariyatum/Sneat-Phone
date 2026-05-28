@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>
            <i class="fas fa-cash-register me-2"></i>
            New Sale
        </h4>

        <a href="{{ route('orders.index', app()->getLocale()) }}"
           class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Back to Sales List
        </a>
    </div>

    <div class="row g-4">

        {{-- LEFT: Products --}}
        <div class="col-lg-8">
            <div class="card shadow-sm">

                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-box me-2"></i>
                        Available Products
                    </h6>
                </div>

                <div class="card-body">

                    {{-- Search --}}
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search text-muted"></i>
                        </span>

                        <input type="text"
                               id="searchInput"
                               class="form-control"
                               placeholder="Search product...">
                    </div>

                    {{-- Table --}}
                    <div class="table-responsive"
                         style="max-height:60vh; overflow-y:auto;">

                        <table class="table table-hover align-middle"
                               id="productsTable">

                            <thead class="table-light sticky-top">
                            <tr>
                                <th>Product</th>
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

                                <td>{{ $product->product_name }}</td>

                                <td>
                                    <code>
                                        {{ $product->product_imei }}
                                    </code>
                                </td>

                                <td>{{ $product->color }}</td>

                                <td>{{ $product->storage }}</td>

                                <td class="text-end text-success fw-bold">
                                    ${{ number_format($product->selling_price ?? 0,2) }}
                                </td>

                                <td class="text-center">

                                    <button type="button"
                                            class="btn btn-sm btn-primary add-to-cart"

                                            data-id="{{ $product->id }}"
                                            data-name="{{ $product->product_name }}"
                                            data-imei="{{ $product->product_imei }}"
                                            data-color="{{ $product->color }}"
                                            data-storage="{{ $product->storage }}"
                                            data-price="{{ $product->selling_price ?? 0 }}">
                                        Add
                                    </button>

                                </td>
                            </tr>

                            @empty

                            <tr>
                                <td colspan="6"
                                    class="text-center text-muted">
                                    No Products
                                </td>
                            </tr>

                            @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>
            </div>
        </div>

        {{-- RIGHT: Sale Form --}}
        <div class="col-lg-4">

            <div class="card shadow-sm sticky-top"
                 style="top:20px;">

                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-receipt me-2"></i>
                        Sale Summary
                    </h6>
                </div>

                <div class="card-body">

                    <form method="POST"
                          action="{{ route('orders.store', app()->getLocale()) }}"
                          id="saleForm">

                        @csrf

                        {{-- Customer --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Customer
                            </label>

                            <select class="form-select"
                                    name="customer_id">

                                <option value="">
                                    Walk-in Customer
                                </option>

                                @foreach($customers ?? [] as $customer)
                                <option value="{{ $customer->id }}">
                                    {{ $customer->name ?? $customer->customer_name }}
                                </option>
                                @endforeach

                            </select>
                        </div>

                        {{-- Payment --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Payment Method
                            </label>

                            <select class="form-select"
                                    name="payment_method">

                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                                <option value="transfer">
                                    Bank Transfer
                                </option>

                            </select>
                        </div>

                        {{-- Date --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Sale Date
                            </label>

                            <input type="date"
                                   class="form-control"
                                   name="sale_date"
                                   value="{{ date('Y-m-d') }}">
                        </div>

                        <hr>

                        {{-- Cart --}}
                        <label class="fw-bold mb-2">
                            Cart Items
                        </label>

                        <div id="cartItems"
                             style="max-height:220px;
                             overflow-y:auto;">

                            <div class="text-center text-muted">
                                No items added
                            </div>

                        </div>

                        <hr>

                        {{-- Hidden Inputs --}}
                        <input type="hidden"
                               name="discount"
                               id="discountInput"
                               value="0">

                        <input type="hidden"
                               name="grand_total"
                               id="grandTotalInput">

                        {{-- Discount --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Discount
                            </label>

                            <input type="number"
                                   class="form-control"
                                   id="discount"
                                   value="0"
                                   min="0"
                                   step="0.01">
                        </div>

                        {{-- Totals --}}
                        <div class="mb-3">

                            <div>
                                <strong>Subtotal:</strong>
                                <span id="subtotal">
                                    $0.00
                                </span>
                            </div>

                            <div>
                                <strong>Grand Total:</strong>
                                <span id="grandTotal"
                                      class="text-success">
                                    $0.00
                                </span>
                            </div>

                        </div>

                        {{-- Note --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Note
                            </label>

                            <textarea class="form-control"
                                      name="note"
                                      rows="2"></textarea>
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                                class="btn btn-success w-100"
                                id="completeSaleBtn">

                            <i class="fas fa-check-circle me-1"></i>
                            Complete Sale

                        </button>

                    </form>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection


@section('scripts')
<script>

let cart = [];

// SEARCH
document.getElementById('searchInput')
.addEventListener('input', function () {

    const keyword = this.value.toLowerCase();

    document.querySelectorAll(
        '#productsTable tbody tr'
    ).forEach(row => {

        row.style.display =
            row.textContent.toLowerCase()
            .includes(keyword)
            ? ''
            : 'none';
    });
});


// ADD TO CART
document.querySelectorAll('.add-to-cart')
.forEach(button => {

    button.addEventListener('click', function () {

        const id =
            this.dataset.id;

        if (cart.find(
            item => item.id === id
        )) {
            return;
        }

        cart.push({

            id: id,
            name: this.dataset.name,
            imei: this.dataset.imei,
            color: this.dataset.color,
            storage: this.dataset.storage,
            price: parseFloat(
                this.dataset.price
            )
        });

        this.disabled = true;
        this.classList
            .replace(
                'btn-primary',
                'btn-success'
            );

        this.innerHTML = 'Added';

        renderCart();
    });
});


// RENDER CART
function renderCart() {

    const cartItems =
        document.getElementById(
            'cartItems'
        );

    if (cart.length === 0) {

        cartItems.innerHTML = `
            <div class="text-center text-muted">
                No items added
            </div>`;

        updateTotals(0);
        return;
    }

    let html = '';
    let subtotal = 0;

    cart.forEach((item, index) => {

        subtotal += item.price;

        html += `
        <div class="border rounded p-2 mb-2 bg-light">

            <div class="fw-bold">
                ${item.name}
            </div>

            <small>
                ${item.imei}
            </small>

            <div class="text-success fw-bold">
                $${item.price.toFixed(2)}
            </div>

            <input type="hidden"
                   name="cart[${index}][product_id]"
                   value="${item.id}">

            <input type="hidden"
                   name="cart[${index}][price]"
                   value="${item.price}">

            <button type="button"
                    class="btn btn-sm btn-danger remove-item mt-2"
                    data-index="${index}">
                Remove
            </button>

        </div>
        `;
    });

    cartItems.innerHTML = html;

    updateTotals(subtotal);
}


// TOTALS
function updateTotals(subtotal) {

    const discount =
        parseFloat(
            document.getElementById(
                'discount'
            ).value
        ) || 0;

    const grandTotal =
        Math.max(
            0,
            subtotal - discount
        );

    document.getElementById(
        'subtotal'
    ).textContent =
        '$' + subtotal.toFixed(2);

    document.getElementById(
        'grandTotal'
    ).textContent =
        '$' + grandTotal.toFixed(2);

    document.getElementById(
        'discountInput'
    ).value =
        discount;

    document.getElementById(
        'grandTotalInput'
    ).value =
        grandTotal;
}


// DISCOUNT
document.getElementById('discount')
.addEventListener('input', function () {

    const subtotal =
        cart.reduce(
            (sum, item) =>
                sum + item.price,
            0
        );

    updateTotals(subtotal);
});


// REMOVE ITEM
document.addEventListener(
    'click',
    function (e) {

        const btn =
            e.target.closest(
                '.remove-item'
            );

        if (!btn) return;

        const index =
            parseInt(
                btn.dataset.index
            );

        const removedId =
            cart[index].id;

        cart.splice(index,1);

        renderCart();

        const addBtn =
            document.querySelector(
                `.add-to-cart[data-id="${removedId}"]`
            );

        if (addBtn) {

            addBtn.disabled = false;

            addBtn.classList
            .replace(
                'btn-success',
                'btn-primary'
            );

            addBtn.innerHTML = 'Add';
        }
    }
);

</script>
@endsection