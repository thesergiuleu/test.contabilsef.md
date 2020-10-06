<div class="img-responsive-block">
    <a href="{{ $item->post_url }}" style="position: absolute; z-index: 1;top:0;left: 0;height: 100%;width: 100%">
        {!! $item->new_on_pic !!}
        <img class="img-left responsive" src="{{ $item->thumbnail_url }}" alt="">
    </a>
</div>
