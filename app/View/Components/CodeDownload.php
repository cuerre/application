<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CodeDownload extends Component
{
    /**
     * QR id
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
        return view('components.code-download', [
            'id' => $this->id
        ]);
    }
}
