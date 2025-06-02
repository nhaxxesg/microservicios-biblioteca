<?php

namespace App\Repositories;

use App\Models\Request;
use App\Contracts\Repositories\RequestRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class RequestRepository implements RequestRepositoryInterface
{
    /**
     * @param Request $model
     */
    public function __construct(protected Request $model)
    {
    }

    /**
     * Crear una nueva solicitud
     *
     * @param array $data
     * @return Request
     */
    public function create(array $data): Request
    {
        return $this->model->create($data);
    }

    /**
     * Obtener una solicitud por su ID
     *
     * @param int $id
     * @return Request|null
     */
    public function findById(int $id): ?Request
    {
        return $this->model->find($id);
    }

    /**
     * Listar solicitudes con filtros y paginación
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function list(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        // Aplicar filtros
        $this->applyFilters($query, $filters);

        return $query->paginate($perPage);
    }

    /**
     * Actualizar una solicitud
     *
     * @param Request $request
     * @param array $data
     * @return Request
     */
    public function update(Request $request, array $data): Request
    {
        $request->update($data);
        return $request->fresh();
    }

    /**
     * Aplicar filtros a la consulta
     *
     * @param Builder $query
     * @param array $filters
     * @return void
     */
    protected function applyFilters(Builder $query, array $filters): void
    {
        if (isset($filters['usuario_id'])) {
            $query->where('usuario_id', $filters['usuario_id']);
        }

        if (isset($filters['estado'])) {
            $query->where('estado', $filters['estado']);
        }

        if (isset($filters['fecha_inicio'])) {
            $query->where('fecha_de_registro', '>=', $filters['fecha_inicio']);
        }

        if (isset($filters['fecha_fin'])) {
            $query->where('fecha_de_registro', '<=', $filters['fecha_fin']);
        }
    }
}
