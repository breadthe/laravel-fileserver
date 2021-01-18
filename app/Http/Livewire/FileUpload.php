<?php

namespace App\Http\Livewire;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class FileUpload extends Component
{
    use WithFileUploads;

    public $file;
    public $uploadedFileInfo = null;

    public function save()
    {
        /*$this->validate([
            'file' => 'image|max:1024', // 1MB Max
        ]);*/

        // file path on disk
        $path = $this->file->store('files');
        $originalFileName = $this->file->getClientOriginalName();
        $fileMime = $this->file->getMimeType(); // Storage::mimeType($path) also works
        $fileSize = Storage::size($path); // bytes

        File::create([
            'user_id' => auth()->id(),
            'path' => $path,
            'name' => $originalFileName,
            'mime' => $fileMime,
            'size' => $fileSize,
        ]);
    }

    public function render()
    {
        return view('livewire.file-upload');
    }
}
