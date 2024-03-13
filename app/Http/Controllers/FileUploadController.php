<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Spatie\Image\Image;

class FileUploadController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            "file" => "file|nullable",
            "image" => "image|nullable",
            "url" => "url",
        ]);

        $path = false;
        if ($file = $request->file("file") ?? $request->file("image")) {
            if ($file instanceof UploadedFile) {
                if ($path = $file->store("files", "public")) {
                    // @phpstan-ignore-next-line
                    if (!App::environment("local")) {
                        Log::debug("File uploaded to " . Storage::path($path));
                        $webp_path = Str::beforeLast($path, ".") . ".webp";
                        Log::debug("Converting to webp: $webp_path");
                        Image::load(Storage::path($path))
                            ->format("webp")
                            ->optimize()
                            ->save($webp_path);
                    }
                }
            }
        }

        if ($url = $request->get("url")) {
            $request = Http::get($url);
            if ($request->successful()) {
                $ext = Str::of($request->header("content-type"))
                    ->split("/\//")
                    ->last();
                $path = "files/" . Str::random(40) . "." . $ext;
                if (Storage::disk("public")->put($path, $request->body())) {
                    if (
                        (Str::endsWith($path, ".webp") === false or
                            collect(["png", "jpeg", "jpg"])->contains($ext)) and
                        !App::environment("local")
                    ) {
                        $webp_path = Str::beforeLast($path, ".") . ".webp";
                    }
                    // @phpstan-ignore-next-line
                    Image::load($path)
                        ->format("webp")
                        ->optimize()
                        ->save(Str::beforeLast($path, ".") . ".webp");
                }
            }
        }

        if ($path) {
            return response()->json([
                "success" => 1,
                "file" => [
                    "url" => Storage::url($webp_path ?? $path),
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
