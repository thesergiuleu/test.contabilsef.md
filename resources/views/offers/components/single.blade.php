<div class="position-post">
    <div class="box-posts job-changes">

        <div class="logo-title">
            <img src="{{ $component['data']->thumbnail_url }}" alt="">
        </div>

        <style>
            .job-listing-meta,.job_application {
                display: none;
            }
        </style>
        <div class="angajare__functie">
            <div class="date-post"><div class="functie"><span>angajeaza:</span>{{ $component['data']->title }}</div>
                <span>{{ format_date($component['data']->created_at) }}</span>
            </div>
            <ul class="date-block">
                <li style="{{ (!$component['data']->location ? 'display:none' : '') }}">{{ $component['data']->location }}</li>
                <li style="{{ (!$component['data']->studies ? 'display:none' : '') }}">{{ $component['data']->studies }}</li>
                <li style="{{ (!$component['data']->time_shift ? 'display:none' : '') }}">{{ $component['data']->time_shift }}</li>
                <li style="{{ (!$component['data']->salary ? 'display:none' : '') }}">{{ $component['data']->salary }}</li>
            </ul>
        </div>
        <div class="angajare_desc">
            <div class="angajare_desc_title">
                <p>DESCRIEREA POSTULUI SI RESPONSABILITATI DE BAZA</p>
            </div>
            {!! nl2br($component['data']->description) !!}

            <div class="angajare_desc_title">
                <p>Cerinţe faţă de candidat</p>
            </div>
            {!! nl2br($component['data']->requirements) !!}
        </div>
        <br>
        <div class="contacts_btn">
            <ul class="date-block bottom">
                <li class="title-bottom">contact</li>
                <li style="{{ (!$component['data']->email ? 'display:none' : '') }}"><a href="mailto:{{$component['data']->email}}">{{$component['data']->email}}</a></li>
                <li style="{{ (!$component['data']->phone ? 'display:none' : '') }}"><a href="tel:{{$component['data']->phone}}">{{$component['data']->phone}}</a></li>
                <li style="{{ (!$component['data']->website ? 'display:none' : '') }}"><a href="{{$component['data']->website}}">{{$component['data']->website}}</a></li>
            </ul>
        </div>
    </div>
</div>
