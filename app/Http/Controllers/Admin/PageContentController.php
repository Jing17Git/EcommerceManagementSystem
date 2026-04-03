<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;

class PageContentController extends Controller
{
    public function index()
    {
        $contents = PageContent::orderBy('page')->orderBy('section')->get()->groupBy('page');
        return view('admin.page-contents.index', compact('contents'));
    }

    public function edit($page)
    {
        $contents = PageContent::where('page', $page)
            ->orderBy('section')
            ->orderBy('key')
            ->get()
            ->groupBy('section');
        
        return view('admin.page-contents.edit', compact('page', 'contents'));
    }

    public function update(Request $request, $page)
    {
        $validated = $request->validate([
            'contents' => 'required|array',
            'contents.*.*' => 'required|string'
        ]);

        foreach ($request->contents as $section => $items) {
            foreach ($items as $key => $value) {
                PageContent::updateOrCreate(
                    ['page' => $page, 'section' => $section, 'key' => $key],
                    ['value' => $value]
                );
            }
        }

        return redirect()->route('admin.page-contents.edit', $page)->with('success', 'Content updated successfully!');
    }
}
