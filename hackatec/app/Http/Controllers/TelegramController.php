<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login;
use Illuminate\Support\Facades\Http;

class TelegramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        /*$data = $request->all();
        $mensaje = $data['message']['text'];
        $separados = explode(" ", $mensaje);
        $chat_id = Login::obtenerChatID($separados[0]);
        $chat_id_sender = $data['message']['chat']['id'];
        if(sizeof($separados) > 1){
            if(Login::verificarNIP1($separados[1],$separados[0]) == 'true'){
                $pin2 = Login::modificarNIP2($separados[0]);
                if($pin2 !='false'){
                    $response2 = Http::post(env('APPI').'sendMessage',[
                    'chat_id'=>$chat_id,
                    'text'=> $pin2
                ]);
                }
            }else{
                $response2 = Http::post(env('APPI').'sendMessage',[
                    'chat_id'=>$chat_id_sender,
                    'text'=> "C贸digo Incorrecto"
                ]);
            }
        }else{
            $response2 = Http::post(env('APPI').'sendMessage',[
                    'chat_id'=>$chat_id_sender,
                    'text'=> 'Recuerda que tienes que mandar tu correo junto con el codigo de acceso'."\n".'Ejemplo'."\n".'correo@gmail.com 123456'
                ]);
        }*/
        $data = $request->all();
        $chat_id_sender = $data['message']['chat']['id'];
        $mensaje = $data['message']['text'];
        $val = Login::validarChatID($chat_id_sender);
        if(Login::validarChatID($chat_id_sender) == 'true'){
            if(Login::verificarNIP1($mensaje,$chat_id_sender) == 'true'){
                $pin2 = Login::modificarNIP2($chat_id_sender);
                if($pin2 !='false'){
                    $response2 = Http::post(env('APPI').'sendMessage',[
                    'chat_id'=>$chat_id_sender,
                    'text'=> $pin2
                ]);
                }
            }else{
                $response2 = Http::post(env('APPI').'sendMessage',[
                    'chat_id'=>$chat_id_sender,
                    'text'=> "Código Incorrecto"
                ]);
            }
        }else{
            $separados = explode(" ", $mensaje);
            if(sizeof($separados) > 1){
                $res = Login::vincularTelegram($separados[0],$chat_id_sender,$separados[1]);
                if($res == 'true'){
                    $pin2 = Login::modificarNIP2($chat_id_sender);
                    if($pin2 !='false'){
                        $response2 = Http::post(env('APPI').'sendMessage',[
                        'chat_id'=>$chat_id_sender,
                        'text'=> $pin2
                    ]);
                    }
                }else{
                    $response2 = Http::post(env('APPI').'sendMessage',[
                        'chat_id'=>$chat_id_sender,
                        'text'=> 'Código Incorrecto',
                    ]);
                }
            }
        }
        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
