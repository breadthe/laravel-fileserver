<?php

namespace App\Http\Livewire;

use Livewire\Component;

class File extends Component
{
    public $file;

    public function render()
    {
        return view('livewire.file');
    }

    public function toggleVisibility()
    {
        $file = \App\Models\File::where(
            [
                'id' => $this->file->id,
                'user_id' => auth()->id(), // check ownership
            ]
        )
            ->firstOrFail();

        $file->update(['public' => !$this->file->public]);

        $this->file = $file; // update the component
    }
}
