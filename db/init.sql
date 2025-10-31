-- Crear base de datos
CREATE DATABASE IF NOT EXISTS myapp;
USE myapp;

-- Crear tabla de usuarios
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar datos de prueba
INSERT INTO users (nombre, email) VALUES
('Juan García', 'juan.garcia@example.com'),
('María López', 'maria.lopez@example.com'),
('Carlos Rodríguez', 'carlos.rodriguez@example.com');
