<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    /**
     * Serve product image files from the public disk without requiring storage symlink.
     */
    public function show(string $path)
    {
        $path = ltrim($path, '/');

        if (!str_starts_with($path, 'products/')) {
            abort(404);
        }

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return response()->file(Storage::disk('public')->path($path));
    }
}
