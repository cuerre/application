<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Box extends Component
{
    /**
     * Extra classes for this component
     * 
     * @var string 
     */
    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct( $class = null )
    {
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.box', [
            'class' => $this->class
        ]);
    }
}
