<?php

namespace App\Http\Controllers;

use App\Models\Sancion;

use Illuminate\Http\Request;


class SancionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    return response()->json(Sancion::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
 public function store(Request $request)
{
    try {
        $request->validate([
            'usuario_id' => 'required|integer',
            'motivo' => 'required|string',
            'estado' => 'in:pendiente,resuelto' 
        ]);

        // Asegúrate de pasar los datos validados, no el Request completo
        $sancion = Sancion::create($request->only(['usuario_id', 'motivo', 'estado']));

        return response()->json($sancion, 201);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Error interno',
            'mensaje' => $e->getMessage(),
            'tipo' => get_class($e)
        ], 500);
    }
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sancion = Sancion::find($id);

        if (!$sancion) {
            return response()->json(['mensaje' => 'Sanción no encontrada'], 404);
        }

        return response()->json($sancion);
      
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
    $sancion = Sancion::find($id);
    if (!$sancion) {
        return response()->json(['mensaje' => 'Sanción no encontrada'], 404);
    }   
    $request->validate([
        'usuario_id' => 'required|integer',
        'motivo' => 'required|string',
        'estado' => 'required|string'
    ]);     
    $sancion->update($request->all());
    return response()->json($sancion, 200);
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
    
    }
}
