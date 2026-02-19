<x-seller-layout>
    <!-- Top Header Bar -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
        <div class="px-8 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Settings</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Manage your store settings and preferences</p>
                </div>
                <div class="flex items-center gap-4">
                    <button class="px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-medium rounded-lg hover:from-orange-600 hover:to-orange-700 transition shadow-sm">
                        <i class="fas fa-save mr-2"></i>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Settings Content -->
    <main class="p-8">
        
        <div class="grid grid-cols-3 gap-6">
            
            <!-- Left Sidebar - Settings Navigation -->
            <div class="col-span-1">
                <div class="bg-white rounded-xl border border-gray-200 p-4">
                    <nav class="space-y-1">
                        <a href="#" class="settings-nav flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-700 bg-orange-100 text-orange-600">
                            <i class="fas fa-store w-5"></i>
                            <span>Store Profile</span>
                        </a>
                        <a href="#" class="settings-nav flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-box w-5"></i>
                            <span>Products</span>
                        </a>
                        <a href="#" class="settings-nav flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-truck w-5"></i>
                            <span>Shipping</span>
                        </a>
                        <a href="#" class="settings-nav flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-money-bill-wave w-5"></i>
                            <span>Payments</span>
                        </a>
                        <a href="#" class="settings-nav flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-bell w-5"></i>
                            <span>Notifications</span>
                        </a>
                        <a href="#" class="settings-nav flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-shield-alt w-5"></i>
                            <span>Security</span>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Right Content - Settings Forms -->
            <div class="col-span-2 space-y-6">
                
                <!-- Store Profile Settings -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Store Profile</h3>
                    
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Store Name</label>
                            <input type="text" value="John's Electronics Store" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Store Email</label>
                            <input type="email" value="seller@example.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Store Description</label>
                        <textarea rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">Your trusted source for premium electronics and gadgets. We offer the latest Apple products, accessories, and more.</textarea>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" value="+1 (555) 123-4567" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Business Address</label>
                            <input type="text" value="123 Main Street, New York, NY 10001" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        </div>
                    </div>
                </div>

                <!-- Business Settings -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Business Settings</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Auto-accept orders</p>
                                <p class="text-xs text-gray-500">Automatically accept orders without manual review</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Low stock alerts</p>
                                <p class="text-xs text-gray-500">Get notified when products are running low</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Email notifications</p>
                                <p class="text-xs text-gray-500">Receive email updates for orders and returns</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between py-3">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Two-factor authentication</p>
                                <p class="text-xs text-gray-500">Add an extra layer of security to your account</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Shipping Preferences -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Shipping Preferences</h3>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Default Shipping Carrier</label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                <option>UPS</option>
                                <option>FedEx</option>
                                <option>USPS</option>
                                <option>DHL</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Processing Time</label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                <option>Same Day</option>
                                <option>1-2 Business Days</option>
                                <option selected>3-5 Business Days</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Free Shipping Threshold</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                            <input type="number" value="100" class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Set minimum order amount for free shipping</p>
                    </div>
                </div>

            </div>

        </div>

    </main>

    <script>
    // Settings Navigation Active State
    document.querySelectorAll('.settings-nav').forEach(nav => {
        nav.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.settings-nav').forEach(n => {
                n.classList.remove('bg-orange-100', 'text-orange-600');
                n.classList.add('hover:bg-gray-50');
            });
            this.classList.add('bg-orange-100', 'text-orange-600');
            this.classList.remove('hover:bg-gray-50');
        });
    });
    </script>
</x-seller-layout>
