<div class="articol">
    @foreach ($section['components'] as $component)
        @include($component['name'], $component)
    @endforeach
</div>
