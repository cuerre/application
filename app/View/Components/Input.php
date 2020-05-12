<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    /**
     * The type.
     *
     * @var string
     */
    public $type;
    
    /**
     * The name.
     *
     * @var string
     */
    public $name;
    
    /**
     * The placeholder.
     *
     * @var string
     */
    public $pre;
    
    /**
     * The label.
     *
     * @var string
     */
    public $label;

    /**
     * The value.
     *
     * @var string
     */
    public $value;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $type='text', $pre=null, $label=null, $value=null)
    {
        //
        $this->name   = $name;
        $this->type   = $type;
        $this->pre    = $pre;
        $this->label  = $label;
        $this->value  = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.input',[
            'name'  => $this->name,
            'type'  => $this->type,
            'pre'   => $this->pre,
            'label' => $this->label,
            'value' => $this->value
        ]);
    }
}
