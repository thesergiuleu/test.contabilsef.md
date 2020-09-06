<ul @if(isset($options->submenu)) class="sub-menu" @else id="menu-meniu" class="menu" @endif>
    @php

        if (Voyager::translatable($items)) {
        $items = $items->load('translations');
        }

    @endphp

    @foreach ($items as $item)

        @php

            $originalItem = $item;
            if (Voyager::translatable($item)) {
            $item = $item->translate($options->locale);
            }

            $isActive = null;
            $styles = null;
            $icon = null;

            // Background Color or Color
            if (isset($options->color) && $options->color == true) {
            $styles = 'color:'.$item->color;
            }
            if (isset($options->background) && $options->background == true) {
            $styles = 'background-color:'.$item->color;
            }

            // Check if link is current
            if(url($item->link()) == url()->current()){
            $isActive = 'current-menu-item';
            }

            // Set Icon
            if(isset($options->icon) && $options->icon == true){
            $icon = '<i class="' . $item->icon_class . '"></i>';
            }

        @endphp

        <li class="{{ $isActive }} page_item page-item-2">
            <a href="{{ url($item->link()) }}" target="{{ $item->target }}" style="{{ $styles }}">
                {!! $icon !!}
                <span>{{ $item->title }}</span>
            </a>
            @if(!$originalItem->children->isEmpty())
                @php
                    $options->submenu = true
                @endphp
                @include('layouts.navbar', ['items' => $originalItem->children, 'options' => $options])
            @endif
        </li>
    @endforeach

</ul>
