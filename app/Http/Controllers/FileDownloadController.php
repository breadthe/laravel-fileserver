<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileDownloadController extends Controller
{
    public function download(Request $request)
    {
        $file = File::where('uuid', $request->uuid)->firstOrFail();
        $path =
            $file->disk === 'local'
                ? $file->path
                : urldecode($file->path); // B2 requires the path to be decoded in order to read it properly

        // Prevent downloading private files, except by the logged-in owner
        if (!$file->public && ($file->user_id !== auth()->id() || auth()->guest())) {
            abort(404);
        }

        if (Storage::disk($file->disk)->exists($path)) {
            $headers = [
                'Content-Type' => $file->mime ?? 'application/octet-stream',
                'Content-Length' => Storage::disk($file->disk)->size($path),
                'Content-Disposition' => "attachment; filename=\"{$file->name}\"",
            ];

            $file->trackDownload($request);
            // TODO emit Livewire event to update the download count without refreshing the page

            return response()->streamDownload(function () use ($file, $path) {
                echo Storage::disk($file->disk)->get($path);
            }, $file->name, $headers);
        } else {
            abort(404);
        }
    }
}
