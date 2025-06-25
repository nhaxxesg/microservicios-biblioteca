<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Autores;
use Illuminate\Http\Request;

class AutoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(Autores::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);
        $autor = Autores::create($request->all());
        return response()->json($autor, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $autor = Autores::find($id);
        if (!$autor) {
            return response()->json(['message' => 'Autor no encontrado'], 404); 
        }
        return response()->json($autor, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $autor = Autores::find($id);
        if (!$autor) {
            return response()->json(['message' => 'Autor no encontrado'], 404);
        }
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);
        $autor->update($request->all());
        return response()->json($autor, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
