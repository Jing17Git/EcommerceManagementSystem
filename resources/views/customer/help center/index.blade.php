@extends('layouts.app')

@section('title', 'Help Center')

@section('content')

{{-- HERO --}}
<section class="bg-[#1c1e38] border-b border-orange-500/10 px-6 md:px-14 py-16 relative overflow-hidden">
    {{-- glow --}}
    <div class="absolute -top-16 -right-16 w-72 h-72 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <span class="inline-block bg-orange-500/15 text-orange-400 text-xs font-semibold tracking-widest uppercase px-4 py-1 rounded-full border border-orange-500/25 mb-4">
        Help Center
    </span>
    <h1 class="text-4xl font-bold text-white leading-tight mb-3">How can we<br>help you?</h1>
    <p class="text-gray-400 text-base max-w-xl leading-relaxed">
        Browse our frequently asked questions, guides, and support articles to find quick answers.
    </p>
</section>

{{-- TOPIC CARDS --}}
<section class="px-6 md:px-14 py-12">
    <h2 class="text-lg font-semibold text-white mb-1">Browse by Topic</h2>
    <div class="w-9 h-0.5 bg-orange-500 rounded mb-6"></div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-14">

        <a href="{{ route('shipping.info') }}"
           class="bg-[#1c1e38] border border-white/5 rounded-2xl p-7 hover:border-orange-500/30 hover:-translate-y-1 hover:shadow-xl transition-all duration-200 group">
            <div class="w-11 h-11 bg-orange-500/10 border border-orange-500/20 rounded-xl flex items-center justify-center text-xl mb-5">🚚</div>
            <h3 class="text-white font-semibold mb-2">Shipping & Delivery</h3>
            <p class="text-gray-400 text-sm leading-relaxed">Delivery timelines, shipping rates, and carrier tracking.</p>
        </a>

        <a href="{{ route('returns') }}"
           class="bg-[#1c1e38] border border-white/5 rounded-2xl p-7 hover:border-orange-500/30 hover:-translate-y-1 hover:shadow-xl transition-all duration-200 group">
            <div class="w-11 h-11 bg-orange-500/10 border border-orange-500/20 rounded-xl flex items-center justify-center text-xl mb-5">↩️</div>
            <h3 class="text-white font-semibold mb-2">Returns & Refunds</h3>
            <p class="text-gray-400 text-sm leading-relaxed">Return policies, eligibility, and refund timelines.</p>
        </a>

        <div class="bg-[#1c1e38] border border-white/5 rounded-2xl p-7 hover:border-orange-500/30 hover:-translate-y-1 hover:shadow-xl transition-all duration-200 cursor-pointer">
            <div class="w-11 h-11 bg-orange-500/10 border border-orange-500/20 rounded-xl flex items-center justify-center text-xl mb-5">💳</div>
            <h3 class="text-white font-semibold mb-2">Payments & Billing</h3>
            <p class="text-gray-400 text-sm leading-relaxed">Accepted methods, failed transactions, and invoices.</p>
        </div>

        <div class="bg-[#1c1e38] border border-white/5 rounded-2xl p-7 hover:border-orange-500/30 hover:-translate-y-1 hover:shadow-xl transition-all duration-200 cursor-pointer">
            <div class="w-11 h-11 bg-orange-500/10 border border-orange-500/20 rounded-xl flex items-center justify-center text-xl mb-5">🔐</div>
            <h3 class="text-white font-semibold mb-2">Account & Security</h3>
            <p class="text-gray-400 text-sm leading-relaxed">Manage your account, reset password, update details.</p>
        </div>

        <div class="bg-[#1c1e38] border border-white/5 rounded-2xl p-7 hover:border-orange-500/30 hover:-translate-y-1 hover:shadow-xl transition-all duration-200 cursor-pointer">
            <div class="w-11 h-11 bg-orange-500/10 border border-orange-500/20 rounded-xl flex items-center justify-center text-xl mb-5">🛍️</div>
            <h3 class="text-white font-semibold mb-2">Orders & Cancellations</h3>
            <p class="text-gray-400 text-sm leading-relaxed">Modify orders, cancellation window, and order history.</p>
        </div>

        <a href="{{ route('contact') }}"
           class="bg-[#1c1e38] border border-white/5 rounded-2xl p-7 hover:border-orange-500/30 hover:-translate-y-1 hover:shadow-xl transition-all duration-200 group">
            <div class="w-11 h-11 bg-orange-500/10 border border-orange-500/20 rounded-xl flex items-center justify-center text-xl mb-5">🎧</div>
            <h3 class="text-white font-semibold mb-2">Talk to Support</h3>
            <p class="text-gray-400 text-sm leading-relaxed">Reach our team directly via email, phone, or walk-in.</p>
        </a>

    </div>

    {{-- FAQ --}}
    <h2 class="text-lg font-semibold text-white mb-1">Frequently Asked Questions</h2>
    <div class="w-9 h-0.5 bg-orange-500 rounded mb-6"></div>

    <div class="space-y-3" x-data="{ open: null }">

        @foreach ([
            ['q' => 'How do I place an order?',
             'a' => 'Browse our catalog, add items to your cart, proceed to checkout, and select your preferred payment method. You\'ll receive an order confirmation via email within a few minutes.'],
            ['q' => 'Can I change my order after placing it?',
             'a' => 'Orders can be modified within 1 hour of placement. After that window, the order enters processing and changes may not be possible. Please contact us immediately if you need to make adjustments.'],
            ['q' => 'Do you offer Cash on Delivery (COD)?',
             'a' => 'Yes! COD is available for orders within Metro Manila and select provincial areas. A COD fee of ₱50 applies. COD is not available for orders exceeding ₱10,000.'],
            ['q' => 'What payment methods do you accept?',
             'a' => 'We accept GCash, Maya, credit/debit cards (Visa & Mastercard), online banking, and Cash on Delivery. All online payments are secured and encrypted.'],
            ['q' => 'My item arrived damaged. What should I do?',
             'a' => 'Take clear photos of the damaged item and packaging, then contact our support team within 48 hours of delivery. We\'ll arrange a replacement or refund at no cost to you.'],
        ] as $i => $faq)

        <div class="bg-[#1c1e38] border border-white/5 rounded-xl overflow-hidden">
            <button
                class="w-full flex justify-between items-center px-6 py-5 text-left text-sm font-medium transition hover:bg-orange-500/5"
                :class="open === {{ $i }} ? 'text-orange-400' : 'text-white'"
                @click="open = open === {{ $i }} ? null : {{ $i }}">
                <span>{{ $faq['q'] }}</span>
                <svg class="w-4 h-4 shrink-0 ml-4 text-gray-400 transition-transform duration-300"
                     :class="open === {{ $i }} ? 'rotate-180 text-orange-400' : ''"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="open === {{ $i }}"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-cloak>
                <p class="px-6 pb-5 text-sm text-gray-400 leading-relaxed">{{ $faq['a'] }}</p>
            </div>
        </div>

        @endforeach
    </div>
</section>

@endsection