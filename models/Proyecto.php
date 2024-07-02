<?php

namespace Model;

use Model\ActiveRecord;

class Proyecto extends ActiveRecord
{
    protected static $tabla = 'proyectos';
    protected static $columnasDB = ['id', 'proyecto', 'url', 'propietarioId', 'created_at', 'updated_at', 'deleted_at'];

    public $id;
    public $proyecto;
    public $url;
    public $propietarioId;
    public $created_at;
    public $updated_at;
    public $deleted_at;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->proyecto = $args['proyecto'] ?? '';
        $this->url = $args['url'] ?? '';
        $this->propietarioId = $args['propietarioId'] ?? '';
        $this->created_at = $args['created_at'] ?? null;
        $this->updated_at = $args['updated_at'] ?? null;
        $this->deleted_at = $args['deleted_at'] ?? null;
    }

    public function validarProyecto()
    {
        if (!$this->proyecto) {
            self::$alertas['error'][] = 'El Nombre del Proyecto es Obligatorio';
        }
        return self::$alertas;
    }

    public function eliminar()
    {
        return $this->softDelete();
    }

    public function editar($args = [])
    {
        $this->sincronizar($args);
        return $this->guardar();
    }
}
