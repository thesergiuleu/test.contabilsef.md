@if($item->comments()->count() > 0) <p class="cl"  style="margin: 0;    margin-right: 5px;    margin-left: 10px;"><img src="{{ asset('assets/imgs/comment_6.png') }}" style="width: 15px" alt="">{{ $item->comments()->count() }}</p> @endif

