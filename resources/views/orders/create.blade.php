<!-- MAO SREYPOV -->
@extends('layouts.app')

@push('styles')
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    /* Prevent text selections to make the POS UI feel like a native desktop app */
    .pos-window { user-select: none; }
</style>
@endpush

@section('content')
<div class="pos-window bg-[#f0f2f5] font-sans h-[calc(100vh-120px)] flex flex-col overflow-hidden rounded-3xl shadow-sm border border-gray-100">

    <div class="flex flex-1 overflow-hidden">
        
        <main class="flex-1 p-6 overflow-y-auto">
            <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                </div>
        </main>

        <aside class="w-[360px] bg-white border-l border-gray-100 flex flex-col justify-between shadow-sm">
            
            <div class="p-4 border-b border-gray-50">
                <div class="text-xs text-slate-400 mb-2 font-medium">Order: <span id="orderNumber" class="font-bold text-slate-700">#11826</span></div>
                
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-slate-400 text-sm"></i>
                    </div>
                    <select id="customerSelect" class="block w-full pl-9 pr-8 py-2.5 border border-gray-200 rounded-xl text-sm bg-gray-50/50 font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 appearance-none cursor-pointer">
                        @forelse($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->customer_name ?? $customer->name ?? 'Walk-in Customer' }}</option>
                        @empty
                            <option value="Walk-in Customer">Walk-in Customer</option>
                        @endforelse
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400 text-xs">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </div>

            <div id="cartBody" class="flex-1 overflow-y-auto px-4 py-2 space-y-3">
                </div>

            <div class="p-4 border-t border-gray-100 bg-white ">
                <div class="flex justify-between items-center mb-4 px-1">
                    <span class="text-sm font-semibold text-slate-400">Total</span>
                    <span id="cartTotal" class="text-2xl font-black text-slate-900">$ 0.00</span>
                </div>
                
                <div class="flex gap-3 ">
                    <button id="receiptBtn" onclick="printReceipt()" class="w-12 h-12 rounded-xl flex items-center justify-center transition" disabled>
                        <i class="fas fa-receipt text-base"></i>
                    </button>
                    <button id="submitOrderBtn" onclick="submitOrder()" class="flex-1 rounded-xl font-semibold text-sm flex items-center justify-center gap-2 transition" disabled>
                        <i class="fas fa-cash-register text-xs"></i>
                        Submit Order
                    </button>
                </div>
            </div>
        </aside>

    </div>
</div>

