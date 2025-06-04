<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\book;
use Illuminate\Http\Request;

class bookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        return response()->json(book::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'anio_publicacion' => 'required|digits:4|integer|min:1000|max:' . date('Y'),
            'categoria' => 'required|string|max:100',
            'estado' => 'in:disponible,prestado'
        ]);

        $libro = book::create($request->all());

        return response()->json($libro, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $libro = book::find($id);

        if (!$libro) {
            return response()->json(['mensaje' => 'Libro no encontrado'], 404);
        }

        return response()->json($libro);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $libro = book::find($id);

        if (!$libro) {
            return response()->json(['mensaje' => 'Libro no encontrado'], 404);
        }

        $libro->update($request->all());

        return response()->json($libro);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $libro = book::find($id);

        if (!$libro) {
            return response()->json(['mensaje' => 'Libro no encontrado'], 404);
        }

        $libro->delete();

        return response()->json(['mensaje' => 'Libro eliminado']);
    }
}
