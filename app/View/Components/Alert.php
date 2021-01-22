<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $type = 'success'; // success or info; currently error renders independently, and does not need specifying

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function render()
    {
        return view('components.alert');
    }
}
