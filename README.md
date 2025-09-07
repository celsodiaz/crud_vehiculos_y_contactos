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
git clone https://github.com/tu-usuario/contactos-vehiculos.git
cd contactos-vehiculos
```

### 2. Instalar Dependencias
```bash
composer install
```

### 3. Configuración del Entorno
```bash
# Copiar archivo de configuración
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate
```

### 4. Variables de Entorno (.env)
```env
# Configuración de la aplicación
APP_NAME="Sistema Contactos y Vehículos"
APP_ENV=local
APP_KEY=base64:CLAVE_GENERADA_AUTOMATICAMENTE
APP_DEBUG=true
APP_URL=http://localhost:8000

# Base de datos - MySQL
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=contactos_vehiculos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password

# Base de datos - SQLite (alternativa)
# DB_CONNECTION=sqlite
# DB_DATABASE=/ruta/completa/database/database.sqlite

# Cache y sesiones
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Configuración de correo (opcional)
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 5. Configurar Base de Datos
```bash
# Crear base de datos (MySQL)
mysql -u root -p -e "CREATE DATABASE contactos_vehiculos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# O para SQLite
touch database/database.sqlite
```

---

## ▶️ Puesta en Marcha

### 1. Ejecutar Migraciones
```bash
php artisan migrate
```

### 2. Poblar con Datos de Prueba
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

# Ejecutar tests (si están configurados)
php artisan test
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

#### Vehículos de Ejemplo
```json
{
    "contacto_id": 1,
    "placa": "ABC-123",
    "marca": "Toyota",
    "modelo": "Corolla",
    "año": 2022
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

## 🧪 Testing

### Probar con cURL
```bash
# Crear contacto
curl -X POST http://localhost:8000/api/contactos \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "nombre": "María",
    "apellidos": "González López",
    "nro_documento": "87654321",
    "correo": "maria@email.com",
    "telefono": "123456789"
  }'
```

### Herramientas Recomendadas
- **Postman**: Para testing completo de API
- **Insomnia**: Alternativa ligera a Postman
- **Thunder Client**: Extensión para VS Code

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

---

## 🤝 Contribución

1. Fork el proyecto
2. Crea tu rama de feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

---

## 📝 Licencia

Este proyecto está licenciado bajo la Licencia MIT - ver el archivo [LICENSE.md](LICENSE.md) para más detalles.

---

## 📞 Soporte

- **Email**: soporte@tu-proyecto.com
- **Documentación**: [Wiki del proyecto](https://github.com/tu-usuario/contactos-vehiculos/wiki)
- **Issues**: [GitHub Issues](https://github.com/tu-usuario/contactos-vehiculos/issues)

