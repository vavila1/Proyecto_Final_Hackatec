<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Ruta '/Login', Peticion GET, Linkeada con la funcion index del controlador Login
Route::get('/login',[LoginController::class,'index']);
//Ruta '/Login', Petición POST, lineada a la funcion store del controlador Login
// Se le pone el nombre login para hacer llamadas a esta ruta de manera más sencilla
Route::post('/login',[LoginController::class,'store'])->name('login');
//Ruta '/login/2' se mostrará el código a ingresar en telegram y habrá espacio para llenar con el código que arroje telegram
Route::post('/login/2',[LoginController::class,'NIP'])->name('NIP');
Route::get('/logout',[LoginController::class,'logout'])->name('logout');
Route::get('/',function(){
	if(session('id')){
		return view('home');
	}else{
		return redirect('/login');
	}
})->name('home');
