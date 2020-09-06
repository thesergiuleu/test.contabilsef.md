<div class="post-link">
    @foreach ( $component['data'] as $key => $item )
        <div class="links"
             data-url=""
             style="background-image: url({{ asset($item->background) }}">

            <a href="{{ $item->url }}"> <span></span> {{ $item->title }}</a>
            @if( $key == 1 && !auth()->user() )
                <a href="{{ route('subscribe') }}">Abonează-te</a>
            @elseif( $key == 1 && auth()->user() )
                <a href="{{ route('profile') }}">Abonează-te</a>
            @endif
        </div>
    @endforeach
</div>
