<x-box class="mb-5">
    <x-box-header>
        {{ __('Payments history') }}
    </x-box-header>

    @if( count($payments) == 0 )
        <p class="text-secondary">
            {{ __('You have not payments yet') }}
        </p>
    @else
        <table class="table table-borderless text-secondary">
            <thead>
                <tr>
                    <th scope="col">{{ __('Date') }}</th>
                    <th scope="col">{{ __('Description') }}</th>
                    <th scope="col">{{ __('Amount') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $payments as $payment )
                    <tr>
                        <td class="align-middle">
                            {{ $payment->created_at->toFormattedDateString() }}
                        </th>
                        <td class="align-middle">
                            {{-- Show transaction description --}}
                            @php
                                try {
                                    $briefDescription = Str::limit($payment->data['outcome']['result']['purchase_units'][0]['reference_id'], 20);
                                    $longDescription  = $payment->data['outcome']['result']['purchase_units'][0]['reference_id'];
                                    $paidAt           = Carbon\Carbon::parse($payment->data['outcome']['result']['update_time'])->toDayDateTimeString();
                                } catch ( Exception $e ){
                                    Log::error($e);
                                    $briefDescription = null;
                                    $longDescription  = null;
                                    $paidAt = null;
                                }
                            @endphp

                            @if ( 
                                !is_null($briefDescription) && 
                                !is_null($longDescription) && 
                                !is_null($paidAt)
                            )
                                {{ $briefDescription }}
                                
                                @php
                                    $popoverContent  = "<p><b>". __('Description').": </b>".$longDescription ."</p><p></p>";
                                    $popoverContent .= "<p><b>". __('Paid at') .": </b>". $paidAt ."</p><p></p>";
                                @endphp
                                 
                                <a  tabindex="0" 
                                    role="button" 
                                    class="btn btn-light align-middle btn-sm" 
                                    data-container="body" 
                                    data-trigger="focus"
                                    data-toggle="popover" 
                                    data-placement="bottom" 
                                    data-html="true" 
                                    data-content="{{ $popoverContent }}">
                                    <i class="material-icons md-18 align-middle">expand_more</i>
                                </a>
                            @else
                                {{ __('Not registered') }}
                            @endif
                        </td>
                        <td class="align-middle">
                            {{-- Show amount of money spent when present --}}
                            @php
                                try {
                                    echo $payment->data['outcome']['result']['purchase_units'][0]['amount']['value'];
                                    echo ' ';
                                    echo $payment->data['outcome']['result']['purchase_units'][0]['amount']['currency_code'];
                                } catch ( Exception $e ){
                                    Log::error($e);
                                    echo __('Not registered');
                                }
                            @endphp
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</x-box>