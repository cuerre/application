<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LinkButton extends Component
{
    /**
     * The prepend icon
     *
     * @var string
     */
    public $icon;

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
     * The menu content
     *
     * @var string
     */
    public $content;
    
    /**
     * The destination
     *
     * @var string
     */
    public $link;

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
    public function __construct($icon=null, $content, $link, $size=null, $block=false, $color='primary')
    {
        //
        $this->icon    = $icon;
        $this->content = $content;
        $this->link    = $link;
        $this->size    = $size;
        $this->block   = $block;
        $this->color   = $color;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.link-button',[
            'icon'    => $this->icon,
            'content' => $this->content,
            'link'    => $this->link,
            'size'    => $this->size,
            'block'   => $this->block,
            'color'   => $this->color,
        ]);
    }
}
