<?php

namespace App\Contracts\Services;

use App\Models\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface RequestServiceInterface
{
    /**
     * Crear una nueva solicitud
     *
     * @param array $data
     * @return Request
     */
    public function createRequest(array $data): Request;

    /**
     * Obtener una solicitud por su ID
     *
     * @param int $id
     * @return Request
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getRequestById(int $id): Request;

    /**
     * Listar solicitudes con filtros
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function listRequests(array $filters, int $perPage = 15): LengthAwarePaginator;

    /**
     * Actualizar una solicitud
     *
     * @param int $id
     * @param array $data
     * @return Request
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function updateRequest(int $id, array $data): Request;
}
