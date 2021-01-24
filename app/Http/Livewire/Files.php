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
        $file = File::where([
            'user_id' => auth()->id(),
            'uuid' => $uuid,
        ])->firstOrFail();

        try {
            Storage::disk($file->disk)->delete($file->path);
            File::destroy($file->id);
            session()->flash('message', 'File successfully deleted.');
        } catch (\Exception $e) {
            session()->flash('error', "Error deleting file from disk \"{$this->storageDisk}\": {$e->getMessage()}");
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
