<div class="oferte">
    <div class="postari-sidebar">
        <div class="title-sidebar">
            <h1>{{ $component['title'] }}</h1>
            @if($component['data'])
                @foreach ($component['data'] as $key => $item)
                    <div class="post-info">
                        <a href="{{ $item->url }}">{{ $item->title }}</a>
                        <h3>{{ $item->city }}, {{ $item->category }}</h3>
                        <div class="icons">
                            <span>{{ $item->date }}</span>
                        </div>
                    </div>
                @endforeach
            @else
                <h2>Nu sunt joburi</h2>
            @endif
            <div class="border-bottom" style="display:flex;">
                @if($component['add_new'])
                    <a href="#"  style="    width: 50%;  text-align: left;  justify-content: flex-start;  padding-left: 20px;"  class="more">Adauga job</a>
                @endif
                @if ($component['view_more'])
                    <a href="#"  style="width: 50%"  class="more">vezi mai mult</a>
                @endif
            </div>
        </div>
    </div>
</div>
