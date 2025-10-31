@echo off
REM Script para iniciar la aplicación de forma automática en Windows
REM Sin necesidad de configuración

color 0A
echo.
echo ========================================
echo  Sistema de Gestion de Usuarios
echo ========================================
echo.
echo 🚀 Iniciando aplicacion...
echo.

REM Verificar si Docker está instalado
docker --version >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo ❌ Docker no está instalado.
    echo Por favor instala Docker Desktop desde:
    echo https://www.docker.com/products/docker-desktop
    pause
    exit /b 1
)

REM Verificar si Docker Compose está instalado
docker-compose --version >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo ❌ Docker Compose no está instalado.
    echo Por favor instala Docker Compose.
    pause
    exit /b 1
)

REM Crear archivo .env si no existe
if not exist .env (
    echo 📝 Creando archivo .env con valores por defecto...
    copy .env.example .env >nul
    echo ✅ Archivo .env creado
) else (
    echo ✅ Archivo .env ya existe
)

echo.
echo 🐳 Iniciando contenedores Docker...
echo Por favor espera, esto puede tomar algunos minutos en la primera ejecución...
echo.
docker-compose up -d

echo.
echo ⏳ Esperando a que MySQL esté listo...
timeout /t 10 /nobreak

echo.
echo ========================================
echo ✅ ¡Aplicacion iniciada correctamente!
echo ========================================
echo.
echo 🌐 Accede a la aplicacion en tu navegador:
echo    http://localhost/
echo.
echo 📊 API REST disponible en:
echo    http://localhost/users
echo.
echo ========================================
echo 📋 Comandos útiles:
echo    Ver logs:     docker-compose logs -f
echo    Detener:      docker-compose stop
echo    Eliminar:     docker-compose down -v
echo ========================================
echo.
pause
