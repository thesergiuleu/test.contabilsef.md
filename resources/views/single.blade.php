@extends('layouts.app')
@section('content')
    <section id='main_content' class='main_route_section'>
        <section class="{{ isset($classes) ? $classes : 'lista-de-articole Un-articole DespreProiect Informatie-cu-plata' }}">
            <section class="post-web">
                @if(isset($map))
                    <div style="height: 350px" id="map"
                         data-long="{{ setting('site.longitude') ??  '28.840406'}}"
                         data-lat="{{ setting('site.latitude') ?? '47.021819' }}"
                         data-marker="{{ asset('assets/imgs/local.png') }}">
                    </div>
                @endif
                <div class="kat-container">
                    @if (isset($breadCrumbs) && $breadCrumbs)
                        @include('components.bread-crumbs', ['breadCrumbs' => $breadCrumbs])
                    @endif
                    <div style="padding-top: 10px" class="content-web">
                        @foreach($sections as $section)
                            @include($section['name'], $section)
                        @endforeach
                    </div>
                </div>
            </section>
        </section>
    </section>
@endsection
