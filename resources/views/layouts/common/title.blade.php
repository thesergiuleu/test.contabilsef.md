<a href="{{ $item->post_url }}" class="title-articol"> {!! !isset($doesNotShowNew) ? $item->new_on_text : '' !!} {{ $item->title }}</a>
