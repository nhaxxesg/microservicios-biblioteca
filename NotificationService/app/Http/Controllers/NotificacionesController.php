<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Http\Controllers\Controller;

class NotificacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(Notification::all(),200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'user_id' => 'required|integer',
            'mensaje' => 'required|string|max:255',
            'f_envio' => 'required|date',
            'f_visto' => 'nullable|date',
            'tipo' => 'required|string|max:50',
            'estado' => 'required|string|max:50'
        ]);
 
        $notification = Notification::create($request->all());
        
        return response()->json($notification, 201);  
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $notification = Notification::find($id);
        if (!$notification) {
            return response()->json(['mensaje' => 'Notificación no encontrada'], 404);  
        }
        return response()->json($notification, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $notification = Notification::findOrFail($id);

        $request->validate([
            'user_id' => 'required|integer',
            'mensaje' => 'required|string|max:255',
            'f_envio' => 'required|date',
            'f_visto' => 'nullable|date',
            'tipo' => 'required|string|max:50',
            'estado' => 'required|string|max:50'
        ]);
        $notification->update($request->all());
        return response()->json($notification, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
