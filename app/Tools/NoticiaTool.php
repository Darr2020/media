<?php

namespace App\Tools;

/**
 * Clase utilizada para ayuda en las vistas blade
 */
class NoticiaTool {
    
    /**
     * Imprimir correctamente la cantidad de vistas en K o M.
     */
    public static function fitViews($vistas)
    {
        $units = [
            '100000000' => '100<span>M+</span>',
            '10000000' => '10<span>M+</span>',
            '1000000' => '1<span>M+</span>',
            '100000' => '100<span>K+</span>',
            '10000' => '10<span>K+</span>',
            '1000' => '1<span>K+</span>',
        ];
        
        foreach($units as $key =>$u)
        {
            if($vistas >= (integer) $key)
            {
                echo $u;
                return;
            }
        }

        echo $vistas;
        return;
    }

    /**
     * La posicion del titulo en la vista dinamicamente.
     */
    public static function getPosition($siglas)
    {
        $valores = [
            'ii' => 'inferior',
            'si' => 'superior',
            'ci' => 'central',
            'se' => 'superior',
            'ie' => 'inferior',
        ];

        return $valores[$siglas];
    }

    /**
     * La posicion del titulo en la vista dinamicamente.
     */
    public static function format($date)
    {
        $date = new \DateTime($date);
        return $date->format('d-m-Y');
    }

    /**
     * La posicion del titulo en la vista dinamicamente.
     */
    public static function hour($date)
    {
        $date = new \DateTime($date);
        return $date->format('h:m a');
    }

    /**
     * Colocar las posiciones de las paginas principales
     */
    public static function mainPosition($pos)
    {
        $valores = [
            'inferior' => ['ii','ie'],
            'superior' => ['se','si'],
            'central' => ['ci'],
        ];

        foreach($valores as $key => $v)
        {
            if(in_array($pos, $v))
            {
                return $key;
            }
        }
    }
}
