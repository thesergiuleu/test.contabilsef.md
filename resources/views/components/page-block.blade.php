<div class="position-post">
    <div class="box-posts" style="margin-bottom: 0">
        <h1 class="title-select">{{ $component['title'] }}</h1>
    </div>
    <div class="sub_men padding-null container-p">
        {!! find_glossary_terms($component['data']->body) !!}
    </div>

    @if($component['data']->slug == \App\Page::SUBSCRIBE)
        <div style="text-align: center">
            @if(auth()->user())
                <a href="#" onclick="openSubscribeModal('{{ route("page.view", \App\Page::TERMS_AND_CONDITIONS_REVISTA) }}', 'Revista electronică ”Contabilsef.md”', '{{ \App\Subscription::TYPE_REVISTA }}')" class="myBtnRed">Abonează-te</a>
            @else
                <a href="#" class="autentific myBtnRed">Abonează-te</a>
            @endif
        </div>
    @endif
    @if($component['data']->slug == \App\Page::CONSULTANT_SNC)
        <div style="text-align: center">
            @if(auth()->user())
                <a href="#" onclick="openSubscribeModal('{{ route("page.view", \App\Page::TERMS_AND_CONDITIONS_SNC) }}', 'Consultant SNC', '{{ \App\Subscription::TYPE_CONSULTANT }}')" class="myBtnRed">Abonează-te</a>
            @else
                <a href="#" class="autentific myBtnRed">Abonează-te</a>
            @endif
        </div>
    @endif
</div>
