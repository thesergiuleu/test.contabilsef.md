@if($component['data']->isNotEmpty())
    <div class="title">
        <a href="#">{{ $component['title'] }}</a>
    </div>
    <div class="slider-ultimul">
        <div class="content-ultim">
            <div class="owl-carousel" id="refactoryPollHomeContainer">
                @foreach($component['data'] as $item)
                    @if($item->answers()->where('ip_address', $_SERVER['REMOTE_ADDR'])->exists())
                        <div class="owl-principal">
                            <div class="post_2slider">
                                <p>{{ $item->question }}</p>
                            </div>
                            <div class="pollResult">
                                <div class="pollResult">
                                    <ul class="wpp_result_list">
                                        @foreach($item->poolOptions as $option)
                                            <li class="wpp_option_single slideRight">
                                                <span>{{ $option->name }}</span>
                                                <span class="progress_bar" style="width: {{ $option->getPercentage($item) }}%;"></span>
                                                <span>{{ $option->getVotes($item) }} ({{ $option->getPercentage($item) }} %)</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div style="font-size: 17px; font-weight: 500; padding-left: 15px;">Total: ({{ $item->answers()->count() }} voturi)</div>                                            </div>
                            </div>
                        </div>
                    @else
                        <div class="owl-principal">
                            <div class="single-poll">
                                <h1 itemprop="name" class="title wpp_poll_title">{{ $item->question }}</h1>
                                <form id="pool-vote-form" method="POST" action="{{ route('pool.vote', $item->id) }}">
                                    @csrf
                                    <ul class="wpp_option_list">
                                        @foreach($item->poolOptions as $option)
                                            <li class="wpp_option_single">
                                                <input type="radio" value="{{ $option->id }}" name="pool_option_id" class="submit_poll_option">
                                                <label class="option_title">
                                                    {{ $option->name }}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <input type="hidden" name="ip_address" value="{{ $_SERVER['REMOTE_ADDR'] }}">
                                    <button type="submit" class="button wpp_submit">Votează</button>
                                    @include('layouts.response-message')
                                </form>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <style>
        .pollResult .wpp_result_list li > span:last-child{
            margin: 0 10px;
        }
        .pollResult .wpp_result_list li > span:first-child{
            font-weight: 600;
            width: 100%;
        }
        .pollResult .wpp_result_list li{
            display: flex;
            flex-wrap: wrap;
            padding-bottom: 10px;
        }
        .pollResult .wpp_result_list{
            display: block;
            padding: 0 15px;
        }
        .pollResult{
            width: 100%;
        }
        .progress_bar{
            height: 20px;
            background: #f1aa2c;
            display: block;
            border-radius: 6px;
        }
    </style>
@endif
