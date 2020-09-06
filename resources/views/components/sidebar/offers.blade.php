<div class="oferte">
    <div class="postari-sidebar">
        <div class="title-sidebar">
            <h1>{{ $component['title'] }}</h1>
            @if($component['data']->isNotEmpty())
                @foreach ($component['data'] as $key => $item)
                    <div class="post-info">
                        <a href="{{ $item->url }}">{{ $item->title }}</a>
                        <h3>{{ $item->location }}, {{ $item->vacancy }}</h3>
                        <div class="icons">
                            <span>{{ format_date($item->created_at) }}</span>
                        </div>
                    </div>
                @endforeach
            @else
                <h2>Nu sunt joburi</h2>
            @endif
            <div class="border-bottom" style="display:flex;">
                @if($component['add_new'])
                    <a href="{{ route('offer.create')  }}"  style="    width: 50%;  text-align: left;  justify-content: flex-start;  padding-left: 20px;"  class="more">Adauga job</a>
                @endif
                @if ($component['view_more'])
                    <a href="{{ route('offer.index') }}"  style="width: 50%"  class="more">vezi mai mult</a>
                @endif
            </div>
        </div>
    </div>
</div>
