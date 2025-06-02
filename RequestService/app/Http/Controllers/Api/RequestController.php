<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRequestValidation;
use App\Http\Requests\UpdateRequestValidation;
use App\Contracts\Services\RequestServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestController extends Controller
{
    /**
     * @param RequestServiceInterface $requestService
     */
    public function __construct(
        protected RequestServiceInterface $requestService
    ) {
    }

    /**
     * Crear una nueva solicitud de libro.
     *
     * @param CreateRequestValidation $request
     * @return JsonResponse
     */
    public function store(CreateRequestValidation $request): JsonResponse
    {
        $bookRequest = $this->requestService->createRequest($request->validated());

        return response()->json([
            'data' => $bookRequest,
            'message' => 'Solicitud creada exitosamente.'
        ], Response::HTTP_CREATED);
    }

    /**
     * Listar solicitudes con filtros opcionales.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'usuario_id',
            'estado',
            'fecha_inicio',
            'fecha_fin'
        ]);

        $perPage = $request->input('per_page', 15);
        
        $requests = $this->requestService->listRequests($filters, $perPage);

        return response()->json($requests);
    }

    /**
     * Obtener una solicitud específica.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $bookRequest = $this->requestService->getRequestById($id);

        return response()->json([
            'data' => $bookRequest
        ]);
    }

    /**
     * Actualizar una solicitud.
     *
     * @param UpdateRequestValidation $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateRequestValidation $request, int $id): JsonResponse
    {
        $bookRequest = $this->requestService->updateRequest($id, $request->validated());

        return response()->json([
            'data' => $bookRequest,
            'message' => 'Solicitud actualizada exitosamente.'
        ]);
    }
}
