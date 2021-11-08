<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login;

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
        $data = $request->all();
        $mensaje = $data['message']['text'];
        $separados = explode(" ", $mensaje);
        //$chat_id_sender = $data['message']['chat']['id'];
        $chat_id = obtenerChatID($separados[0]);
        if(Login::verificarNIP1($separados[1],$separados[0]) == 'true'){
            $pin2 = Login::modificarNIP2($separados[0]);
            if($response !='false'){
                $response2 = Http::post(env('APPI').'sendMessage',[
                'chat_id'=>$chat_id,
                'text'=> $pin2
            ]);
            }
        }
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
