# 📦 Guía de Deploy a GitHub y Docker Hub

## 🚀 Subir a GitHub

### 1. Crear repositorio en GitHub

Ve a https://github.com/new y crea un repositorio llamado:
- **Nombre:** `docker-php-mysql`
- **Descripción:** Sistema de Gestión de Usuarios con Docker, PHP y MySQL
- **Visibilidad:** Public (o Private si prefieres)

### 2. Conectar repositorio local con GitHub

En tu terminal, en la carpeta del proyecto:

```bash
git init
git config user.email "tu-email@gmail.com"
git config user.name "Tu Nombre"
git add .
git commit -m "Proyecto inicial: Sistema de Gestión de Usuarios con Docker"
git branch -M main
git remote add origin https://github.com/TU_USUARIO/docker-php-mysql.git
git push -u origin main
```

**Reemplaza:**
- `tu-email@gmail.com` con tu email
- `Tu Nombre` con tu nombre
- `TU_USUARIO` con tu usuario de GitHub

### 3. Verificar que se subió

Abre en tu navegador: `https://github.com/TU_USUARIO/docker-php-mysql`

---

## 🐳 Subir Imagen a Docker Hub

### 1. Crear cuenta en Docker Hub

Si no tienes cuenta:
1. Ve a https://hub.docker.com/signup
2. Crea una cuenta gratis
3. Confirma tu email

### 2. Construir la imagen localmente

```bash
docker build -t tu-usuario-docker/php-app:1.0 ./app
```

**Reemplaza `tu-usuario-docker` con tu usuario de Docker Hub**

Ejemplos:
- `docker build -t baty123/php-app:1.0 ./app`
- `docker build -t juanperez/php-app:1.0 ./app`

### 3. Autenticarte en Docker Hub

```bash
docker login
```

Ingresa tu usuario y contraseña de Docker Hub

### 4. Subir la imagen

```bash
docker push tu-usuario-docker/php-app:1.0
```

### 5. Verificar que se subió

Ve a: `https://hub.docker.com/r/tu-usuario-docker/php-app`

Deberías ver tu imagen con el tag `1.0`

---

## 📝 Actualizar docker-compose.yml (Opcional)

Una vez que tengas la imagen en Docker Hub, puedes cambiar el archivo `docker-compose.yml` para que use tu imagen en lugar de construir:

**Cambiar esto:**
```yaml
app:
  build:
    context: ./app
    dockerfile: Dockerfile
```

**Por esto:**
```yaml
app:
  image: tu-usuario-docker/php-app:1.0
```

Luego sube los cambios a GitHub:

```bash
git add docker-compose.yml
git commit -m "Usar imagen de Docker Hub en docker-compose"
git push
```

---

## 📋 Resumen de Comandos Completo

```bash
# ========== GITHUB ==========
cd C:\Users\BATY\Desktop\docker-php-mysql

git init
git config user.email "tu-email@gmail.com"
git config user.name "Tu Nombre"
git add .
git commit -m "Proyecto inicial: Sistema de Gestión de Usuarios con Docker"
git branch -M main
git remote add origin https://github.com/TU_USUARIO/docker-php-mysql.git
git push -u origin main

# ========== DOCKER HUB ==========
docker build -t tu-usuario-docker/php-app:1.0 ./app
docker login
docker push tu-usuario-docker/php-app:1.0
```

---

## ✅ Flujo Completo para Otros Usuarios

Una vez que hayas hecho todo lo anterior, otros pueden ejecutar tu proyecto así:

**Opción 1 - Clonar y construir (Más lento):**
```bash
git clone https://github.com/TU_USUARIO/docker-php-mysql.git
cd docker-php-mysql
docker-compose up -d
```

**Opción 2 - Clonar y usar imagen de Hub (Más rápido):**
```bash
git clone https://github.com/TU_USUARIO/docker-php-mysql.git
cd docker-php-mysql
start.bat  # En Windows
# o
./start.sh  # En Linux/Mac
```

---

## 🔄 Actualizar Cambios Futuros

Cuando hagas cambios y quieras actualizar:

### En GitHub:
```bash
git add .
git commit -m "Descripción de los cambios"
git push
```

### En Docker Hub (si cambios PHP):
```bash
docker build -t tu-usuario-docker/php-app:2.0 ./app
docker push tu-usuario-docker/php-app:2.0

# Actualizar docker-compose.yml con la nueva versión
```

---

## 🆘 Solución de Problemas

### Error: "docker: command not found"
- Instala Docker Desktop desde: https://www.docker.com/products/docker-desktop

### Error: "Permission denied" en Linux
```bash
sudo usermod -aG docker $USER
```

### Error: "Push failed - permission denied"
- Verifica que hayas hecho `docker login` correctamente
- Verifica que el nombre de la imagen sea correcto

### Error: "remote origin already exists"
```bash
git remote remove origin
git remote add origin https://github.com/TU_USUARIO/docker-php-mysql.git
```

---

## 📚 Recursos Útiles

- **GitHub Docs:** https://docs.github.com
- **Docker Hub Docs:** https://docs.docker.com/docker-hub/
- **Git Basics:** https://git-scm.com/book

---

¡Listo! Ahora tu proyecto está en GitHub y tu imagen en Docker Hub 🚀
