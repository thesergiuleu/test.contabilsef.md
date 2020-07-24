@if(isset($options['comments_count']) && $options['comments_count'])
    <p class="cl"><img src="{{ asset('assets/imgs/comment_6.png') }}" style="width: 15px" alt="">{{ $item->comments_count }}</p>
@endif
