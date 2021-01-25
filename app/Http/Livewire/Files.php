<?php

namespace App\Http\Livewire;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Files extends Component
{
    public $files;

    protected $listeners = ['newFileUploaded' => 'getFiles', 'deleteFile' => 'delete'];

    public function delete(string $uuid)
    {
        // Locate the file
        $file = File::where([
            'user_id' => auth()->id(),
            'uuid' => $uuid,
        ])->firstOrFail();

        try {
            // Remove it from disk
            Storage::disk($file->disk)->delete($file->path());

            // Remove it from the DB
            $file->delete();

            session()->flash('message', 'File successfully deleted.');
        } catch (\Exception $e) {
            session()->flash('error', "Error deleting file from disk \"{$file->disk}\": {$e->getMessage()}");
        }
    }

    public function render()
    {
        $this->getFiles();

        return view('livewire.files');
    }

    public function getFiles() {
        $this->files = auth()->user()->files()->withCount('downloads')->orderByDesc('created_at')->get();
    }
}
