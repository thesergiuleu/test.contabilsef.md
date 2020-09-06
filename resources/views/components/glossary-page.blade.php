<style>
    .myBtn {
        margin: 0;
        font-size: 15px;
        font-weight: 500;
        width: 216px;
        color: #fff;
        background-color: #b42a30;
        box-shadow: 0 1px 10px 0 hsla(0,0%,45%,.03);

        border-radius: 5px;
        transition: all .2s linear;
        padding: 8px 31px;
        text-decoration: none !important;
    }
    .buttonSearch{
        background: #fff;
        padding: 15px 0px 0px 10px;
    }
    .myBtn:hover{
        opacity: .7;
    }
</style>
<div class="position-post">
    <div class="box-posts">
        <p class="title-select">{{ $component['title'] }}</p>
    </div>
    @if(request()->has('keyword') && request()->get('keyword'))
        <div class="letter-item">
            <p>
                {{ request()->get('keyword') }}
            </p>
        </div>
    @endif

    @foreach ($component['data'] as $key => $item)
        <div class="toggle-item">
            <p class="click-element"><i class="fa fa-plus cheange-icon" aria-hidden="true"></i> {{ $item->keyword }}</p>
            <div class="dop-down">
                <p class="show-element">
                    <span>
                        {{ $item->description }}
                    </span>
                </p>
            </div>
        </div>
    @endforeach

    @include('layouts.common.pagination', ['component' => $component])

</div>
