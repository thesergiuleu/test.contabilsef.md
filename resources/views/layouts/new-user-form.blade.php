@if(!auth()->check())
    @if($isUser)
        <input id="csrf_token" type="hidden" name="_token" value="{{csrf_token()}}">
        <div style="margin-bottom: 8px;" class="col-md-12">
            <span>Dvs. sunteți înregistrați pe pagină cu aceast e-mail.</span>
        </div>
        <div class="form-group col-md-6">
            <label for="name">parola</label>
            <input type="password" class="form-control form-control-lg"
                   name="password" id="password" placeholder="parola">
        </div>
        <div class="col-md-12">
        </div>
        <div style="margin-top: 7px" class="col-md-6">
            <button onclick="login('{{route('login')}}')" type="button" class="btn btn-block btn-primary">Autentificare</button>
        </div>
    @else
        <div style="margin-bottom: 8px;" class="col-md-12">
            <span>Acesta e un cont nou. Completează datele de mai jos.</span>
        </div>
        <div class="form-group col-md-6">
            <label for="name">nume prenume</label>
            <input type="text" class="form-control form-control-lg"
                   name="name" id="name" placeholder="Nume Prenume">
        </div>
        <div class="form-group col-md-6">
            <label for="name">telefon</label>
            <input type="tel" class="form-control form-control-lg"
                   name="phone"  id="phone" placeholder="Numar de telefon">
        </div>
        <div class="form-group col-md-6">
            <label for="name">parola</label>
            <input type="password" class="form-control form-control-lg"
                   name="password" id="password" placeholder="parola">
        </div>
        <div class="form-group col-md-6">
            <label for="password_confirmation">confirma parola</label>
            <input type="password" class="form-control form-control-lg"
                   name="password_confirmation" id="password_confirmation" placeholder="confirma parola">
        </div>
    @endif

@endif
