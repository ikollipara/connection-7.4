<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            "file" => "file|nullable",
            "image" => "image|nullable",
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
        $validated = $request->validate([
            "path" => "required|string",
        ]);

        if (Str::of($validated["path"])->startsWith("/storage/")) {
            $validated["path"] = Str::of($validated["path"])->replace(
                "/storage/",
                "",
            );
        }

        Storage::disk("public")->delete($validated["path"]);
    }
}
