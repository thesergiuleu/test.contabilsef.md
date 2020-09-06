<div class="articol" @if(isset($fullPage)) style="width: 100%" @endif>
    @foreach ($section['components'] as $component)
        @include($component['name'], $component)
    @endforeach
</div>
