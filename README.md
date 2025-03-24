# Proyecto API NumerIQ

Este es el proyecto de la api para NumerIQ, cuenta con conexión a base de datos remoto y los pasos de como instalarlo y configurarlo.
## Requisitos

Antes de comenzar, asegúrate de tener instalados los siguientes requisitos en tu sistema:

- PHP 8.0 o superior
- Composer
- Git

## Instalación

Sigue estos pasos para instalar el proyecto en tu máquina local:

### 1. Clonar el repositorio
```bash
  git clone https://github.com/Grxson/api-numeriq.git
  cd api-numeriq
```

### 2. Instalar dependencias de PHP
```bash
  composer install 
```

### 3. Configurar el archivo de entorno
Copia el archivo de configuración de entorno y edítalo según tu configuración local:
```bash
  cp .env.example .env
```
Edita el archivo `.env` y configura la conexión a la base de datos:
```ini
DB_CONNECTION=mysql
DB_HOST=193.203.166.236
DB_PORT=3306
DB_DATABASE=u707936654_NumerIQ
DB_USERNAME=u707936654_estadia
DB_PASSWORD=Grxson@Gael_1
```

### 4. Generar la clave de la aplicación
```bash
  php artisan key:generate
```


### 7. Iniciar el servidor local
```bash
  php artisan serve
```
El servidor estará disponible en `http://127.0.0.1:8000/`.

### 8. Modificar VerifiCsrfToken

Navegar entre los archivos del proyecto hasta encontrar "VerifiCsrfToken"

### Ruta: api-numeriq\vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\VerifiCsrfToken

````angular2html
Agregar las rutas a desviar de la verificación de csrfToken, en este caso api:

protected $except = ['api/*'];
````
## Comandos útiles

- **Limpiar caché**
```bash
  php artisan cache:clear
  php artisan config:clear
  php artisan route:clear
  php artisan view:clear
```

- **Actualizar dependencias**
```bash
  composer update
```
- **Ver rutas del proyecto**
```bash
  php artisan route:list
```
