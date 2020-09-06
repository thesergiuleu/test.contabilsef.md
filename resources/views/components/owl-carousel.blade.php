<div class="slider-2">
    <div class="slider-multiple">
        <div class="owl-carousel">
            @if($component['data']->isNotEmpty())
                @foreach($component['data'] as $items)
                    <div class="owl-principal 2222222222222222222222222222222222222222222222">
                        @foreach($items as $item)
                            <div class="post-slider">
                                @if ($item->thumbnail_url)
                                    @include('layouts.common.thumbnail', ['options' => $component['options'], 'item' => $item])
                                @endif
                                <div class="sub_men">
                                    @if($item->thumbnail_url)
                                        @include('layouts.common.title', ['options' => $component['options'], 'item' => $item, 'doNotShowNew' => true])
                                    @else
                                        @include('layouts.common.title', ['options' => $component['options'], 'item' => $item])
                                    @endif
                                    @include('layouts.common.under-title', ['options' => $component['options'], 'item' => $item])
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @else
                <h2>Nu sunt articole</h2>
            @endif

        </div>
    </div>
    @if ($component['view_more'])
        <a href="{{ $component['route'] }}" class="more border-bottom">vezi mai mult</a>
    @endif
</div>
