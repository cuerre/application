<div class="form-group mb-4">
    @if( !is_null($label) )
        <label for="{{ $name }}" class="text-md-right small font-weight-bolder">
            {{ $label }}
        </label>
    @endif
    <input 
        type="{{ $type }}" 
        id="{{ $name }}" 
        name="{{ $name }}" 
        class="form-control form-control-sm py-4 @error($name) is-invalid @enderror" 
        @if( !is_null($pre) )
            placeholder="{{ $pre }}"
        @endif
        autocomplete="{{ $name }}"
        value="{{ old($name) }}">
        
    @error($name)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    
</div>

