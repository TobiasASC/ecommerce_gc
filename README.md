# E-commerce - GC Diseños 🛍️

Un catálogo digital y plataforma de e-commerce autogestionable desarrollado para mostrar productos de diseño, controlar stock y gestionar categorías de forma dinámica.

<img width="1905" height="903" alt="image" src="https://github.com/user-attachments/assets/dc740f4f-bd46-4339-9326-3cc0d1cba072" />


##  Características principales (Features)

*   **Catálogo Público:** Vista optimizada de productos con imágenes alojadas en la nube.
*   **Gestión de Datos:** Uso de migraciones y seeders para la carga inicial estructurada de productos y usuarios.
*   **Almacenamiento en la Nube:** Integración con Cloudinary para la gestión y optimización de imágenes.
*   **Despliegue Serverless:** Configurado para funcionar en entornos sin servidor como Vercel, conectado a una base de datos remota.

## 🛠️ Tecnologías utilizadas

*   **Backend:** PHP, Laravel
*   **Base de Datos:** MariaDB (Alojada en Aiven)
*   **Almacenamiento de Archivos:** Cloudinary
*   **Despliegue / Hosting:** Vercel

## ⚙️ Guía de Instalación Local
Paso 1 - Clonar el repositorio
```bash
git clone https://github.com/TobiasASC/ecommerce_gc.git
```
Paso 2 - Instalar dependencias
```bash
composer install
```
Paso 3 - Configurar variables de entorno
```bash
cp .env.example .env
```
Generar key
```bash
php artisan key:generate
```
Configurar .env para conectar la BD local.
```bash
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce_gc
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```
Paso 4 - Ejecutar migraciones y seeders
```bash
php artisan migrate --seed
```
Paso 5 - Iniciar el servidor local
```bash
php artisan serve
```
**Usuarios**:
- Cliente
  cliente@example.com
  12345678

- Admin
  admin@example.com
  12345678
           
<h4>Desarrollado por Tobias Sanchez Cueba 🚀</h4>
