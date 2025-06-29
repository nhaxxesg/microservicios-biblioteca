<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Loans;
use Illuminate\Http\Request;

class LoansController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(Loans::all(), 200);
    }

    /**
     * Obtener todos los préstamos de un usuario específico.
     */
    public function prestamosPorUsuario($id_usuario)
    {
        $prestamos = Loans::where('id_lector', $id_usuario)->get();
        
        if ($prestamos->isEmpty()) {
            return response()->json(['mensaje' => 'No se encontraron préstamos para este usuario'], 404);
        }
        
        return response()->json($prestamos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
        'id_admin' => 'required|integer',
        'id_lector' => 'required|integer',
        'id_libro' => 'required|integer',
        'loan_date' => 'required|date',
        'f_devolucion_establecida' => 'required|date',
        'f_devolucion_real' => 'nullable|date',
        'estado' => 'required|in:pendiente,devuelto,activo',
    ]);

        $Loan = Loans::create($request->all());
        return response()->json($Loan, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $Loan = Loans::find($id);
        if (!$Loan) {
            return response()->json(['message' => 'prestamo no encontrado'], 404);
        }
        return response()->json($Loan, 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $Loan = Loans::find($id);
        if (!$Loan) {
            return response()->json(['message' => 'prestamo no encontrado'], 404); 
        }
        $request->validate([
            'id_admin' => 'required|integer',
            'id_lector' => 'required|integer',
            'id_libro' => 'required|integer',
            'loan_date' => 'required|date',
            'f_devolucion_establecida' => 'required|date',
            'f_devolucion_real' => 'nullable|date',
            'estado' => 'required|in:pendiente,devuelto',
        ]);
        $Loan->update($request->all());
        return response()->json($Loan, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
