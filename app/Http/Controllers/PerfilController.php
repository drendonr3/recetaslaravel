<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except'=>'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function show(Perfil $perfil)
    {
         // Obtener recetas con paginación
         $recetas= Receta::where('user_id',$perfil->user_id)->paginate(2);
        return view('perfiles.show',compact('perfil','recetas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function edit(Perfil $perfil)
    {   
        // Ejecutar el Policy
        $this->authorize('view',$perfil);
        return view('perfiles.edit',compact('perfil'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perfil $perfil)
    {
        // Ejecutar el Policy
        $this->authorize('update',$perfil);
        // Validar
        $data = request()->validate([
           'nombre'=>'required', 
           'url'=>'required', 
           'biografia'=>'required'
        ]);
        // Si el usuario sube una imagen
        if ($request['imagen']){
           //Obtener Nombre Imagen
            $ruta_imagen=$request['imagen']->store('upload-perfiles','public');

            // Resize de imagen
            $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(600,600);
            $img->save();

            $array_imagen = ['imagen' => $ruta_imagen];           
        }
        // Asignar Nombre y URL
        Auth::user()->url = $data['url'];
        Auth::user()->name = $data['nombre'];
        Auth::user()->save();

        //Eliminar url y name de $data
        unset($data['url']);
        unset($data['nombre']);

        
        // Asignar Biografía e Imagen
        Auth::user()->perfil()->update(
            array_merge($data, $array_imagen??[])
        );
               
        // Redireccionar
        return redirect()->action([RecetaController::class,'index']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perfil $perfil)
    {
        //
    }
}
