<div class="post-baner">
    @foreach ($component['data'] as $k => $item)
        <a
            class="custom_banners_big_link"
            target="_blank"
            data-id=""
            href="{{ $item->redirect_url ?? '#' }}"
        >
            <div class="banner_wrapper">
                <div class="banner">
                    <img
                        width="{{ $item->position == \App\Banner::POSITION_MAIN_CENTER ? '620' : '376' }}"
                        height="80"
                        src="{{ $item->image_url }}"
                        class="attachment-full size-full"
                        alt=""
                        sizes="{{ $item->position == \App\Banner::POSITION_MAIN_CENTER ? '(max-width: 620px) 100vw, 620px' : '(max-width: 376px) 100vw, 376px' }}">

                </div>
            </div>
        </a>
    @endforeach
</div>
