<?php

namespace App\Http\Controllers;

use App\Interfaces\RequerimientoRepositoryInterface;
use App\Classes\ApiResponseClass;
use App\Http\Resources\RequerimientoResource;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\StoreRequerimientoRequest;
use App\Http\Requests\UpdateRequerimientoRequest;
use App\Models\Requerimiento;



class RequerimientoController extends Controller
{
    private RequerimientoRepositoryInterface $requerimientoRepositoryInterface;
    
    public function __construct(RequerimientoRepositoryInterface $requerimientoRepositoryInterface)
    {
        $this->requerimientoRepositoryInterface = $requerimientoRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->requerimientoRepositoryInterface->index();
        if($data->isEmpty()){
            $data = [
                'message' => 'No se encontraron registros',
                'status' => 404
            ];
            return ApiResponseClass::sendResponse($data,'',404);
        }

        return ApiResponseClass::sendResponse(RequerimientoResource::collection($data),'',200);
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
    public function store(StoreRequerimientoRequest $request)
    {
        
        DB::beginTransaction();

        try {
            $details = $request->validated();
            $requerimiento = $this->requerimientoRepositoryInterface->store($details);

            // Confirmar la transacción
            DB::commit();
            // Devolver una respuesta de éxito
            return ApiResponseClass::sendResponse(
                new RequerimientoResource($requerimiento),
                'Requerimiento creado exitosamente',
                201
            );
        } catch (\Exception $ex) {
            DB::rollBack();
            // Devolver una respuesta de error usando tu sistema personalizado
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Requerimiento $requerimiento)
    {
        $data = $this->requerimientoRepositoryInterface->getById($requerimiento->id);
        if($data->isEmpty()){
            $data = [
                'message' => 'No se encontraron registros',
                'status' => 404
            ];
            return ApiResponseClass::sendResponse($data,'',404);
        }

        return ApiResponseClass::sendResponse(RequerimientoResource::collection($data),'',200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Requerimiento $requerimiento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequerimientoRequest $request, Requerimiento $requerimiento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requerimiento $requerimiento)
    {
        //
    }
}
