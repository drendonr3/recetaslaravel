@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" integrity="sha512-5m1IeUDKtuFGvfgz32VVD0Jd/ySGX7xdLxhqemTmThxHdgqlgPdupWoSN8ThtUSLpAGBvA8DY2oO7jJCrGdxoA==" crossorigin="anonymous" />
@endsection

@section('botones')
    @include('ui.back')
@endsection

@section('content')
    <h2 class="text-center mb-5">Editar Receta: {{$receta->titulo}}</h2>

    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <form method="POST" action={{route('recetas.update',['receta'=>$receta->id])}} novalidate enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="titulo">Título Receta</label>
                    <input type="text"
                            name="titulo"
                            class="form-control @error('titulo') is-invalid @enderror"
                            id="titulo"
                            placeholder="Título Receta"
                            value="{{$receta->titulo}}">
                    @error('titulo')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="categoria">Categoría</label>
                    <select
                    name='categoria'
                    class="form-control @error('categoria') is-invalid @enderror"
                    id="categoria">
                        <option value="">--Seleccione--</option>
                        @foreach($categorias as $categoria)
                            <option 
                            {{$receta->categoria_id==$categoria->id ?'selected':""}}
                            value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                        @endforeach
                    </select>
                    @error('categoria')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="ingredientes">Ingredientes</label>
                    <input
                        type="hidden"
                        id="ingredientes"
                        name="ingredientes"
                        value="{{$receta->ingredientes}}"
                    >
                    <trix-editor input='ingredientes' class="form-control @error('ingredientes') is-invalid @enderror"></trix-editor>
                    @error('ingredientes')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="preparacion">Preparación</label>
                    <input
                        type="hidden"
                        id="preparacion"
                        name="preparacion"
                        value="{{$receta->preparacion}}"
                    >
                    <trix-editor input='preparacion' class="form-control @error('preparacion') is-invalid @enderror"></trix-editor>
                    @error('preparacion')
                        <span class="invalid-feed}back d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group mt-3">
                    <label for="imagen">Elige la Imagen</label>
                    <input 
                        type="file" 
                        id="imagen" 
                        class="form-control @error('imagen') is-invalid @enderror"
                        name='imagen'
                        >
                        <div class="mt-4">
                            <p>Imagen Actual:</p>

                            <img src="/storage/{{$receta->imagen}}" style="width: 300px" alt="Imagen Actual">
                        </div>
                        @error('imagen')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                        @enderror
                </div>

                <div class="form-group">
                    <input type="submit"
                            class="btn btn-primary"
                            value="Modificar Receta">
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js" integrity="sha512-2RLMQRNr+D47nbLnsbEqtEmgKy67OSCpWJjJM394czt99xj3jJJJBQ43K7lJpfYAYtvekeyzqfZTx2mqoDh7vg==" crossorigin="anonymous" defer></script>
@endsection

