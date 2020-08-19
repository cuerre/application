<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Snippet extends Component
{
    /**
     * 
     * Language you are scripting
     */
    public $language;

    /**
     * 
     * Pre defined snippet
     */
    public $snippet;

    /**
     * 
     * Extra CSS classes
     */
    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($language=null, $snippet=null, $class=null)
    {
        $this->language = $language;
        $this->snippet  = $snippet;
        $this->class    = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.snippet',[
            'language' => $this->language,
            'snippet'  => $this->snippet,
            'class'    => $this->class
        ]);
    }
}
