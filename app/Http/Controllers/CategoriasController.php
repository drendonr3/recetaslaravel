<?php

namespace App\Http\Controllers;

use App\Models\CategoriaReceta;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    public function show(CategoriaReceta $categoriaReceta){
        $recetas = $categoriaReceta->recetas()->paginate(1);
        return view('categorias.show')
        ->with('recetas',$recetas)
        ->with('categoriaReceta',$categoriaReceta);
    }
}
