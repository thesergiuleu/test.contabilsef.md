<div class="post-contabil-șef">
    <div class="title">
        <a href="#">{{ $component['title'] }}</a>
    </div>
    <div class="post-sef border-bottom">
        @foreach($component['data'] as $item)
            @include('layouts.item', ['item' => $item, 'options' => $component['options']])
        @endforeach
    </div>
</div>
