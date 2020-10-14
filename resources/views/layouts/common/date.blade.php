<p class="cl">
    <img src="{{ asset('assets/imgs/r.png') }}" alt="date">
    {{ format_date($item->category->slug === \App\Category::INSTRUIRE_CATEGORY ? $item->event_date : $item->created_at) }}
</p>

