<form action="{{ $component['route'] }}" method="get" class="selects-post">
    <p>Sortează după:</p>
    <select name="year_get" onchange="this.form.submit()">
        <option value="">An</option>
        @foreach($component['filters']['year'] as $key => $value)
            <option @if(request()->input('year_get', null) == $key) selected @endif value="{{$key}}">{{$value}}</option>
        @endforeach
    </select>
    <select name="month_get" onchange="this.form.submit()">
        <option value="">Luna</option>
        @foreach($component['filters']['month'] as $key => $value)
            <option @if(request()->input('month_get', null) == $key) selected @endif value="{{$key}}">{{$value}}</option>
        @endforeach
    </select>
    <select name="status_get" onchange="this.form.submit()">
        <option value="">Tipul</option>
        @foreach($component['filters']['type'] as $key => $value)
            <option @if(request()->input('status_get', null) == $key) selected @endif value="{{$key}}">{{$value}}</option>
        @endforeach
    </select>
</form>
