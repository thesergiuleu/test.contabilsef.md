<div class="post-link">
    @foreach ( $component['data'] as $key => $item )
        <div class="links"
             data-url=""
             style="background-image: url({{ asset($item->background) }}">
            <span></span>
            <a href="{{ ($item->category ?: $item->post_url) }}"> {{ $item->title }} </a>
            @if( $key == 0 && !auth() )
                <a href="{{ $item->post_url }}">Abonează-te</a>
            @elseif( $key == 0 && auth() )
                <a href="{{ route('subscribe') }}">Abonează-te</a>
            @endif
        </div>
    @endforeach
</div>
