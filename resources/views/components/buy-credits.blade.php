<x-box>
    <x-box-header>
        {{ __('Buy credits') }}
    </x-box-header>
    
    <p class="text-break text-muted mb-4">
        {{ __('We trust PayPal as provider because it is safer than others for our customers.') }} 
        {{ __('Use your Paypal account or a credit card into PayPal to get credits.') }} 
    </p>

    <form method="POST" action="{{ route('payment') }}">
        @csrf

        {{-- Name --}}
        <x-input
            name="credits" 
            type="text" 
            :pre="__('Enter EUR amount')">
        </x-input>

        {{-- Submit button --}}
        <div class="d-flex justify-content-end">
            <x-submit-button 
                content="Continue to PayPal">
            </x-submit-button>
        </div>
    </form>

</x-box>