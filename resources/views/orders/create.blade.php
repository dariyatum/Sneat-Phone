

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone POS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 font-sans h-screen flex flex-col overflow-hidden">

    <div class="flex flex-1 overflow-hidden">
        
        <aside class="w-20 bg-white border-r border-gray-200 flex flex-col items-center py-4 space-y-4">
            <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center text-white font-bold mb-4">
                <i class="fab fa-apple text-xl"></i>
            </div>
            
            <button class="w-16 h-16 bg-blue-600 text-white rounded-xl flex flex-col items-center justify-center text-xs font-semibold shadow-md transition">
                <i class="fas fa-search text-base mb-1"></i>
                Search
            </button>
            
            <button class="w-16 h-16 bg-blue-50 text-blue-600 rounded-xl flex flex-col items-center justify-center text-xs font-semibold border border-blue-200 transition hover:bg-blue-100">
                <i class="fas fa-mobile-alt text-base mb-1"></i>
                All Phones
            </button>
            
            <button class="w-16 h-16 text-gray-500 rounded-xl flex flex-col items-center justify-center text-xs font-semibold border border-gray-200 transition hover:bg-gray-50">
                <i class="fab fa-apple text-lg mb-1 text-black"></i>
                APPLE
            </button>
        </aside>

        <main class="flex-1 p-6 overflow-y-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition flex flex-col">
                    <div class="h-48 bg-gray-50 flex items-center justify-center overflow-hidden p-2">
                        <img src="https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=400" alt="iPhone 13" class="h-full object-contain object-center">
                    </div>
                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-gray-800 text-sm">iPhone 13 [ IMEI: 9111 ]</h3>
                            <p class="text-xs text-gray-400 mt-1">Used, iPhone 13, 256G, Black, Original</p>
                        </div>
                        <div class="mt-4 text-base font-bold text-gray-900">$295.00</div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition flex flex-col">
                    <div class="h-48 bg-gray-50 flex items-center justify-center overflow-hidden p-2">
                        <img src="https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=400" alt="iPhone 15 Pro Max" class="h-full object-contain object-center">
                    </div>
                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-gray-800 text-sm">iPhone 15 pro max [ IMEI: 8497 ]</h3>
                            <p class="text-xs text-gray-400 mt-1">Used, iPhone 15 Promax, 512GB, Black, Original</p>
                        </div>
                        <div class="mt-4 text-base font-bold text-gray-900">$870.00</div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition flex flex-col">
                    <div class="h-48 bg-gray-50 flex items-center justify-center overflow-hidden p-2">
                        <img src="https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=400" alt="iPhone 15" class="h-full object-contain object-center">
                    </div>
                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-gray-800 text-sm">iPhone 15 [ IMEI: 2111 ]</h3>
                            <p class="text-xs text-gray-400 mt-1">Used, iPhone 15, 256G, Black, Original</p>
                        </div>
                        <div class="mt-4 text-base font-bold text-gray-900">$560.00</div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition flex flex-col">
                    <div class="h-48 bg-gray-50 flex items-center justify-center overflow-hidden p-2">
                        <img src="https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=400" alt="iPhone 15" class="h-full object-contain object-center">
                    </div>
                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-gray-800 text-sm">15 [ IMEI: 5705 ]</h3>
                            <p class="text-xs text-gray-400 mt-1">Used, iPhone 15, 128GB, Black, Original</p>
                        </div>
                        <div class="mt-4 text-base font-bold text-gray-900">$490.00</div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition flex flex-col">
                    <div class="h-48 bg-gray-50 flex flex-col items-center justify-center p-4 border-b border-gray-100">
                        <i class="fas fa-camera text-4xl text-gray-300 mb-2"></i>
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider text-center">Product Image Coming Soon</span>
                    </div>
                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-gray-800 text-sm">iPhone 13 [ IMEI: -- ]</h3>
                            <p class="text-xs text-gray-400 mt-1">Used, iPhone 13, 128G, Stock Item</p>
                        </div>
                        <div class="mt-4 text-base font-bold text-gray-900">$330.00</div>
                    </div>
                </div>

            </div>
        </main>

        <aside class="w-80 bg-white border-l border-gray-200 flex flex-col justify-between shadow-lg">
            <div class="p-4 border-b border-gray-100">
                <div class="text-xs text-gray-400 mb-1 font-medium">Order: <span class="font-bold text-gray-700">#00953</span></div>
                
                <div class="relative mt-2">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400 text-sm"></i>
                    </div>
                    <select class="block w-full pl-9 pr-8 py-2 border border-gray-200 rounded-lg text-sm bg-gray-50 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none cursor-pointer">
                        <option>តាំងសេង</option>
                        <option>Walk-in Customer</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400 text-xs">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </div>

            <div class="flex-1 flex flex-col items-center justify-center p-6 text-gray-400 space-y-2">
                <i class="fas fa-shopping-basket text-4xl text-gray-200"></i>
                <p class="text-sm">Cart is empty</p>
            </div>

            <div class="p-4 border-t border-gray-100 bg-gray-50">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-sm font-semibold text-gray-500">Total</span>
                    <span class="text-xl font-black text-gray-950">$ 0</span>
                </div>
                
                <div class="grid grid-cols-4 gap-2">
                    <button class="col-span-1 bg-gray-200 text-gray-500 rounded-lg py-3 flex items-center justify-center hover:bg-gray-300 transition cursor-not-allowed" disabled>
                        <i class="fas fa-receipt text-lg"></i>
                    </button>
                    <button class="col-span-3 bg-blue-600 text-white rounded-lg py-3 px-4 font-semibold text-sm flex items-center justify-center gap-2 hover:bg-blue-700 transition shadow-md shadow-blue-200">
                        <i class="fas fa-cash-register"></i>
                        Submit Order
                    </button>
                </div>
            </div>
        </aside>

    </div>

</body>
</html>