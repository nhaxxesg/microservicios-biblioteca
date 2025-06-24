<?php

namespace App\Http\Controllers;

use App\Models\CategoriasLibros;
use Illuminate\Http\Request;

class CategoriasLibrosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
         return response()->json(CategoriasLibros::all(), 200);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'id_libro' => 'required|integer',
            'id_categoria' => 'required|integer',
        ]);
        $categoriasLibros = CategoriasLibros::create($request->all());
        return response()->json($categoriasLibros, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $categoriasLibros = CategoriasLibros::find($id);
        if (!$categoriasLibros) {
            return response()->json(['message' => 'no hay'], 404);
        }
        return response()->json($categoriasLibros, 200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoriasLibros $categoriasLibros)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoriasLibros $categoriasLibros)
    {
        //
        $request->validate([
            'id_libro' => 'required|integer',
            'id_categoria' => 'required|integer',
        ]);
        $categoriasLibros->update($request->all());
        return response()->json($categoriasLibros, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoriasLibros $categoriasLibros)
    {
        //
    }
}
