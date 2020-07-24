<div class="post-contabil-șef" style="margin-top: 43px">
    <div class="title">
        <a href="#">{{ $component['title'] }} </a>
    </div>
</div>
<div class="slider-2">
    <div class="slider-multiple">
        <div class="owl-carousel">
            @foreach ($component['data'] as $items)
                <div class="owl-principal">
                    @foreach ($items as $item)
                        <div class="post-slider">
                            <div class="sub_men padding-null">
                                @include('layouts.common.title', ['options' => $component['options'], 'item' => $item])
                                @include('layouts.common.under-title', ['options' => $component['options'], 'item' => $item])
                                @include('layouts.common.short', ['options' => $component['options'], 'item' => $item])
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

    </div>
    <a href="#" class="more border-bottom">vezi mai mult</a>
</div>
