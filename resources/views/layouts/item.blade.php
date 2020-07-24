<div class="itmP">
    @include('layouts.common.thumbnail', ['options' => $options, 'item' => $item])
    <div class="categoriSef">
        @include('layouts.common.title', ['options' => $options, 'item' => $item, 'doesNotShowNew' => true])
        @include('layouts.common.under-title', ['options' => $options, 'item' => $item])
        @include('layouts.common.short', ['options' => $options, 'item' => $item])
    </div>
</div>
