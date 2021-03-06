<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SubmitButton extends Component
{    
    /**
     * The button content
     *
     * @var string
     */
    public $content;
    
    /**
     * The button size
     *
     * @var string
     */
    public $size;
    
    /**
     * The button block mode
     *
     * @var string
     */
    public $block;
    
    /**
     * The button content
     *
     * @var string
     */
    public $confirmation;

    /**
     * The button color
     *
     * @var string
     */
    public $color;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($content, $size=null, $block=false, $confirmation=null, $color='primary')
    {
        $this->content        = $content;
        $this->size           = $size;
        $this->block          = $block;
        $this->confirmation   = $confirmation;
        $this->color          = $color;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.submit-button',[
            'content'        => $this->content,
            'size'           => $this->size,
            'block'          => $this->block,
            'confirmation'   => $this->confirmation,
            'color'          => $this->color,
        ]);
    }
}
