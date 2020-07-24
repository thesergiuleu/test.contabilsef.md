@if(isset($options['lock']) && $options['lock'])
    @if($item->privacy == 0)
        <img class="lacata" src="{{ asset('assets/imgs/lac.png') }}" alt="">
    @endif
@endif
