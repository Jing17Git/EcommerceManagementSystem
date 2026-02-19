<x-seller-layout>
    <!-- Top Header Bar -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
        <div class="px-8 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Orders</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Track and manage your customer orders</p>
                </div>
                <div class="flex items-center gap-4">
                    <button class="px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-medium rounded-lg hover:from-orange-600 hover:to-orange-700 transition shadow-sm">
                        <i class="fas fa-download mr-2"></i>Export
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Orders Content -->
    <main class="p-8">
        
        <!-- Stats Grid -->
        <div class="grid grid-cols-4 gap-6 mb-8">
            
            <!-- Total Orders Card -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                    </div>
                    <span class="text-green-600 text-sm font-semibold bg-green-50 px-2 py-1 rounded">
                        <i class="fas fa-arrow-up mr-1"></i>8.2%
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Total Orders</h3>
                <p class="text-3xl font-bold text-gray-900">348</p>
                <p class="text-gray-400 text-xs mt-2">This month</p>
            </div>

            <!-- Pending Orders Card -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <span class="text-red-600 text-sm font-semibold bg-red-50 px-2 py-1 rounded">
                        <i class="fas fa-arrow-up mr-1"></i>5
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Pending</h3>
                <p class="text-3xl font-bold text-gray-900">28</p>
                <p class="text-gray-400 text-xs mt-2">Awaiting processing</p>
            </div>

            <!-- Shipped Card -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-truck text-purple-600 text-xl"></i>
                    </div>
                    <span class="text-green-600 text-sm font-semibold bg-green-50 px-2 py-1 rounded">
                        <i class="fas fa-arrow-up mr-1"></i>12
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Shipped</h3>
                <p class="text-3xl font-bold text-gray-900">68</p>
                <p class="text-gray-400 text-xs mt-2">In transit</p>
            </div>

            <!-- Delivered Card -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <span class="text-green-600 text-sm font-semibold bg-green-50 px-2 py-1 rounded">
                        <i class="fas fa-arrow-up mr-1"></i>15%
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Delivered</h3>
                <p class="text-3xl font-bold text-gray-900">245</p>
                <p class="text-gray-400 text-xs mt-2">This month</p>
            </div>

        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-3 gap-6 mb-8">
            
            <!-- Orders Trend Chart -->
            <div class="col-span-2 bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Orders Trend</h3>
                        <p class="text-sm text-gray-500 mt-1">Daily order volume</p>
                    </div>
                    <div class="flex gap-2">
                        <button class="chart-tab px-4 py-2 text-sm font-medium rounded-lg bg-orange-100 text-orange-600">7D</button>
                        <button class="chart-tab px-4 py-2 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-100 transition">30D</button>
                    </div>
                </div>
                <canvas id="ordersChart" height="100"></canvas>
            </div>

            <!-- Order Status Distribution -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Order Status</h3>
                <p class="text-sm text-gray-500 mb-6">Current breakdown</p>
                <div class="flex items-center justify-center mb-6">
                    <canvas id="orderStatusChart" width="160" height="160"></canvas>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <span class="text-sm text-gray-600">Delivered</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">245</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-purple-500"></div>
                            <span class="text-sm text-gray-600">Shipped</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">68</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                            <span class="text-sm text-gray-600">Processing</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">7</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <span class="text-sm text-gray-600">Pending</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">28</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Recent Orders Table -->
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Recent Orders</h3>
                        <p class="text-sm text-gray-500 mt-1">Latest transactions from your store</p>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">#ORD-4521</td>
                            <td class="px-6 py-4 text-sm text-gray-700">Sarah Johnson</td>
                            <td class="px-6 py-4 text-sm text-gray-700">iPhone 15 Pro</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">$1,199</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-700">
                                    Shipped
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">Feb 16, 2026</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">#ORD-4520</td>
                            <td class="px-6 py-4 text-sm text-gray-700">Michael Chen</td>
                            <td class="px-6 py-4 text-sm text-gray-700">MacBook Air M3</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">$1,499</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                    Delivered
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">Feb 15, 2026</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">#ORD-4519</td>
                            <td class="px-6 py-4 text-sm text-gray-700">Emily Davis</td>
                            <td class="px-6 py-4 text-sm text-gray-700">AirPods Pro</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">$249</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
                                    Processing
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">Feb 15, 2026</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">#ORD-4518</td>
                            <td class="px-6 py-4 text-sm text-gray-700">James Wilson</td>
                            <td class="px-6 py-4 text-sm text-gray-700">iPad Pro 12.9"</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">$1,099</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                    Delivered
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">Feb 14, 2026</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">#ORD-4517</td>
                            <td class="px-6 py-4 text-sm text-gray-700">Lisa Anderson</td>
                            <td class="px-6 py-4 text-sm text-gray-700">Apple Watch Ultra</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">$799</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                    Pending
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">Feb 14, 2026</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <script>
    // Orders Trend Chart
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    const ordersGradient = ordersCtx.createLinearGradient(0, 0, 0, 300);
    ordersGradient.addColorStop(0, 'rgba(59, 130, 246, 0.3)');
    ordersGradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

    new Chart(ordersCtx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Orders',
                data: [42, 51, 48, 62, 71, 59, 68],
                borderColor: '#3b82f6',
                backgroundColor: ordersGradient,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointBackgroundColor: '#3b82f6'
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

    // Order Status Chart
    const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Delivered', 'Shipped', 'Processing', 'Pending'],
            datasets: [{
                data: [245, 68, 7, 28],
                backgroundColor: ['#10b981', '#8b5cf6', '#3b82f6', '#eab308'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '70%',
            plugins: {
                legend: { display: false }
            }
        }
    });

    // Chart Tab Switching
    document.querySelectorAll('.chart-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.chart-tab').forEach(t => {
                t.classList.remove('bg-orange-100', 'text-orange-600');
                t.classList.add('text-gray-600');
            });
            this.classList.add('bg-orange-100', 'text-orange-600');
            this.classList.remove('text-gray-600');
        });
    });
    </script>
</x-seller-layout>
