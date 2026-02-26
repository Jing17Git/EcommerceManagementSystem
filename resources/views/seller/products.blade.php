<x-seller-layout>
    <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
        <div class="px-8 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Products</h1>
                <p class="text-sm text-gray-500 mt-1">Manage your product catalog</p>
            </div>
            <a href="{{ route('seller.products.create') }}" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                Add Product
            </a>
        </div>
    </header>

    <main class="p-8 space-y-6">
        @if(session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-sm text-gray-500">Total</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] ?? 0 }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-sm text-gray-500">Active</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['active'] ?? 0 }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-sm text-gray-500">Low Stock</p>
                <p class="text-2xl font-bold text-amber-600">{{ $stats['lowStock'] ?? 0 }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="text-sm text-gray-500">Out of Stock</p>
                <p class="text-2xl font-bold text-red-600">{{ $stats['outOfStock'] ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Product</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Category</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Price</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Stock</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $product->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $product->slug }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $product->category?->name ?? 'Uncategorized' }}</td>
                                <td class="px-4 py-3 text-sm font-semibold text-gray-900">${{ number_format($product->price, 2) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $product->stock }}</td>
                                <td class="px-4 py-3">
                                    @if($product->is_active)
                                        <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Active</span>
                                    @else
                                        <span class="px-2 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('seller.products.edit', $product) }}" class="px-3 py-1.5 rounded-md bg-blue-100 text-blue-700 text-sm font-medium hover:bg-blue-200 transition">Edit</a>
                                        <form action="{{ route('seller.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 rounded-md bg-red-100 text-red-700 text-sm font-medium hover:bg-red-200 transition">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $products->links() }}
            </div>
        </div>
    </main>
</x-seller-layout>
