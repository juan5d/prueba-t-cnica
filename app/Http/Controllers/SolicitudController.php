<?php

namespace App\Http\Controllers;

use App\Interfaces\SolicitudRepositoryInterface;
use App\Classes\ApiResponseClass;
use App\Http\Resources\SolicitudResource;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\StoreRequerimientoRequest;
use App\Http\Requests\StoreSolicitudRequest;
use App\Http\Requests\UpdateSolicitudRequest;
use App\Models\Solicitud;

class SolicitudController extends Controller
{
    private SolicitudRepositoryInterface $solicitudRepositoryInterface;
    
    public function __construct(SolicitudRepositoryInterface $solicitudRepositoryInterface)
    {
        $this->solicitudRepositoryInterface = $solicitudRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->solicitudRepositoryInterface->index();
        if($data->isEmpty()){
            $data = [
                'message' => 'No se encontraron registros',
                'status' => 404
            ];
            return ApiResponseClass::sendResponse($data,'',404);
        }

        return ApiResponseClass::sendResponse(SolicitudResource::collection($data),'',200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSolicitudRequest $request)
    {
        DB::beginTransaction();

        try {
            // Crear la solicitud
            $details = $request->validated();
            $solicitud = $this->solicitudRepositoryInterface->store($details);

            // Obtener un soporte aleatorio
            $soporte = \App\Models\Soporte::inRandomOrder()->first();
            if (!$soporte) {
                throw new \Exception("No hay soportes disponibles para asignar.");
            }

            // Llamar a RequerimientoController@store
            $requerimientoRequest = new StoreRequerimientoRequest([
                'solicitud_id' => $solicitud->id,
                'soporte_id' => $soporte->id,
                'comentario' => 'Asignación automática de soporte',
                'estado' => 'Asignado',
                'fecha_solucion' => null,
            ]);

            $this->requerimientoController->store($requerimientoRequest);

            DB::commit();

            return ApiResponseClass::sendResponse(
                new SolicitudResource($solicitud),
                'Solicitud creada exitosamente y asignada a un soporte',
                201
            );
        } catch (\Exception $ex) {
            DB::rollBack();
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Solicitud $solicitud)
    {
        $data[] = $this->solicitudRepositoryInterface->getById($solicitud->getAttributes()['id']);

        if(!$data){
            $data = [
                'message' => 'No se encontraron registros',
                'status' => 404
            ];
            return ApiResponseClass::sendResponse($data,'',404);
        }

        return ApiResponseClass::sendResponse(SolicitudResource::collection($data),'',200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Solicitud $solicitud)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSolicitudRequest $request, Solicitud $solicitud)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Solicitud $solicitud)
    {
        //
    }
}
