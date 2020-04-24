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
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($icon=null, $content, $link)
    {
        //
        $this->icon    = $icon;
        $this->content = $content;
        $this->link    = $link;
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
            'link'    => $this->link
        ]);
    }
}
