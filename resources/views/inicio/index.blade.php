@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" />
@endsection

@section('hero')
    <div class="hero-categorias">
        <form action="{{route('buscar.show')}}" class="container h-100">
            <div class="h-100 row align-items-center">
                <div class="col-md-4 texto-buscar">
                    <p class="display-4">
                        Encuentra una receta para tu próxima comida
                    </p>
                    <input 
                        type="search"
                        name="buscar"
                        class="form-control"
                        placeholder="Buscar Receta"
                        >
                </div>
            </div>
        </form>
    </div>
@endsection

@section('content')
    {{-- <img class="w-100" src="{{asset('/images/bgimagen.jpg')}}" alt="Imagen Fondo"> --}}

    <div class="container nuevas-recetas">
        <h2 class="titulo-categoria text-uppercase mb-4"> Últimas recetas</h2>
        <div class="owl-carousel owl-theme">
            @foreach($nuevas as $nueva)
                <div class="card">
                    <img src="/storage/{{$nueva->imagen}}" class="card-img-top" alt="Imagen Receta">
                    <div class="card-body">
                        <h3>{{$nueva->titulo}}</h3>
                        <p>{{Str::words(strip_tags($nueva->preparacion),10)}}</p>
                        <a href="{{route('recetas.show',['receta'=>$nueva->id])}}" 
                        class="btn btn-primary d-block font-weight-bold text-uppercase">Ver</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="container">
        <h2 class="titulo-categoria text-uppercase mt-5 mb-4">Recetas Más Votadas</h2>
        @foreach($votadas as $receta)
            @include('ui.receta')

        @endforeach
    </div>
    @foreach($recetas as $key => $grupo)
        <div class="container">
            @if(count($grupo[0])>0)
                <h2 class="titulo-categoria text-uppercase mt-5 mb-4">{{str_replace('-',' ',$key)}} </h2>
                @foreach($grupo[0] as $receta)
                   @include('ui.receta')

                @endforeach
            @endif
        </div>
    @endforeach
@endsection
