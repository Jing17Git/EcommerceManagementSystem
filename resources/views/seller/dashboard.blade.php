<x-seller-layout>
    @php
        $user = Auth::user();
        $storeName = $user->store_name ?: ($user->name . "'s Store");
        $storeDescription = $user->store_description ?: 'Update your shop profile in Settings to add a store description.';
        $storeEmail = $user->store_email ?: $user->email;
        $storePhone = $user->store_phone ?: 'No phone set';
        $storeAddress = $user->store_address ?: 'No address set';
        $sellerSince = $user->created_at->format('F Y');
        $customerCount = \App\Models\Order::where('seller_id', $user->id)->distinct('user_id')->count('user_id');
    @endphp

    <!-- Top Header Bar -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
        <div class="px-8 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Welcome back, {{ $storeName }}! Here's your store overview.</p>
                </div>
                <div class="flex items-center gap-4">
                    {{-- Switch Account Section - Show if user can switch to buyer --}}
                    @if(isset($currentRole) && $currentRole !== 'buyer')
                        <form method="POST" action="{{ route('seller.switchAccount') }}" class="flex items-center">
                            @csrf
                            <input type="hidden" name="role" value="buyer">
                            <button type="submit" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-500 hover:bg-green-600 rounded-lg transition">
                                <i class="fas fa-exchange-alt text-sm"></i><span>Switch to Buyer</span>
                            </button>
                        </form>
                    @else
                        <div class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-green-700 bg-green-50 border border-green-200 rounded-lg">
                            <i class="fas fa-check-circle text-sm"></i><span>Buyer Account Active</span>
                        </div>
                    @endif
                    <button class="relative p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                        <i class="fas fa-bell text-lg"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Dashboard Content -->
    <main class="p-8">
        
        <!-- Store Banner Card -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-8 mb-8 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <h2 class="text-3xl font-bold">{{ $storeName }}</h2>
                        <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium">
                            <i class="fas fa-check-circle mr-1"></i>Active
                        </span>
                    </div>
                    <p class="text-orange-100 text-lg mb-4">Seller since {{ $sellerSince }}</p>
                    <p class="text-orange-100 text-sm mb-4 max-w-2xl">{{ $storeDescription }}</p>
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-star text-yellow-300"></i>
                            <span class="font-semibold">4.8/5</span>
                            <span class="text-orange-100 text-sm">({{ $customerCount }} reviews)</span>
                        </div>
                        <div class="h-6 w-px bg-white/30"></div>
                        <div>
                            <span class="font-semibold">{{ $stats['productsCount'] }}</span>
                            <span class="text-orange-100 text-sm ml-1">Active Products</span>
                        </div>
                        <div class="h-6 w-px bg-white/30"></div>
                        <div>
                            <span class="font-semibold">{{ number_format($customerCount) }}</span>
                            <span class="text-orange-100 text-sm ml-1">Total Customers</span>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-orange-100 text-sm mb-2">Store ID</div>
                    <div class="text-2xl font-bold">#SLR-{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</div>
                    <div class="text-orange-100 text-xs mt-3 space-y-1">
                        <p>{{ $storeEmail }}</p>
                        <p>{{ $storePhone }}</p>
                        <p>{{ $storeAddress }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-4 gap-6 mb-8">
            
            <!-- Revenue Card -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-dollar-sign text-orange-600 text-xl"></i>
                    </div>
                    <span class="text-green-600 text-sm font-semibold bg-green-50 px-2 py-1 rounded">
                        <i class="fas fa-arrow-up mr-1"></i>{{ $stats['thisMonthRevenue'] > 0 ? number_format(($stats['thisMonthRevenue'] / max($stats['revenue'], 1)) * 100, 1) : 0 }}%
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">My Revenue</h3>
                <p class="text-3xl font-bold text-gray-900">${{ number_format($stats['revenue'], 2) }}</p>
                <p class="text-gray-400 text-xs mt-2">Total Revenue</p>
            </div>

            <!-- Total Orders Card -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                    </div>
                    <span class="text-green-600 text-sm font-semibold bg-green-50 px-2 py-1 rounded">
                        <i class="fas fa-arrow-up mr-1"></i>{{ $stats['ordersCount'] > 0 ? number_format(($stats['ordersCount'] / max($stats['ordersCount'], 1)) * 100, 1) : 0 }}%
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Total Orders</h3>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['ordersCount'] }}</p>
                <p class="text-gray-400 text-xs mt-2">All Time</p>
            </div>

            <!-- Items Sold Card -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-box text-green-600 text-xl"></i>
                    </div>
                    <span class="text-green-600 text-sm font-semibold bg-green-50 px-2 py-1 rounded">
                        <i class="fas fa-arrow-up mr-1"></i>{{ $stats['productsCount'] > 0 ? '100' : 0 }}%
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Active Products</h3>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['productsCount'] }}</p>
                <p class="text-gray-400 text-xs mt-2">In Inventory</p>
            </div>

            <!-- Pending Returns Card -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-undo text-red-600 text-xl"></i>
                    </div>
                    <span class="text-red-600 text-sm font-semibold bg-red-50 px-2 py-1 rounded">
                        <i class="fas fa-arrow-down mr-1"></i>{{ $stats['ordersCount'] > 0 ? number_format(($stats['pendingReturns'] / max($stats['ordersCount'], 1)) * 100, 1) : 0 }}%
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Pending Returns</h3>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['pendingReturns'] }}</p>
                <p class="text-gray-400 text-xs mt-2">Needs attention</p>
            </div>

        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-3 gap-6 mb-8">
            
            <!-- Sales Chart -->
            <div class="col-span-2 bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Sales Overview</h3>
                        <p class="text-sm text-gray-500 mt-1">Your daily sales performance</p>
                    </div>
                    <div class="flex gap-2">
                        <button class="chart-tab px-4 py-2 text-sm font-medium rounded-lg bg-orange-100 text-orange-600">7D</button>
                        <button class="chart-tab px-4 py-2 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-100 transition">30D</button>
                        <button class="chart-tab px-4 py-2 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-100 transition">90D</button>
                    </div>
                </div>
                <canvas id="salesChart" height="80"></canvas>
            </div>

            <!-- Order Status Donut -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Order Status</h3>
                <p class="text-sm text-gray-500 mb-6">Current breakdown</p>
                <div class="flex items-center justify-center mb-6">
                    <canvas id="orderStatusChart" width="180" height="180"></canvas>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <span class="text-sm text-gray-600">Delivered</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">{{ $orderStatuses['delivered'] }} ({{ $stats['ordersCount'] > 0 ? number_format(($orderStatuses['delivered'] / $stats['ordersCount']) * 100, 0) : 0 }}%)</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                            <span class="text-sm text-gray-600">Processing</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">{{ $orderStatuses['processing'] }} ({{ $stats['ordersCount'] > 0 ? number_format(($orderStatuses['processing'] / $stats['ordersCount']) * 100, 0) : 0 }}%)</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <span class="text-sm text-gray-600">Pending</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">{{ $orderStatuses['pending'] }} ({{ $stats['ordersCount'] > 0 ? number_format(($orderStatuses['pending'] / $stats['ordersCount']) * 100, 0) : 0 }}%)</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-indigo-500"></div>
                            <span class="text-sm text-gray-600">Shipped</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">{{ $orderStatuses['shipped'] }} ({{ $stats['ordersCount'] > 0 ? number_format(($orderStatuses['shipped'] / $stats['ordersCount']) * 100, 0) : 0 }}%)</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <span class="text-sm text-gray-600">Cancelled</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">{{ $orderStatuses['cancelled'] }} ({{ $stats['ordersCount'] > 0 ? number_format(($orderStatuses['cancelled'] / $stats['ordersCount']) * 100, 0) : 0 }}%)</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Bottom Section: Orders, Wallet, Products, Activity -->
        <div class="grid grid-cols-3 gap-6">
            
            <!-- Recent Orders - Spans 2 columns -->
            <div class="col-span-2 bg-white rounded-xl border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Recent Orders</h3>
                            <p class="text-sm text-gray-500 mt-1">Latest transactions from your store</p>
                        </div>
                        <a href="{{ route('seller.orders') }}" class="text-sm font-medium text-orange-600 hover:text-orange-700">View All →</a>
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
                            @forelse($recentOrders as $order)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $order->user->name ?? 'Guest' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $order->order_number ?? ('ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT)) }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">${{ number_format($order->total_amount, 2) }}</td>
                                <td class="px-6 py-4">
                                    @if($order->status == 'delivered')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Delivered</span>
                                    @elseif($order->status == 'processing')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">Processing</span>
                                    @elseif($order->status == 'shipped')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">Shipped</span>
                                    @elseif($order->status == 'cancelled')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Cancelled</span>
                                    @else
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No recent orders found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Column: Wallet + Products + Activity -->
            <div class="space-y-6">
                
                <!-- Wallet Card -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">My Wallet</h3>
                        <i class="fas fa-wallet text-orange-500 text-xl"></i>
                    </div>
                    <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-lg p-5 mb-4 text-white">
                        <p class="text-gray-400 text-xs mb-1">Available Balance</p>
                        <p class="text-3xl font-bold mb-4">${{ number_format($stats['revenue'], 2) }}</p>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-400 text-xs mb-1">This Month</p>
                                <p class="font-semibold">${{ number_format($stats['thisMonthRevenue'], 2) }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-xs mb-1">Pending</p>
                                <p class="font-semibold">${{ number_format($stats['pendingReturns'] * 100, 2) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between py-3 border-t border-gray-200">
                        <span class="text-sm text-gray-600">Total Withdrawn</span>
                        <span class="text-sm font-semibold text-gray-900">$0.00</span>
                    </div>
                    <button class="w-full mt-4 px-4 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-medium rounded-lg hover:from-orange-600 hover:to-orange-700 transition shadow-sm">
                        <i class="fas fa-money-bill-wave mr-2"></i>Request Withdrawal
                    </button>
                </div>

                <!-- Top Products -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Top Products</h3>
                        <a href="{{ route('seller.products.index') }}" class="text-sm font-medium text-orange-600 hover:text-orange-700">View All →</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($topProducts as $product)
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-box text-gray-400"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">SKU: {{ $product->sku ?? 'N/A' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-900">${{ number_format($product->price, 2) }}</p>
                                @if($product->stock > 10)
                                <span class="inline-block px-2 py-0.5 bg-green-100 text-green-700 text-xs font-semibold rounded">In Stock</span>
                                @elseif($product->stock > 0)
                                <span class="inline-block px-2 py-0.5 bg-orange-100 text-orange-700 text-xs font-semibold rounded">Low Stock</span>
                                @else
                                <span class="inline-block px-2 py-0.5 bg-red-100 text-red-700 text-xs font-semibold rounded">Out of Stock</span>
                                @endif
                            </div>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500 text-center py-4">No products found</p>
                        @endforelse
                    </div>
                </div>

                <!-- Activity Feed -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Activity</h3>
                    <div class="space-y-4">
                        @if($orderStatuses['delivered'] > 0)
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-900 font-medium">{{ $orderStatuses['delivered'] }} orders delivered</p>
                                <p class="text-xs text-gray-500">Total revenue: ${{ number_format($stats['revenue'], 2) }}</p>
                            </div>
                        </div>
                        @endif
                        @if($orderStatuses['processing'] > 0)
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-shopping-cart text-blue-600 text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-900 font-medium">{{ $orderStatuses['processing'] }} orders processing</p>
                                <p class="text-xs text-gray-500">Awaiting shipment</p>
                            </div>
                        </div>
                        @endif
                        @if($stats['pendingReturns'] > 0)
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-undo text-yellow-600 text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-900 font-medium">{{ $stats['pendingReturns'] }} pending returns</p>
                                <p class="text-xs text-gray-500">Needs attention</p>
                            </div>
                        </div>
                        @endif
                        @if($stats['productsCount'] > 0)
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-box text-purple-600 text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-900 font-medium">{{ $stats['productsCount'] }} active products</p>
                                <p class="text-xs text-gray-500">In your store</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

            </div>

        </div>

    </main>

    <script>
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const salesGradient = salesCtx.createLinearGradient(0, 0, 0, 300);
    salesGradient.addColorStop(0, 'rgba(249, 115, 22, 0.3)');
    salesGradient.addColorStop(1, 'rgba(249, 115, 22, 0)');

    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Sales',
                data: [4200, 5100, 4800, 6200, 7100, 5900, 6800],
                borderColor: '#f97316',
                backgroundColor: salesGradient,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointBackgroundColor: '#f97316',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1f2937',
                    padding: 12,
                    titleColor: '#f3f4f6',
                    bodyColor: '#f3f4f6',
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return '$' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f3f4f6', drawBorder: false },
                    ticks: {
                        callback: function(value) {
                            return '$' + (value / 1000) + 'K';
                        },
                        color: '#9ca3af'
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#9ca3af' }
                }
            }
        }
    });

    // Order Status Donut Chart
    const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
    new Chart(orderStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Delivered', 'Processing', 'Pending', 'Shipped', 'Cancelled'],
            datasets: [{
                data: [
                    {{ $orderStatuses['delivered'] }},
                    {{ $orderStatuses['processing'] }},
                    {{ $orderStatuses['pending'] }},
                    {{ $orderStatuses['shipped'] }},
                    {{ $orderStatuses['cancelled'] }}
                ],
                backgroundColor: ['#10b981', '#3b82f6', '#eab308', '#6366f1', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '70%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1f2937',
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
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
