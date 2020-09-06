<div class="serch-box">
    <form action="{{ route('glossary.index') }}" method="get" class="item-search" id="item-search-form">
        <input type="hidden" name="start_with" value="@if(request()->has('start_with')) {{ request()->get('start_with') }} @endif">
        <input type="text" name="search" class="text-input" value="@if(request()->has('search')) {{ request()->get('search') }} @endif" placeholder="Cautare...">
    </form>
    <div class="buttonSearch" style="display: none" >
        <a onclick="$('#item-search-form').submit()" class="myBtn" >Cauta</a>
    </div>
    <ul class="intem-list">
        <li class="latter @if (!request()->has('start_with')) active-letter @endif" ><a href="{{ route('glossary.index') }}">Toate</a></li>
        @foreach($component['data'] as $item)
            <li class="latter @if (request()->has('start_with') && request()->get('start_with') == $item) active-letter @endif" ><a href="{{ route('glossary.index') . '?start_with=' . $item }}">{{ $item }}</a></li>
        @endforeach
    </ul>

</div>
<script>
    $(document).on('keyup','input[name="search"]',function(){
        $('.buttonSearch').css('display','block');
    });
</script>
