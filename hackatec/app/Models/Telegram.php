<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telegram extends Model
{
    use HasFactory;

    public static function prueba(){
    	$mensaje = "";
    	$mensaje.='$arr = [';
    	$j = 35;
    	for($i = 0;$i<4;$i++){
    		$mensaje.="'";
    		$mensaje.=chr($j);
    		$mensaje.="'";
    		if($i!=3){
    			$mensaje.=",";
    		}
    		$j++;
    	}
    	$mensaje.="];";
    	return $mensaje;
    }

    public static function prueba2(){
    	$may = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
    	$min = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
    	$num = ['0','1','2','3','4','5','6','7','8','9'];
    	$car = ['#','$','%','&','@'];
    	$contra = '';
    	for($i=0;$i<32;$i++){
    		$var = random_int(1,4);
    		if($var == 1){
    			$tam = sizeof($may);
    			$contra.= $may[random_int(0,$tam-1)];
    		}else if($var == 2){
    			$tam = sizeof($min);
    			$contra.= $min[random_int(0,$tam-1)];
    		}else if($var == 3){
    			$tam = sizeof($num);
    			$contra.= $num[random_int(0,$tam-1)];
    		}else if($var==4){
    			$tam = sizeof($car);
    			$contra.= $car[random_int(0,$tam-1)];
    		}
    	} return $contra;

    }

    
}
