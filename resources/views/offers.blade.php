@extends('layouts.app')

@section('content')
    <section id='main_content' class='main_route_section'>
        <section class="{{ isset($classes) ? $classes : 'lista-de-articole adauga-un-job lista-oferte' }}">
            <section class="post-web">
                <div class="kat-container" id="bradgrims-margin">
                    @if (isset($breadCrumbs) && $breadCrumbs)
                        @include('components.bread-crumbs', ['breadCrumbs' => $breadCrumbs])
                    @endif
                    <div class="content-web">
                        @foreach($sections as $section)
                            @include($section['name'], $section)
                        @endforeach
                    </div>
                </div>
            </section>
        </section>
    </section>
@endsection
