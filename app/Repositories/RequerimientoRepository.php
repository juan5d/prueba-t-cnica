<?php

namespace App\Repositories;
use App\Models\Requerimiento;
use App\Interfaces\RequerimientoRepositoryInterface;
class RequerimientoRepository implements RequerimientoRepositoryInterface
{
      /**
     * Obtener todos los requerimientos con sus relaciones.
     */
    public function index()
    {
        return Requerimiento::with(['solicitud', 'soporte'])->get(); // Eager loading para cargar relaciones
    }

    /**
     * Obtener un requerimiento por su ID con sus relaciones.
     *
     * @param int $id
     * @return Requerimiento
     */
    public function getById($id)
    {
        return Requerimiento::with(['solicitud', 'soporte'])->findOrFail($id);
    }

    /**
     * Crear un nuevo requerimiento.
     *
     * @param array $data
     * @return Requerimiento
     */
    public function store(array $data)
    {
        return Requerimiento::create($data);
    }

    /**
     * Actualizar un requerimiento existente.
     *
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update(array $data, $id)
    {
        $requerimiento = Requerimiento::findOrFail($id);

        return $requerimiento->update($data);
    }

    /**
     * Eliminar un requerimiento por su ID.
     *
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        Requerimiento::destroy($id);
    }
}