<?php
// index.php - Punto de entrada principal de la aplicación

// Obtener la ruta y el método HTTP
$request_method = $_SERVER['REQUEST_METHOD'];
$request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Si acceden a / o /index.php, mostrar el dashboard
if ($request_path === '/' || $request_path === '/index.php') {
    require_once 'dashboard.php';
    exit;
}

// Para la API /users, retornar JSON
if ($request_path === '/users') {
    header('Content-Type: application/json; charset=utf-8');

    if ($request_method === 'GET') {
        require_once 'users.php';
        getUsers();
    } elseif ($request_method === 'POST') {
        require_once 'users.php';
        addUser();
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
    }
} else {
    // Ruta no encontrada
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(404);
    echo json_encode(['error' => 'Ruta no encontrada']);
}
?>
