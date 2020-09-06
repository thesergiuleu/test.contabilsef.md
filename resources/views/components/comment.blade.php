<section class="lista-de-articole management unSeminar unRaspuns">
    <div class="content-web">
        <div class="articol"  style="width: 100%">
            <div class="position-post" style="border-bottom: 0 solid #e1e1e1;  margin-bottom: 0; padding: 0">
                <div class="comentarii">
                    <h2>Comentarii</h2>
                    <div id="comments" class="comments-area">
                        @if($component['data']->comments()->whereNull('parent_id')->get()->isNotEmpty())
                            @include('components.comment-list', ['comments' => $component['data']->comments()->whereNull('parent_id')->get(), 'is_children' => false])
                        @endif


                    </div><!-- .comments-area -->
                </div>
                <a name="respond"></a>
                <div class="post-info add-post-container">
                    <div class="boxt-title">
                        <span>Adauga un comentariu</span>
                    </div>
                    <form method="post" id="commentform" action="{{route('comments.store', $component['data']->id)}}" class="comment-form">
                        @csrf
                        <p class="comment-notes" style="padding-bottom: 10px">
                            <span id="email-notes">Adresa ta de email nu va fi publicată.</span></p>
                        <p class="comment-form-comment"><label STYLE="display: block" for="comment">Comentariu</label>
                            <textarea class="@if($errors->has('body')) has-error @endif" id="comment" name="body" cols="45" rows="8" maxlength="65525" required="required">{{ old('body') }}</textarea></p>
                        <p class="comment-form-author"><label STYLE="display: block" for="name">Nume</label>
                            <input id="name" name="name" class="@if($errors->has('name')) has-error @endif" type="text" value="{{ old('name') }}" size="30" maxlength="245"></p>
                        <p class="comment-form-email"><label STYLE="display: block" for="email">Email</label>
                            <input id="email" name="email" type="text" class="@if($errors->has('email')) has-error @endif" value="{{ old('email') }}" size="30" maxlength="100" aria-describedby="email-notes"></p>

                        @if(request()->has('reply_to'))
                            <input type="hidden" name="parent_id" value="{{ request()->get('reply_to') }}">
                        @endif
                        @if(!auth()->user())
                            @include('components.reCaptcha')
                        @endif

                        <button type="submit" class="submit">Publică comentariul</button>
                    </form>
                    <p class="labelMessage"></p>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    #submit[disabled="disabled"]{
        background-color: #959595;
        cursor: no-drop;
    }
</style>
