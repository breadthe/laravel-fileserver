<?php

namespace App\Http\Livewire;

use App\Models\File;
use Livewire\Component;
use Livewire\WithFileUploads;

class FileUpload extends Component
{
    use WithFileUploads;

    public $file = null;
    public $storageDisk = 'local'; // files are stored to the local disk by default
    public $isPublic = true; // files are public by default
    public $inputId = 1; // give the file input an id so I can reset it later

    public function save()
    {
        /*$this->validate([
            'file' => 'image|max:1024', // 1MB Max
        ]);*/

        // file path on disk
        $originalFileName = $this->file->getClientOriginalName();
        $fileMime = $this->file->getMimeType(); // Storage::mimeType($path) also works
        $fileSize = $this->file->getSize();

        try {
            $newFile = File::create([
                'user_id' => auth()->id(),
                'public' => $this->isPublic,
                'disk' => $this->storageDisk,
                'name' => $originalFileName,
                'mime' => $fileMime,
                'size' => $fileSize,
            ]);

            $this->file->storeAs(
                $newFile->path(), // folder (path) + file name
                '', // the file name is already in the path
                $this->storageDisk
            );

            $this->emit('newFileUploaded');

            session()->flash('message', "File successfully uploaded to \"{$this->storageDisk}\" disk.");
        } catch (\Exception $e) {
            session()->flash('error', "Error uploading to \"{$this->storageDisk}\" disk: {$e->getMessage()}");
        }

        $this->resetForm();
    }

    // Cancel saving the temporary uploaded file to disk
    public function cancel()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->file = null; // doesn't work, and neither does $this->reset('file')
        $this->storageDisk = 'local';
        $this->isPublic = true;
        $this->inputId++; // workaround for clearing the file input
    }

    public function render()
    {
        return view('livewire.file-upload');
    }
}
