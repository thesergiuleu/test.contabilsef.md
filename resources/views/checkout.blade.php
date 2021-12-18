@extends('layouts.app')
@section('content')
    <section id='main_content' class='main_route_section'>
        <section class="lista-de-articole Un-articole DespreProiect Informatie-cu-plata">
            <section class="post-web">
                <div class="kat-container">
                    @if (isset($breadCrumbs) && $breadCrumbs)
                        @include('components.bread-crumbs', ['breadCrumbs' => $breadCrumbs])
                    @endif
                    <div class="content-web">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12" style="margin-bottom: 22px;">
                                    <h3>Înscrie-te în comunitatea oamenilor cu gândire antreprenorială</h3>
                                    <h4>Poți întrerupe oricând abonamentul tău, cu un click, direct din contul tău</h4>
                                </div>
                                <div class="col-md-8">
                                    <form id="checkoutForm" method="POST" action="{{route('checkout.store', [$service, $package])}}">
                                        @csrf
                                        <div style="width: 100%" class="articol">
                                            <div class="position-post">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h3>Detalii cont</h3>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="email">adresa de e-mail</label>
                                                        <input @if(auth()->check()) readonly @endif @if(!auth()->check()) onfocusout='checkEmail(this)' @endif name="email" value="{{ auth()->user()->email ?? null }}" data-url="{{route('check-email')}}" type="email" class="form-control form-control-lg"
                                                               id="email" placeholder="Introdu adresa de email">
                                                    </div>
                                                    <div id="new-user-form"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h3>Informații de facturare</h3>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="name">nume prenume</label>
                                                        <input required value="{{ auth()->user()->name ?? null }}" type="text" class="form-control form-control-lg"
                                                               id="name" name="name" placeholder="Nume Prenume">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="company">denumirea companiei</label>
                                                        <input value="{{ auth()->user()->company ?? null }}" type="text" class="form-control form-control-lg"
                                                               name="company" id="company" placeholder="sau Denumirea companiei">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="name">telefon</label>
                                                        <input type="tel" class="form-control form-control-lg"
                                                              value="{{ auth()->user()->phone ?? null }}" name="phone"  id="phone" placeholder="Numar de telefon">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="cod_fiscal">cod fiscal</label>
                                                        <input type="text" class="form-control form-control-lg"
                                                               id="cod_fiscal"
                                                               name="cod_fiscal"
                                                               placeholder="Codul fiscal al platitorului">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="payment_method">metoda de plata</label>
                                                        <select required class="form-control form-control-lg"
                                                                name="payment_method" id="payment_method">
                                                            <option value="">Alege metoda de plata</option>
                                                            @foreach($paymentMethods as $key => $value)
                                                                <option value="{{$key}}">{{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="width: 100%" class="articol">
                                            <div class="position-post">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h3>Servicii</h3>
                                                    </div>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <div class="col-md-8">
                                                        <span style="font-weight: bold">{{ $service->name }}</span> abonament <span style="font-weight: bold">{{ $package->name }}</span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        MDL {{ $package->price }}
                                                    </div>
                                                    <br>
                                                    <br>
                                                    @if($package->getDiscount() > 0)
                                                        <div class="col-md-8">
                                                            <span style="color: red">Reducere</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <span style="color: red">MDL {{ $package->discount }}</span>
                                                        </div>
                                                        <br>
                                                        <br>
                                                        <div style="text-align: right"  class="col-md-8">
                                                            <span style="font-weight: bold">Total</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="hidden" name="payed_amount" value="{{ $package->price - $package->getDiscount() }}">
                                                            <span style="font-weight: bold">MDL {{ $package->price - $package->getDiscount() }}</span>
                                                        </div>
                                                    @endif
                                                    <input type="hidden" name="payed_amount" value="{{ $package->price - $package->getDiscount() }}">
                                                    <br>
                                                    <br>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="terms" value="1" id="defaultCheck1">
{{--                                                                <label class="form-check-label" for="defaultCheck1">Sînt de acord cu <a target="_blank" href="{{ route('page.view', $service->page->slug) }}">termeni și condiții</a></label>--}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <br>
                                                    <div class="div" style="width: 50%; text-align: center; margin: 0 auto">
                                                        @include('layouts.response-message')
                                                    </div>
                                                    <br>

                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-primary aligncenter">Procesează comanda</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-4">
                                    <div style="width: 100%" class="articol">
                                        <div class="position-post">
                                            CURSURI PREMIUM
                                            Ai acces la platforma actualizată constant cu resurse noi.

                                            INTERVIURI CU EXPERȚI
                                            Afli idei practice de la experți, influenceri și antreprenori - înveți meserie rapid de la cei care au deja rezultate dovedite.

                                            COMUNITATE EXCLUSIVĂ
                                            Ai acces la Grupul de Facebook și la evenimentul anual fizic, unde interacționezi direct cu membrii și experții Upriserz.

                                            ACTUALIZĂRI REGULATE
                                            Primești săptămânal conținut nou, ca să nu rămâi în urmă cu noutățile din piață și te asiguri că aplici doar informații la zi.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </section>
@endsection
