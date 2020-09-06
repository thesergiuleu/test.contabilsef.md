<div class="box-item">
    <ul>
        <li class="actve-li"><a href="{{ route('category.view', $component['data']->parentCategory->slug) }}" class="actve-li">{{ $component['data']->parentCategory->name }}</a></li>
        @foreach($component['data']->parentCategory->children as $item)
            <li class="{{ (config('app.url').$_SERVER['REQUEST_URI'] == route('category.view', $item->slug) ? 'esential-li' : '') }}"><a href="{{ route('category.view', $item->slug) }}">{{ $item->name }}</a></li>
        @endforeach
    </ul>
</div>
