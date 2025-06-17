<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // GET: Listar todas las categorías
    public function index(Request $request)
    {
        // Puedes pasar ?per_page=10 como query param para definir la cantidad por página
        $perPage = $request->get('per_page', 10);

        $categories = Category::paginate($perPage);

        return response()->json($categories, 200);
    }

    // POST: Crear una nueva categoría
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'grupo' => 'required|string|max:255',
        ]);

        $category = Category::create($request->all());

        return response()->json($category, 201);
    }

    // PUT: Actualizar una categoría
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'grupo' => 'required|string|max:255',
        ]);

        $category->update($request->all());

        return response()->json($category, 200);
    }
}
