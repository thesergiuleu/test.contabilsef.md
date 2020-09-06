<div class="categor">
    @foreach($options as $key => $option)
        @if($key != 'short')
            @include("layouts.common.$key", ['options' => $options, 'item' => $item])
        @endif
    @endforeach
</div>
