<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DashboardMenu extends Component
{
    /**
     * Header on the top.
     *
     * @var string
     */
    public $header;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($header)
    {
        //
        $this->header = $header;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.dashboard-menu', [
            'header' => $this->header
        ]);
    }
}
