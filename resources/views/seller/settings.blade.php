<x-seller-layout>
    <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
        <div class="px-8 py-4">
            <h1 class="text-2xl font-bold text-gray-900">Settings</h1>
            <p class="text-sm text-gray-500 mt-1">Manage store profile and seller preferences</p>
        </div>
    </header>

    <main class="p-8">
        @if(session('success'))
            <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('seller.settings.update') }}" method="POST" class="space-y-6 max-w-4xl">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Store Profile</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Store Name</label>
                        <input type="text" name="store_name" value="{{ old('store_name', $user->store_name) }}" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500">
                        @error('store_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Store Email</label>
                        <input type="email" name="store_email" value="{{ old('store_email', $user->store_email) }}" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500">
                        @error('store_email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Store Description</label>
                    <textarea name="store_description" rows="4" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500">{{ old('store_description', $user->store_description) }}</textarea>
                    @error('store_description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Store Phone</label>
                        <input type="text" name="store_phone" value="{{ old('store_phone', $user->store_phone) }}" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500">
                        @error('store_phone') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Store Address</label>
                        <input type="text" name="store_address" value="{{ old('store_address', $user->store_address) }}" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500">
                        @error('store_address') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Business Settings</h2>
                <div class="space-y-4">
                    <label class="flex items-center gap-3">
                        <input type="hidden" name="auto_accept_orders" value="0">
                        <input type="checkbox" name="auto_accept_orders" value="1" @checked(old('auto_accept_orders', $user->auto_accept_orders)) class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="text-sm text-gray-700">Auto-accept orders</span>
                    </label>
                    <label class="flex items-center gap-3">
                        <input type="hidden" name="low_stock_alerts" value="0">
                        <input type="checkbox" name="low_stock_alerts" value="1" @checked(old('low_stock_alerts', $user->low_stock_alerts)) class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="text-sm text-gray-700">Enable low stock alerts</span>
                    </label>
                    <label class="flex items-center gap-3">
                        <input type="hidden" name="email_notifications" value="0">
                        <input type="checkbox" name="email_notifications" value="1" @checked(old('email_notifications', $user->email_notifications)) class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="text-sm text-gray-700">Enable email notifications</span>
                    </label>
                </div>
                @error('auto_accept_orders') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                @error('low_stock_alerts') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                @error('email_notifications') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Shipping Preferences</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Default Shipping Carrier</label>
                        <select name="default_shipping_carrier" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500">
                            <option value="">Select Courier</option>
                            <option value="J&T Express" @selected(old('default_shipping_carrier', $user->default_shipping_carrier) === 'J&T Express')>J&T Express</option>
                            <option value="LBC Padala" @selected(old('default_shipping_carrier', $user->default_shipping_carrier) === 'LBC Padala')>LBC Padala</option>
                            <option value="Flash Express" @selected(old('default_shipping_carrier', $user->default_shipping_carrier) === 'Flash Express')>Flash Express</option>
                        </select>
                        @error('default_shipping_carrier') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Processing Time</label>
                        <select name="processing_time" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500">
                            <option value="">Select Processing Time</option>
                            <option value="Same Day" @selected(old('processing_time', $user->processing_time) === 'Same Day')>Same Day</option>
                            <option value="1-2 Business Days" @selected(old('processing_time', $user->processing_time) === '1-2 Business Days')>1-2 Business Days</option>
                            <option value="3-5 Business Days" @selected(old('processing_time', $user->processing_time) === '3-5 Business Days')>3-5 Business Days</option>
                            <option value="5-7 Business Days" @selected(old('processing_time', $user->processing_time) === '5-7 Business Days')>5-7 Business Days</option>
                        </select>
                        @error('processing_time') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Free Shipping Threshold</label>
                    <select name="free_shipping_threshold" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500">
                        <option value="">Select Threshold</option>
                        <option value="0" @selected((string) old('free_shipping_threshold', $user->free_shipping_threshold) === '0')>No minimum (0)</option>
                        <option value="500" @selected((string) old('free_shipping_threshold', $user->free_shipping_threshold) === '500')>500</option>
                        <option value="1000" @selected((string) old('free_shipping_threshold', $user->free_shipping_threshold) === '1000')>1000</option>
                        <option value="1500" @selected((string) old('free_shipping_threshold', $user->free_shipping_threshold) === '1500')>1500</option>
                        <option value="2000" @selected((string) old('free_shipping_threshold', $user->free_shipping_threshold) === '2000')>2000</option>
                    </select>
                    @error('free_shipping_threshold') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <button type="submit" class="px-4 py-2 rounded-lg bg-orange-600 text-white hover:bg-orange-700 transition">
                    Save Changes
                </button>
            </div>
        </form>
    </main>
</x-seller-layout>
