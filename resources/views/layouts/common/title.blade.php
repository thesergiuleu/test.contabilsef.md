<a href="{{ $item->post_url }}" class=" @if(!isset($doNotShowNew)) title-articol @else textP @endif"> {!! !isset($doNotShowNew) ? $item->new_on_text : '' !!} {{ $item->title }}</a>
