# Farmatodo

Aplicación desarrollada para la materia de Calidad de Software (COM450).

## Integrantes

Luis Fernando Salgado Miguez
Abril Johana Berrios Escalera

## Sobre el desarrollo

A continuación los enlaces a documentos elaborados en el desarrollo:

-   [Backlog de producto](https://docs.google.com/spreadsheets/d/1rZWDaX1RDoly0KbPf8y7MzhEC8ZJ9g1FCluktv_0PSw/edit?usp=sharing)
-   [Backlog de los Sprints](https://docs.google.com/spreadsheets/d/1og7FDTyo-0ARGZR4pi5ZAQFAsn6mB43uGB-4O1ZCD60/edit?usp=sharing)

## Instalación

El proyecto esta realizado con [Laravel 9](https://laravel.com/docs/9.x/), por tanto considere cumplir con los [requerimientos](https://laravel.com/docs/9.x/deployment#server-requirements) para instalarlo y ejecutarlo.

### Repositorio

Clonar el repositorio (debe tener instalado [GIT](https://git-scm.com/))

```bash
git clone https://github.com/fermelli/farmatodo.git
```

Ó

```bash
git clone git@github.com:fermelli/farmatodo.git
```

### Dependencias Back-end

Debe tener instalado [composer](https://getcomposer.org/)

```bash
composer install
```

Copie del archivo [`.env.example`](./.env.example) a un archivo `.env` que contendrá las configuraciones de ambiente.

```bash
cp .env.example .env
```

Realizar los cambios en el archivo de configuraciones de ambiente:

```.env
...
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=farmatodo
DB_USERNAME=root
DB_PASSWORD=password
...
```

Ejecutar las migraciones y el sembrado de datos

```bash
php artisan migrate --seed
```

Crear el enlace simbólico, para el almacenamiento de archivos (subida de imágenes).

```bash
php artisan storage:link
```

Tambien debe descargar las imágenes de los productos: [images_products.7z](https://drive.google.com/file/d/1pBUbex83D0rfkM_hihhAqRgNOOEnpJRA/view?usp=sharing) desde Google Drive, descomprimir y copiar en el directorio `products` ubicado en `storage/app/public/`.

### Dependencias del Front-end

Debe tener instalado [Node](https://nodejs.org/es/)

```bash
npm install
```

Compile los assets (CSS y JS) con:

```bash
npm run dev
```

### Ejecución

Corra la aplicación con:

```bash
php artisan serve
```

### Usuarios y Roles

Para ingresar al panel como super-administrador puede ingresar con el usuario: `testeo.test.55@gmail.com` y la contraseña: `passsword`, con el cual podrá visualizar todos los usuarios existentes (considere que para cualquiera la contraseña es `passsword`).

| Rol           | Ej. usuario              | Roles | Productos | Reporte | Descuentos | Compras |
|---------------|--------------------------|-------|-----------|---------|------------|---------|
| Super Admin   | testeo.test.55@gmail.com | Si    | Si        | Si      | Si         | No      |
| Admin         | admin@email.com          | No    | Si        | Si      | Si         | No      |
| User          | user.user@email.com      | No    | No        | No      | No         | Si      |

## Estilo de codificación

### PHP y Laravel

Se utiliza [`PHP_CodeSniffer`](https://github.com/squizlabs/PHP_CodeSniffer) como herramienta de linter a traves del paquete [`laravel-phpcs`](https://github.com/mreduar/laravel-phpcs) para seguir estilos de codificacion apropiados para PHP y Laravel.

Las configuraciones se encuentran en el archivo: [`phpcs.xml`](./phpcs.xml)

Y se ejecutan las verificaciones del código con:

```bash
./vendor/bin/phpcs
```

El mismo que genera un reporte de los errores y advertencias para codificación no adecuadas.

Se pueden realizar correcciones automaticamente ejecutando:

```bash
./vendor/bin/phpcbf
```

Adicionalmente se cuenta con un [`hook`](https://git-scm.com/book/en/v2/Customizing-Git-Git-Hooks) para el `pre-commit` (antes del commit) que verifica que se siguen la reglas establecidas.

### JS (VUE) y CSS

Se utiliza [ESLint](https://eslint.org/) y el plugin para Vue.js ([eslint-plugin-vue](https://eslint.vuejs.org/)) para el análisis del código y mantener la calidad.

Tambien se usa [Prettier](https://prettier.io/) para formateo de código.

### Extensiones

Se recomiendan utilizar las extensiones establecidas en [`extensions.json`](.vscode/extensions.json).

## Testing

Se utiliza [PHPUnit](https://phpunit.de/) que viene por defecto con Laravel, por tanto no tendrá que realizar ninguna configuración adicional, pero para saber más acerca consulte [Laravel Testing](https://laravel.com/docs/9.x/testing).

### Ejecución de pruebas

Puede ejecutar la pruebas con:

```bash
./vendor/bin/phpunit
```

 Ó tambien

```bash
php artisan test
```

Despues de realizar la pruebas debe sembrar los datos nuevamente para eso ejecute:

```bash
php artisan db:seed
```

Para las pruebas de subida de imagénes es necesario contar con la extension `php_gd2.dll`, que se puede activar en el archivo `php.ini` de su directorio PHP. Descomente la linea:

```bash
extension:gd
```

Ó la linea

```bash
extension=php_gd2.dll
```
