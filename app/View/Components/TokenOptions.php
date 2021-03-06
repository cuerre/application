<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TokenOptions extends Component
{
    /**
     * Token id
     * @var
     */
    public $id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct( $id )
    {
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.token-options', [
            'id' => $this->id
        ]);
    }
}
