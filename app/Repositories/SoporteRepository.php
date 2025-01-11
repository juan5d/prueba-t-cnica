<?php

namespace App\Repositories;
use App\Models\Soporte;
use App\Interfaces\SoporteRepositoryInterface;
class SoporteRepository implements SoporteRepositoryInterface
{
    public function index(){
        return Soporte::all();
    }

    public function getById($id){
       return Soporte::findOrFail($id);
    }

    public function store(array $data){
       return Soporte::create($data);
    }

    public function update(array $data,$id){
       return Soporte::whereId($id)->update($data);
    }
    
    public function delete($id){
        Soporte::destroy($id);
    }
}
