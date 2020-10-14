@if($item->category->slug !== \App\Category::INSTRUIRE_CATEGORY)
    <span><img src="{{ asset('assets/imgs/ays.png') }}" alt=""> {{ $item->views }}</span>
@endif
