# Instalación
## Requisitos previos

- PHP 7.2.5 o superior
- Composer

### Instalación de PHP (con MySQL y Apache)

- WAMP para sistemas Windows: https://www.wampserver.com/en
- LAMP para sistemas Linux: https://www.ionos.es/digitalguide/servidores/know-how/servidor-lamp-la-solucion-para-webs-dinamicas
- MAMP para sistemas MAC: https://www.mamp.info/en/windows
- XAMPP para cualquier sistema operativo: https://www.apachefriends.org/es/index.html

Cualquiera de esos paquetes viene con versión gratuita que es más que suficiente.

Comprueba que las siguientes extensiones de PHP están instaladas:

Ctype, iconv, JSON, PCRE, Session, SimpleXML, and Tokenizer;

Puedes comprobar las extensiones habilitadas actualmente usando php -m.

https://symfony.com/doc/current/setup.html#technical-requirements

### Instalación de composer

https://getcomposer.org/download

### Instalación de Visual Studio Code

https://code.visualstudio.com

## Creación del proyecto

- Creación de un esqueleto para proyecto web tradicional:

> composer create-project symfony/website-skeleton my-project

- Creación de un esqueleto para proyecto sin visualización web (APIs, commandos...)

> composer create-project symfony/skeleton my-project

## Arrancar el servidors

> php -S localhost:8000 -t public/

## Documentación adicional

https://symfony.com/doc/current/setup.html
## Ejercicio Instalación

Crear un proyecto website-skeleton y otro proyecto skeleton.

Comentar las diferencias observadas entre los dos proyectos.
