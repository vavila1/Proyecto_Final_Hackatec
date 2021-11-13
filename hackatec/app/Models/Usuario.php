<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuario';

    //Se busca el nombre y apellido del usuario según el id de la cuenta proporcionada
    public static function datosUsuario($id_cuenta){
    	//Se hace la consulta con eloquent
    	$datos_usuario = self::select('usuario.nombre as nombre','usuario.apellido as apellido')
                ->where('usuario.id_cuenta','=',$id_cuenta)
                ->get();
         //Se declara un arreglo para transformar el formato de salida de objeto a arreglo
         $response = [];
         foreach($datos_usuario as $item){
         	$response = [
         		'nombre' => $item->nombre,
         		'apelldio' => $item->apellido
         	];
         }
         return $response;
    }

    public static function obtenerUltimo(){
       $ultimo = self::select('usuario.id as id')
                ->orderByDesc('usuario.id')
                ->get();
        $ultimo = $ultimo->toArray();
        $ultimo = $ultimo[0]['id'];
        return $ultimo;
    }
}
