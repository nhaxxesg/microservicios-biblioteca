<?php

namespace App\Http\Controllers;

use App\Models\Sancion;
use App\Http\Requests\StoreSancionRequest;
use App\Http\Requests\UpdateSancionRequest;
use App\Http\Resources\SancionResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SancionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Sancion::query();

            if ($request->has('estado')) {
                $query->where('estado', $request->estado);
            }

            if ($request->has('usuario_id')) {
                $query->where('usuario_id', $request->usuario_id);
            }

            if ($request->has('incluir_eliminadas') && $request->incluir_eliminadas) {
                $query->withTrashed();
            }

            $sanciones = $query->paginate($request->per_page ?? 15);
            
            return SancionResource::collection($sanciones);
        } catch (\Exception $e) {
            Log::error('Error al listar sanciones: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener las sanciones'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSancionRequest $request)
    {
        try {
            $sancion = Sancion::create($request->validated());
            
            Log::info('Sanción creada', ['sancion_id' => $sancion->id, 'usuario_id' => $sancion->usuario_id]);
            return new SancionResource($sancion);
        } catch (\Exception $e) {
            Log::error('Error al crear sanción: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $sancion = Sancion::withTrashed()->findOrFail($id);
            return new SancionResource($sancion);
        } catch (\Exception $e) {
            Log::error('Error al obtener sanción: ' . $e->getMessage());
            return response()->json(['error' => 'Sanción no encontrada'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSancionRequest $request, $id)
    {
        try {
            $sancion = Sancion::findOrFail($id);
            $sancion->update($request->validated());
            
            Log::info('Sanción actualizada', ['sancion_id' => $id]);
            return new SancionResource($sancion);
        } catch (\Exception $e) {
            Log::error('Error al actualizar sanción: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $sancion = Sancion::findOrFail($id);
            $sancion->delete();
            
            Log::info('Sanción eliminada', ['sancion_id' => $id]);
            return response()->json(null, 204);
        } catch (\Exception $e) {
            Log::error('Error al eliminar sanción: ' . $e->getMessage());
            return response()->json(['error' => 'Error al eliminar la sanción'], 400);
        }
    }

    public function porUsuario($usuario_id, Request $request)
    {
        try {
            $query = Sancion::where('usuario_id', $usuario_id);

            if ($request->has('estado')) {
                $query->where('estado', $request->estado);
            }

            $sanciones = $query->paginate($request->per_page ?? 15);
            
            return SancionResource::collection($sanciones);
        } catch (\Exception $e) {
            Log::error('Error al listar sanciones por usuario: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener las sanciones'], 500);
        }
    }

    public function porLibro($book_id, Request $request)
    {
        try {
            $query = Sancion::where('book_id', $book_id);

            if ($request->has('estado')) {
                $query->where('estado', $request->estado);
            }

            $sanciones = $query->paginate($request->per_page ?? 15);
            
            return SancionResource::collection($sanciones);
        } catch (\Exception $e) {
            Log::error('Error al listar sanciones por libro: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener las sanciones'], 500);
        }
    }
}
