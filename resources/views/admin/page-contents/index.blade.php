<x-admin-layout>
<x-slot name="header">Page Content Management</x-slot>

<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6">Page Content Management</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('admin.page-contents.edit', 'welcome') }}" class="block p-6 bg-blue-50 hover:bg-blue-100 rounded-lg border border-blue-200 transition">
            <h3 class="text-lg font-semibold text-blue-900 mb-2">Welcome Page</h3>
            <p class="text-sm text-blue-700">Edit hero banners, features, and promotional content</p>
        </a>
        
        <a href="{{ route('admin.page-contents.edit', 'buyer-dashboard') }}" class="block p-6 bg-green-50 hover:bg-green-100 rounded-lg border border-green-200 transition">
            <h3 class="text-lg font-semibold text-green-900 mb-2">Buyer Dashboard</h3>
            <p class="text-sm text-green-700">Edit dashboard banners and promotional sections</p>
        </a>
        
        <a href="{{ route('admin.page-contents.edit', 'footer') }}" class="block p-6 bg-purple-50 hover:bg-purple-100 rounded-lg border border-purple-200 transition">
            <h3 class="text-lg font-semibold text-purple-900 mb-2">Footer</h3>
            <p class="text-sm text-purple-700">Edit footer company info, contact details, and social links</p>
        </a>
    </div>
</div>
</x-admin-layout>
