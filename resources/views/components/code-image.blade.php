@php
    $codeImage = App\Http\Controllers\CodesController::GetEmbededImage( $id );
@endphp
<div class="d-flex justify-content-center">
    <img src="data:image/png;base64, {{ $codeImage }}" class="rounded-lg" style="width: 6rem !important;">
</div>