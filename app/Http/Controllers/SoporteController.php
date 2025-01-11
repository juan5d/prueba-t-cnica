<?php

namespace App\Http\Controllers;

use App\Interfaces\SoporteRepositoryInterface;
use App\Classes\ApiResponseClass;
use App\Http\Resources\SoporteResource;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\StoreSoporteRequest;
use App\Http\Requests\UpdateSoporteRequest;
use App\Models\Soporte;

class SoporteController extends Controller
{
    private SoporteRepositoryInterface $soporteRepositoryInterface;
    
    public function __construct(SoporteRepositoryInterface $soporteRepositoryInterface)
    {
        $this->soporteRepositoryInterface = $soporteRepositoryInterface;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreSoporteRequest $request)
    {
        // Obtener los datos validados del formulario
        $details = [
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'correo' => $request->correo,
        ];

        DB::beginTransaction();

        try {
            $soporte = $this->soporteRepositoryInterface->store($details);

            // Confirmar la transacción
            DB::commit();
            // Devolver una respuesta de éxito
            return ApiResponseClass::sendResponse(
                new SoporteResource($soporte),
                'Soporte creado exitosamente',
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
    public function show(Soporte $soporte)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Soporte $soporte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSoporteRequest $request, Soporte $soporte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Soporte $soporte)
    {
        //
    }
}
