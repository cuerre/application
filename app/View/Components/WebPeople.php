<?php

namespace App\View\Components;

use Illuminate\View\Component;

class WebPeople extends Component
{
    /**
     * Person picture
     * @var String
     */
    public $picture;

    /**
     * Person name
     * @var String
     */
    public $name;

    /**
     * Person description
     * @var String
     */
    public $description;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($picture = null, $name = null, $description = null)
    {
        $this->picture     = $picture;
        $this->name        = $name;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.web-people',[
            'picture'     => $this->picture,
            'name'        => $this->name,
            'description' => $this->description 
        ]);
    }
}
