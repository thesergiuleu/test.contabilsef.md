<div class="post-contabil-șef">
    <div class="title">
        <a href="#">{{ $component['title'] }}</a>
    </div>
    <div class="post-sef border-bottom">
        @if($component['data']->isNotEmpty())
            @foreach($component['data'] as $item)
                @include('layouts.item', ['item' => $item, 'options' => $component['options']])
            @endforeach
        @else
            <h2>Nu sunt articole</h2>
        @endif
    </div>
</div>
