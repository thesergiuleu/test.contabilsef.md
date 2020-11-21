@if((bool)$component['data']->cant_copy)
    <style type="text/css"> @media print {
            body {
                display: none
            }
        } </style> @endif
<div class="position-post">

    <div class="box-posts" style="margin-bottom: 0">
        <h1 class="title-select">{{ $component['data']->title }}</h1>
    </div>

    @include('layouts.common.under-title', ['options' => $component['options'], 'item' => $component['data']])
    <div class="sub_men padding-null container-p"
        @if((bool)$component['data']->cant_copy)
            style="-moz-user-select: none; -webkit-user-select: none; -ms-user-select:none; user-select:none;-o-user-select:none;"
            unselectable="on"
            onselectstart="return false;"
            onmousedown="return false;"
        @endif>

        @guest
            @if((bool)$component['data']->privacy)
                {!! find_glossary_terms($component['data']->body) !!}
            @else
                {!! find_glossary_terms($component['data']->getShort(200)) !!}
                @include('layouts.box-abonat', ['check' => false, 'item' => $component['data']])
            @endif
        @endguest

        @auth
            @if(auth()->user()->canSeePostBody($component['data']))
                {!! find_glossary_terms($component['data']->body) !!}
            @else
                {!! find_glossary_terms($component['data']->getShort(200)) !!}
                @include('layouts.box-abonat', ['check' => true, 'item' => $component['data']])
            @endif
        @endauth
    </div>
</div>
