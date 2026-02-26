@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')

{{-- HERO --}}
<section class="bg-[#1c1e38] border-b border-orange-500/10 px-6 md:px-14 py-16 relative overflow-hidden">
    <div class="absolute -top-16 -right-16 w-72 h-72 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <span class="inline-block bg-orange-500/15 text-orange-400 text-xs font-semibold tracking-widest uppercase px-4 py-1 rounded-full border border-orange-500/25 mb-4">
        Contact Us
    </span>
    <h1 class="text-4xl font-bold text-white leading-tight mb-3">Get in touch<br>with us</h1>
    <p class="text-gray-400 text-base max-w-xl leading-relaxed">
        Our support team is ready to help you Mon–Sat, 9AM to 7PM. Expect a response within 24 hours.
    </p>
</section>

<section class="px-6 md:px-14 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

        {{-- FORM --}}
        <div>
            <h2 class="text-lg font-semibold text-white mb-1">Send a Message</h2>
            <div class="w-9 h-0.5 bg-orange-500 rounded mb-7"></div>

            <form action="{{ route('contact.send') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Your Name</label>
                    <input type="text" name="name" placeholder="Juan Dela Cruz" required
                        class="w-full bg-[#1c1e38] border border-white/8 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-500 focus:outline-none focus:border-orange-500/50 transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Email Address</label>
                    <input type="email" name="email" placeholder="juan@email.com" required
                        class="w-full bg-[#1c1e38] border border-white/8 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-500 focus:outline-none focus:border-orange-500/50 transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Subject</label>
                    <select name="subject"
                        class="w-full bg-[#1c1e38] border border-white/8 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-orange-500/50 transition">
                        <option value="">-- Select a topic --</option>
                        <option>Order Issue</option>
                        <option>Shipping & Delivery</option>
                        <option>Returns & Refunds</option>
                        <option>Payment Problem</option>
                        <option>Product Inquiry</option>
                        <option>Other</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Message</label>
                    <textarea name="message" rows="5" placeholder="Describe your concern in detail..." required
                        class="w-full bg-[#1c1e38] border border-white/8 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-500 focus:outline-none focus:border-orange-500/50 transition resize-y"></textarea>
                </div>

                @if(session('success'))
                    <div class="bg-green-500/10 border border-green-500/25 text-green-400 text-sm rounded-xl px-4 py-3">
                        {{ session('success') }}
                    </div>
                @endif

                <button type="submit"
                    class="bg-orange-500 hover:bg-orange-400 text-white font-semibold text-sm px-8 py-3 rounded-xl transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-orange-500/30">
                    Send Message
                </button>
            </form>
        </div>

        {{-- CONTACT DETAILS --}}
        <div>
            <h2 class="text-lg font-semibold text-white mb-1">Our Contact Details</h2>
            <div class="w-9 h-0.5 bg-orange-500 rounded mb-7"></div>

            <div class="bg-[#1c1e38] border border-white/5 rounded-2xl divide-y divide-white/5">

                <div class="flex gap-4 p-6">
                    <div class="w-10 h-10 bg-orange-500/10 border border-orange-500/20 rounded-xl flex items-center justify-center text-lg shrink-0">📍</div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Address</p>
                        <p class="text-white text-sm">123 Artisan Street, Manila,<br>Philippines 1001</p>
                    </div>
                </div>

                <div class="flex gap-4 p-6">
                    <div class="w-10 h-10 bg-orange-500/10 border border-orange-500/20 rounded-xl flex items-center justify-center text-lg shrink-0">📞</div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Phone</p>
                        <p class="text-white text-sm">+63 912 345 6789</p>
                    </div>
                </div>

                <div class="flex gap-4 p-6">
                    <div class="w-10 h-10 bg-orange-500/10 border border-orange-500/20 rounded-xl flex items-center justify-center text-lg shrink-0">✉️</div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Email</p>
                        <p class="text-white text-sm">support@localworks.ph</p>
                    </div>
                </div>

                <div class="flex gap-4 p-6">
                    <div class="w-10 h-10 bg-orange-500/10 border border-orange-500/20 rounded-xl flex items-center justify-center text-lg shrink-0">🕐</div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Business Hours</p>
                        <p class="text-white text-sm">Mon – Sat: 9AM – 7PM</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection