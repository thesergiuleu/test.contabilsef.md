@if( $item->link )
    <p class="servici-v" style="display: -webkit-inline-box;"><img style="width: 12px; height: 11px;" src="{{ asset('assets/imgs/cl.png') }}" alt="">
        {!! preg_replace("/<a(.*?)>/", "<a$1 target=\"_blank\">", $item->link); !!}
    </p>
@endif

