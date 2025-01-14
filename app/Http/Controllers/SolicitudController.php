<?php

namespace App\Http\Controllers;

use App\Interfaces\SolicitudRepositoryInterface;
use App\Classes\ApiResponseClass;
use App\Http\Resources\SolicitudResource;
use Illuminate\Support\Facades\DB;

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
    // Obtener los datos validados del formulario
    

    DB::beginTransaction();

    try {
        $details = $request->validated();
        // Crear la solicitud
        $solicitud = $this->solicitudRepositoryInterface->store($details);

        // Obtener un soporte de manera aleatoria
        $soporte = \App\Models\Soporte::inRandomOrder()->first();

        if (!$soporte) {
            throw new \Exception("No hay soportes disponibles para asignar.");
        }

        // Crear el registro en la tabla requerimientos
        \App\Models\Requerimiento::create([
            'solicitud_id' => $solicitud->id,
            'soporte_id' => $soporte->id,
            'comentario' => 'Asignación automática de soporte',
            'estado' => 'Asignado',
            'fecha_solucion' => null, // O establece una fecha predeterminada si es necesario
        ]);

        // Confirmar la transacción
        DB::commit();

        // Devolver una respuesta de éxito
        return ApiResponseClass::sendResponse(
            new SolicitudResource($solicitud),
            'Solicitud creada exitosamente y asignada a un soporte',
            201
        );
    } catch (\Exception $ex) {
        DB::rollBack();
        // Registrar el error para depuración
        \Log::error('Error en SolicitudController@store: ' . $ex->getMessage());

        // Devolver una respuesta de error usando tu sistema personalizado
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
