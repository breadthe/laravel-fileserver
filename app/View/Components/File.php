<?php

namespace App\View\Components;

use Illuminate\View\Component;

class File extends Component
{
    public $file;

    public function __construct(\App\Models\File $file)
    {
        $this->file = $file;
    }

    public function render()
    {
        return view('components.file');
    }
}
