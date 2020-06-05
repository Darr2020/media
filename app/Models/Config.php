<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;

class Config
{

    /**
     * Propiedades para manejamiento de objetos
     */
    protected $current;
    protected $selected;
    protected $currentConf;

    /**
     * Devuelve una instancia para tratar una configuracion en especifico
     */
    public function __construct($type = null, $valor = null){
        if($type){
            $this->setCurrent(self::getConfig($type));
            $this->currentConf = $type;
        }
        if(is_numeric($valor)){
            $this->get($valor);
        }
    }

    /**
     * Tipos de Archivos de Configuracion
     */
    const MAIN = 1;
    const ELEMENTS = 2;
    const IFRAMES = 3;
    const GRIDS = 4;
    const LAYOUTS = 5;
    const ELEMENTS_APPROVED = 6;
    const GRIDS_APPROVED = 7;
    const ELEMENTS_OLD = 8;
    const GRIDS_OLD = 9;

    /**
     * Guardar la llave en la configuración de $current
     */
    public function save(){
        $selected = $this->getSelected();
        $current = $this->getCurrent();
        $key = $selected->key;
        unset($selected->key);
        $current[$key] = $selected;
        Config::setConfig($this->currentConf, $current);
    }

    /**
     * Guardar el current completamente
     */
    public function saveAll(){
        $current = $this->getCurrent();
        Config::setConfig($this->currentConf, $current);
    }

    /**
     * Obtener toda la informacion de una fila especifica de la configuracion
     * @param $type - El tipo de configuracion
     * @return $value - La fila solicitada
     */
    public static function getByKey($type, $value){
        return self::getConfig($type)[$value];
    }

    /**
     * Obtener toda la informacion de una fila especifica de la configuracion
     * @param $type - El tipo de configuracion
     * @return $value - La fila solicitada
     */
    public static function getByValue($type, $key, $value){
        $config = collect(self::getConfig($type));
        $new = $config->filter(function($e, $l) use ($key, $value) {
            return $e->{$key} == $value;
        });
        return $new->first();
    }

    /**
     * Obtener toda la informacion de una fila especifica de la configuracion
     * @param $type - El tipo de configuracion
     * @return $value - La fila solicitada
     */
    public function instanceByValue($key, $value){
        $config = collect($this->current);
        $new = $config->filter(function($e, $l) use ($key, $value) {
            return $e->{$key} == $value;
        });
        $this->setSelected($new->first());
    }

    /**
     * Seleccionar toda la informacion de una Grilla
     * @param $value - La posicion de la grilla en la configuracion
     * @return Array $valores
     */
    public static function getGridData($value){
        $grid = self::getConfig(self::GRIDS)[$value];
        $layouts = self::getConfig(self::LAYOUTS);
        $el = array_filter($layouts, function($e) use ($grid){  
            return ($grid->type == $e->name); 
        });
        return array_values($el)[0];
    }

    /**
     * Seleccionar toda la informacion de una Grilla - Instance
     * @param $value - La posicion de la grilla en la configuracion
     * @return Array $valores
     */
    public function expand(){
        $grid = $this->selected->grid = self::getConfig(self::GRIDS)[$this->selected->grid_position];
        $layouts = self::getConfig(self::LAYOUTS);
        $el = array_filter($layouts, function($e) use ($grid){  
            return ($grid->type == $e->name); 
        });
        $this->selected->layout = array_values($el)[0];
    }

    /**
     * Seleccionar una fila del arreglo.
     * @param $key - Fila a seleccionar
     */
    public function get($key){
        $taken = $this->current[$key];
        $taken->key = $key;
        $this->setSelected($taken);
        return $this->getSelected();
    }

    /**
     * Seleccionar una fila del arreglo.
     * @param $key - Fila a seleccionar
     */
    public function set($selectedNew){
        $this->setSelected($selectedNew);
    }

