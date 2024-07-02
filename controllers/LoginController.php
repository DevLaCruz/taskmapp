<?php

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;

class LoginController
{
    public static function login(Router $router)
    {
        $alerts = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new User($_POST);
            $alerts = $auth->validateLogin();

            if (empty($alerts)) {

                //Verificar que el usuario existe
                $user = User::where('email', $auth->email);
                if (!$user || !$user->confirm) {
                    User::setAlerta('error', 'Usuario no existe o no esta confirm');
                } else {
                    if (password_verify($_POST['password'], $user->password)) {
                        //Iniciar sesión
                        session_start();
                        $_SESSION['id'] = $user->id;
                        $_SESSION['name'] = $user->name;
                        $_SESSION['email'] = $user->email;
                        $_SESSION['login'] = true;

                        header('Location: /dashboard');
                    } else {
                        User::setAlerta('error', 'Password Incorrect');
                    }
                }
            }
        }


        //Render a la vista
        $router->render('auth/login', [
            'title' => 'Iniciar Sesión',
            'alerts' => $alerts
        ]);
    }

    public static function logout()
    {
        session_start();
        $_SESSION = [];
        header('Location: /');
    }

    public static function create(Router $router)
    {
        $alerts = [];
        $user = new User;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->sincronizar($_POST);
            $alerts = $user->validateNewAccounts();

            if (empty($alerts)) {
                $existUser = User::where('email', $user->email);
                if ($existUser) {
                    User::setAlerta('error', 'El usuario ya existe');
                    $alerts = User::getAlertas();
                } else {
                    //Hashing a password
                    $user->hashPass();

                    //delete password2:
                    unset($user->password2);

                    //Create a new user
                    $user->generateToken();
                    $result = $user->guardar();

                    //Send email
                    $email = new Email($user->email, $user->name, $user->token);
                    $email->sendConfirmation();

                    if ($result) {
                        header('Location:/confirmation-message');
                    }
                }
            }
        }

        //Render a la vista
        $router->render('auth/create', [
            'title' => 'Crear tu Cuenta',
            'user' => $user,
            'alerts' => $alerts
        ]);
    }

    public static function forgot(Router $router)
    {
        $alerts = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User($_POST);
            $alerts = $user->validateEmail($_POST);

            if (empty($alerts)) {
                //buscar user
                $user = User::where('email', $user->email);

                if ($user && $user->confirm == '1') {
                    //Generate a new token
                    $user->generateToken();
                    unset($user->password2);

                    //update the user
                    $user->guardar();

                    //send email
                    $email = new Email($user->email, $user->name, $user->token);
                    $email->sendInstructions();

                    //print alert
                    User::setAlerta('exito', 'hemops nviado u email para que recuperes');
                } else {
                    User::setAlerta('error', 'El usuario no existe');
                }
            }
        }

        $alerts = User::getAlertas();

        $router->render('auth/forgot', [
            'title' => 'Olvidaste tu contraseña',
            'alerts' => $alerts
        ]);
    }


    public static function reset(Router $router)
    {
        $token = s($_GET['token']);
        $show = true;

        if (!$token) header('Location:/');

        //Identify the user
        $user = User::where('token', $token);

        if (empty($user)) {
            User::setAlerta('error', 'Token not valid');
            $show = false;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->sincronizar($_POST);

            //Validar el pass
            $alerts = $user->validPass();

            if (empty($alerts)) {
                //hashing
                $user->hashPass();

                //delete token
                $user->token = null;

                //save in db
                $result = $user->guardar();

                //redirect
                if ($result) {
                    header('Location:/');
                }
            }
        }

        $alerts = User::getAlertas();

        //Show in view
        $router->render('auth/reset', [
            'title' => 'Restablece tu contraseña',
            'alerts' => $alerts,
            'show' => $show
        ]);
    }

    public static function message(Router $router)
    {

        $router->render('auth/confirmation-message', [
            'title' => 'Cuenta creada con exito'
        ]);
    }

    public static function confirm(Router $router)
    {
        $token = s($_GET['token'] ?? '');

        if (!$token) {
            header('Location: /');
            return;
        }

        $user = User::where('token', $token);

        if (empty($user)) {
            // Not found user
            User::setAlerta('error', 'Token no válido');
        } else {
            // Confirm account
            $user->confirm = 1;
            $user->token = null;
            unset($user->password2);

            // Guardar en la BD
            $user->guardar();

            User::setAlerta('exito', 'Cuenta comprobada correctamente');
        }

        $alerts = User::getAlertas();

        $router->render('auth/confirm', [
            'title' => 'Confirma tu cuenta con éxito',
            'alerts' => $alerts
        ]);
    }
}
