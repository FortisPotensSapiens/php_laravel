<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use Carbon\Carbon;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:524288', // 512 MB in KB
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $extension = $extension ? ".{$extension}" : '.txt';
        $generatedName = Str::random(40) . $extension;
        $path = "files/{$generatedName}";

        Storage::disk('local')->put($path, file_get_contents($file));

        // schedule deletion in 30 days via Laravel Task Scheduling or external cron
        Storage::disk('local')->put("meta/{$generatedName}.json", json_encode([
            'expires_at' => Carbon::now()->addDays(30)->toDateTimeString(),
        ]));

        return response(
            url("/file/{$generatedName}"),
            200
        )->header('X-Delete', url("/delete/{$generatedName}"));
    }

    public function download(string $name)
    {
        $path = "files/{$name}";

        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        $mime = Storage::disk('local')->mimeType($path) ?? 'application/octet-stream';
        return response(Storage::disk('local')->get($path), 200)
            ->header('Content-Type', $mime);
    }

    public function delete(string $name)
    {
        $filePath = "files/{$name}";
        $metaPath = "meta/{$name}.json";

        if (Storage::disk('local')->exists($filePath)) {
            Storage::disk('local')->delete([$filePath, $metaPath]);
            return response()->json(['deleted' => true]);
        }

        return response()->json(['deleted' => false], 404);
    }
}