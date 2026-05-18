<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie; // <- usar el modelo

class CatalogController extends Controller
{
    // Comentado: ya no usamos el array estático
    // private $arrayPeliculas = array(...);

    public function getShow($id){
        // obtener la película desde la base de datos
        $pelicula = Movie::findOrFail($id);

        return view('catalog.show', ['id' => $id, 'pelicula' => $pelicula]);
    }

    public function getIndex(){
        // obtener todas las películas
        $peliculas = Movie::all();

        return view('catalog.index')->with('peliculas', $peliculas);
    }

    public function getCreate(){
        return view('catalog.create');
    }

    public function getEdit($id){
        $pelicula = Movie::findOrFail($id);

        return view('catalog.edit', ['id' => $id, 'pelicula' => $pelicula]);
    }

    public function index()
    {
        return view('catalog.index');
    }

    public function postCreate(Request $request){
        $pelicula = new Movie();
        $pelicula->title     = $request->input('title');
        $pelicula->year      = $request->input('year');
        $pelicula->director  = $request->input('director');
        $pelicula->poster    = $request->input('poster');
        $pelicula->rented    = $request->input('rented') === 'true';
        $pelicula->synopsis  = $request->input('synopsis');
        $pelicula->save();

        // Mostrar la vista `postCreate` con la película creada.
        // Si prefieres redirigir al índice, cambia esta línea por
        // `return redirect()->route('catalog.index');`
        return view('catalog.postCreate', ['pelicula' => $pelicula]);
    }


    public function putEdit(Request $request, $id){
        $pelicula = Movie::findOrFail($id);
        $pelicula->title    = $request->input('title');
        $pelicula->year     = $request->input('year');
        $pelicula->director = $request->input('director');
        $pelicula->poster   = $request->input('poster');
        $pelicula->rented   = $request->input('rented') === 'true';
        $pelicula->synopsis = $request->input('synopsis');
        $pelicula->save();

        return redirect()->route('catalog.show', $id);
    }
}
