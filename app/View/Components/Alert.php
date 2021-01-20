<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $type;

    public function __construct(string $type = 'success')
    {
        $this->type = $type;
    }

    public function render()
    {
        return view('components.alert');
    }
}
