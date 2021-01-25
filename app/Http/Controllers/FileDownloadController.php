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

        // Prevent downloading private files, except by the logged-in owner
        if (!$file->public && ($file->user_id !== auth()->id() || auth()->guest())) {
            abort(404);
        }

        if (Storage::disk($file->disk)->exists($file->path())) {
            $headers = [
                'Content-Type' => $file->mime ?? 'application/octet-stream',
                'Content-Length' => $file->size,
                'Content-Disposition' => "attachment; filename=\"{$file->name}\"",
            ];

            $file->trackDownload($request);
            // TODO emit Livewire event to update the download count without refreshing the page

            return response()->streamDownload(function () use ($file) {
                echo Storage::disk($file->disk)->get($file->path());
            }, $file->name, $headers);
        } else {
            abort(404);
        }
    }
}
