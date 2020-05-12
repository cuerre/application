<div class="dropdown">
    <button 
        class="btn btn-sm dropdown-toggle mr-1" 
        data-display="static" 
        type="button" 
        data-toggle="dropdown" 
        aria-haspopup="true" 
        aria-expanded="false">
        <i class="material-icons align-middle">save_alt</i>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ url('dashboard/codes/download?code=' . $id) }}&output=PNG">.PNG</a>
        <a class="dropdown-item" href="{{ url('dashboard/codes/download?code=' . $id) }}&output=SVG">.SVG</a>
        <a class="dropdown-item" href="{{ url('dashboard/codes/download?code=' . $id) }}&output=EPS">.EPS</a>
    </div>
</div>