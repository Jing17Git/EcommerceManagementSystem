@extends('layouts.app')

@section('title', 'Terms of Service')

@section('content')

<section class="bg-[#1c1e38] border-b border-orange-500/10 px-6 md:px-14 py-16 relative overflow-hidden">
    <div class="absolute -top-16 -right-16 w-72 h-72 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <span class="inline-block bg-orange-500/15 text-orange-400 text-xs font-semibold tracking-widest uppercase px-4 py-1 rounded-full border border-orange-500/25 mb-4">Legal</span>
    <h1 class="text-4xl font-bold text-white leading-tight mb-3">Terms of Service</h1>
    <p class="text-gray-400 text-base max-w-xl leading-relaxed">Last updated: January 1, 2025</p>
</section>

<section class="px-6 md:px-14 py-12 max-w-4xl mx-auto">
    <div class="bg-[#1c1e38] border border-orange-500/20 rounded-2xl p-6 mb-10 flex gap-4">
        <div class="text-2xl">📋</div>
        <div>
            <h3 class="text-white font-semibold mb-1">Please read these terms carefully</h3>
            <p class="text-gray-400 text-sm leading-relaxed">By accessing or using Local Works, you agree to be bound by these Terms of Service. If you do not agree to these terms, please do not use our platform.</p>
        </div>
    </div>

    @foreach ([
        ['1. Acceptance of Terms', 'By creating an account or making a purchase on Local Works, you confirm that you are at least 18 years old (or have parental consent), that you have read and agree to these Terms of Service, and that the information you provide is accurate and complete.'],
        ['2. Use of the Platform', 'You may use Local Works for lawful purposes only. You agree not to engage in any activity that interferes with or disrupts the platform, attempt to gain unauthorized access to any part of the service, use automated tools to scrape or extract data, post false, misleading, or fraudulent content, or violate any applicable local, national, or international laws.'],
        ['3. Purchases & Payments', 'All prices are listed in Philippine Pesos (₱) and are inclusive of applicable taxes. Payment must be completed at the time of purchase. We accept GCash, Maya, Visa, Mastercard, and Cash on Delivery (COD) for eligible orders. We reserve the right to cancel orders in cases of pricing errors or suspected fraud.'],
        ['4. Seller Responsibilities', 'Sellers on Local Works are responsible for accurately describing their products, fulfilling orders in a timely manner, maintaining product quality and authenticity, complying with all applicable laws regarding the sale of their products, and handling customer inquiries professionally.'],
        ['5. Returns & Refunds', 'Our return and refund policy is outlined in our Returns & Refunds page. By making a purchase, you agree to the terms of that policy. Disputes between buyers and sellers will be mediated by Local Works support.'],
        ['6. Intellectual Property', 'All content on Local Works — including logos, text, graphics, and software — is the property of Local Works or its content suppliers and is protected by Philippine and international copyright laws. You may not reproduce or distribute any content without written permission.'],
        ['7. Limitation of Liability', 'Local Works shall not be liable for any indirect, incidental, special, or consequential damages arising from your use of the platform. Our total liability to you for any claim shall not exceed the amount you paid for the transaction giving rise to the claim.'],
        ['8. Termination', 'We reserve the right to suspend or terminate your account at any time for violation of these terms, fraudulent activity, or any behavior deemed harmful to our community. You may also delete your account at any time by contacting support.'],
        ['9. Governing Law', 'These Terms of Service are governed by the laws of the Republic of the Philippines. Any disputes shall be subject to the exclusive jurisdiction of the courts of Manila, Philippines.'],
        ['10. Changes to Terms', 'We may modify these terms at any time. Continued use of the platform after changes constitutes acceptance of the updated terms. We will notify registered users of significant changes via email.'],
    ] as $i => [$title, $body])
    <div class="mb-8">
        <h2 class="text-lg font-semibold text-white mb-3 flex items-center gap-3">
            <span class="w-7 h-7 bg-orange-500/15 text-orange-400 rounded-lg flex items-center justify-center text-xs font-bold border border-orange-500/20">{{ $i + 1 }}</span>
            {{ $title }}
        </h2>
        <p class="text-gray-400 text-sm leading-relaxed pl-10">{{ $body }}</p>
    </div>
    @endforeach

    <div class="border-t border-white/5 pt-8 mt-4">
        <p class="text-gray-400 text-sm">Questions about these terms? <a href="{{ route('contact') }}" class="text-orange-400 hover:underline">Contact us</a> at support@localworks.ph</p>
    </div>

</section>

@endsection