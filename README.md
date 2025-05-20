# 📘 API de Gestión de Inventario con Roles

## 🚀 Descripción del Proyecto

Este proyecto es una **API RESTful construida con Laravel 10** que permite gestionar un inventario básico de productos y categorías, con control de acceso por roles (`admin` | `user`). Incluye autenticación basada en tokens, validación robusta, y está lista para ser desplegada públicamente.

---

## 🧱 Stack Tecnológico

- **PHP**: 8.3.x
- **Laravel**: 12.x
- **Base de datos**: MySQL 8.x
- **ORM**: Eloquent
- **Autenticación**: Laravel Sanctum
- **Despliegue**: Vercel + conexión remota a MySQL
- **Documentación API**: Postman Collection

---

## 🛠️ Instrucciones para Configurar Localmente

1. Clona el repositorio:
```bash
git clone https://github.com/camilo180601/ApiTestTechnical
cd ApiTestTechnical
```

2. Instala las dependencias:
```bash
composer install
```

3. Copia el archivo `.env`:
```bash
cp .env.example .env
```

4. Genera la key de la aplicación:
```bash
php artisan key:generate
```

5. Configura la base de datos MySQL en `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=apitesttechnical
DB_USERNAME=root
DB_PASSWORD=tu_contraseña
```

6. Ejecuta las migraciones y seeders:
```bash
php artisan migrate --seed
```

7. Inicia el servidor de desarrollo:
```bash
php artisan serve
```

---

## 📦 Endpoints Disponibles

### 🔐 Autenticación y Usuarios

| Método | Endpoint         | Rol Requerido | Descripción                          |
|--------|------------------|---------------|--------------------------------------|
| POST   | /api/register    | Público/Admin | Registra usuario (Admin puede definir rol) |
| POST   | /api/login       | Público       | Inicia sesión y devuelve token       |
| POST   | /api/logout      | Autenticado   | Cierra sesión del usuario actual     |

### 📦 Productos

| Método | Endpoint            | Rol         | Descripción                     |
|--------|---------------------|-------------|---------------------------------|
| GET    | /api/products       | Todos       | Lista productos                 |
| GET    | /api/products/{id}  | Todos       | Detalle de producto             |
| POST   | /api/products       | Solo admin  | Crea producto                   |
| PUT    | /api/products/{id}  | Solo admin  | Actualiza producto              |
| DELETE | /api/products/{id}  | Solo admin  | Elimina producto                |

### 📁 Categorías

| Método | Endpoint             | Rol         | Descripción                     |
|--------|----------------------|-------------|---------------------------------|
| GET    | /api/categories      | Todos       | Lista categorías                |
| POST   | /api/categories      | Solo admin  | Crea categoría                  |
| PUT    | /api/categories/{id} | Solo admin  | Actualiza categoría             |
| DELETE | /api/categories/{id} | Solo admin  | Elimina categoría               |

---

## ✅ Seguridad y Roles

- Roles definidos como `enum('admin','user')` en la tabla `users`.
- Autenticación con **Laravel Sanctum** mediante token.
- Middleware personalizado `IsAdmin` para protección de endpoints sensibles.
- Gestión clara de errores y respuestas JSON estandarizadas.

---

## 📄 Validación y Manejo de Errores

Cada endpoint tiene validaciones específicas. Si una solicitud no pasa la validación, la respuesta será:

```json
{
  "message": "El campo nombre es obligatorio",
  "errors": {
    "name": ["El campo nombre es obligatorio"]
  }
}
```

---

## 📂 Estructura del Proyecto

- `app/Http/Controllers`: Controladores API
- `app/Http/Middleware/IsAdmin.php`: Middleware de rol
- `routes/api.php`: Endpoints RESTful
- `routes/web.php`: Soporte para Blade (separado de la lógica de la API)
- `app/Models`: Eloquent Models

---

## 🧠 Decisiones de Diseño

| Elemento                    | Elección / Justificación                                            |
|----------------------------|----------------------------------------------------------------------|
| Roles como enum            | Suficiente para dos roles fijos, sin necesidad de tabla extra       |
| Middleware personalizado   | `IsAdmin` separa claramente la lógica de autorización               |
| Reutilización de controladores | Los controladores están diseñados para servir exclusivamente a la API RESTful, sin lógica compartida con vistas Blade |
| Base de datos MySQL        | Compatibilidad con despliegue y gestión relacional completa         |
| Despliegue en Vercel       | Fácil, rápido, y se configuró `.vercel.json` para enrutar bien las APIs |

---

## 🌍 URL Pública de Despliegue

🟢 [https://apitesttechnical.vercel.app](https://apitesttechnical.vercel.app)

---

## 🧪 Pruebas API (Postman)

📥 Archivo: `api-collection.postman.json`

### Instrucciones:
1. Importa el archivo en Postman.
2. Usa el endpoint `/api/login` para obtener tu token.
3. Agrega el token en **Authorization > Bearer Token**.
4. Ejecuta los demás endpoints autenticados.

---

## ⚙️ Variables de Entorno a configurar

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=https://apitesttechnical.vercel.app

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=apitesttechnical
DB_USERNAME=root
DB_PASSWORD=********

```

---

## ☁️ Despliegue en Vercel
- El archivo `.vercelignore` se incluye para omitir a la hora de hacer el despliegue
- El archivo `vercel.json` se incluye para redirigir correctamente las rutas API:

```bash
vercel .
vercel --prod
```

```json
{
  "rewrites": [
    { "source": "/api/(.*)", "destination": "/index.php" }
  ]
}
```

- Base de datos MySQL conectada a través de variables de entorno.
- Asegúrate de que el servidor MySQL sea accesible públicamente o desde Vercel (host remotos o Railway, PlanetScale, etc).