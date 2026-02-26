@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('content')

<section class="bg-[#1c1e38] border-b border-orange-500/10 px-6 md:px-14 py-16 relative overflow-hidden">
    <div class="absolute -top-16 -right-16 w-72 h-72 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <span class="inline-block bg-orange-500/15 text-orange-400 text-xs font-semibold tracking-widest uppercase px-4 py-1 rounded-full border border-orange-500/25 mb-4">Legal</span>
    <h1 class="text-4xl font-bold text-white leading-tight mb-3">Privacy Policy</h1>
    <p class="text-gray-400 text-base max-w-xl leading-relaxed">Last updated: January 1, 2025</p>
</section>

<section class="px-6 md:px-14 py-12 max-w-4xl mx-auto">
    <div class="bg-[#1c1e38] border border-orange-500/20 rounded-2xl p-6 mb-10 flex gap-4">
        <div class="text-2xl">🔒</div>
        <div>
            <h3 class="text-white font-semibold mb-1">Your privacy matters to us</h3>
            <p class="text-gray-400 text-sm leading-relaxed">Local Works is committed to protecting your personal information. This policy explains what data we collect, how we use it, and your rights over it.</p>
        </div>
    </div>

    @foreach ([
        ['1. Information We Collect', 'We collect information you provide directly to us, such as your name, email address, shipping address, and payment details when you create an account or place an order. We also automatically collect certain information when you visit our site, including your IP address, browser type, and browsing behavior through cookies and similar technologies.'],
        ['2. How We Use Your Information', 'We use the information we collect to process your orders and payments, send order confirmations and shipping updates, respond to your comments and questions, send promotional communications (with your consent), improve our website and services, and comply with legal obligations.'],
        ['3. Sharing Your Information', 'We do not sell, trade, or rent your personal information to third parties. We may share your information with trusted service providers who assist us in operating our website and conducting our business, such as payment processors (GCash, Maya, Visa/Mastercard) and shipping couriers (J&T Express, LBC, Ninja Van). These parties are bound by confidentiality agreements.'],
        ['4. Data Security', 'We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. All payment transactions are encrypted using SSL technology. However, no method of transmission over the internet is 100% secure.'],
        ['5. Cookies', 'We use cookies to enhance your browsing experience, remember your preferences, and analyze site traffic. You can choose to disable cookies through your browser settings, but this may affect the functionality of certain parts of our website.'],
        ['6. Your Rights', 'You have the right to access, correct, or delete your personal information at any time. You may also opt out of marketing communications by clicking "unsubscribe" in any email we send. To exercise these rights, please contact us at support@localworks.ph.'],
        ['7. Children\'s Privacy', 'Our website is not directed to children under the age of 13. We do not knowingly collect personal information from children. If you believe we have inadvertently collected information from a child, please contact us immediately.'],
        ['8. Changes to This Policy', 'We may update this Privacy Policy from time to time. We will notify you of any significant changes by posting the new policy on this page and updating the "Last updated" date. Your continued use of our services after any changes constitutes your acceptance of the new policy.'],
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
        <p class="text-gray-400 text-sm">Questions about this policy? <a href="{{ route('contact') }}" class="text-orange-400 hover:underline">Contact us</a> at support@localworks.ph</p>
    </div>

</section>

@endsection