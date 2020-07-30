<div class="dropdown">
    <a id="navbarDropdown" 
       class="dropdown-toggle btn btn-white" 
       href="#" 
       role="button" 
       data-toggle="dropdown" 
       aria-haspopup="true" 
       aria-expanded="false" 
       v-pre>
        {{ Auth::user()->email }} <span class="caret"></span>
    </a>

    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
        <h6 class="dropdown-header">{{ __('Current bill') }}</h6>
        <h6 class="dropdown-header font-weight-normal">{{ Auth::user()->CurrentBill() }} €</h6>
        <h6 class="dropdown-header">{{ __('Remaining credits') }}</h6>
        <h6 class="dropdown-header font-weight-normal">{{ Auth::user()->credits }} €</h6>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ url('desk') }}">
            {{ __('Desk') }}
        </a>

        <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>