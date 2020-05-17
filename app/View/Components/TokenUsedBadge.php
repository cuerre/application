<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TokenUsedBadge extends Component
{
    /**
     * The date when token was used
     * for last time
     * 
     * @var string
     */
    public $last;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct( $last = null )
    {
        $this->last = $last;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.token-used-badge',[
            'last' => $this->last,
        ]);
    }
}
