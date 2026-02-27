@extends('layouts.app')
@section('title', 'Shop Now')
@section('content')

<section class="bg-[#1c1e38] border-b border-orange-500/10 px-6 md:px-14 py-16 relative overflow-hidden">
    <div class="absolute -top-16 -right-16 w-72 h-72 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <span class="inline-block bg-orange-500/15 text-orange-400 text-xs font-semibold tracking-widest uppercase px-4 py-1 rounded-full border border-orange-500/25 mb-4">Shop</span>
    <h1 class="text-4xl font-bold text-white leading-tight mb-3">Discover Handcrafted<br>Treasures</h1>
    <p class="text-gray-400 text-base max-w-xl leading-relaxed">Browse hundreds of unique items made by talented Filipino artisans. Every purchase directly supports a local small business.</p>
</section>

<section class="px-6 md:px-14 py-12 max-w-6xl mx-auto">

    {{-- CATEGORIES --}}
    <h2 class="text-lg font-semibold text-white mb-1">Shop by Category</h2>
    <div class="w-9 h-0.5 bg-orange-500 rounded mb-6"></div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-14">
        @foreach ([
            ['💎', 'Jewelry'],
            ['🛋️', 'Home Decor'],
            ['🏺', 'Ceramics'],
            ['👗', 'Textiles'],
            ['🎨', 'Art & Prints'],
            ['🌿', 'Eco Products'],
        ] as $cat)
        <div class="bg-[#1c1e38] border border-white/5 rounded-2xl p-5 text-center hover:border-orange-500/30 hover:-translate-y-1 transition-all duration-200 cursor-pointer">
            <div class="text-2xl mb-3">{{ $cat[0] }}</div>
            <p class="text-white text-sm font-semibold">{{ $cat[1] }}</p>
        </div>
        @endforeach
    </div>

    {{-- PRODUCTS --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold text-white mb-1">All Products</h2>
            <div class="w-9 h-0.5 bg-orange-500 rounded"></div>
        </div>
        <a href="{{ route('login') }}" class="bg-orange-500 hover:bg-orange-400 text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition">
            Login to Shop
        </a>
    </div>

    @php $products = \App\Models\Product::where('is_active', true)->latest()->take(9)->get(); @endphp

    @if($products->isNotEmpty())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($products as $product)
        <div class="bg-[#1c1e38] border border-white/5 rounded-2xl overflow-hidden hover:border-orange-500/30 hover:-translate-y-1 hover:shadow-xl transition-all duration-200">
            <div class="h-44 bg-[#12132a] overflow-hidden">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                @else
                    <div class="w-full h-full flex items-center justify-center text-4xl">🛍️</div>
                @endif
            </div>
            <div class="p-5">
                <p class="text-xs text-orange-400 font-semibold mb-1">{{ $product->category->name ?? 'Handcrafted' }}</p>
                <h3 class="text-white font-semibold mb-3 truncate">{{ $product->name }}</h3>
                <div class="flex items-center justify-between">
                    <span class="text-orange-400 font-bold">₱{{ number_format($product->price, 2) }}</span>
                    @auth
                    <form method="POST" action="{{ route('buyer.cart.add', $product) }}">
                        @csrf
                        <button type="submit" class="text-xs bg-orange-500/10 text-orange-400 border border-orange-500/20 px-3 py-1.5 rounded-lg hover:bg-orange-500 hover:text-white transition">
                            Add to Cart
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="text-xs bg-orange-500/10 text-orange-400 border border-orange-500/20 px-3 py-1.5 rounded-lg hover:bg-orange-500 hover:text-white transition">
                        Add to Cart
                    </a>
                    @endauth
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-[#1c1e38] border border-white/5 rounded-2xl p-16 text-center">
        <div class="text-5xl mb-4">🛍️</div>
        <h3 class="text-white font-semibold mb-2">Products coming soon</h3>
        <p class="text-gray-400 text-sm">Our artisans are busy crafting amazing items. Check back soon!</p>
    </div>
    @endif

</section>
@endsection
