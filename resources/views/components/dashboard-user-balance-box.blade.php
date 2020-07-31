{{-- Smartphones & bigger --}}
@push('styles.phone.portrait')
    .dashboard-user-balance-box-wrapper-small {
        display: block;
    }

    .dashboard-user-balance-box-wrapper-large {
        display: none;
    }
@endpush



{{-- Desktop & bigger --}}
@push('styles.large')
    .dashboard-user-balance-box-wrapper-small {
        display: none;
    }

    .dashboard-user-balance-box-wrapper-large {
        display: block;
    }
@endpush



{{-- Desktop version --}}
<div class="container dashboard-user-balance-box-wrapper-large">
    <div class="row align-items-center">
        <div class="col border-right text-right">
            <span class="font-weight-bold text-muted small">
                {{ __('Current') }}
            </span>
        </div>
        <div class="col border-left text-left">
            <span class="font-weight-bold text-muted small">
                {{ __('Remaining') }}
            </span>
        </div>
        <div class="w-100"></div>
        <div class="col border-right text-right">
            <span class="text-muted small">
                {{ Auth::user()->CurrentBill() }} €
            </span>
        </div>
        <div class="col border-left text-left">
            <span class="text-muted small">
                {{ Auth::user()->credits }} €
            </span>
        </div>
    </div>
</div>



{{-- Mobile version --}}
<div class="container dropdown dashboard-user-balance-box-wrapper-small">
    <a id="balanceDropdown" 
       class="dropdown-toggle btn btn-white text-muted" 
       href="#" 
       role="button" 
       data-toggle="dropdown" 
       aria-haspopup="true" 
       aria-expanded="false" 
       v-pre>
        <span class="material-icons align-middle">account_balance</span> 
    </a>

    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="balanceDropdown">
        <h6 class="dropdown-header">{{ __('Current bill') }}</h6>
        <h6 class="dropdown-header font-weight-normal">{{ Auth::user()->CurrentBill() }} €</h6>
        <h6 class="dropdown-header">{{ __('Remaining credits') }}</h6>
        <h6 class="dropdown-header font-weight-normal">{{ Auth::user()->credits }} €</h6>
    </div>
</div>