<div class="position-post">
    <div class="box-posts">
        <p class="title-select">{{ $component['data']->name }}</p>
    </div>
    <div class="sub_men padding-null container-p">
    </div>

    <div class="boxe-contabilitate">
        @foreach($component['data']->children as $item)
            <a href="{{ route('category.view', $item->slug) }}" class="item-cont">
                <p>{{ $item->name }}</p>
                <span class="form_angle"><img src="{{ asset('assets/imgs/right-arrow.png') }}" alt=""></span>
            </a>
        @endforeach
    </div>
</div>
