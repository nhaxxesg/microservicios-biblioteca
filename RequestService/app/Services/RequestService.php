<?php

namespace App\Services;

use App\Models\Request;
use App\Contracts\Services\RequestServiceInterface;
use App\Contracts\Repositories\RequestRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class RequestService implements RequestServiceInterface
{
    /**
     * @param RequestRepositoryInterface $repository
     */
    public function __construct(protected RequestRepositoryInterface $repository)
    {
    }

    /**
     * Crear una nueva solicitud
     *
     * @param array $data
     * @return Request
     */    
    public function createRequest(array $data): Request
    {
        // Validar estado inicial
        $data['estado'] = 'pendiente';
        
        // Eliminar cualquier valor de fecha_de_registro que venga en los datos
        unset($data['fecha_de_registro']);
        
        // Asegurar que book_id está presente
        if (!isset($data['book_id'])) {
            throw new \InvalidArgumentException('El ID del libro es requerido para crear una solicitud');
        }
        
        $request = $this->repository->create($data);
        
        // Registrar el evento
        Log::info('Nueva solicitud creada', ['request_id' => $request->id]);
        
        return $request;
    }

    /**
     * Obtener una solicitud por su ID
     *
     * @param int $id
     * @return Request
     * @throws ModelNotFoundException
     */
    public function getRequestById(int $id): Request
    {
        $request = $this->repository->findById($id);
        
        if (!$request) {
            throw new ModelNotFoundException("Solicitud no encontrada con ID: {$id}");
        }
        
        return $request;
    }

    /**
     * Listar solicitudes con filtros
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function listRequests(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->list($filters, $perPage);
    }

    /**
     * Actualizar una solicitud
     *
     * @param int $id
     * @param array $data
     * @return Request
     * @throws ModelNotFoundException
     */
    public function updateRequest(int $id, array $data): Request
    {
        $request = $this->getRequestById($id);
        
        // Validar el estado si se está actualizando
        if (isset($data['estado']) && !in_array($data['estado'], Request::ESTADOS)) {
            throw new \InvalidArgumentException('Estado no válido');
        }
        
        $request = $this->repository->update($request, $data);
        
        // Registrar el evento
        Log::info('Solicitud actualizada', [
            'request_id' => $request->id,
            'changes' => $data
        ]);
        
        return $request;
    }
}
