<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeFeature;
use Illuminate\Http\Request;

class HomeFeatureController extends Controller
{
    public function index()
    {
        $features = HomeFeature::orderBy('position')->paginate(10);
        return view('admin.home-features.index', compact('features'));
    }

    public function create()
    {
        return view('admin.home-features.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:50',
            'bg_color' => 'required|string|max:50',
            'icon_color' => 'required|string|max:50',
        ]);

        HomeFeature::create($request->all());

        return redirect()->route('admin.home-features.index')
            ->with('success', 'Feature created successfully.');
    }

    public function edit(HomeFeature $homeFeature)
    {
        return view('admin.home-features.edit', compact('homeFeature'));
    }

    public function update(Request $request, HomeFeature $homeFeature)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:50',
            'bg_color' => 'required|string|max:50',
            'icon_color' => 'required|string|max:50',
        ]);

        $homeFeature->update($request->all());

        return redirect()->route('admin.home-features.index')
            ->with('success', 'Feature updated successfully.');
    }

    public function destroy(HomeFeature $homeFeature)
    {
        $homeFeature->delete();

        return redirect()->route('admin.home-features.index')
            ->with('success', 'Feature deleted successfully.');
    }
}

