{{-- ATTENTION: This view requires Prism.js to highlight the code --}}
<div class="shadow-sm rounded bg-light p-3 {{ $class }}">
    <div class="d-flex align-items-center text-uppercase font-weight-bolder small mb-3 text-muted">
        <i class="material-icons mr-2 align-middle">code</i>
        <span class="align-middle">
            code 
        </span>
        @if( !is_null($language) )
            <span class="ml-2 align-middle">
                <code>{{ $language }}</code>
            </span>
        @endif
    </div>
    @if( !is_null($snippet) )
        @if( view()->exists('snippets.' . $snippet) )
            <pre class="bg-light"><code class="language-{{$language}}">@include('snippets.' . $snippet)</code></pre>
        @endif
    @endif
    @unless( empty($slot->__toString()) === true )
        <pre class="bg-light"><code class="language-{{$language}}">{{ html_entity_decode($slot) }}</code></pre>
    @endunless
</div>