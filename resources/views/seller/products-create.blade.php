<x-seller-layout>
    <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
        <div class="px-8 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Add Product</h1>
                <p class="text-sm text-gray-500 mt-1">Create a new product listing</p>
            </div>
            <a href="{{ route('seller.products.index') }}" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition">
                Back to Products
            </a>
        </div>
    </header>

    <main class="p-8">
        <div class="max-w-3xl bg-white rounded-xl border border-gray-200 p-6">
            <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border-black focus:border-orange-500 focus:ring-orange-500">
                    @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select id="category_id" name="category_id" required class="w-full rounded-lg border-black focus:border-orange-500 focus:ring-orange-500">
                        <option value="" disabled @selected(old('category_id') === null)>Select category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Choose the category where this product belongs.</p>
                    @error('category_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                        <input id="price" type="number" step="0.01" min="0" name="price" value="{{ old('price') }}" required class="w-full rounded-lg border-black focus:border-orange-500 focus:ring-orange-500">
                        @error('price') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                        <input id="stock" type="number" min="0" name="stock" value="{{ old('stock', 0) }}" required class="w-full rounded-lg border-black focus:border-orange-500 focus:ring-orange-500">
                        @error('stock') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea id="description" name="description" rows="4" class="w-full rounded-lg border-black focus:border-orange-500 focus:ring-orange-500">{{ old('description') }}</textarea>
                    @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                    <input id="image" type="file" name="image" class="w-full rounded-lg border-black focus:border-orange-500 focus:ring-orange-500">
                    @error('image') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-2">
                    <input type="hidden" name="is_active" value="0">
                    <input id="is_active" type="checkbox" name="is_active" value="1" @checked(old('is_active', 1)) class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                    <label for="is_active" class="text-sm text-gray-700">Active product</label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="px-4 py-2 rounded-lg bg-orange-600 text-white hover:bg-orange-700 transition">Create Product</button>
                </div>
            </form>
        </div>
    </main>
</x-seller-layout>
