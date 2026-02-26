@extends('layouts.app')
@section('title', 'About Us')
@section('content')

<section class="bg-[#1c1e38] border-b border-orange-500/10 px-6 md:px-14 py-16 relative overflow-hidden">
    <div class="absolute -top-16 -right-16 w-72 h-72 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <span class="inline-block bg-orange-500/15 text-orange-400 text-xs font-semibold tracking-widest uppercase px-4 py-1 rounded-full border border-orange-500/25 mb-4">About Us</span>
    <h1 class="text-4xl font-bold text-white leading-tight mb-3">We're on a mission to<br>support local artisans</h1>
    <p class="text-gray-400 text-base max-w-xl leading-relaxed">Local Works was founded to bridge the gap between talented Filipino craftsmen and customers who value authentic, handmade products.</p>
</section>

<section class="px-6 md:px-14 py-12 max-w-5xl mx-auto">

    {{-- STORY --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16 items-center">
        <div>
            <h2 class="text-lg font-semibold text-white mb-1">Our Story</h2>
            <div class="w-9 h-0.5 bg-orange-500 rounded mb-5"></div>
            <p class="text-gray-400 text-sm leading-relaxed mb-4">Local Works started in 2020 when our founders noticed that skilled local artisans struggled to reach customers beyond their immediate communities. We built this platform to give every craftsman — from weavers in Pampanga to potters in Cebu — a digital storefront to share their work with the world.</p>
            <p class="text-gray-400 text-sm leading-relaxed">Today we support hundreds of local sellers across the Philippines, helping them grow their businesses while preserving traditional crafts and techniques passed down through generations.</p>
        </div>
        <div class="grid grid-cols-2 gap-4">
            @foreach ([
                ['500+', 'Local Artisans'],
                ['12,000+', 'Products Listed'],
                ['8,500+', 'Happy Customers'],
                ['4.9★', 'Average Rating'],
            ] as $stat)
            <div class="bg-[#1c1e38] border border-white/5 rounded-2xl p-6 text-center hover:border-orange-500/30 transition">
                <p class="text-3xl font-bold text-orange-400 mb-1">{{ $stat[0] }}</p>
                <p class="text-gray-400 text-sm">{{ $stat[1] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- VALUES --}}
    <h2 class="text-lg font-semibold text-white mb-1">Our Values</h2>
    <div class="w-9 h-0.5 bg-orange-500 rounded mb-6"></div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-16">
        @foreach ([
            ['🤝', 'Community First',    'Every decision we make considers the impact on our artisan community and their livelihoods.'],
            ['✨', 'Authenticity',        'We verify every seller and product to ensure customers receive genuine handcrafted items.'],
            ['🌱', 'Sustainability',      'We promote eco-conscious practices and support artisans who use sustainable materials.'],
        ] as $v)
        <div class="bg-[#1c1e38] border border-white/5 rounded-2xl p-7 hover:border-orange-500/30 hover:-translate-y-1 transition-all duration-200">
            <div class="w-11 h-11 bg-orange-500/10 border border-orange-500/20 rounded-xl flex items-center justify-center text-xl mb-5">{{ $v[0] }}</div>
            <h3 class="text-white font-semibold mb-2">{{ $v[1] }}</h3>
            <p class="text-gray-400 text-sm leading-relaxed">{{ $v[2] }}</p>
        </div>
        @endforeach
    </div>

    {{-- TEAM --}}
    <h2 class="text-lg font-semibold text-white mb-1">Meet the Team</h2>
    <div class="w-9 h-0.5 bg-orange-500 rounded mb-6"></div>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-5">
        @foreach ([
            ['Maria Santos',   'CEO & Co-founder',     'MS'],
            ['Juan Reyes',     'CTO & Co-founder',     'JR'],
            ['Ana Cruz',       'Head of Operations',   'AC'],
            ['Carlo Mendoza',  'Head of Marketing',    'CM'],
        ] as $member)
        <div class="bg-[#1c1e38] border border-white/5 rounded-2xl p-6 text-center hover:border-orange-500/30 transition">
            <div class="w-14 h-14 bg-orange-500/15 border-2 border-orange-500/30 rounded-full flex items-center justify-center text-orange-400 font-bold text-lg mx-auto mb-4">{{ $member[2] }}</div>
            <h4 class="text-white font-semibold text-sm mb-1">{{ $member[0] }}</h4>
            <p class="text-gray-400 text-xs">{{ $member[1] }}</p>
        </div>
        @endforeach
    </div>

</section>
@endsection