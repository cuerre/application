<footer class="container-fluid bg-light mt-5 ">
    <div class="container text-muted pt-3">
        <div class="row p-3 justify-content-center">
            <div class="col-auto mr-auto">
                <span class="font-weight-bolder">{{ __('Company') }}</span>
                <a href="/about" class="d-block small text-muted">{{ __('About') }}</a>
                <a href="/dashboard/support" class="d-block small text-muted">{{ __('Support') }}</a>
                {{--
                <a href="/press" class="d-block small text-muted">Press</a>
                --}}
            </div>
            <div class="col-auto">
                <span class="font-weight-bolder">{{ __('Community') }}</span>
                <a href="/documentation/donations" class="d-block small text-muted">{{ __('Donations') }}</a>
            </div>
            <div class="col-auto ml-auto">
                <span class="font-weight-bolder">{{ __('Information') }}</span>
                <a href="/documentation/faq" class="d-block small text-muted">{{ __('FAQ') }}</a>
                <a href="/documentation/contracts/terms" class="d-block small text-muted">{{ _('Terms') }}</a>
                <a href="/documentation/contracts/privacy" class="d-block small text-muted">{{ __('Privacy') }}</a>
            </div>
        </div>
        <div class="row text-muted px-3 mb-5">
            <div class="col">
                <img src="{{ asset('imgs/logo-footer.png') }}" style="max-height: 1rem;" class="align-middle mr-2"/>
            </div>
        </div>
    </div>
</footer>