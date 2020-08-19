<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ActionListItem extends Component
{
    /**
     * The field name bolded.
     *
     * @var string
     */
    public $field;
    
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
    public function __construct($field=null, $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.action-list-item',[
            'field' => $this->field,
            'value' => $this->value
        ]);
    }
}
