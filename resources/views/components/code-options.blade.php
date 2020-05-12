<div class="dropdown">
    <button 
        class="btn btn-sm dropdown-toggle mr-1" 
        data-display="static" 
        type="button" 
        data-toggle="dropdown" 
        aria-haspopup="true" 
        aria-expanded="false">
        <i class="material-icons align-middle">menu</i>
    </button>
    <div class="dropdown-menu">

        {{-- Modify --}}
        <a class="dropdown-item" href="{{ url('dashboard/codes/modification?code='.$id) }}">
            {{ __('Modify') }}
        </a>

        {{-- Delete --}}
        <form action="{{ url('dashboard/codes') }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="id" value="{{ $id }}">
            <button 
                type="submit" 
                class="dropdown-item" 
                onclick="return confirm('Are you sure?')">
                {{ __('Delete') }}
            </button>  
        </form>
        
    </div>
</div>