    /**
     * Reemplazar la configuraciòn aprovada por la actual
     * @param Type $type
     */
    const REVERT = 2;
    const OVERRID = 1;
    public static function overridChange($type){
        switch($type){
            
            case self::REVERT:
            //COLOCAR LA CONFIGURACION DE APPROVED EN ACTUAL
            Config::setConfig(Config::ELEMENTS, Config::getConfig(Config::ELEMENTS_APPROVED));
            Config::setConfig(Config::GRIDS, Config::getConfig(Config::GRIDS_APPROVED));
            //COLOCAR LA CONFIGURACION OLD EN APPROVED
            Config::setConfig(Config::ELEMENTS_APPROVED, Config::getConfig(Config::ELEMENTS_OLD));
            Config::setConfig(Config::GRIDS_APPROVED, Config::getConfig(Config::GRIDS_OLD));
            $response = ['success' => 'La pantalla principal ha sido revertida'];
            break;

            case self::OVERRID:
            //COLOCAR LA CONFIGURACION VIEJA EN OLD
            Config::setConfig(Config::ELEMENTS_OLD, Config::getConfig(Config::ELEMENTS_APPROVED));
            Config::setConfig(Config::GRIDS_OLD, Config::getConfig(Config::GRIDS_APPROVED));
            //COLOCAR LA CONFIGURACION DE ACTUAL EN APROVADA
            Config::setConfig(Config::ELEMENTS_APPROVED, Config::getConfig(Config::ELEMENTS));
            Config::setConfig(Config::GRIDS_APPROVED, Config::getConfig(Config::GRIDS));
            $response = ['success' => 'La pantalla principal ha cambiado'];
            break;
        }

        return $response;
    }


    /**
     * Obtener una configuracion especifica estaticamente.
     * @param $type Tipo.
     * @return Object $configuration.
     */
    public static function getConfig($type){
        switch($type){
            
            case self::MAIN:
                $config = json_decode(Storage::disk('noticia')->get('config/config.json'));
            break;
            
            case self::ELEMENTS:
                $config = json_decode(Storage::disk('noticia')->get('config/elements.json'));
            break;

            case self::IFRAMES:
                $config = json_decode(Storage::disk('noticia')->get('config/iframes.json'));
            break;

            case self::GRIDS:
                $config = json_decode(Storage::disk('noticia')->get('config/grids.json'));
            break;

            case self::LAYOUTS:
                $config = json_decode(Storage::disk('noticia')->get('config/layouts.json'));
            break;

            case self::ELEMENTS_APPROVED:
                $config = json_decode(Storage::disk('noticia')->get('config/elements_approved.json'));
            break;

            case self::GRIDS_APPROVED:
                $config = json_decode(Storage::disk('noticia')->get('config/grids_approved.json'));
            break;

            case self::ELEMENTS_OLD:
                $config = json_decode(Storage::disk('noticia')->get('config/elements_old.json'));
            break;

            case self::GRIDS_OLD:
                $config = json_decode(Storage::disk('noticia')->get('config/grids_old.json'));
            break;
        }
        return $config;
    }
    
    /**
     * Modificar la configuracion individualmente.
     * @param $type - Tipo
     * @param $file - nueva configuracion
     */
    public static function setConfig($type, $file){
        
        switch($type){
            
            case self::MAIN:
                Storage::disk('noticia')->put('config/config.json', json_encode($file));
            break;
            
            case self::ELEMENTS:
                Storage::disk('noticia')->put('config/elements.json', json_encode($file));
            break;

            case self::IFRAMES:
                Storage::disk('noticia')->put('config/iframes.json', json_encode($file));
            break;

            case self::GRIDS:
                Storage::disk('noticia')->put('config/grids.json', json_encode($file));
            break;

            case self::LAYOUTS:
                Storage::disk('noticia')->put('config/layout.json', json_encode($file));
            break;

            case self::ELEMENTS_APPROVED:
                Storage::disk('noticia')->put('config/elements_approved.json', json_encode($file));
            break;

            case self::GRIDS_APPROVED:
                Storage::disk('noticia')->put('config/grids_approved.json', json_encode($file));
            break;

            case self::ELEMENTS_OLD:
                Storage::disk('noticia')->put('config/elements_old.json', json_encode($file));
            break;

            case self::GRIDS_OLD:
                Storage::disk('noticia')->put('config/grids_old.json', json_encode($file));
            break;
        }
    }

    /**
     * Getters and Setters
     */
    public function getSelected(){
        return $this->selected;
    }

    public function setSelected($set, $key = null){
        $this->selected = $set;
        if($key){
            $this->selected->key = $key;
        }
    }

    public function getCurrent(){
        return $this->current;
    }

    public function setCurrent($set){
        $this->current = $set;
    }


}
