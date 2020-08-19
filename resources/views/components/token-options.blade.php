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
    <div class="dropdown-menu dropdown-menu-right">

        {{-- Delete --}}
        <form action="{{ url('desk/tokens') }}" method="POST">
            @csrf
            @method('DELETE')
            <input name="id" type="hidden" value="{{ $id }}">
            <button 
                type="submit" 
                class="dropdown-item" 
                onclick="return confirm('Are you sure?')">
                {{ __('Delete') }}
            </button>  
        </form>

        {{-- Enable / Disable --}}
        <form action="{{ url('desk/tokens/switching') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="token" value="{{ $id }}">
            <button 
                type="submit" 
                class="dropdown-item"
                onclick="return confirm('Are you sure?')">
                {{ __('Switch') }}
            </button>  
        </form>
        
    </div>
</div>