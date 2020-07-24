<div class="position-post">
    <div class="box-posts">
        <p class="title-select">{{ $component['title'] }}</p>
        @include('layouts.common.filters', ['component' => $component])
    </div>

    <div class="post-contabil-șef">
        <div class="post-sef">
            @if($component['data'])
                @foreach ( $component['data'] as $key => $item )
                    @include('layouts.item', ['item' => $item, 'options' => $component['options']])
                @endforeach
            @else
                <h2>Nu sunt articole</h2>
            @endif
        </div>
    </div>
    @include('layouts.common.pagination', ['component' => $component])
</div>
