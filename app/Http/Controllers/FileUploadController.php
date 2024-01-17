<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            "file" => "required_without:image|file",
            "image" => "required_without:file|image",
        ]);

        $path = false;
        if ($file = $request->file("file") ?? $request->file("image")) {
            if ($file instanceof UploadedFile) {
                $path = $file->store("files", "public");
            }
        }

        if ($path) {
            return response()->json([
                "success" => 1,
                "file" => [
                    "url" => Storage::url($path),
                ],
            ]);
        } else {
            return response()->json([
                "success" => 0,
                "file" => [
                    "url" => "",
                ],
            ]);
        }
    }

    public function destroy(Request $request): void
    {
        $request->validate([
            "path" => "required|string",
        ]);

        /** @var string */
        $path = $request->path;

        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }
}
