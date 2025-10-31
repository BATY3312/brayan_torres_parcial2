<?php
// users.php - Lógica para gestionar usuarios

// Configuración de conexión a la base de datos
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_password = getenv('DB_PASSWORD') ?: '';
$db_name = getenv('DB_NAME') ?: 'myapp';

/**
 * Obtener conexión a la base de datos
 */
function getDatabaseConnection() {
    global $db_host, $db_user, $db_password, $db_name;

    try {
        $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
        $pdo = new PDO($dsn, $db_user, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'No se pudo conectar a la base de datos: ' . $e->getMessage()]);
        exit;
    }
}

/**
 * Obtener lista de usuarios
 */
function getUsers() {
    try {
        $pdo = getDatabaseConnection();
        $stmt = $pdo->query("SELECT id, nombre, email FROM users ORDER BY id ASC");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'success' => true,
            'data' => $users,
            'count' => count($users)
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al obtener usuarios: ' . $e->getMessage()]);
    }
}

/**
 * Agregar nuevo usuario
 */
function addUser() {
    try {
        // Obtener datos JSON del cuerpo de la solicitud
        $input = json_decode(file_get_contents('php://input'), true);

        // Validar datos requeridos
        if (empty($input['nombre']) || empty($input['email'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Los campos nombre y email son requeridos']);
            return;
        }

        $nombre = trim($input['nombre']);
        $email = trim($input['email']);

        // Validar formato del email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['error' => 'El formato del email no es válido']);
            return;
        }

        // Validar longitud del nombre
        if (strlen($nombre) < 2 || strlen($nombre) > 100) {
            http_response_code(400);
            echo json_encode(['error' => 'El nombre debe tener entre 2 y 100 caracteres']);
            return;
        }

        $pdo = getDatabaseConnection();

        // Verificar si el email ya existe
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            http_response_code(409);
            echo json_encode(['error' => 'El email ya existe en la base de datos']);
            return;
        }

        // Insertar nuevo usuario
        $stmt = $pdo->prepare("INSERT INTO users (nombre, email) VALUES (?, ?)");
        $stmt->execute([$nombre, $email]);

        $new_id = $pdo->lastInsertId();

        http_response_code(201);
        echo json_encode([
            'success' => true,
            'message' => 'Usuario creado exitosamente',
            'id' => (int)$new_id,
            'nombre' => $nombre,
            'email' => $email
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al crear usuario: ' . $e->getMessage()]);
    }
}
?>
