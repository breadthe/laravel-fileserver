<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Files extends Component
{
    public function __construct()
    {
        //
    }

    public function render()
    {
        $files = auth()->user()->files()->orderByDesc('created_at')->get();

        return view('components.files', compact('files'));
    }
}
