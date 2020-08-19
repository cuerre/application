<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Cuerre')
<img src="{{ asset('imgs/logo-notification.png') }}" class="logo" alt="Cuerre Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
