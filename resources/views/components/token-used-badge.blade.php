@php

    use \Illuminate\Support\Facades\Redis;

    try {

        # Try to get current wasted rate from cache
        $rateCurrent = 0;
        if( Redis::exists($token) ){

            $key = Redis::get($token);

            if( !is_null($key) ){
                $key = json_decode( $key, true);
                $rateCurrent = $key['rateCurrent'];
            }
        }

        # Calculate background color
        $usedPercent = $rateCurrent / $rateLimit;

        $bgColor = 'LightSeaGreen';
        if( $usedPercent >= 0.9 ){
            $bgColor = 'LightCoral';
        }

    } catch ( Exception $e ){
        
        $usedPercent = 1;
        $bgColor     = 'LightCoral';
    }
@endphp


<div class="d-inline ml-2">
    <span 
        class="badge badge-primary rounded-pill" 
        style="background-color: {{ $bgColor }} !important;">
        {{ $rateCurrent }} / {{ $rateLimit }}
    </span>
</div>