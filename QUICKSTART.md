# ⚡ INICIO RÁPIDO - Sin Configuración

## 3 pasos para ejecutar la aplicación:

### 1️⃣ Clonar el proyecto
```bash
git clone https://github.com/TU_USUARIO/docker-php-mysql.git
cd docker-php-mysql
```

### 2️⃣ Ejecutar el script de inicio
**En Windows:**
```bash
start.bat
```

**En Linux/Mac:**
```bash
chmod +x start.sh
./start.sh
```

### 3️⃣ Abrir en el navegador
```
http://localhost/
```

---

## ¡Ya está! 🎉

Sin necesidad de modificar `.env`, sin configuración adicional.

**La aplicación incluye:**
- ✅ Dashboard moderno e interactivo
- ✅ API REST lista para usar
- ✅ Base de datos MySQL con datos de prueba
- ✅ Persistencia de datos

---

## Comandos útiles

```bash
# Ver logs en vivo
docker-compose logs -f

# Detener la aplicación
docker-compose stop

# Reiniciar
docker-compose restart

# Eliminar todo (con datos)
docker-compose down -v
```

---

## Para más detalles

Ver [README.md](./README.md) para documentación completa

Ver [DEPLOY.md](./DEPLOY.md) para subir a GitHub y Docker Hub
