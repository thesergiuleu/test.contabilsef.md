<div class="postari-sidebar">
    <div class="title-sidebar">
        <h1>{{ $component['title'] }}</h1>
        <div class="scroll_div">
            <div class="scrollbar" id="style-2">
                <div class="force-overflow myOverflowContainer">
                    @foreach ($component['data'] as $key => $item)
                        <div class="post-info">
                            <a href="{{$item->post_url}}">{{ $item->title }}</a>

                            <div class="icons">
                                <img class="margin-left" src="{{ asset('assets/imgs/r.png') }}"
                                     alt="">
                                <span> {{ $item->date }} </span>
                                <span>
                                <img
                                    src="{{ asset('assets/imgs/cl.png') }}"
                                    alt=""
                                ><a href="#">Club afaceri</a>
                            </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @if ($component['view_more'])
            <a href="#" class="more border-bottom">vezi mai mult</a>
        @endif
    </div>
</div>
