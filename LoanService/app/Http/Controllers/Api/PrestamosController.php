<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PrestamosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Prestamo::query();

        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('libro_id')) {
            $query->where('libro_id', $request->libro_id);
        }

        if ($request->has('incluir_eliminados') && $request->incluir_eliminados) {
            $query->withTrashed();
        }

        return $query->paginate($request->per_page ?? 15);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'libro_id' => 'required|integer|exists:libros,id',
            'user_id' => 'required|integer|exists:users,id',
            'fecha_prestamo' => 'required|date',
            'fecha_devolucion_prevista' => 'required|date|after:fecha_prestamo',
            'estado' => 'required|string|in:' . implode(',', Prestamo::ESTADOS()),
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // TODO: Verify if user has active sanctions
        // TODO: Verify if book is available

        $prestamo = Prestamo::create($request->all());

        return response()->json($prestamo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $prestamo = Prestamo::findOrFail($id);

        // Check if user has permission to view this loan
        if (!Auth::user()->isAdmin() && Auth::id() !== $prestamo->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($prestamo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $prestamo = Prestamo::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'fecha_devolucion_real' => 'nullable|date',
            'estado' => 'sometimes|string|in:' . implode(',', Prestamo::ESTADOS()),
            'sancion_id' => 'nullable|integer|exists:sanciones,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->has('fecha_devolucion_real')) {
            $prestamo->fecha_devolucion_real = $request->fecha_devolucion_real;
            
            // If returning late, might need to create a sanction
            if ($prestamo->isRetrasado()) {
                // TODO: Integration with Sanctions service
            }
        }

        $prestamo->update($request->all());

        return response()->json($prestamo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $prestamo = Prestamo::findOrFail($id);
        $prestamo->delete();

        return response()->json(null, 204);
    }

    public function userLoans($userId)
    {
        // Check if user has permission to view these loans
        if (!Auth::user()->isAdmin() && Auth::id() !== (int)$userId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $prestamos = Prestamo::where('user_id', $userId)
            ->when(request('estado'), function ($query, $estado) {
                return $query->where('estado', $estado);
            })
            ->paginate(request('per_page', 15));

        return response()->json($prestamos);
    }
}
