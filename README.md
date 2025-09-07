# 🚗 Sistema de Gestión de Contactos y Vehículos

API REST desarrollada en Laravel para la gestión de contactos y sus vehículos asociados, con sistema de filtrado avanzado y paginación.

## 📋 Características

- ✅ CRUD completo de Contactos y Vehículos
- ✅ Sistema de filtrado avanzado con múltiples operadores (`eq`, `like`, `gte`, `lte`)
- ✅ Relaciones entre Contactos y Vehículos (1:N)
- ✅ Paginación personalizable
- ✅ Validaciones robustas con Form Requests
- ✅ Resources para formateo consistente de respuestas
- ✅ Búsqueda por datos del cliente en vehículos

---

## 🔧 Requisitos del Entorno

### Versiones Mínimas
- **PHP**: >= 8.1
- **Composer**: >= 2.0
- **Node.js**: >= 16.x (opcional, para assets)
- **Base de Datos**: MySQL >= 8.0 / PostgreSQL >= 13 / SQLite >= 3.8

### Extensiones PHP Requeridas
```bash
php -m | grep -E "(openssl|pdo|mbstring|tokenizer|xml|ctype|json|bcmath|curl|fileinfo)"
```

- `openssl`
- `pdo` + driver específico (`pdo_mysql`, `pdo_pgsql`, `pdo_sqlite`)
- `mbstring`
- `tokenizer`
- `xml`
- `ctype`
- `json`
- `bcmath`
- `curl`
- `fileinfo`

---

## 🧰 Instalación y Configuración

### 1. Clonar el Repositorio
```bash
git clone git@github.com:celsodiaz/crud_vehiculos_y_contactos.git
cd crud_vehiculos_y_contactos
```

### 2. Instalar Dependencias
```bash
composer install
```

### 3. Configuración del Entorno
```bash
# Ejecutar este comando para crear un archivo .env
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate
```
### 4. Variables de Entorno (Copiar en el archivo creado .env)
```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:jI3epNtkGsKJLMOR0K5QC9UH1wrCk3A01DjvHUZ0kZA=
APP_DEBUG=true
APP_URL=http://localhost:8000

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
# APP_MAINTENANCE_STORE=database

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
# CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

```

---

## ▶️ Puesta en Marcha

### 1. Ejecutar Migraciones
```bash
php artisan migrate
```
Escribir 'yes' para generar la BD

### 2. Crear Datos de Prueba
```bash
php artisan db:seed
```

### 3. Levantar el Servidor de Desarrollo
```bash
php artisan serve
```

La aplicación estará disponible en: **http://localhost:8000**

### 4. Comandos Adicionales
```bash
# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Ver rutas disponibles
php artisan route:list

```

---

## 🗄️ Estructura de la Base de Datos

### Migraciones Incluidas

#### Tabla: `contactos`
```sql
CREATE TABLE `contactos` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nombre` varchar(100) NOT NULL,
    `apellidos` varchar(150) NOT NULL,
    `nro_documento` varchar(20) NOT NULL UNIQUE,
    `correo` varchar(255) NOT NULL UNIQUE,
    `telefono` varchar(20) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `contactos_nro_documento_unique` (`nro_documento`),
    UNIQUE KEY `contactos_correo_unique` (`correo`)
);
```

#### Tabla: `vehiculos`
```sql
CREATE TABLE `vehiculos` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `contacto_id` bigint(20) UNSIGNED NOT NULL,
    `placa` varchar(10) NOT NULL UNIQUE,
    `marca` varchar(50) NOT NULL,
    `modelo` varchar(50) NOT NULL,
    `año` year(4) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `vehiculos_placa_unique` (`placa`),
    KEY `vehiculos_contacto_id_foreign` (`contacto_id`),
    CONSTRAINT `vehiculos_contacto_id_foreign` FOREIGN KEY (`contacto_id`) REFERENCES `contactos` (`id`) ON DELETE CASCADE
);
```

### Relaciones
- **Contacto** ↔ **Vehículos**: 1 contacto puede tener múltiples vehículos
- **Vehículo** ↔ **Contacto**: 1 vehículo pertenece a 1 contacto

---

## 🔑 Usuario Demo

### Datos de Prueba (Seeders)

#### Contactos de Ejemplo
```json
{
    "nombre": "Juan Carlos",
    "apellidos": "Pérez García",
    "nro_documento": "12345678",
    "correo": "juan.perez@email.com",
    "telefono": "987654321"
}
```

---

## 📚 Uso de la API

### Endpoints Principales

#### Contactos
```bash
# Listar contactos
GET /api/contactos

