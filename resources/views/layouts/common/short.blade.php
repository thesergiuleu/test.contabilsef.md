@if(isset($options['short']) && $options['short'])
    <p class="{{ $options['short'] == 120 ? 'last-p' : 'words-articol'}}">
        {{ $item->getShort($options['short']) }}
    </p>
@endif
