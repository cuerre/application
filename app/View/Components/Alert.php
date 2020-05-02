<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * The alert type.
     *
     * @var string
     */
    public $type;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type='warning')
    {
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.alert', [
            'type'    => $this->type
        ]);
    }
}
