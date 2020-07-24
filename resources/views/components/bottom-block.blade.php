<div class="title">
    <a href="#">{{ $component['title'] }} </a>
</div>
<div class="post-legislatie">

    @foreach ( $component['data'] as $key => $item )
        <div class="post-slider @if($key < (count($component['data'])-2)  ) border-bottom @endif">
            <div class="sub_men padding-null">
                @include('layouts.common.title', ['options' => $component['options'], 'item' => $item])
                @include('layouts.common.under-title', ['options' => $component['options'], 'item' => $item])
            </div>
        </div>
    @endforeach

    @if ($component['view_more'])
        <a href="#" class="more">vezi mai mult</a>
    @endif
</div>
