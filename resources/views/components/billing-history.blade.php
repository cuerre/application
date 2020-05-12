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
                        <td>{{ $payment->created_at->toFormattedDateString() }}</th>
                        <td>{{ $payment->data['DESC'] }}</td>
                        <td>{{ $payment->data['AMT'] }} €</td>
                        {{--<td>@mdo</td>--}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</x-box>