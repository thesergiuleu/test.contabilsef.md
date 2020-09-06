<ol class="@if ($is_children) children @else comment-list @endif">
    @foreach($comments as $item)
        <li id="comment-{{$item->id}}">
            <div class="comment-body">
                <div class="comment-author vcard">
                    <img alt="" src="https://secure.gravatar.com/avatar/1d01512b4142f0c87c713658ad49c579?s=56&amp;d=mm&amp;r=g" srcset="https://secure.gravatar.com/avatar/1d01512b4142f0c87c713658ad49c579?s=112&amp;d=mm&amp;r=g 2x" class="avatar avatar-56 photo" height="56" width="56">
                    <cite class="fn">
                        {{ $item->name }}
                    </cite>
                    <span class="says">
                                                    spune:
                                                </span>
                </div>

                <div class="comment-meta commentmetadata">
                    <a href="{{$item->post->post_url}}/#comment-{{$item->id}}">
                        {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('l F jS') }}, {{ \Carbon\Carbon::parse($item->created_at)->format('Y') }} la {{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }}
                    </a>
                </div>

                <p>{{ $item->body }}</p>

                <div class="reply">
                    <a rel="nofollow" class="comment-reply-link" href="{{ $item->post->post_url }}?reply_to={{$item->id}}#respond" aria-label="Răspunde la {{ $item->name }}">Răspunde</a></div>
            </div>
            @if($item->children->isNotEmpty())
                @include('components.comment-list', ['comments' => $item->children, 'is_children' => true])
            @endif
        </li>
    @endforeach
</ol><!-- .comment-list -->
