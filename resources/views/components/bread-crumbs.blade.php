<div class="bradgrubs">
    @if(count($breadCrumbs) == 0)
        <a href="{{ route('home') }}" rel="nofollow"> {{ __('Acasa') }} </a>&nbsp;&nbsp;»&nbsp;&nbsp;
    @else
        <a href="{{ route('home') }}" rel="nofollow"> {{ __('Acasa') }} </a>&nbsp;&nbsp;»&nbsp;&nbsp;
    @foreach ($breadCrumbs as $key => $breadCrumb)
            @if ($loop->last)
                {{ ucfirst($breadCrumb) }}
            @else
                <a href="{{ $key }}" rel="nofollow">{{ ucfirst($breadCrumb) }}</a>&nbsp;&nbsp;»&nbsp;&nbsp;
            @endif
        @endforeach
    @endif
</div>
