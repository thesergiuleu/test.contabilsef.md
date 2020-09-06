<a href="{{ $item->post_url }}" class="title-articol"> {!! !isset($doNotShowNew) ? $item->new_on_text : '' !!} {{ $item->title }}</a>
