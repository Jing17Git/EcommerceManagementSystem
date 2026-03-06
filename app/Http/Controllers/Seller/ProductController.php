<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the seller's products.
     */
    public function index()
    {
        $products = Product::with('category')
            ->where('seller_id', auth()->id())
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => Product::where('seller_id', auth()->id())->count(),
            'active' => Product::where('seller_id', auth()->id())->where('is_active', true)->count(),
            'lowStock' => Product::where('seller_id', auth()->id())->where('stock', '>', 0)->where('stock', '<=', 5)->count(),
            'outOfStock' => Product::where('seller_id', auth()->id())->where('stock', '<=', 0)->count(),
        ];

        return view('seller.products', compact('products', 'stats'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = $this->defaultSellerCategories();
        return view('seller.products-create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $validated;
        $data['seller_id'] = auth()->id();
        $data['is_active'] = $request->boolean('is_active');

        // handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('seller.products.index')
                         ->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        // Ensure seller can only edit their own products
        if ($product->seller_id !== auth()->id()) {
            abort(403);
        }

        $categories = $this->defaultSellerCategories();
        return view('seller.products-edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Ensure seller can only update their own products
        if ($product->seller_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $validated;
        $data['is_active'] = $request->boolean('is_active');

        // handle image upload
        if ($request->hasFile('image')) {
            // delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('seller.products.index')
                         ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Ensure seller can only delete their own products
        if ($product->seller_id !== auth()->id()) {
            abort(403);
        }

        // delete image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return back()->with('success', 'Product deleted successfully.');
    }

    /**
     * Ensure the default seller categories exist and return them in fixed order.
     */
    private function defaultSellerCategories()
    {
        $names = ['Jewelry', 'Home Decor', 'Ceramics', 'Textiles', 'Art & Prints'];

        foreach ($names as $name) {
            Category::firstOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => null,
                    'is_active' => true,
                ]
            );
        }

        return Category::whereIn('name', $names)
            ->get()
            ->sortBy(function ($category) use ($names) {
                return array_search($category->name, $names, true);
            })
            ->values();
    }
}
