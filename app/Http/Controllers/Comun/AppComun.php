<?php

namespace App\Http\Controllers\Comun;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class AppComun extends Controller {

    public static function convertir_a_mayusculas($dato) {
        $params = mb_strtoupper($dato, 'UTF-8');
        return $params;
    }

    public static function convertir_a_minusculas($dato) {
        $params = mb_strtolower($dato, 'UTF-8');
        return $params;
    }

    public static function dar_formato_fecha_slash($fecha) {
        try {
            if ($fecha != '' || $fecha != NULL) {
                $ano = substr($fecha, 0, 4);
                $mes = substr($fecha, 5, 2);
                $dia = substr($fecha, 8, 2);
                
                $fecha_formateada = $dia . '/' . $mes . '/' . $ano;
            } else {
                $fecha_formateada = 'Sin Fecha';
            }
            return $fecha_formateada;
        } catch (Exception $e) {
            echo 'Error al dar formato a la fecha';
        }
    }

    public static function dar_formato_fecha_guion($fecha) {
        try {
            if ($fecha != '' || $fecha != NULL) {
//                $anom = substr($fecha, 0, 4);
//                $mesm = substr($fecha, 5, 2);
//                $diam = substr($fecha, 8, 2);
                $anom = substr($fecha, 6, 9); //año
                $mesm = substr($fecha, 3, 2); //mes
                $diam = substr($fecha, 0, 2); //dia
                $fecha_formateada = $diam . '-' . $mesm . '-' . $anom;
            } else {
                $fecha_formateada = 'Sin Fecha';
            }
            return $fecha_formateada;
        } catch (Exception $e) {
            echo 'Error al dar formato con guión a la fecha';
        }
    }

    public static function girarFormatoFecha($fecha) {
        try {
            if ($fecha != '' || $fecha != NULL) {
                $anom = substr($fecha, 6, 9); //año
                $mesm = substr($fecha, 3, 2); //mes
                $diam = substr($fecha, 0, 2); //dia
                $fecha_formateada = $anom . '-' . $mesm . '-' . $diam;
            } else {
                $fecha_formateada = 'Sin Fecha';
            }
            return $fecha_formateada;
        } catch (Exception $e) {
            echo 'Error al dar formato con guión a la fecha';
        }
    }

    public static function conv_a_mayus_prim_letra($dato) {
        $params = ucwords(mb_strtolower(str_replace("Ñ", "ñ", $dato)));
        return $params;
    }

    public function cedula_formato($dato) {
        $params = number_format($dato, 0, ",", ".");
        return $params;
    }

    public static function passw_generic($var) {
        $params = password_hash($var, PASSWORD_DEFAULT);
        return $params;
    }

    
    public static function generateRandomString($len = 20){
        $str = '1234567890asdfghjklñqwertyuiopzxcvbnnm';
        $string = '';
        for($i = 0; $i <= $len; $i++){
            $string .= $str[rand(0, strlen($str) - 1)];
        }
        return $string;
    }

}
