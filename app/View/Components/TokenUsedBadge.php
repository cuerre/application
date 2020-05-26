<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TokenUsedBadge extends Component
{
    /**
     * The token to check
     * 
     * @var string
     */
    public $token;

    /**
     * The token's rate limit
     * 
     * @var string
     */
    public $rateLimit;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct( $token = null, $rateLimit = null )
    {
        $this->token     = $token;
        $this->rateLimit = $rateLimit;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.token-used-badge',[
            'token'     => $this->token,
            'rateLimit' => $this->rateLimit,
        ]);
    }
}
