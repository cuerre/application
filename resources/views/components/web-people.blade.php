<div class="col-lg-4 py-3">
    <div class="d-flex flex-column align-items-center">
        <img src="{{ asset('imgs/people/' . $picture) }}" class="rounded-circle" style="width: 14rem;"/>
        <p class="mt-3 h5 font-weight-bolder">
            {{ $name }}
        </p>
        <p>
            {{ $description }}
        </p>
    </div>
</div>