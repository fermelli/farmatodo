# Farmatodo

Aplicación desarrollada para la materia de Calidad de Software (COM450).

## Instalación

Clonar el repositorio (debe tener instalado [GIT](https://git-scm.com/))

```bash
git clone https://gitlab.com/fermelli/farmatodo.git
```

Ó

```bash
git clone git@gitlab.com:fermelli/farmatodo.git
```

Instalar las dependencias del back-end (debe tener instalado [composer](https://getcomposer.org/))

```bash
composer install
```

Realizar los cambios en el archivo de configuraciones de ambiente: `.env` (copie del archivo [`.env.example`](./.env.example)).

```bash
cp .env.example .env
```

Ejecutar las migraciones

```bash
php artisan migrate
```

Tambien instalar las dependencias del front-end (debe tener instalado [Node](https://nodejs.org/es/))

```bash
npm install
```

Compile los assets (css y js) con:

```bash
npm run dev
```

Corra la aplicación con:

```bash
php artisan serve
```

## Estilo de codificación

### PHP y Laravel

Se utiliza [`PHP_CodeSniffer`](https://github.com/squizlabs/PHP_CodeSniffer) como herramienta de linter a traves del paquete [`laravel-phpcs`](https://github.com/mreduar/laravel-phpcs) para seguir estilos de codificacion apropiados para PHP y Laravel.

Las configuraciones se encuentran en: [`phpcs.xml`](./phpcs.xml)

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
