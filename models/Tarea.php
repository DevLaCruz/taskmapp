<?php

namespace Model;

class Tarea extends ActiveRecord
{
    protected static $tabla = 'tareas';
    protected static $columnasDB = ['id', 'nombre', 'estado', 'proyectoId','created_at','updated_at','deleted_at'];

    public $id;
    public $nombre;
    public $estado;
    public $proyectoId;
    public $created_at;
    public $updated_at;
    public $deleted_at;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->estado = $args['estado'] ?? 0;
        $this->proyectoId = $args['proyectoId'] ?? '';
        $this->created_at = $args['created_at'] ?? '';
        $this->updated_at = $args['updated_at'] ?? '';
        $this->deleted_at=$args['deleted_at'] ?? '';
    }
}
