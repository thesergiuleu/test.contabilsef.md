<div class="slider-2">
    <div class="slider-multiple">
        <div class="owl-carousel">
            @foreach($component['data'] as $items)
                <div class="owl-principal 2222222222222222222222222222222222222222222222">
                    @foreach($items as $item)
                        <div class="post-slider">
                            @include('layouts.common.thumbnail', ['options' => $component['options'], 'item' => $item])
                            <div class="sub_men">
                                @include('layouts.common.title', ['options' => $component['options'], 'item' => $item, 'doesNotShowNew' => true])
                                @include('layouts.common.under-title', ['options' => $component['options'], 'item' => $item])
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
    @if ($component['view_more'])
        <a href="#" class="more border-bottom">vezi mai mult</a>
    @endif
</div>
