<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CardHeader extends Component
{
    /**
     * The hint on top
     *
     * @var string
     */
    public $hint;
    
    /**
     * The big title
     *
     * @var string
     */
    public $title;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $hint=null)
    {
        $this->hint  = $hint;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.card-header',[
            'title' => $this->title,
            'hint'  => $this->hint
        ]);
    }
}
