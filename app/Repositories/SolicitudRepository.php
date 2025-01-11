<?php

namespace App\Repositories;
use App\Models\Solicitud;
use App\Interfaces\SolicitudRepositoryInterface;
class SolicitudRepository implements SolicitudRepositoryInterface
{
    public function index(){
        return Solicitud::all();
    }

    public function getById($id){
       return Solicitud::findOrFail($id);
    }

    public function store(array $data){
       return Solicitud::create($data);
    }

    public function update(array $data,$id){
       return Solicitud::whereId($id)->update($data);
    }
    
    public function delete($id){
        Solicitud::destroy($id);
    }
}
