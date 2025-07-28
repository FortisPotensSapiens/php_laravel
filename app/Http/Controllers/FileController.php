<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\File;

class FileController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:524288',
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $generatedName = Str::random(40);
        $expiresAt = now()->addDays(30);

        Storage::putFileAs('files', $file, $generatedName);

        $fileRecord = new File();
        $fileRecord->original_name = $originalName;
        $fileRecord->generated_name = $generatedName;
        $fileRecord->expires_at = $expiresAt;
        $fileRecord->save();

        return response(url('/file/' . $generatedName))
            ->header('X-Delete', url('/delete/' . $generatedName));
    }

    public function download($generatedName)
    {
        $file = File::where('generated_name', $generatedName)->firstOrFail();

        return Storage::download('files/' . $file->generated_name, $file->original_name);
    }

    public function delete($generatedName)
    {
        $file = File::where('generated_name', $generatedName)->firstOrFail();

        Storage::delete('files/' . $file->generated_name);

        $file->delete();

        return response('File deleted.');
    }
}
