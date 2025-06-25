<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitudes;

class SolicitudesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(Solicitudes::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'id_usuario' => 'required|integer',
            'id_libro' => 'required|integer',
            'estado' => 'required|string|max:50',
            'fecha_de_registro' => 'required|date',
        ]);
        $solicitud = Solicitudes::create($request->all());
        return response()->json($solicitud, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $solicitud = Solicitudes::find($id);
        if (!$solicitud) {
            return response()->json(['mensaje' => 'Solicitud no encontrada'], 404);
        }
        return response()->json($solicitud, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $solicitud = Solicitudes::findOrFail($id);
        $request->validate([
            'id_usuario' => 'required|integer',
            'id_libro' => 'required|integer',
            'estado' => 'required|string|max:50',
            'fecha_de_registro' => 'required|date',
        ]);
        $solicitud->update($request->all());
        return response()->json($solicitud, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
