<?php

require_once __DIR__ . '/../includes/app.php';


use Controllers\LoginController;
use Controllers\DashboardController;
use Controllers\TareaController;
use MVC\Router;

$router = new Router();


//Login
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

//Create Account
$router->get('/create', [LoginController::class, 'create']);
$router->post('/create', [LoginController::class, 'create']);

//Forgot Password
$router->get('/forgot', [LoginController::class, 'forgot']);
$router->post('/forgot', [LoginController::class, 'forgot']);

//Set a new Password
$router->get('/reset', [LoginController::class, 'reset']);
$router->post('/reset', [LoginController::class, 'reset']);

//Confirm of Account
$router->get('/confirmation-message', [LoginController::class, 'message']);
$router->get('/confirm', [LoginController::class, 'confirm']);

// ZONA DE PROYECTOS
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/crear-lista', [DashboardController::class, 'crear_proyecto']);
$router->post('/crear-lista', [DashboardController::class, 'crear_proyecto']);
$router->get('/lista', [DashboardController::class, 'proyecto']);
$router->get('/perfil', [DashboardController::class, 'perfil']);
$router->post('/perfil', [DashboardController::class, 'perfil']);
$router->get('/cambiar-password', [DashboardController::class, 'cambiar_password']);
$router->post('/cambiar-password', [DashboardController::class, 'cambiar_password']);

// API para las tareas
$router->get('/api/tareas', [TareaController::class, 'index']);
$router->post('/api/tarea', [TareaController::class, 'crear']);
$router->post('/api/tarea/actualizar', [TareaController::class, 'actualizar']);
$router->post('/api/tarea/eliminar', [TareaController::class, 'eliminar']);


$router->post('/api/proyecto/editar', [DashboardController::class, 'editar']);
$router->post('/api/proyecto/eliminar', [DashboardController::class, 'eliminar']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
