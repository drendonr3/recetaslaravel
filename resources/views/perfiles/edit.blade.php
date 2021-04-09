@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" integrity="sha512-5m1IeUDKtuFGvfgz32VVD0Jd/ySGX7xdLxhqemTmThxHdgqlgPdupWoSN8ThtUSLpAGBvA8DY2oO7jJCrGdxoA==" crossorigin="anonymous" />
@endsection

@section('botones')
    @include('ui.back')
@endsection

@section('content')
    <h1 class="text-center">
        Editar Mi Perfil
    </h1>
    <div class="row justify-content-center mt-5">
        <div class="col-md-10 bg-white p-3">
            <form 
            action="{{route('perfiles.update',['perfil'=>$perfil->id])}}"
            method="POST"
            enctype="multipart/form-data"
            >
            @csrf
            @method('PUT')
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text"
                            name="nombre"
                            class="form-control @error('nombre') is-invalid @enderror"
                            id="nombre"
                            placeholder="Tu Nombre"
                            value="{{$perfil->usuario->name}}">
                    @error('nombre')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="url">Sitio Web</label>
                    <input type="text"
                            name="url"
                            class="form-control @error('url') is-invalid @enderror"
                            id="url"
                            placeholder="Tu Sitio Web"
                            value="{{$perfil->usuario->url}}">
                    @error('url')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="biografia">Biografía</label>
                    <input
                        type="hidden"
                        id="biografia"
                        name="biografia"
                        value="{{$perfil->biografia}}"
                    >
                    <trix-editor input='biografia' class="form-control @error('biografia') is-invalid @enderror"></trix-editor>
                    @error('biografia')
                        <span class="invalid-feed}back d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="imagen">Tu Imagen</label>
                    <input 
                        type="file" 
                        id="imagen" 
                        class="form-control @error('imagen') is-invalid @enderror"
                        name='imagen'
                        >
                        @if($perfil->imagen)
                            <div class="mt-4">
                                <p>Imagen Actual:</p>

                                <img src="/storage/{{$perfil->imagen}}" style="width: 300px" alt="Imagen Perfil">
                            </div>
                            @error('imagen')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        @endif
                </div>

                <div class="form-group">
                    <input type="submit"
                            class="btn btn-primary"
                            value="Actualizar Perfil">
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js" integrity="sha512-2RLMQRNr+D47nbLnsbEqtEmgKy67OSCpWJjJM394czt99xj3jJJJBQ43K7lJpfYAYtvekeyzqfZTx2mqoDh7vg==" crossorigin="anonymous" defer></script>
@endsection

