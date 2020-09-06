<h1 class="title"> {{ $component['title'] }} </h1>
<a href="{{ route('offer.create') }}" class="adauga_job">adauga un job</a>


<form action="{{ $component['route']  }}" method="get">
    <select class="selectlista-oferte" name="vacancy" id="#" onchange="this.form.submit();">
        <option value="">Cauta postul</option>
        @foreach($component['filters']['vacancies'] as $key => $value)
            <option @if(request()->input('vacancy', null) == $key) selected @endif value="{{$key}}">{{$value}}</option>
        @endforeach
    </select>
</form>
@if($component['data']->isNotEmpty())
    @foreach ($component['data'] as $key => $item)
    <div class="post-oferte" style="position: relative">
        <a href="{{ $item->url }}" style="position: absolute; width: 100%;height: 100%;z-index: 1;top: 0;left: 0;"></a>
        <div class="top__content">
            <a href="{{ $item->url }}" class="img-oferte"><img
                    src="{{ $item->thumbnail_url }}"
                    alt=""></a>

            <h1>
                <span>{{ $item->company_name }}</span>
                <span style="color: #8e8e8e;">{{ $item->vacancy }}</span>
            </h1>

            <p class="data_oferte">
                <span> {{ $item->location }} </span>
                <span> {{ format_date($item->created_at) }} </span>
            </p>
        </div>
        <p class="simple-words">{{ $item->getShort(200) }}</p>
    </div>
    @endforeach
@else
    <h2 style="padding-bottom: 260px">Nu sunt joburi</h2>
@endif
@if($component['data']->lastPage() > 1)
    @include('layouts.common.pagination', ['component' => $component])
@endif

