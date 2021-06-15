Estructura de directorios
=========================

Directorios
-----------

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

En el directorio **public** se encuentran los únicos archivos públicos de la aplicación: css, js, imágenes... y el único fichero php público: el index.php

En el directorio **src** se encuentra el código fuente (ficheros .php) de nuestra aplicación.

En el directorio **templates** se encuentran las plantillas de twig.

En el directorio **tests** se encuentran los tests (unitarios, de integración, e2e...).

En el directorio **translations** se encuentran los ficheros diccionario para las traducciones a otros idiomas de los textos de nuestra aplicación.

En el directorio **var** se encuentran ficheros que genera temporalmente la aplicación: caché, logs, profilers...

En el directorio **vendor** se encuetran las dependencias del proyecto gestionadas por composer.

Archivos
--------

- .env
- .env.test
- .gitignore
- .phpunit.result.cache
- composer.json
- composer.lock
- phpunit.xml.dist
- symfony.lock

