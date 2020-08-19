<li class="nav-item">
    <a href="{{ $link }}" class="nav-link text-muted pl-0">
        <i class="material-icons align-middle mr-2">
            {{ $icon }}
        </i>
        <span class="align-middle">
            @php 
                $allowedMethods = ['get', 'post', 'put', 'delete'];
                foreach( $allowedMethods as $method ){
                    $replacement = '<code class="text-uppercase font-weight-bold text-primary">'.$method.'</code>';
                    $content = preg_replace('/\{(http:){1}('.$method.')\}/', $replacement, $content);
                }
                echo $content;
            @endphp
        </span>
    </a>
</li>
