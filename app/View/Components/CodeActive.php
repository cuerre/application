<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CodeActive extends Component
{
    /**
     * Active model flag
     * @var
     */
    public $active;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct( $active=true )
    {
        $this->active = $active;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.code-active',[
            'active' => $this->active
        ]);
    }
}
