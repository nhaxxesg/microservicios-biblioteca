<?php

namespace App\Contracts\Repositories;

use App\Models\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface RequestRepositoryInterface
{
    /**
     * Crear una nueva solicitud
     *
     * @param array $data
     * @return Request
     */
    public function create(array $data): Request;

    /**
     * Obtener una solicitud por su ID
     *
     * @param int $id
     * @return Request|null
     */
    public function findById(int $id): ?Request;

    /**
     * Listar solicitudes con filtros y paginación
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function list(array $filters, int $perPage = 15): LengthAwarePaginator;

    /**
     * Actualizar una solicitud
     *
     * @param Request $request
     * @param array $data
     * @return Request
     */
    public function update(Request $request, array $data): Request;
}
