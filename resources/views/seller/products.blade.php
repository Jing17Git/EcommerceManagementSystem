<x-seller-layout>
    <!-- Top Header Bar -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
        <div class="px-8 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Products</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Manage and track your product performance</p>
                </div>
                <div class="flex items-center gap-4">
                    <button class="px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-medium rounded-lg hover:from-orange-600 hover:to-orange-700 transition shadow-sm">
                        <i class="fas fa-plus mr-2"></i>Add Product
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Products Content -->
    <main class="p-8">
        
        <!-- Stats Grid -->
        <div class="grid grid-cols-4 gap-6 mb-8">
            
            <!-- Total Products Card -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-box text-blue-600 text-xl"></i>
                    </div>
                    <span class="text-green-600 text-sm font-semibold bg-green-50 px-2 py-1 rounded">
                        <i class="fas fa-arrow-up mr-1"></i>5.2%
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Total Products</h3>
                <p class="text-3xl font-bold text-gray-900">24</p>
                <p class="text-gray-400 text-xs mt-2">Active listings</p>
            </div>

            <!-- Categories Card -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-tags text-purple-600 text-xl"></i>
                    </div>
                    <span class="text-green-600 text-sm font-semibold bg-green-50 px-2 py-1 rounded">
                        <i class="fas fa-arrow-up mr-1"></i>2.1%
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Categories</h3>
                <p class="text-3xl font-bold text-gray-900">8</p>
                <p class="text-gray-400 text-xs mt-2">Product categories</p>
            </div>

            <!-- Low Stock Card -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                    </div>
                    <span class="text-red-600 text-sm font-semibold bg-red-50 px-2 py-1 rounded">
                        <i class="fas fa-arrow-up mr-1"></i>3
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Low Stock</h3>
                <p class="text-3xl font-bold text-gray-900">3</p>
                <p class="text-gray-400 text-xs mt-2">Need restocking</p>
            </div>

            <!-- Out of Stock Card -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-times-circle text-red-600 text-xl"></i>
                    </div>
                    <span class="text-green-600 text-sm font-semibold bg-green-50 px-2 py-1 rounded">
                        <i class="fas fa-arrow-down mr-1"></i>1
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Out of Stock</h3>
                <p class="text-3xl font-bold text-gray-900">1</p>
                <p class="text-gray-400 text-xs mt-2">Unavailable items</p>
            </div>

        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-2 gap-6 mb-8">
            
            <!-- Products by Category Chart -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Products by Category</h3>
                        <p class="text-sm text-gray-500 mt-1">Distribution of your product catalog</p>
                    </div>
                </div>
                <canvas id="categoryChart" height="200"></canvas>
            </div>

            <!-- Stock Levels Chart -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Stock Levels</h3>
                        <p class="text-sm text-gray-500 mt-1">Current inventory status</p>
                    </div>
                </div>
                <canvas id="stockChart" height="200"></canvas>
            </div>

        </div>

        <!-- Top Selling Products Table -->
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Top Selling Products</h3>
                        <p class="text-sm text-gray-500 mt-1">Your best performing products</p>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">SKU</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Sold</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">iPhone 15 Pro</td>
                            <td class="px-6 py-4 text-sm text-gray-700">IPH-15P-128</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">$1,199</td>
                            <td class="px-6 py-4 text-sm text-gray-700">45</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">234</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                    In Stock
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">MacBook Air M3</td>
                            <td class="px-6 py-4 text-sm text-gray-700">MBA-M3-256</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">$1,499</td>
                            <td class="px-6 py-4 text-sm text-gray-700">28</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">189</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                    In Stock
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">AirPods Pro 2</td>
                            <td class="px-6 py-4 text-sm text-gray-700">APP-2-WHT</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">$249</td>
                            <td class="px-6 py-4 text-sm text-gray-700">5</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">156</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-700">
                                    Low Stock
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">iPad Pro 12.9"</td>
                            <td class="px-6 py-4 text-sm text-gray-700">IPD-PRO-256</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">$1,099</td>
                            <td class="px-6 py-4 text-sm text-gray-700">0</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">98</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                    Out of Stock
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <script>
    // Products by Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: ['Electronics', 'Accessories', 'Wearables', 'Audio', 'Other'],
            datasets: [{
                data: [12, 5, 3, 2, 2],
                backgroundColor: ['#f97316', '#3b82f6', '#10b981', '#8b5cf6', '#6b7280'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        usePointStyle: true,
                        padding: 15
                    }
                }
            }
        }
    });

    // Stock Levels Chart
    const stockCtx = document.getElementById('stockChart').getContext('2d');
    new Chart(stockCtx, {
        type: 'bar',
        data: {
            labels: ['iPhone 15 Pro', 'MacBook Air', 'AirPods Pro', 'iPad Pro', 'Apple Watch'],
            datasets: [{
                label: 'Stock',
                data: [45, 28, 5, 0, 12],
                backgroundColor: ['#10b981', '#10b981', '#f59e0b', '#ef4444', '#10b981'],
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f3f4f6' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
    </script>
</x-seller-layout>
