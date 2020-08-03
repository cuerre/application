<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Str;

class CollapsibleBox extends Component
{
    /**
     * A random prefix to be set
     * before the HTML 'id' tag
     * to allow existance of several 
     * collapsible boxes.
     *
     * @var string
     */
    public $prefix;

    /**
     * Extra classes for this
     * component
     *
     * @var string
     */
    public $class;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($class=null)
    {
        //
        $this->class  = $class; 
        $this->prefix = Str::random(20);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.collapsible-box', [
            'prefix' => $this->prefix,
            'class'  => $this->class
        ]);
    }
}
