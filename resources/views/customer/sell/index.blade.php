@extends('layouts.app')
@section('title', 'Sell on Local Works')
@section('content')

<section class="bg-[#1c1e38] border-b border-orange-500/10 px-6 md:px-14 py-16 relative overflow-hidden">
    <div class="absolute -top-16 -right-16 w-72 h-72 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <span class="inline-block bg-orange-500/15 text-orange-400 text-xs font-semibold tracking-widest uppercase px-4 py-1 rounded-full border border-orange-500/25 mb-4">Sell With Us</span>
    <h1 class="text-4xl font-bold text-white leading-tight mb-3">Turn your craft<br>into a business</h1>
    <p class="text-gray-400 text-base max-w-xl leading-relaxed">Join hundreds of Filipino artisans already selling on Local Works. Set up your shop in minutes and reach thousands of customers nationwide.</p>
    <a href="{{ route('register') }}" class="inline-block mt-6 bg-orange-500 hover:bg-orange-400 text-white font-semibold px-8 py-3 rounded-xl transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-orange-500/30">
        Start Selling Today
    </a>
</section>

<section class="px-6 md:px-14 py-12 max-w-5xl mx-auto">

    {{-- BENEFITS --}}
    <h2 class="text-lg font-semibold text-white mb-1">Why sell on Local Works?</h2>
    <div class="w-9 h-0.5 bg-orange-500 rounded mb-6"></div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-14">
        @foreach ([
            ['🚀', 'Easy Setup',         'Create your seller account and list your first product in under 10 minutes. No technical skills needed.'],
            ['📦', 'We Handle Logistics', 'We partner with J&T, LBC, and Ninja Van so you can focus on crafting while we handle delivery coordination.'],
            ['💰', 'Low Fees',            'We charge only a small commission per sale. No monthly fees, no listing fees. You only pay when you earn.'],
            ['📊', 'Sales Dashboard',     'Track your orders, revenue, and customer reviews all in one easy-to-use seller dashboard.'],
            ['🎯', 'Built-in Marketing',  'Your products get featured in our homepage, newsletters, and social media channels at no extra cost.'],
            ['🤝', 'Seller Support',      'Dedicated seller support team available Mon–Sat 9AM–7PM to help you grow your business.'],
        ] as $b)
        <div class="bg-[#1c1e38] border border-white/5 rounded-2xl p-7 hover:border-orange-500/30 hover:-translate-y-1 transition-all duration-200">
            <div class="w-11 h-11 bg-orange-500/10 border border-orange-500/20 rounded-xl flex items-center justify-center text-xl mb-5">{{ $b[0] }}</div>
            <h3 class="text-white font-semibold mb-2">{{ $b[1] }}</h3>
            <p class="text-gray-400 text-sm leading-relaxed">{{ $b[2] }}</p>
        </div>
        @endforeach
    </div>

    {{-- HOW IT WORKS --}}
    <h2 class="text-lg font-semibold text-white mb-1">How It Works</h2>
    <div class="w-9 h-0.5 bg-orange-500 rounded mb-8"></div>
    <div class="relative mb-14">
        <div class="absolute left-[18px] top-10 bottom-10 w-0.5 bg-orange-500/15 rounded"></div>
        @foreach ([
            ['1', 'Create Your Account',   'Register as a seller using your email. Verify your identity and provide your business details.'],
            ['2', 'Set Up Your Shop',       'Add your shop name, description, and profile photo. Tell customers your story.'],
            ['3', 'List Your Products',     'Upload photos, set prices, and write descriptions for each of your handcrafted items.'],
            ['4', 'Start Receiving Orders', 'Customers browse and purchase your products. You get notified instantly via email and SMS.'],
            ['5', 'Get Paid',               'Payments are released to your GCash or bank account within 3–5 business days after order completion.'],
        ] as $step)
        <div class="flex gap-5 mb-8 last:mb-0 relative">
            <div class="w-9 h-9 min-w-9 bg-orange-500/10 border-2 border-orange-500/30 rounded-full flex items-center justify-center text-orange-400 font-bold text-sm z-10">{{ $step[0] }}</div>
            <div class="pt-1">
                <h4 class="text-white font-semibold text-sm mb-1">{{ $step[1] }}</h4>
                <p class="text-gray-400 text-sm leading-relaxed">{{ $step[2] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- CTA --}}
    <div class="bg-gradient-to-r from-orange-500/20 to-orange-600/10 border border-orange-500/25 rounded-2xl p-10 text-center">
        <h3 class="text-white font-bold text-2xl mb-3">Ready to start selling?</h3>
        <p class="text-gray-400 text-sm mb-6 max-w-md mx-auto">Join our growing community of local artisans and reach thousands of customers who love handmade products.</p>
        <a href="{{ route('register') }}" class="inline-block bg-orange-500 hover:bg-orange-400 text-white font-semibold px-8 py-3 rounded-xl transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-orange-500/30">
            Create Seller Account
        </a>
    </div>

</section>
@endsection