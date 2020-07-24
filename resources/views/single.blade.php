@extends('layouts.app')

@section('content')
    <section id='main_content' class='main_route_section'>
        <section class="lista-de-articole Un-articole DespreProiect">
            <section class="post-web">
                <div class="kat-container">
                    @if (isset($breadCrumbs) && $breadCrumbs)
                        @include('components.bread-crumbs')
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
