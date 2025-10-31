<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Usuarios</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        header {
            text-align: center;
            color: white;
            margin-bottom: 40px;
        }

        header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        header p {
            font-size: 1.1em;
            opacity: 0.9;
        }

        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        @media (max-width: 768px) {
            .main-content {
                grid-template-columns: 1fr;
            }
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.4);
        }

        .card h2 {
            color: #667eea;
            margin-bottom: 20px;
            font-size: 1.5em;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: 500;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        button:active {
            transform: translateY(0);
        }

        .users-list {
            max-width: 100%;
        }

        .user-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 12px;
            border-left: 4px solid #667eea;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .user-item:hover {
            background: #f0f1ff;
            transform: translateX(5px);
        }

        .user-info {
            flex: 1;
        }

        .user-name {
            font-weight: 600;
            color: #333;
            font-size: 1.1em;
        }

        .user-email {
            color: #666;
            font-size: 0.95em;
            margin-top: 3px;
        }

        .user-id {
            background: #667eea;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
            margin-right: 10px;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }

        .alert.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            display: block;
        }

        .alert.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            display: block;
        }

        .alert.warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
            display: block;
        }

        .loading {
            text-align: center;
            color: #667eea;
            padding: 20px;
            font-weight: 600;
        }

        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .stats {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .stat-number {
            font-size: 2em;
            font-weight: 700;
            color: #667eea;
        }

        .stat-label {
            color: #666;
            font-size: 0.9em;
            margin-top: 5px;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #999;
        }

        .empty-state-icon {
            font-size: 3em;
            margin-bottom: 10px;
        }

        footer {
            text-align: center;
            color: white;
            padding: 20px;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>👥 Sistema de Gestión de Usuarios</h1>
            <p>Administra tus usuarios de forma fácil y rápida</p>
        </header>

        <div class="main-content">
            <!-- Formulario para agregar usuario -->
            <div class="card">
                <h2>Nuevo Usuario</h2>
                <div id="formAlert" class="alert"></div>

                <form id="userForm">
                    <div class="form-group">
                        <label for="nombre">Nombre Completo</label>
                        <input
                            type="text"
                            id="nombre"
                            name="nombre"
                            placeholder="Juan García"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="juan@example.com"
                            required
                        >
                    </div>

                    <button type="submit">Agregar Usuario</button>
                </form>

                <div class="stats">
                    <div class="stat-number" id="totalUsers">0</div>
                    <div class="stat-label">Usuarios en total</div>
                </div>
            </div>

            <!-- Lista de usuarios -->
            <div class="card">
                <h2>Lista de Usuarios</h2>
                <div id="listAlert" class="alert"></div>

                <div id="usersList" class="users-list">
                    <div class="loading">
                        <span class="spinner"></span>
                        Cargando usuarios...
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <p>Sistema de Gestión de Usuarios - Docker + PHP + MySQL</p>
        </footer>
    </div>

    <script>
        const API_BASE = '/users';

        // Cargar usuarios al iniciar
        document.addEventListener('DOMContentLoaded', loadUsers);

        // Manejar envío del formulario
        document.getElementById('userForm').addEventListener('submit', handleAddUser);

        /**
         * Cargar lista de usuarios
         */
        async function loadUsers() {
            const usersList = document.getElementById('usersList');
            try {
                const response = await fetch(API_BASE);
                const result = await response.json();

                if (result.success && Array.isArray(result.data)) {
                    displayUsers(result.data);
                    updateUserCount(result.count);
                } else {
                    showAlert('error', 'Error al cargar usuarios', 'listAlert');
                }
            } catch (error) {
                showAlert('error', 'Error de conexión: ' + error.message, 'listAlert');
                usersList.innerHTML = '<div class="empty-state"><div class="empty-state-icon">⚠️</div><p>No se pudo conectar con el servidor</p></div>';
            }
        }

        /**
         * Mostrar usuarios en la lista
         */
        function displayUsers(users) {
            const usersList = document.getElementById('usersList');

            if (users.length === 0) {
                usersList.innerHTML = '<div class="empty-state"><div class="empty-state-icon">📭</div><p>No hay usuarios aún. ¡Agrega uno!</p></div>';
                return;
            }

            usersList.innerHTML = users.map(user => `
                <div class="user-item">
                    <div class="user-info">
                        <div class="user-name">${escapeHtml(user.nombre)}</div>
                        <div class="user-email">${escapeHtml(user.email)}</div>
                    </div>
                    <span class="user-id">ID: ${user.id}</span>
                </div>
            `).join('');
        }

        /**
         * Actualizar contador de usuarios
         */
        function updateUserCount(count) {
            document.getElementById('totalUsers').textContent = count;
        }

        /**
         * Manejar adición de nuevo usuario
         */
        async function handleAddUser(e) {
            e.preventDefault();

            const nombre = document.getElementById('nombre').value.trim();
            const email = document.getElementById('email').value.trim();

            // Validación básica
            if (!nombre || !email) {
                showAlert('error', 'Por favor completa todos los campos', 'formAlert');
                return;
            }

            try {
                const response = await fetch(API_BASE, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ nombre, email })
                });

                const result = await response.json();

                if (response.status === 201 && result.success) {
                    showAlert('success', '✓ Usuario creado exitosamente', 'formAlert');
                    document.getElementById('userForm').reset();
                    // Recargar lista después de 1 segundo
                    setTimeout(loadUsers, 1000);
                } else if (response.status === 409) {
                    showAlert('error', '⚠️ Este email ya existe', 'formAlert');
                } else {
                    showAlert('error', result.error || 'Error al crear usuario', 'formAlert');
                }
            } catch (error) {
                showAlert('error', 'Error: ' + error.message, 'formAlert');
            }
        }

        /**
         * Mostrar alertas
         */
        function showAlert(type, message, elementId) {
            const alert = document.getElementById(elementId);
            alert.className = `alert ${type}`;
            alert.textContent = message;
            alert.style.display = 'block';

            // Auto-ocultar en 5 segundos
            if (type === 'success') {
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 5000);
            }
        }

        /**
         * Escapar HTML para evitar XSS
         */
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    </script>
</body>
</html>
