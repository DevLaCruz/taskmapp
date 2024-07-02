<?php

namespace Controllers;

use MVC\Router;
use Model\User;
use Model\Proyecto;


class DashboardController
{
    public static function index(Router $router)
    {

        session_start();
        isAuth();

        $id = $_SESSION['id'];
        $proyectos = Proyecto::belongsTo('propietarioId', $id);

        $router->render('dashboard/index', [
            'title' => 'Listas',
            'proyectos' => $proyectos
        ]);
    }

    public static function crear_proyecto(Router $router)
    {
        session_start();
        isAuth();

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proyecto = new Proyecto($_POST);
            $alertas = $proyecto->validarProyecto();

            if (empty($alertas)) {
                // Generar una URL única
                $proyecto->url = md5(uniqid());

                // Sincronizar con el ID del usuario autenticado
                $proyecto->propietarioId = $_SESSION['id'];

                // Guardar el proyecto
                $resultado = $proyecto->guardar();

                if ($resultado) {
                    header('Location: /lista?id=' . $proyecto->url);
                }
            }
        }

        $router->render('dashboard/crear-proyecto', [
            'alertas' => $alertas
        ]);
    }
    public static function proyecto(Router $router)
    {
        session_start();
        isAuth();

        $token = $_GET['id'];
        if (!$token) header('Location: /dashboard');
        // Revisar que la persona que visita el proyecto, es quien lo creo
        $proyecto = Proyecto::where('url', $token);
        if ($proyecto->propietarioId !== $_SESSION['id']) {
            header('Location: /dashboard');
        }

        $router->render('dashboard/lista', [
            'title' => $proyecto->proyecto,
            'date' => $proyecto->created_at
        ]);
    }

    public static function perfil(Router $router)
    {
        session_start();
        isAuth();
        $alertas = [];

        $User = User::find($_SESSION['id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $User->sincronizar($_POST);

            $alertas = $User->validate_profile();

            if (empty($alertas)) {

                $existeUser = User::where('email', $User->email);

                if ($existeUser && $existeUser->id !== $User->id) {
                    // Mensaje de error
                    User::setAlerta('error', 'Email no válido, ya pertenece a otra cuenta');
                    $alertas = $User->getAlertas();
                } else {
                    // Guardar el registro
                    $User->guardar();

                    User::setAlerta('exito', 'Guardado Correctamente');
                    $alertas = $User->getAlertas();

                    // Asignar el nombre nuevo a la barra
                    $_SESSION['name'] = $User->name;
                }
            }
        }

        $router->render('dashboard/perfil', [
            'title' => 'Perfil',
            'User' => $User,
            'alerts' => $alertas
        ]);
    }

    public static function cambiar_password(Router $router)
    {
        session_start();
        isAuth();

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $User = User::find($_SESSION['id']);

            // Sincronizar con los datos del User
            $User->sincronizar($_POST);

            $alertas = $User->newest_password();

            if (empty($alertas)) {
                $resultado = $User->check_password();

                if ($resultado) {
                    $User->password = $User->new_password;

                    // Eliminar propiedades No necesarias
                    unset($User->current_password);
                    unset($User->password_nuevo);

                    // Hashear el nuevo password
                    $User->hashPass();

                    // Actualizar
                    $resultado = $User->guardar();

                    if ($resultado) {
                        User::setAlerta('exito', 'Password Guardado Correctamente');
                        $alertas = $User->getAlertas();
                    }
                } else {
                    User::setAlerta('error', 'Password Incorrecto');
                    $alertas = $User->getAlertas();
                }
            }
        }

        $router->render('dashboard/cambiar-password', [
            'title' => 'Cambiar Password',
            'alerts' => $alertas
        ]);
    }


    public static function editar()
    {
        session_start();
        isAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['id'];
            $nuevoNombre = $data['nombre'];

            $proyecto = Proyecto::find($id);

            // Verificar que el proyecto pertenezca al usuario
            if ($proyecto->propietarioId !== $_SESSION['id']) {
                echo json_encode(['success' => false, 'message' => 'No tienes permiso para editar esta lista']);
                return;
            }

            $proyecto->proyecto = $nuevoNombre;
            $resultado = $proyecto->guardar();

            echo json_encode(['success' => $resultado, 'message' => $resultado ? 'Nombre de Lista actualizado' : 'Error al actualizar la lista']);
        }
    }

    public static function eliminar()
    {
        session_start();
        isAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['id'];

            $proyecto = Proyecto::find($id);

            // Verificar que el proyecto pertenezca al usuario
            if ($proyecto->propietarioId !== $_SESSION['id']) {
                echo json_encode(['success' => false, 'message' => 'No tienes permiso para eliminar esta lista']);
                return;
            }

            $resultado = $proyecto->eliminar();

            echo json_encode(['success' => $resultado, 'message' => $resultado ? 'Lista eliminada' : 'Error al eliminar la lista']);
        }
    }
}
