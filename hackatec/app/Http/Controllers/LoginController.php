<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login;

class LoginController extends Controller
{
    //

	//Ruta /login Peticion GET
    public function index(){
    	//Retorna la vista llamada login
    	return view('login');
    }

    // Ruta /login Peticion POST que obtiene como parámetro un objeto de tipo Request
    public function store(Request $request){
    	//Pasamos todos los datos de objeto tipo Request a arreglo con la llamada a la función all() del objeto
    	$datos = $request->all();
    	//Si la cuenta existe y la contraseña es igual, se redirige al home
    	if(Login::checarContra($datos) == 'true'){
            $codigo = Login::modificarNIP1($datos['correo']);
            if($codigo !='false'){
                return view('login2',[
                'codigo' => $codigo,
                'correo' => $datos['correo']
                ]);
            }
    	}else{
    		return back()->with('error','Usuario y/o contraseña incorrectos');
    	}
    }

    //Ruta '/logout' Peticion GET
    public function logout(){
    	//Eliminamos todas las variables de sesión
        session()->flush();
        return redirect('/login');
    }

    public function NIP(Request $request){
    	$datos = $request->all();
        if(isset($datos['ca_2'])){
            if(Login::verificarNIP2($datos['ca_2'],$datos['correo']) == 'true'){
                $limpiar_nips = Login::limpiarNIPS($datos['correo']);
                Login::crear_sesion($datos['correo']);
                return redirect('/');
            }else{
                return redirect('/login')->with('error','Código Incorrecto');
            }
        }else{
            if(isset($datos['registro'])){
                $codigo = Login::modificarNIP1($datos['correo']);
                if($codigo !='false'){
                    return view('login2',[
                    'codigo' => $codigo,
                    'correo' => $datos['correo'],
                    'registro' => 1,
                    'error' => 'Debes ingresar el código proporcionado por el bot en Telegram',
                    ]);
                }
            }else{
                $codigo = Login::modificarNIP1($datos['correo']);
                if($codigo !='false'){
                    return view('login2',[
                    'codigo' => $codigo,
                    'correo' => $datos['correo'],
                    'error' => 'Debes ingresar el código proporcionado por el bot en Telegram',
                    ]);
                }
            }
        }
    }

    public function show_r(){
        return view('registrar');
    }
    public function post_r(Request $request){
        $datos = $request->all();
        $vc = Login::checarCuenta($datos['correo']);
        if( $vc == 'false'){
            $conf = Login::registrarCuenta($datos);
            if($conf == 'true'){
                $codigo = Login::modificarNIP1($datos['correo']);
                if($codigo !='false'){
                    return view('login2',[
                    'codigo' => $codigo,
                    'correo' => $datos['correo'],
                    'registro' => 1
                    ]);
                }
            }else{
                return redirect('/registro');
            }
        }else if($vc == 1){
            $codigo = Login::modificarNIP1($datos['correo']);
            return view('login2',[
                    'codigo' => $codigo,
                    'correo' => $datos['correo'],
                    'registro' => 1
                    ]);
        }else if($vc == 2){
            return redirect('/login');
        }
    }
}