<script type="text/javascript">
    // 1. Direct database collection translation injection safely mapped
    const products = @json($products ?? []);
    let cart = [];

    // Trigger boot grid loader directly without waiting for push stack frames
    setTimeout(function() {
        renderProducts();
        renderCart();
        generateOrderNumber();
    }, 150);

    function generateOrderNumber() {
        const num = Math.floor(10000 + Math.random() * 90000);
        const el = document.getElementById('orderNumber');
        if(el) el.innerText = `#${num}`;
    }

    function renderProducts() {
        const container = document.getElementById("productsGrid");
        if (!container) return;
        container.innerHTML = "";

        if (products.length === 0) {
            container.innerHTML = `
                <div class="col-span-full text-center py-12 text-slate-400 font-medium text-sm">
                    No active products found in the database directory.
                </div>`;
            return;
        }

        products.forEach(product => {
            let imgSection = '';
            if (product.image) {
                imgSection = `
                    <div class="h-44 bg-neutral-950 flex items-center justify-center overflow-hidden">
                        <img src="${product.image}" alt="Phone Image" class="w-full h-full object-cover opacity-90 transition duration-300 group-hover:scale-105">
                    </div>`;
            } else {
                imgSection = `
                    <div class="h-44 bg-gray-50 flex flex-col items-center justify-center p-4 border-b border-gray-100">
                        <i class="fas fa-camera text-3xl text-gray-300 mb-2"></i>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider text-center">Product Image Coming Soon</span>
                    </div>`;
            }

            const price = product.selling_price ? parseFloat(product.selling_price) : 0;
            const name = product.product_name || "Unknown Model";
            const imei = product.product_imei || product.imei || "--";
            const desc = product.note || product.specs || "Original smartphone collection item.";

            const cardHtml = `
                <div onclick="addToCart(${product.id})" class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md hover:border-blue-200 transition duration-200 flex flex-col cursor-pointer transform active:scale-[0.98]">
                    ${imgSection}
                    <div class="p-4 flex-1 flex flex-col justify-between min-h-[110px]">
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm">
                                ${name} <span class="text-slate-400 font-medium">[ IMEI: ${imei} ]</span>
                            </h3>
                            <p class="text-xs text-slate-400 font-medium mt-1.5 leading-relaxed truncate">${desc}</p>
                        </div>
                        <div class="mt-4 text-base font-black text-slate-900">$${price.toFixed(2)}</div>
                    </div>
                </div>`;
            container.innerHTML += cardHtml;
        });
    }

    function addToCart(productId) {
        const product = products.find(p => p.id === productId);
        if(!product) return;

        const cartItem = cart.find(item => item.product.id === productId);
        if (cartItem) {
            cartItem.quantity += 1;
        } else {
            cart.push({ product, quantity: 1 });
        }
        renderCart();
    }

    function changeQuantity(productId, delta) {
        const index = cart.findIndex(item => item.product.id === productId);
        if (index !== -1) {
            cart[index].quantity += delta;
            if (cart[index].quantity <= 0) {
                cart.splice(index, 1);
            }
            renderCart();
        }
    }

    function removeFromCart(productId) {
        cart = cart.filter(item => item.product.id !== productId);
        renderCart();
    }

    function renderCart() {
        const cartBody = document.getElementById("cartBody");
        const totalDisplay = document.getElementById("cartTotal");
        const submitBtn = document.getElementById("submitOrderBtn");
        const receiptBtn = document.getElementById("receiptBtn");

        if(!cartBody) return;

        if (cart.length === 0) {
            cartBody.innerHTML = `
                <div class="h-full flex flex-col items-center justify-center text-slate-400 space-y-2 pb-12">
                    <i class="fas fa-shopping-basket text-4xl text-slate-200"></i>
                    <p class="text-xs font-medium text-slate-400">Cart is empty</p>
                </div>`;
            if(totalDisplay) totalDisplay.innerText = "$ 0.00";
            
            if(submitBtn) {
                submitBtn.disabled = true;
                submitBtn.className = "flex-1 bg-[#9aa1b1] text-white rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition cursor-not-allowed py-3.5";
            }
            if(receiptBtn) {
                receiptBtn.disabled = true;
                receiptBtn.className = "w-12 h-12 bg-[#e8ebf3] text-[#9aa1b1] rounded-xl flex items-center justify-center transition cursor-not-allowed";
            }
            return;
        }

        cartBody.innerHTML = "";
        let totalPrice = 0;

        cart.forEach(item => {
            const itemPrice = item.product.selling_price ? parseFloat(item.product.selling_price) : 0;
            totalPrice += (itemPrice * item.quantity);

            const name = item.product.product_name || "Unknown Model";
            const imei = item.product.product_imei || item.product.imei || "--";

            const cartItemHtml = `
                <div class="flex items-center justify-between border-b border-gray-100/70 pb-3 mt-1 group">
                    <div class="flex-1 min-w-0 pr-2">
                        <h4 class="text-sm font-bold text-slate-800 truncate">${name}</h4>
                        <p class="text-[11px] text-slate-400 font-medium">IMEI: ${imei}</p>
                        <span class="text-xs font-bold text-blue-600">$${itemPrice.toFixed(2)}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="flex items-center bg-slate-50 border border-slate-100 rounded-lg">
                            <button onclick="changeQuantity(${item.product.id}, -1)" class="px-2 py-1 text-slate-500 hover:bg-slate-200/60 rounded-l-lg transition text-xs font-bold">-</button>
                            <span class="px-1.5 text-xs font-bold text-slate-700 min-w-[14px] text-center">${item.quantity}</span>
                            <button onclick="changeQuantity(${item.product.id}, 1)" class="px-2 py-1 text-slate-500 hover:bg-slate-200/60 rounded-r-lg transition text-xs font-bold">+</button>
                        </div>
                        <button onclick="removeFromCart(${item.product.id})" class="text-slate-300 hover:text-red-500 p-1 transition">
                            <i class="fas fa-trash-alt text-xs"></i>
                        </button>
                    </div>
                </div>`;
            cartBody.innerHTML += cartItemHtml;
        });

        if(totalDisplay) totalDisplay.innerText = `$ ${totalPrice.toFixed(2)}`;
        if(submitBtn) {
            submitBtn.disabled = false;
            submitBtn.className = "flex-1 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition cursor-pointer shadow-md shadow-blue-100 py-3.5";
        }
        if(receiptBtn) {
            receiptBtn.disabled = false;
            receiptBtn.className = "w-12 h-12 bg-slate-100 text-slate-700 hover:bg-slate-200 rounded-xl flex items-center justify-center transition cursor-pointer";
        }
    }

    function submitOrder() {
        const customerSelect = document.getElementById("customerSelect");
        const customerId = customerSelect ? customerSelect.value : null;

        const payload = {
            customer_id: customerId,
            note: "Counter POS Transaction",
            items: cart.map(item => ({
                product_id: item.product.id,
                quantity: item.quantity
            })),
            _token: "{{ csrf_token() }}"
        };

        fetch("{{ route('orders.store', app()->getLocale()) }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify(payload)
        })
        .then(async res => {
            const data = await res.json();
            if(!res.ok) throw new Error(data.message || "Failed.");
            return data;
        })
        .then(data => {
            alert(`Sale successfully saved!\nDatabase Order ID: #${data.order_id}`);
            cart = [];
            renderCart();
            generateOrderNumber();
        })
        .catch(err => alert("Error saving transaction details: " + err.message));
    }

    function printReceipt() {
        alert("Streaming invoice data to layout processing hardware layers...");
    }
</script>
@endsection