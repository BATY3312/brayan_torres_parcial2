#!/bin/bash

# Script para iniciar la aplicación de forma automática
# Sin necesidad de configuración

echo "🚀 Iniciando Sistema de Gestión de Usuarios..."
echo ""

# Verificar si Docker está instalado
if ! command -v docker &> /dev/null; then
    echo "❌ Docker no está instalado. Por favor instala Docker Desktop."
    exit 1
fi

# Verificar si Docker Compose está instalado
if ! command -v docker-compose &> /dev/null; then
    echo "❌ Docker Compose no está instalado. Por favor instala Docker Compose."
    exit 1
fi

# Crear archivo .env si no existe
if [ ! -f .env ]; then
    echo "📝 Creando archivo .env con valores por defecto..."
    cp .env.example .env
    echo "✅ Archivo .env creado"
else
    echo "✅ Archivo .env ya existe"
fi

echo ""
echo "🐳 Iniciando contenedores Docker..."
docker-compose up -d

echo ""
echo "⏳ Esperando a que MySQL esté listo..."
sleep 10

# Verificar que los contenedores estén corriendo
if docker-compose ps | grep -q "php-app"; then
    echo ""
    echo "✅ Contenedores iniciados correctamente!"
    echo ""
    echo "=========================================="
    echo "🌐 Accede a la aplicación en:"
    echo "   http://localhost/"
    echo ""
    echo "📊 API REST disponible en:"
    echo "   http://localhost/users"
    echo "=========================================="
    echo ""
    echo "📋 Comandos útiles:"
    echo "   Ver logs:     docker-compose logs -f"
    echo "   Detener:      docker-compose stop"
    echo "   Eliminar:     docker-compose down -v"
else
    echo "❌ Error al iniciar los contenedores"
    docker-compose logs
    exit 1
fi
