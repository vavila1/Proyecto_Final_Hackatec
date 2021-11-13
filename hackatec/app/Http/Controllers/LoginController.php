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
    	if(Login::verificarNIP2($datos['ca_2'],$datos['correo']) == 'true'){
            $limpiar_nips = Login::limpiarNIPS($datos['correo']);
    		Login::crear_sesion($datos['correo']);
    		return redirect('/');
    	}else{
    		return redirect('/login')->with('error','Código Incorrecto');
    	}
    }

    public function show_r(){
        return view('registrar');
    }
    public function post_r(Request $request){
        $datos = $request->all();
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
    }
}
