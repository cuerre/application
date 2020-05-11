<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BillingHistory extends Component
{
    /**
     * Last 10 payments
     *
     * @return void
     */
    public $payments;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->payments = Payment::where('user_id', Auth::id())
            ->latest()
            ->limit(10)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.billing-history', [
            'payments' => $this->payments
        ]);
    }
}
