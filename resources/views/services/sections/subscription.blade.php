<section id="subscription" class="subscription">
    <h2 class="section-title">Abonamente</h2>
    <div class="content">
        <div class="container">
            <div class="row">
                @foreach($packages as $key => $item)
                    <div class="col-12 col-lg-4">
                        <div class="subsc-item" >
                            <div class="head">
                                <div class="variant">{{ $item->name }}</div>
                                <div class="price">MDL {{ round($item->price) }}</div>
                                <div class="period">anual</div>
                            </div>
                            <div class="content">
                                <ul id="optim">
                                    @foreach($options as $option)
                                        <li><img class="icon" src="{{ in_array($option->id, $item->options()->pluck('id')->toArray()) ? asset('images/icons8-check-mark-48.png') : asset('images/icons8-cross-mark-48.png') }}" alt="icon" /><p class="text">{{ $option->name }}</p></li>
                                    @endforeach
                                </ul>
                                <label class="year">@if($key === 0) Alegeți anul:  <input value="2021" id="datepicker" class="year-select" type="text"> @endif</label>
                                <a href="{{ $service->getCheckoutLink($item->id) }}" class="banner-button">Abonează-te</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
