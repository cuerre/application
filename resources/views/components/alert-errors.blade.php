@if ($errors->any())
<div class="alert alert-danger border-0" role="alert">
    <div class="d-flex flex-row w-100">
        <div class="flex-column flex-shrink-1">
            <i class="material-icons">
                info
            </i>
        </div>
        <div class="flex-column flex-grow-1 px-2 py-0">            
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
        </div>
    </div>
</div>
@endif
