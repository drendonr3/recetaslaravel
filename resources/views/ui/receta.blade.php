<div class="col-md-4 mt-4">
    <div class="card shadow">
        <img class="card-img-top" src="/storage/{{$receta->imagen}}" alt="Imagen Receta" class="card-img-top">
        <div class="card-body">
            <h3 class="card-title">
                {{$receta->titulo}}
            </h3>
            <div class="meta-receta d-flex justify-content-between">
                <p class="text-primary fecha">{{$receta->created_at}}</p>
                <p>{{count($receta->likes)}}  Les gustó</p>
            </div>
            <div class="card-text">
                <p>{{Str::words(strip_tags($receta->preparacion),10)}}</p>
                <a href="{{route('recetas.show',['receta'=>$receta->id])}}" 
                    class="btn btn-primary d-block font-weight-bold text-uppercase">Ver</a>
                </a>
            </div>
            
        </div>
    </div>
</div>