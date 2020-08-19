{{-- cookie-consent --}}
<div class="js-cookie-consent fixed-bottom row justify-content-center py-4 px-3 text-light bg-primary shadow-lg" 
     {{-- style="background: #409CFF;" --}}>

    {{-- cookie-consent__message --}}
    <span class="my-auto">
        {!! trans('cookieConsent::texts.message') !!}
    </span>

    {{-- cookie-consent__agree --}}
    <button class="js-cookie-consent-agree btn btn-light mx-3 my-auto">
        {{ trans('cookieConsent::texts.agree') }}
    </button>

</div>
