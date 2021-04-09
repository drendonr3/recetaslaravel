<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaReceta;
use App\Models\Receta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class RecetaController extends Controller
{
    public function __construct(){
        $this->middleware('auth',['except'=>['show','search']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = Auth::user();

        //$recetas = Auth::user()->recetas;
        // Obtener recetas con paginación
        $recetas= Receta::where('user_id',$usuario->id)->paginate(2);

        return view('recetas.index')
            ->with('recetas',$recetas)
            ->with('usuario',$usuario);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //DB::table('categoria_receta')->get()->pluck('nombre','id')->dd();
        // Sin modelo
        //$categorias = DB::table('categoria_recetas')->get()->pluck('nombre','id');

        // Con modelo
        $categorias = CategoriaReceta::all(['id','nombre']);
        return view('recetas.create')->with('categorias',$categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validacion
        $data = request()->validate([
           'titulo'  =>'required|min:6',
           'categoria' => 'required',
           'preparacion' => 'required',
           'ingredientes' => 'required',
           'imagen' => 'required|image'
        ]);

        //Obtener Nombre Imagen
        $ruta_imagen=$request['imagen']->store('upload-recetas','public');

        // Resize de imagen
        $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1000,550);
        $img->save();

        // Almacenar en base de datos sin modelo
        // DB::table('recetas')->insert([
        //     'titulo'=>$data['titulo'],
        //     'ingredientes'=>$data['ingredientes'],
        //     'preparacion'=>$data['preparacion'],
        //     'imagen'=>$ruta_imagen,
        //     'user_id'=>Auth::user()->id,
        //     'categoria_id' =>$data['categoria']
        //     ]);
//        dd($request->all());



        // Almacenar en la base de datos con modelo
            Auth::user()->recetas()->create([
            'titulo'=>$data['titulo'],
            'ingredientes'=>$data['ingredientes'],
            'preparacion'=>$data['preparacion'],
            'imagen'=>$ruta_imagen,
            'categoria_id' =>$data['categoria']
        ]);
        // Redireccionar
        return redirect('/recetas');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Receta $receta)
    {
        // Obtener si el usuario actual le gusta la receta y está autenticado
        $like = (Auth::user())? Auth::user()->meGusta->contains($receta->id) :false;

        // Pasa la cantidad de likes a la vista
        $likes = $receta->likes->count();
        return view('recetas.show')->with('receta',$receta)->with('like',$like)->with('likes',$likes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {
        // Ejecutar el Policy
        $this->authorize('view',$receta);
        $categorias = CategoriaReceta::all(['id','nombre']);
        return view('recetas.edit', compact('categorias','receta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receta $receta)
    {
        //Revisa el Policy
        $this->authorize('update',$receta);

        $data = request()->validate([
            'titulo'  =>'required|min:6',
            'categoria' => 'required',
            'preparacion' => 'required',
            'ingredientes' => 'required'
         ]);

        // Asignar los valores
        $receta->titulo = $data['titulo'];
        $receta->preparacion = $data['preparacion'];
        $receta->ingredientes = $data['ingredientes'];
        $receta->categoria_id = $data['categoria'];

        // Si el usuario sube una nueva imagen
        if (request('imagen')){
            $ruta_imagen=$request['imagen']->store('upload-recetas','public');

            // Resize de imagen
            $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1000,550);
            $img->save();

            // Asignar al objeto
            $receta->imagen = $ruta_imagen;
        }
        $receta->save();

        return redirect()->action([RecetaController::class,'index']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta)
    {
        //Revisa el Policy
        $this->authorize('update',$receta);      
        
        // Eliminar la receta
        $receta->delete();
        return redirect()->action([RecetaController::class,'index']);       
    }

    public function search(Request $request){
        $busqueda = $request['buscar'];

        $recetas = Receta::where('titulo','like','%'.$busqueda.'%')->paginate(1);
        $recetas->appends(['buscar'=>$busqueda]);
        return view('busquedas.show',compact('recetas','busqueda'));

    }

}
