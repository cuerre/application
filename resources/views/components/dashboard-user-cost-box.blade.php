<div class="container">
    <div class="row">
        <div class="col border-right text-right">
            <span class="font-weight-bold text-muted small">
                {{ __('Current cost') }}
            </span>
        </div>
        <div class="col border-left text-left">
            <span class="font-weight-bold text-muted small">
                {{ __('Remaining credits') }}
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