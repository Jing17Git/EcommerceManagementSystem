@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Home Features</h1>
    <p class="text-gray-600">Manage "Why Choose ShopHub?" section on homepage.</p>
</div>

@if (session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="bg-gradient-to-r from-orange-50 to-orange-25 border border-orange-100 rounded-2xl p-8 shadow-lg mb-8">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl lg:text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent mb-2">Home Features</h2>
            <p class="text-xl text-gray-600 font-medium">Manage dynamic "Why Choose ShopHub?" cards on homepage ✨</p>
        </div>
        <a href="{{ route('admin.home-features.create') }}" class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add New Feature
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 overflow-x-auto">
        @forelse($features as $feature)
        <div class="group bg-white/80 backdrop-blur-sm border border-white/50 rounded-2xl p-6 hover:shadow-2xl hover:border-orange-200 hover:bg-white transition-all duration-300 hover:-translate-y-2 hover:scale-[1.02]">
            <div class="flex items-start gap-4 mb-4">
                <div class="w-14 h-14 {{ $feature->bg_color }} group-hover:{{ Str::replace('text-', '', $feature->icon_color) }}-500 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg ring-1 ring-white/20">
                    <i class="{{ $feature->icon }} {{ $feature->icon_color }} text-xl group-hover:scale-110 transition-transform duration-300"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-xl text-gray-900 mb-2 line-clamp-1 group-hover:text-orange-700 transition-colors">{{ $feature->title }}</h4>
                    <p class="text-gray-600 leading-relaxed line-clamp-3">{{ $feature->description }}</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 items-center">
                <span class="px-3 py-1 {{ $feature->bg_color }} {{ Str::replace('text-', '', $feature->icon_color) }}-600 text-xs font-bold rounded-full border ring-1 ring-white/30 shadow-sm">Live Preview</span>
                <div class="flex items-center gap-1 text-xs font-mono text-gray-500">
                    <span>#{{ $feature->id }}</span>
                    <span>•</span>
                    Pos: {{ $feature->position }}
                </div>
                @if($feature->is_active)
                    <div class="ml-auto flex items-center gap-1">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-xs font-bold text-green-700">Active</span>
                    </div>
                @else
                    <div class="ml-auto flex items-center gap-1">
                        <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                        <span class="text-xs font-bold text-gray-500">Draft</span>
                    </div>
                @endif
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100 flex gap-2">
                <a href="{{ route('admin.home-features.edit', $feature) }}" class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white py-2 px-4 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H8a2 2 0 00-2 2v6a2 2 0 002 2h2v-5l3-2.828 3 2.828V13a1 1 0 01-1 1H8"></path></svg>
                    Edit
                </a>
                <form action="{{ route('admin.home-features.destroy', $feature) }}" method="POST" class="flex-1" onsubmit="return confirm('Delete this feature? Changes on homepage will reflect immediately!')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white py-2 px-4 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-20 bg-gradient-to-br from-orange-50 to-yellow-50 rounded-2xl border-2 border-dashed border-orange-200 p-12">
            <div class="w-24 h-24 bg-gradient-to-br from-orange-400 to-orange-500 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-2xl">
                <i class="fas fa-star text-3xl text-white animate-bounce"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">No Features Yet</h3>
            <p class="text-lg text-gray-600 mb-8 max-w-md mx-auto">Create your first "Why Choose ShopHub?" feature to showcase on homepage!</p>
            <a href="{{ route('admin.home-features.create') }}" class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-10 py-4 rounded-2xl font-bold text-lg shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 inline-flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Create First Feature
            </a>
        </div>
        @endforelse
    </div>

    <div class="mt-12 text-center">
        {{ $features->links() }}
    </div>
</div>
@endsection