# Crear contacto
POST /api/contactos

# Ver contacto específico
GET /api/contactos/{id}

# Actualizar contacto
PUT /api/contactos/{id}

# Eliminar contacto
DELETE /api/contactos/{id}
```

#### Vehículos
```bash
# Listar vehículos
GET /api/vehiculos

# Crear vehículo
POST /api/vehiculos

# Ver vehículo específico
GET /api/vehiculos/{id}

# Actualizar vehículo
PUT /api/vehiculos/{id}

# Eliminar vehículo
DELETE /api/vehiculos/{id}
```

### Ejemplos de Filtros

#### Filtros para Contactos
```bash
# Buscar por nombre (exacto)
GET /api/contactos?nombre[eq]=Juan

# Buscar por nombre (parcial)
GET /api/contactos?nombre[like]=Jua

# Buscar por documento
GET /api/contactos?documento[eq]=12345678

# Incluir vehículos relacionados
GET /api/contactos?includeVehiculos=true

# Paginación personalizada
GET /api/contactos?per_page=25

# Combinando filtros
GET /api/contactos?nombre[like]=Juan&includeVehiculos=true&per_page=10
```

#### Filtros para Vehículos
```bash
# Buscar por marca
GET /api/vehiculos?marca[like]=Toyota

# Buscar por año
GET /api/vehiculos?año[gte]=2020

# Buscar por cliente (nombre del propietario)
GET /api/vehiculos?clienteNombre[like]=Juan

# Buscar por documento del cliente
GET /api/vehiculos?clienteDocumento[eq]=12345678
```

### Operadores de Filtro Disponibles
- `[eq]` - Igual exacto
- `[like]` - Búsqueda parcial (contiene)
- `[gte]` - Mayor o igual que (fechas/números)
- `[lte]` - Menor o igual que (fechas/números)

---
### Herramientas Recomendadas para testing

- **Postman**: Para testing completo de API
- **Insomnia**: Alternativa ligera a Postman
- **Thunder Client**: Extensión para VS Code

## 🧪 Testing con Insomnia

### Configuración Inicial en Insomnia

#### 1. **Configurar Headers Globales**
```
Content-Type: application/json
Accept: application/json
```
**Ejemplo para crear contacto o Vehiculo en insomnia**

#### 2. **Crear Contacto**
```
Método: POST
URL: http://localhost:8000/api/contactos
```

**Body (JSON):**
```json
{
    "nombre": "María",
    "apellidos": "González López",
    "nro_documento": "87654321",
    "correo": "maria@email.com",
    "telefono": "123456789"
}
```

#### 3. **Crear Vehículo**
```
Método: POST
URL: http://localhost:8000/api/vehiculos
```

**Body (JSON):**
```json
{
    "contacto_id": 1,
    "placa": "XYZ-789",
    "marca": "Honda",
    "modelo": "Civic",
    "año": 2023
}
```

#### 4. **Probar Filtros**
```
GET http://localhost:8000/api/contactos?nombre[like]=María&includeVehiculos=true
GET http://localhost:8000/api/vehiculos?marca[eq]=Honda&clienteNombre[like]=María
```

![Imagen de Imnsomnia con todos los servicios](./assets/insomnia.jpg)


---

## 🚀 Despliegue en Producción

### Variables de Entorno para Producción
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com

# Base de datos de producción
DB_CONNECTION=mysql
DB_HOST=tu-servidor-db
DB_DATABASE=contactos_vehiculos_prod
```

### Comandos de Despliegue
```bash
# Optimizar para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

