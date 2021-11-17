<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Usuario;

class Login extends Model
{
    use HasFactory;

   protected $table = 'cuenta';

   public static function checarContra($datos){
   	//Se obtiene la contraseña asociada a la cuenta
   	$datos_cuenta = self::select('cuenta.contra as contra')
                ->where('cuenta.correo','=',$datos['correo'])
                ->get();
    //Se crea una variable de tipo arreglo para transformar de objeto a arreglo con el metodo toArray()
    $response = $datos_cuenta->toArray();
    //Si la consulta trae un arreglo nulo,no hay ninguna cuenta registrada con ese correo por lo tanto se regresa un false
    if($response == null){
    	return 'false';
    }
    //Se obtiene la contraseña
    $response = $response[0]['contra'];
    //Si la contraseña es igual a la registrada, se retorna true, sino, se retorna false
    if($datos['contra'] == $response){
    	return 'true';
    }else{
    	return 'false';
    }
   }

   //Función para crear la sesión con los datos siguientes: id de la cuenta, el nombre del usuario y la contraseña.
   public static function crear_sesion($correo){
    	$sesion = self::select('cuenta.id as id','usuario.nombre as nombre','usuario.apellido as apellido')
    				->where('cuenta.correo','=',$correo)
                    ->join('usuario','cuenta.id_usuario','usuario.id')
    				->get();
        foreach($sesion as $item){
            /*$request->session()->put('id',$item->id);
            $request->session()->put('nombre',$item->nombre);
            $request->session()->put('apellido',$item->apellido);*/
            session([
            	'id'=>$item->id,
            	'nombre' => $item->nombre,
            	'apellido' => $item->apellido
            ]);
        }
    	return 0;

    }

    public static function NIP(){
    	$pin = '';
    	for($i = 0;$i<6;$i++){
    		if($i == 0){
    			$pin.=random_int(1,9);
    		}else{
    			$pin.=random_int(0,9);
    		}
    	}
    	return $pin;
    }

    public static function verificarNIP2($NIP,$correo){
    	$nip = self::select('cuenta.ca_2 as ca_2')
    				->where([
    					['cuenta.correo','=',$correo]
    				])
    				->get();
    	$nip = $nip->toArray();
    	if($nip==null){
    		return 'false';
    	}
    	$nip = $nip[0]['ca_2'];
    	if($nip == $NIP){
    		return 'true';
    	}else{
    		return 'false';
    	}
    }
    public static function verificarNIP1($NIP,$chat_id){
    	$nip = self::select('cuenta.ca_1 as ca_1')
    				->where([
    					['cuenta.chat_id','=',$chat_id]
    				])
    				->get();
    	$nip = $nip->toArray();
    	if($nip==null){
    		return 'false';
    	}
    	$nip = $nip[0]['ca_1'];
    	if($nip == $NIP){
    		return 'true';
    	}else{
    		return 'false';
    	}
    }

    public static function modificarNIP2($chat_id){
    	$nip = self::NIP();
    	$id = self::select('cuenta.id as id')
    				->where([
    					['cuenta.chat_id','=',$chat_id]
    				])
    				->get();
    	$id = $id->toArray();
    	$id = $id[0]['id'];
    	$datos = self::find($id);
    	$datos->ca_2 = $nip;
    	$datos->save();
    	if($datos->save()){
    		return $nip;
    	}else{
    		return 'false';
    	}
    }

    //Este se usa únicamente para el registro
    public static function modificarNIP2R($correo){
        $nip = self::NIP();
        $id = self::select('cuenta.id as id')
                    ->where([
                        ['cuenta.correo','=',$correo]
                    ])
                    ->get();
        $id = $id->toArray();
        $id = $id[0]['id'];
        $datos = self::find($id);
        $datos->ca_2 = $nip;
        $datos->save();
        if($datos->save()){
            return $nip;
        }else{
            return 'false';
        }
    }
    public static function modificarNIP1($correo){
        $nip = self::NIP();
        $id = self::select('cuenta.id as id')
                    ->where([
                        ['cuenta.correo','=',$correo]
                    ])
                    ->get();
        $id = $id->toArray();
        $id = $id[0]['id'];
        $datos = self::find($id);
        $datos->ca_1 = $nip;
        $datos->save();
        if($datos->save()){
            return $nip;
        }else{
            return 'false';
        }
    }

    public static function limpiarNIPS($correo){
        $nip = self::NIP();
        $id = self::select('cuenta.id as id')
                    ->where([
                        ['cuenta.correo','=',$correo]
                    ])
                    ->get();
        $id = $id->toArray();
        $id = $id[0]['id'];
        $datos = self::find($id);
        $datos->ca_1 = null;
        $datos->ca_2 = null;
        $datos->save();
        if($datos->save()){
            return 'true';
        }else{
            return 'false';
        }
    }

    public static function validarChatID($chat_id){
        $validacion = self::select('cuenta.chat_id as chat_id')
                    ->where([
                        ['cuenta.chat_id','=',$chat_id]
                    ])
                    ->get();
        $validacion = $validacion->toArray();
        if($validacion==null){
            return 'false';
        }else{
            return 'true';
        }
    }

    public static function obtenerChatID($correo){
    	$chat_id = self::select('cuenta.chat_id as chat_id')
    				->where([
    					['cuenta.correo','=',$correo]
    				])
    				->get();
    	$chat_id = $chat_id->toArray();
    	if($chat_id!=null){
    		return $chat_id[0]['chat_id'];
    	}else{
    		return 'false';
    	}
    }

    public static function checarCuenta($correo){
        //$correo = $data['correo'];
        $cuenta = self::select('cuenta.id_estatus')
                    ->where([
                        ['cuenta.correo','=',$correo]
                    ])
                    ->get();
        $cuenta = $cuenta->toArray();
        if($cuenta == null){
            return 'false';
        }
        return $cuenta[0]['id_estatus'];
    }

    public static function vincularTelegram($correo,$chat_id,$nip){
        $cuenta = self::select('cuenta.id')
                    ->where([
                        ['cuenta.correo','=',$correo]
                    ])
                    ->get();
        $cuenta = $cuenta->toArray();
        if($cuenta==null){
            return 'false';
        }
        $cuenta = $cuenta[0]['id'];
        $cuenta = Login::find($cuenta);
        if($cuenta->ca_1 == $nip){
            $cuenta->chat_id = $chat_id;
            $cuenta->id_estatus = 2;
            $cuenta->save();
            if($cuenta->save()){
                return 'true';
            }
        }else{
            return 'false';
        }

    }

    public static function registrarCuenta($data){
        $usuario = new Usuario;
        $cuenta = new Login;
        DB::beginTransaction();
        $usuario->nombre = $data['nombre'];
        $usuario->apellido = $data['apellido'];
        $usuario->save();
        $ultimo = Usuario::obtenerUltimo();
        $cuenta->correo = $data['correo'];
        $cuenta->contra = $data['contra'];
        $cuenta->id_estatus = 1;
        $cuenta->id_usuario = $ultimo;
        $cuenta->save();
        if($cuenta->save() == true && $usuario->save() == true){
            DB::commit();
            return 'true';
        }else{
            DB::rollBack();
            return 'false';
        }
    }
}
