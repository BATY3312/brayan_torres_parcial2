# Sistema de Gestión de Usuarios - Docker + PHP + MySQL

Una aplicación web moderna para gestionar usuarios con interfaz visual e integración con base de datos MySQL, completamente containerizada usando Docker y Docker Compose.

## 🎯 Descripción del Proyecto

Esta aplicación proporciona:

- **Dashboard interactivo** con interfaz moderna y responsiva
- **API REST** para gestionar usuarios
- **Base de datos MySQL** con persistencia de datos
- **Docker Compose** para orquestación de servicios

### Características principales

✅ Interfaz web moderna con diseño responsivo
✅ Formulario para crear nuevos usuarios
✅ Lista en tiempo real de usuarios
✅ API REST para consultas (GET /users, POST /users)
✅ Validación de datos en cliente y servidor
✅ Mensajes de alerta y confirmación
✅ Base de datos MySQL persistente

## 📁 Estructura del Proyecto

```
docker-php-mysql/
├── app/
│   ├── index.php          # Punto de entrada principal
│   ├── dashboard.php      # Interfaz web del dashboard
│   ├── users.php          # Lógica de gestión de usuarios
│   ├── .htaccess          # Configuración de Apache rewrite
│   ├── Dockerfile         # Imagen de PHP 8.2 con Apache
│   └── .gitignore         # Archivos ignorados por Git
├── db/
│   └── init.sql          # Script de inicialización de base de datos
├── docker-compose.yml     # Orquestación de servicios Docker
├── .env                   # Variables de entorno (no subir a Git)
├── .env.example          # Template de variables de entorno
├── .gitignore            # Archivos ignorados por Git
└── README.md             # Este archivo
```

## 🔧 Requisitos

- **Docker** (v20.10 o superior)
- **Docker Compose** (v2.0 o superior)

## 🚀 Instalación y Configuración

### 1. Clonar el repositorio

```bash
git clone https://github.com/tu-usuario/docker-php-mysql.git
cd docker-php-mysql
```

### 2. Configurar variables de entorno

```bash
cp .env.example .env
```

**Archivo `.env`:**

```
DB_HOST=db
DB_USER=appuser
DB_PASSWORD=apppassword
DB_NAME=myapp
DB_ROOT_PASSWORD=rootpassword
```

> ⚠️ **Nota de seguridad:** Cambia las contraseñas en producción

### 3. Iniciar los servicios

```bash
docker-compose up -d
```

Este comando:
- Construye la imagen de PHP desde el Dockerfile
- Descarga la imagen de MySQL 8
- Crea los contenedores
- Inicializa la base de datos con datos de prueba
- Inicia ambos servicios en background

### 4. Verificar que los servicios están corriendo

```bash
docker-compose ps
```

Deberías ver:
- **php-app**: Corriendo en puerto 80
- **mysql-db**: Corriendo en puerto 3307

## 🌐 Usar la Aplicación

### Acceder al Dashboard

Abre tu navegador en:

```
http://localhost/
```

Verás una interfaz moderna donde puedes:
- **Ver todos los usuarios** en una lista ordenada
- **Agregar nuevos usuarios** con nombre y email
- **Recibir notificaciones** de éxito o error

### API REST

La aplicación también proporciona una API JSON en `/users`:

#### Obtener lista de usuarios

```bash
curl http://localhost/users
```

**Respuesta (200 OK):**

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "nombre": "Juan García",
      "email": "juan.garcia@example.com"
    },
    {
      "id": 2,
      "nombre": "María López",
      "email": "maria.lopez@example.com"
    }
  ],
  "count": 2
}
```

#### Crear un nuevo usuario

```bash
curl -X POST http://localhost/users \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "Pedro Sánchez",
    "email": "pedro@example.com"
  }'
```

**Respuesta (201 Created):**

```json
{
  "success": true,
  "message": "Usuario creado exitosamente",
  "id": 3,
  "nombre": "Pedro Sánchez",
  "email": "pedro@example.com"
}
```

**Respuesta en caso de error (400 Bad Request):**

```json
{
  "error": "Los campos nombre y email son requeridos"
}
```

**Respuesta si el email ya existe (409 Conflict):**

```json
{
  "error": "El email ya existe en la base de datos"
}
```

## 📋 Validaciones

La aplicación implementa las siguientes validaciones:

| Campo | Validación | Error |
|-------|-----------|-------|
| **Nombre** | 2-100 caracteres | "El nombre debe tener entre 2 y 100 caracteres" |
| **Email** | Formato válido | "El formato del email no es válido" |
| **Email** | Único en BD | "El email ya existe en la base de datos" |

## 🔌 Códigos HTTP

| Código | Significado | Caso |
|--------|------------|------|
| 200 | OK | GET exitoso |
| 201 | Created | Usuario creado exitosamente |
| 400 | Bad Request | Validación fallida |
| 404 | Not Found | Ruta no encontrada |
| 405 | Method Not Allowed | Método HTTP no soportado |
| 409 | Conflict | Email duplicado |
| 500 | Server Error | Error interno del servidor |

## 📊 Base de Datos

### Tabla `users`

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Datos iniciales

La BD incluye 3 usuarios de prueba:
- Juan García (juan.garcia@example.com)
- María López (maria.lopez@example.com)
- Carlos Rodríguez (carlos.rodriguez@example.com)

## 🛠️ Comandos Útiles

### Ver logs en vivo

```bash
docker-compose logs -f
```

### Ver logs de un servicio específico

```bash
docker-compose logs -f app
docker-compose logs -f db
```

### Detener los servicios

```bash
docker-compose stop
```

### Reiniciar los servicios

```bash
docker-compose restart
```

### Eliminar contenedores (sin perder datos)

```bash
docker-compose down
```

### Eliminar todo incluyendo datos

```bash
docker-compose down -v
```

### Acceder a la terminal del contenedor PHP

```bash
docker-compose exec app bash
```

### Acceder a MySQL

```bash
docker-compose exec db mysql -u appuser -p myapp
# Contraseña: apppassword
```

### Ejecutar comandos en el contenedor

```bash
# Ver archivos
docker-compose exec app ls -la /var/www/html/

