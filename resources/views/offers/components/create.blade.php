<style>
    .input {
        width: 100%;
        border-radius: 5px;
        background-color: #ebebeb;
        box-shadow: -0.1px 3px 3px 0 rgba(0, 0, 0, .03);
        border: none;
        outline: 0;
        padding: 7px 10px;
        font-weight: 500;
        margin-top: 5px;
    }

    .input-btn {
        display: initial;
        padding: 5px 15px;
        color: #fff;
        border-radius: 3px;
        cursor: pointer;
        margin-right: 10px;
        background: #3c5a98;
        height: 36px;
    }

    .select {
        width: 100%;
        border-radius: 5px;
        background-color: #ebebeb;
        box-shadow: -0.1px 3px 3px 0 rgba(0, 0, 0, .03);
        border: none;
        outline: 0;
        padding: 7px 10px;
        font-weight: 500;
        margin-top: 5px;
        height: 36px;
    }

    .div {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        width: calc(33% - 20px);
        font-size: 14px;
        font-weight: 600;
        font-style: normal;
        font-stretch: normal;
        line-height: 1.43;
        letter-spacing: normal;
        color: #252525;
        text-transform: uppercase;
        margin-bottom: 20px;
        margin: 10px;
    }

    .textarea {
        min-height: 176px;
        border-radius: 5px;
        background-color: #ebebeb;
        outline: 0;
        padding: 10px;
        border: none;
        box-shadow: -0.1px 3px 3px 0 rgba(0, 0, 0, .03);
        max-width: 100%;
        width: 100%;
        font-weight: 500;
        margin-top: 10px;
    }
</style>

<h1 class="title">Adăugare ofertă</h1>

<p class="description">* ofertele vor fi disponibile în termen de 6 luni</p>

<form id="offer-form" action="{{ route('offer.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="div">
        <label>
            DENUMIREA COMPANIEI <span class="required">*</span>
        </label>
        <input type="text" class="input @if($errors->has('company_name')) has-error @endif" value="{{ old('company_name') }}" name="company_name">
    </div>

    <div class="div">
        <label>
            POST VACANT
            <span class="required">*</span>
        </label>
        <select class="select @if($errors->has('vacancy')) has-error @endif"  name="vacancy">
            <option value="">Vă rog alegeți</option>
            @foreach(\App\Offer::VACANCIES as $key => $value)
                <option value="{{ $key }}" @if(old('vacancy') == $key) selected @endif>{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <div class="div">
        <label>
            LOCAȚIE
            <span class="required">*</span>
        </label>
        <select class="select @if($errors->has('location')) has-error @endif" name="location">
            <option value="">Vă rog alegeți</option>
            @foreach(\App\Offer::LOCATIONS as $key => $value)
                <option value="{{ $key }}" @if(old('location') == $key) selected @endif>{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <div class="div">
        <label>
            SALARIU
        </label>
        <input type="text" class="input @if($errors->has('salary')) has-error @endif"  value="{{ old('salary') }}" name="salary">
    </div>
    <div class="div">
        <label>
            TELEFON
        </label>
        <input type="text" class="input @if($errors->has('phone')) has-error @endif" name="phone" value="{{ old('phone') }}">
    </div>
    <div class="div">
        <label>
            EMAIL <span class="required">*</span>
        </label>
        <input type="text" class="input @if($errors->has('email')) has-error @endif" name="email" value="{{ old('email') }}">
    </div>
    <div class="div">
        <label>
            STUDII
        </label>
        <select class="select @if($errors->has('studies')) has-error @endif" name="studies">
            <option value="">Vă rog alegeți</option>
            @foreach(\App\Offer::STUDIES as $key => $value)
                <option value="{{ $key }}" @if(old('studies') == $key) selected @endif>{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <div class="div">
        <label>
            PROGRAM DE LUCRU
        </label>
        <select class="select @if($errors->has('time_shift')) has-error @endif" name="time_shift">
            <option value="">Vă rog alegeți</option>
            @foreach(\App\Offer::TIME_SHIFTS as $key => $value)
                <option value="{{ $key }}" @if(old('time_shift') == $key) selected @endif>{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <div class="div">
        <label>
            ÎNCARCĂ LOGO
        </label>
        <label for="load-logo" style="text-align: center" class="input input-btn">Adaugă imagine</label>
        <input type="file" id="load-logo" style="display: none" name="logo">
    </div>
    <div class="div" style="width: 48%">
        <label>
            DESCRIEREA POSTULUI ŞI RESPONSABILITĂŢI DE BAZĂ
            <span class="required">*</span>
        </label>
        <textarea class="textarea @if($errors->has('description')) has-error @endif" name="description">{{ old('description') }}</textarea>
    </div>
    <div class="div" style="width: 48%">
        <label>
            CERINȚE FAȚA DE CANDIDAT
            <span class="required">*</span>
        </label>
        <textarea class="textarea @if($errors->has('requirements')) has-error @endif" name="requirements">{{ old('requirements') }}</textarea>
    </div>
    <div class="div" style="width: 100%">
        <label>
            WEBSITE
        </label>
        <input type="text" class="input @if($errors->has('website')) has-error @endif" value="{{ old('website') }}" name="website">
        <div style="margin-top: 33px">
            @include('components.reCaptcha')
        </div>
    </div>
    <div>
        <button type="submit" style="margin-left: 15px;margin-top: 25px;padding: 8px;height: auto;left: 0;">Trimite <i id="subscription-submit-i"></i>
        </button>
    </div>
    <div class="div" style="width: 100%">
        @include('layouts.response-message')
    </div>
</form>


