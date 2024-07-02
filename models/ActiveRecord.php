<?php

namespace Model;

class ActiveRecord
{
    // Base de Datos
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Alertas y Mensajes
    protected static $alertas = [];

    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database)
    {
        self::$db = $database;
    }

    public static function setAlerta($tipo, $mensaje)
    {
        static::$alertas[$tipo][] = $mensaje;
    }

    // Validación
    public static function getAlertas()
    {
        return static::$alertas;
    }

    public function validar()
    {
        static::$alertas = [];
        return static::$alertas;
    }

    // Registros - CRUD
    public function guardar()
    {
        if (!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    public static function all()
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE deleted_at IS NULL";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$tabla  . " WHERE id = {$id} AND deleted_at IS NULL";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    // Obtener Registro
    public static function get($limite)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE deleted_at IS NULL LIMIT {$limite}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    // Búsqueda Where con Columna 
    public static function where($columna, $valor)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE {$columna} = '{$valor}' AND deleted_at IS NULL";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    // Busca todos los registros que pertenecen a un ID
    public static function belongsTo($columna, $valor)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE {$columna} = '{$valor}' AND deleted_at IS NULL";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // SQL para Consultas Avanzadas.
    public static function SQL($consulta)
    {
        $query = $consulta;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Crea un nuevo registro
    public function crear()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Añadir created_at con la fecha y hora actual
        $atributos['created_at'] = date('Y-m-d H:i:s');

        // Insertar en la base de datos
        $query = "INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        // Resultado de la consulta
        $resultado = self::$db->query($query);

        return [
            'resultado' => $resultado,
            'id' => self::$db->insert_id
        ];
    }

    public function actualizar()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Añadir updated_at con la fecha y hora actual
        $atributos['updated_at'] = date('Y-m-d H:i:s');

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$db->query($query);
        return $resultado;
    }

    // Eliminar un registro - Toma el ID de Active Record
    public function eliminar()
    {
        return $this->softDelete();
    }

    // Soft Delete
    public function softDelete()
    {
        // Obtener la fecha y hora actual
        $this->deleted_at = date('Y-m-d H:i:s');

        // Construir la consulta SQL UPDATE para establecer deleted_at
        $query = "UPDATE " . static::$tabla . " SET deleted_at = '" . $this->deleted_at . "' WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";

        // Ejecutar la consulta UPDATE en la base de datos
        $resultado = self::$db->query($query);

        // Devolver el resultado de la operación UPDATE (true si se actualizó correctamente, false si no)
        return $resultado;
    }

    public static function consultarSQL($query)
    {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // liberar la memoria
        $resultado->free();

        // retornar los resultados
        return $array;
    }

    protected static function crearObjeto($registro)
    {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Identificar y unir los atributos de la BD
    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id' || $columna === 'created_at' || $columna === 'updated_at' || $columna === 'deleted_at') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