# Ver versión de PHP
docker-compose exec app php -v
```

## 🐳 Docker Compose

### Servicios configurados

**app (PHP)**
- Imagen: Construida desde Dockerfile (php:8.2-apache)
- Puerto: 80
- Variables de entorno: Credenciales de BD
- Volumen: Archivos copiados en construcción

**db (MySQL)**
- Imagen: mysql:8
- Puerto: 3307 (mapeado a 3306)
- Variables: Credenciales de root y usuario
- Volúmenes:
  - `db-data`: Persistencia de datos
  - `./db/init.sql`: Script de inicialización
- Health check: Verifica disponibilidad de BD

### Red

- Red custom: `app-network`
- Driver: Bridge
- Permite comunicación entre servicios

## 📦 Archivos Importantes

### Dockerfile

- Base: `php:8.2-apache`
- Extensiones: PDO, pdo_mysql
- Módulos Apache: rewrite, AllowOverride
- Copia los archivos al contenedor

### docker-compose.yml

- Versión: Sin especificar (compatible con Docker Compose v2)
- Servicios: app, db
- Red común: app-network
- Variables de entorno desde .env

### .htaccess

Configuración de Apache:
- Habilita mod_rewrite
- Redirige todas las solicitudes a index.php
- Permite URLs limpias

## 🔒 Seguridad

- ✅ Prepared Statements (previene SQL injection)
- ✅ Validación de email
- ✅ Escape de HTML (previene XSS)
- ✅ Credenciales en variables de entorno
- ✅ CORS habilitado en headers
- ✅ Health checks en BD

## 🚀 Construcción de Imagen para Docker Hub

Si deseas subir tu imagen a Docker Hub:

### 1. Autenticarte en Docker Hub

```bash
docker login
```

### 2. Construir la imagen

```bash
docker build -t tu-usuario-docker/php-app:1.0 ./app
```

### 3. Hacer push

```bash
docker push tu-usuario-docker/php-app:1.0
```

### 4. Usar en docker-compose

En `docker-compose.yml`, reemplaza:

```yaml
app:
  build:
    context: ./app
    dockerfile: Dockerfile
```

Con:

```yaml
app:
  image: tu-usuario-docker/php-app:1.0
```

## 📝 Notas de Desarrollo

- Los archivos PHP se copian en el Dockerfile (no con volúmenes en Windows)
- Cambios en PHP requieren reconstrucción: `docker-compose up -d --build`
- La BD persiste en `db-data` volume
- Los cambios en `init.sql` solo aplican a nuevas BD

## 🔄 Solución de Problemas

### Puerto 80 o 3307 ya está en uso

En `docker-compose.yml`, cambia los puertos:

```yaml
app:
  ports:
    - "8080:80"  # Usar 8080 en lugar de 80

db:
  ports:
    - "3308:3306"  # Usar 3308 en lugar de 3307
```

### Errores de conexión a BD

```bash
# Reiniciar desde cero
docker-compose down -v
docker-compose up -d
```

### Ver que está pasando

```bash
# Ver logs
docker-compose logs db

# Verificar variables de entorno
docker-compose exec app env | grep DB_
```

## 📚 Tecnologías Utilizadas

- **PHP 8.2** - Lenguaje backend
- **Apache 2.4** - Servidor web
- **MySQL 8** - Base de datos
- **Docker** - Containerización
- **Docker Compose** - Orquestación
- **HTML5 & CSS3** - Frontend
- **JavaScript (Vanilla)** - Interactividad

## 🎨 Características del Dashboard

- **Diseño responsivo**: Funciona en desktop, tablet y móvil
- **Gradiente morado**: Interfaz moderna y profesional
- **Cards interactivas**: Hover effects y transiciones
- **Formulario intuitivo**: Validación en tiempo real
- **Lista dinámica**: Se actualiza al agregar usuarios
- **Alertas contextuales**: Éxito, error, advertencia
- **Loading spinner**: Indica operaciones en progreso
- **Contador de usuarios**: Estadística en tiempo real

## 🔮 Mejoras Futuras

- [ ] Autenticación con JWT
- [ ] Editar y eliminar usuarios
- [ ] Búsqueda y filtrado
- [ ] Paginación
- [ ] Exportar datos a CSV/JSON
- [ ] Gráficos de estadísticas
- [ ] Modo oscuro
- [ ] Multilidioma
- [ ] Tests automatizados

## 📄 Licencia

Este proyecto es de código abierto bajo la licencia MIT.

## 👨‍💻 Autor

Creado como parte de un ejercicio práctico avanzado de Docker.

---

**¡Disfruta usando el Sistema de Gestión de Usuarios! 🚀**

Para más información o reportar problemas, abre un issue en el repositorio.
