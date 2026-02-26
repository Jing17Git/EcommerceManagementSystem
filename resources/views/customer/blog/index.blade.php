@extends('layouts.app')
@section('title', 'Blog')
@section('content')

<section class="bg-[#1c1e38] border-b border-orange-500/10 px-6 md:px-14 py-16 relative overflow-hidden">
    <div class="absolute -top-16 -right-16 w-72 h-72 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <span class="inline-block bg-orange-500/15 text-orange-400 text-xs font-semibold tracking-widest uppercase px-4 py-1 rounded-full border border-orange-500/25 mb-4">Blog</span>
    <h1 class="text-4xl font-bold text-white leading-tight mb-3">Stories, Tips &<br>Artisan Spotlights</h1>
    <p class="text-gray-400 text-base max-w-xl leading-relaxed">Discover the people behind the products, get craft inspiration, and learn how to grow your handmade business.</p>
</section>

<section class="px-6 md:px-14 py-12 max-w-5xl mx-auto">

    {{-- FEATURED POST --}}
    <div class="bg-[#1c1e38] border border-white/5 rounded-2xl overflow-hidden mb-10 hover:border-orange-500/30 transition group cursor-pointer">
        <div class="h-56 bg-gradient-to-br from-orange-500/20 to-purple-500/20 flex items-center justify-center text-6xl">✍️</div>
        <div class="p-8">
            <div class="flex gap-3 mb-3">
                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-orange-500/10 text-orange-400 border border-orange-500/20">Featured</span>
                <span class="text-xs text-gray-500">January 15, 2025 · 5 min read</span>
            </div>
            <h2 class="text-white font-bold text-2xl mb-3 group-hover:text-orange-400 transition">How Maria Santos Turned Her Weaving Hobby Into a ₱500K Business</h2>
            <p class="text-gray-400 text-sm leading-relaxed mb-4">From selling woven bags at the local market to running a thriving online shop, Maria's story is an inspiration to artisans everywhere. We sat down with her to learn her secrets.</p>
            <span class="text-orange-400 text-sm font-semibold">Read More →</span>
        </div>
    </div>

    {{-- POSTS GRID --}}
    <h2 class="text-lg font-semibold text-white mb-1">Latest Articles</h2>
    <div class="w-9 h-0.5 bg-orange-500 rounded mb-6"></div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach ([
            ['🏺', 'Craft Tips',       '5 Tips for Photographing Your Handmade Products',                   'Jan 10, 2025', '3 min read'],
            ['💰', 'Business',         'Pricing Your Handmade Items: A Complete Guide',                      'Jan 5, 2025',  '6 min read'],
            ['🌿', 'Sustainability',   'Going Green: Eco-Friendly Packaging Ideas for Artisans',             'Dec 28, 2024', '4 min read'],
            ['📱', 'Marketing',        'How to Use Instagram to Grow Your Craft Business',                   'Dec 20, 2024', '5 min read'],
            ['🎁', 'Seasonal',         'Holiday Gift Guide: Top 20 Handmade Gifts Under ₱500',               'Dec 15, 2024', '4 min read'],
            ['🤝', 'Community',        'Meet the Artisans: Spotlight on Cebu\'s Pottery Community',          'Dec 10, 2024', '7 min read'],
        ] as $post)
        <div class="bg-[#1c1e38] border border-white/5 rounded-2xl overflow-hidden hover:border-orange-500/30 hover:-translate-y-1 transition-all duration-200 cursor-pointer group">
            <div class="h-32 bg-gradient-to-br from-[#12132a] to-[#1c1e38] flex items-center justify-center text-4xl">{{ $post[0] }}</div>
            <div class="p-5">
                <div class="flex gap-2 mb-2">
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-orange-500/10 text-orange-400 border border-orange-500/20">{{ $post[1] }}</span>
                </div>
                <h3 class="text-white font-semibold text-sm leading-snug mb-3 group-hover:text-orange-400 transition">{{ $post[2] }}</h3>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-500">{{ $post[3] }}</span>
                    <span class="text-xs text-gray-500">{{ $post[4] }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</section>
@endsection