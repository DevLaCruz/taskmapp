<?php

namespace Model;

class User extends ActiveRecord
{
    protected static $tabla = 'users';
    protected static $columnasDB = ['id', 'name', 'email', 'password', 'token', 'confirm'];

    public $id;
    public $name;
    public $email;
    public $password;
    public $password2;
    public $current_password;
    public $new_password;
    public $token;
    public $confirm;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? null;
        $this->token = $args['token'] ?? '';
        $this->confirm = $args['confirm'] ?? 0;
    }

    public function validateLogin()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El email no es obligatorio';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatorio';
        }
        return self::$alertas;
    }

    //New Accounts validation
    public function validateNewAccounts()
    {
        if (!$this->name) {
            self::$alertas['error'][] = 'El nombre de usuario es obligatorio';
        }

        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatorio';
        }

        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La contraseña no debe ser menor a 6 caracteres';
        }

        if ($this->password !== $this->password2) {
            self::$alertas['error'][] = 'La contraseñas son diferentes';
        }

        return self::$alertas;
    }

    //Valkida email
    public function validateEmail()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El email no es obligatorio';
        }

        return self::$alertas;
    }

    //valid password
    public function validPass()
    {
        if (!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatorio';
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La contraseña no debe ser menor a 6 caracteres';
        }
        return self::$alertas;
    }

    //valid profile
    public function validate_profile()
    {
        if (!$this->name) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        return self::$alertas;
    }

    //valid new password
    public function newest_password(): array
    {
        if (!$this->current_password) {
            self::$alertas['error'][] = 'El Password Actual no puede ir vacio';
        }
        if (!$this->new_password) {
            self::$alertas['error'][] = 'El Password Nuevo no puede ir vacio';
        }
        if (strlen($this->new_password) < 6) {
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }

    // Comprobar el password
    public function check_password(): bool
    {
        return password_verify($this->current_password, $this->password);
    }

    //hashing password
    public function hashPass()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function generateToken()
    {
        $this->token = md5(uniqid());
    }
}
