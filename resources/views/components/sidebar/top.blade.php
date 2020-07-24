<div class="top-more-read">
    <div class="postari-sidebar">
        <div class="title-sidebar">

            <h1>{{ $component['title'] }}</h1>

            <div class="post-info">
                <div class="info-post-title">
                    <span onclick="setTimeout(function(){ $('.top-container').removeClass('active2');$('#top-contaier-1').addClass('active2'); },100)" class="active3">7 </span>
                    /
                    <span onclick="setTimeout(function(){ $('.top-container').removeClass('active2');$('#top-contaier-2').addClass('active2'); },100)">30</span>
                </div>
            </div>
            <div class="scroll_div">
                <div class="scrollbar" id="style-2">
                    <div id="top-contaier-1" class="top-container force-overflow active2">
                        @foreach($component['data']['top_7'] as $item)
                            <div class="post-img">
                                {!! $item->new_on_pic !!}
                                <img src="{{ $item->thumbnail_url }}" alt="">
                                <div class="texts">
                                    <a href="{{ $item->post_url }}">{{ $item->title }}</a>
                                    <div class="categor">
                                        <p class="cl"><img src="{{ asset('assets/imgs/r.png') }}" alt="">{{ $item->date }}</p>
                                        <span><img src="{{ asset('assets/imgs/ays.png') }}" alt="">{{ $item->views }}</span>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>
                    <div id="top-contaier-2" class="top-container force-overflow">
                        @foreach($component['data']['top_30'] as $item)
                            <div class="post-img">
                                {!! $item->new_on_pic !!}
                                <img src="{{ $item->thumbnail_url }}" {{ $item->thumbnail_url }} alt="">
                                <div class="texts">
                                    <a href="{{ $item->post_url }}">{{ $item->title }}</a>
                                    <div class="categor">
                                        <p class="cl"><img src="{{ asset('assets/imgs/r.png') }}" alt="">{{ $item->date }}</p>
                                        <span><img src="{{ asset('assets/imgs/ays.png') }}" alt="">{{ $item->views }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
