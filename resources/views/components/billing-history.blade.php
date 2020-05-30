<x-box>
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
                    {{--<th scope="col"></th>--}}
                </tr>
            </thead>
            <tbody>
                @foreach ( $payments as $payment )
                    <tr>
                        <td class="align-middle">
                            {{ $payment->created_at->toFormattedDateString() }}
                        </th>
                        <td class="align-middle">
                            {{-- Show transaction id when present --}}
                            @if ( 
                                    in_array('details', array_keys($payment->data)) &&
                                    in_array('DESC', array_keys($payment->data['details']))
                                )
                                {{ Str::limit($payment->data['details']['DESC'], 20)  }}

                                <button type="button" 
                                        class="btn btn-light align-middle btn-sm" 
                                        data-toggle="tooltip" 
                                        data-placement="bottom" 
                                        title="{{ $payment->data['details']['DESC'] }}">
                                    <i class="material-icons md-18 align-middle">expand_more</i>
                                </button>
                            @else
                                {{ __('Not registered') }}
                            @endif
                        </td>
                        <td class="align-middle">
                            {{-- Show amount of money spent when present --}}
                            @if ( 
                                    in_array('details', array_keys($payment->data)) &&
                                    in_array('AMT', array_keys($payment->data['details']))
                                )
                                {{ $payment->data['details']['AMT'] }} €
                            @else
                                {{ __('Not registered') }}
                            @endif
                        </td>
                        {{--<td>@mdo</td>--}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</x-box>