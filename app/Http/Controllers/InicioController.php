<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CategoriaReceta;

class InicioController extends Controller
{
    public  function index()
    {
        // Mostrar Recetas por cantidad de votos
        //$votadas = Receta::has('likes','>=',1)->get();
        $votadas = Receta::withCount('likes')->orderBy('likes_count','desc')->take(3)->get();

        // Obtener las recetas mas nuevas
        $nuevas = Receta::latest()->take(7)->get();

        // Obtener toddas las categorías
        $categorias = CategoriaReceta::all();
        
        // Agrupar por categoria
        $recetas= [];

        foreach($categorias as $categoria){
            $recetas[Str::slug($categoria->nombre)][] = $categoria->recetas->take(2);
        }
        
       
        return view('inicio.index')
        ->with('nuevas',$nuevas)
        ->with('votadas',$votadas)
        ->with('recetas',$recetas);
    }
}
