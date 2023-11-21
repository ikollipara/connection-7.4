<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required_without:image|file',
            'image' => 'required_without:file|image'
        ]);

        $path = ($request->file('file') ?? $request->file('image'))->store('public/files');
        if ($path) {
            return response()->json([
                'success' => 1,
                'file' => [
                    'url' => $path,
                ],
            ]);
        } else {
            return response()->json([
                'success' => 0,
                'file' => [
                    'url' => '',
                ],
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        $path = $request->path;

        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }
}
