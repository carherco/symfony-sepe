# Estructura de directorios

## Directorios

- bin
- config
- public
- src
- templates
- tests
- translations
- var
- vendor

En el directorio **bin** tenemos dos ejecutables: console (para ejecutar comandos de consola) y phpunit (para ejectuar tests)

En el directorio **config** se encuentran los ficheros de configuración del proyecto.

Si utilizamos Doctrine, en el directorio **migrations** se encuentran las migraciones. Durante el curso veremos cómo funcionan y cómo nos pueden ayudar.

En el directorio **public** se encuentran los únicos archivos públicos de la aplicación: css, js, imágenes... y el único fichero php público: el index.php

En el directorio **src** se encuentra el código fuente (ficheros .php) de nuestra aplicación.

En el directorio **templates** se encuentran las plantillas de twig.

En el directorio **tests** se encuentran los tests (unitarios, de integración, e2e...).

En el directorio **translations** se encuentran los ficheros diccionario para las traducciones a otros idiomas de los textos de nuestra aplicación.

En el directorio **var** se encuentran ficheros que genera temporalmente la aplicación: caché, logs, profilers...

En el directorio **vendor** se encuetran las dependencias del proyecto gestionadas por composer.

## Archivos

- .env
- .env.test
- .gitignore
- .phpunit.result.cache
- composer.json
- composer.lock
- phpunit.xml.dist
- symfony.lock

## Ejercicio imagen

1) Descarga esta imagen:

http://clipartmag.com/images/website-under-construction-image-6.gif

2) Crea un directorio images dentro del directorio public.

3) Accede a la imagen a través del navegador con la url:

http://localhost/images/under-construction.gif

## Ejercicio favicon

Pon algún favicon en http://localhost/favicon.ico

Si no tienes ninguno a mano, descarga este:

https://symfony.com/favicon.ico