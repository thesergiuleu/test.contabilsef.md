<div class="itmP">
    @if ($item->thumbnail_url)
        @include('layouts.common.thumbnail', ['options' => $options, 'item' => $item])
    @endif
    <div class="categoriSef">
        @if($item->thumbnail_url)
            @include('layouts.common.title', ['options' => $options, 'item' => $item, 'doNotShowNew' => true])
        @else
            @include('layouts.common.title', ['options' => $options, 'item' => $item])
        @endif
        @include('layouts.common.under-title', ['options' => $options, 'item' => $item])
        @include('layouts.common.short', ['options' => $options, 'item' => $item])
    </div>
</div>
