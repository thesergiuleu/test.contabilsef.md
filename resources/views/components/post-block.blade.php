<div class="position-post">

    <div class="box-posts" style="margin-bottom: 0">
        <h1 class="title-select">{{ $component['data']->title }}</h1>
    </div>

    @include('layouts.common.under-title', ['options' => $component['options'], 'item' => $component['data']])

    <div class="sub_men padding-null container-p">
        {!! $component['data']->body !!}
    </div>
</div>
