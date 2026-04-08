<x-admin-layout>
<x-slot name="header">Cookie Consent Settings</x-slot>

<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6">Cookie Consent Popup Settings</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.cookie-consent.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-6 p-4 border rounded">
            <div class="flex items-center mb-4">
                <input type="checkbox" name="is_enabled" id="is_enabled" value="1" {{ ($cookie->is_enabled ?? true) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                <label for="is_enabled" class="ml-2 text-sm font-medium">Enable Cookie Consent Popup</label>
            </div>
        </div>

        <div class="mb-6 p-4 border rounded">
            <h3 class="text-lg font-semibold mb-4">Popup Content</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Title</label>
                    <input type="text" name="title" value="{{ $cookie->title ?? 'We use cookies' }}" class="w-full px-3 py-2 border rounded" required>
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Message</label>
                    <textarea name="message" rows="4" class="w-full px-3 py-2 border rounded" required>{{ $cookie->message ?? 'We use cookies to enhance your browsing experience, serve personalized content, and analyze our traffic. By clicking "Accept All", you consent to our use of cookies.' }}</textarea>
                    @error('message')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Accept Button Text</label>
                        <input type="text" name="accept_button_text" value="{{ $cookie->accept_button_text ?? 'Accept All' }}" class="w-full px-3 py-2 border rounded" required>
                        @error('accept_button_text')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Decline Button Text</label>
                        <input type="text" name="decline_button_text" value="{{ $cookie->decline_button_text ?? 'Decline' }}" class="w-full px-3 py-2 border rounded" required>
                        @error('decline_button_text')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Save Changes</button>
        </div>
    </form>
</div>
</x-admin-layout>
