<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DashboardTopbar extends Component
{
    /**
     * The sentence on the 
     * left
     * 
     * @var string
     */
    public $sentence;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $sentence = null)
    {
        $this->sentence = $sentence;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.dashboard-topbar', [
            'sentence' => $this->sentence
        ]);
    }
}
