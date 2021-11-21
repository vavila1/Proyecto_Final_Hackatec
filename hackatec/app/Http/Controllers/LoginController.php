<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login;
use Illuminate\Support\Facades\Validator;

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
        $datos_val = Login::checarContra($datos);
        $datos['datos_val'] = $datos_val;
        $validator = Validator::make($datos, 
            //rules
            [
                'correo' => 'required|email',
                'contra' => 'required',
                'datos_val' => 'accepted',
            ],
            //messages
            [
                'correo.required' => 'El correo no puede estar vacio',
                'contra.required' => 'Debes ingresar tu contraseña',
                //'ends_with' => 'Debes ingresar con tu correo institucional',
                'email' => 'Debe ser un correo válido',
                'datos_val.accepted' => 'Usuario y/o Contraseña no validos',
            ]
        );
        if ($validator->fails()) {
            return redirect("/login")->withErrors($validator);
        }else{
            $codigo = Login::modificarNIP1($datos['correo']);
            if($codigo !='false'){
                return view('login2',[
                'codigo' => $codigo,
                'correo' => $datos['correo']
                ]);
            }
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
            if(isset($datos['registro'])){
                if(Login::verificarNIP2($datos['ca_2'],$datos['correo']) == 'true'){
                    $limpiar_nips = Login::limpiarNIPS($datos['correo']);
                    Login::crear_sesion($datos['correo']);
                    return redirect('/');
                }else{
                    $limpiar_nips = Login::limpiarNIPS($datos['correo']);
                    $codigo = Login::modificarNIP1($datos['correo']);
                    if($codigo !='false'){
                        return view('login2',[
                        'codigo' => $codigo,
                        'correo' => $datos['correo'],
                        'registro' => 1,
                        'error' => 'Código Incorrecto',
                        ]);
                    }
                }
            }else{
                if(Login::verificarNIP2($datos['ca_2'],$datos['correo']) == 'true'){
                    $limpiar_nips = Login::limpiarNIPS($datos['correo']);
                    Login::crear_sesion($datos['correo']);
                    return redirect('/');
                }else{
                    $limpiar_nips = Login::limpiarNIPS($datos['correo']);
                    return redirect('/login')->with('error','Código Incorrecto');
                }
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
        //Usamos la funcion del Validator. Recibe como parámetro un array con el contenido,un segundo array con las reglas y un tercer array con los mensajes que se van a mandar en caso de fallar.
        $validator = Validator::make($datos, 
            //rules
            [

                'nombre' => 'required|regex:/^([A-Za-z ÁáÉéÍíÓóÚúÜü]){1,}$/',
                'apellido' => 'required|regex:/^([A-Za-z ÁáÉéÍíÓóÚúÜü]){1,}$/',
                'correo' => 'required|email',
                'contra' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$%&@!])[A-Za-z\d#$%&@!]{16,}$/',
            ],
            //messages
            [
                'correo.required' => 'El correo no puede estar vacio',
                'correo.email' => 'Debes ingresar un correo válido',
                'contra.required' => 'Debes ingresar una contraseña',
                'contra.regex' => 'La contraseña debe ser al menos de 16 caracteres, contener al menos una letra mayúscula, una letra minúscula, un número y uno de los siguientes caracteres especiales: #,$,%,&,@,!',
                'nombre.required' => 'Debes ingresar tu nombre',
                'apellido.required' => 'Debes ingresar tu apellido',
                'nombre.regex' => 'Tu nombre solo debe contener letras',
                'apellido.regex' => 'Tu apellido solo debe contener letras',
            ]
        );
        //Lógica que checa si hay alguna falla. Y en caso de haber, se redirige al registro con los errores.
        //Para que los usuarios puedan visualizar mejor los errores, se escogió la versión completa que muestra todos los errores. Esto consume un poquito más poder de compúto y tiempo pero es para ser transparente con el usuario.
        if ($validator->fails()) {
            return redirect("/registro")->withErrors($validator);
        }else{
            //En caso de no fallar, checamos si el correo ya lo tenemos registrado previamente y el resultado se guarda en la variable vc que significa verificar correo.
            $vc = Login::checarCuenta($datos['correo']);
            //Si no lo tenemos registrado, registramos todo.
            if( $vc == 'false'){
                $conf = Login::registrarCuenta($datos);
                //Si se guardó con éxito, se procede a la vinculación de Telegram con la cuenta
                if($conf == 'true'){
                    //Se genera el primer OTP y se guarda en la base de datos
                    $codigo = Login::modificarNIP1($datos['correo']);
                    //Si no hubo alguna falla al guardar el código, se regresa la vista login2 con el código, el correo y una tercer variable que nos ayuda a identificar si es un registro. (El login no contiene esta variable)
                    if($codigo !='false'){
                        return view('login2',[
                        'codigo' => $codigo,
                        'correo' => $datos['correo'],
                        'registro' => 1
                        ]);
                    }
                }else{
                    //Si hubo algún error en el registro, se redirige a la sección de registro.
                    return redirect('/registro');
                }
            //Si la cuenta ya existe pero no hay una vinculación existente entre la cuenta y Telegram, se devuelve la vista login2 con el código necesario para vincular la cuenta.
            }else if($vc == 1){
                //Se genera el primer OTP
                $codigo = Login::modificarNIP1($datos['correo']);
                return view('login2',[
                        'codigo' => $codigo,
                        'correo' => $datos['correo'],
                        'registro' => 1
                        ]);
            }else if($vc == 2){
                //Si ya es un usuario registrado y tiene una vinculación existente, no se puede registrar de nuevo y se le manda al login.
                return redirect('/login');
            }
        }
    }
}
