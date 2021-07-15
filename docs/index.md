# CURSO SYMFONY 5

## Introducción

- [Instalación](./instalacion.md)
- [Estructura de un proyecto symfony](./estructura_directorios.md)
- [Patrón MVC](./mvc.md)
- [Novedades PHP 7.4 y PHP 8.0](./novedades_PHP.md)

## Creación de la página de Home y menú público

- [Introducción a Controllers](./controllers_intro.md)
- [Introducción al Routing](./routing_intro.md)

### Ejercicio empezando con routing

Creación de 3 rutas:
  
- /home
- /login
- /about-us

Cada una de estas rutas debe estar asociadas a una acción y responder con un h1 básico.

## Creación de vistas (Twig)

- [Introducción a Twig](./twig_intro.md)

### Ejercicio empezando con twig

Crear 1 plantilla de Twig para cada una de las páginas del ejercicio anterior.

Enlazar las páginas con un menú.

Inluir algún fichero de css en las páginas (o algún framework como bootstrap, foundation,  tailwind...)

## Introducción al profiler y a los entornos

## La consola de comandos

- El comando make:controller

### Ejercicio

- Usar make:controller para crear un nuevo controlador que tenga la ruta /catalogo

- Enlazar esta nueva página al menú

## Twig

- Variables. Acceso a atributos con (.)
- Variables globales
- Estructuras de control (if, for…)
- Comentarios
- Operadores
- set


https://twig.symfony.com/doc/3.x/templates.html

### Ejercicio Twig 1

- En la página /catálogo, mostrar la lista de fondos del catálogo de la biblioteca.

## Más Twig

- include
- extends y block

### Ejemplo

Crear una nueva página de ejemplo de herencia de plantillas.

### Ejercicio Twig 2

Usar la herencia de plantillas con las páginas actuales de la aplicación.

## Debug

- Debug en controladores/servicios con dump()
- Debug en Twig con {% dump %}

## Acceso a base de datos. Doctrine.

- [Instalación y configuración](./doctrine_intro.md)
- [Entidades. El comando make:entity](./doctrine_entidades.md)
- [Entity Manager](./doctrine_entity_manager.md)
- [Repository](./doctrine_repositorios.md)

### Ejercicios

- Crear entidades Fondo, Autor, Editorial y Categoría relacionándolas entre ellas.

- Rehacer el listado de catálogo para leer los datos de la base de datos.

- Inspeccionar las consultas en el profiler.

## Más doctrine

- [DQL](https://www.doctrine-project.org/projects/doctrine-orm/en/2.9/reference/dql-doctrine-query-language.html#doctrine-query-language)
- [Query Builder](https://www.doctrine-project.org/projects/doctrine-orm/en/2.9/reference/query-builder.html#the-querybuilder)
- [Native SQL](https://www.doctrine-project.org/projects/doctrine-orm/en/2.9/reference/native-sql.html#native-sql)
- [Generar entidades de una base de datos existente](https://symfony.com/doc/current/doctrine/reverse_engineering.html)
- El problema de las N+1 queries

### Ejercicio Doctrine Problema N+1

Arreglar el problema de las N+1 queries en el listado del catálogo.

## Instalación de Bundles

- [NelmioAliceBundle](https://github.com/hautelook/AliceBundle)

## Controladores y servicios

- [Servicios](./services.md)
- [El objeto Request](./request.md)
- [El objeto Response](./response.md)
- Errores & excepciones
- Páginas de error
- [Session](session.md)
- [Mensajes Flash](./flash.md)
- CORS
- Redirecting and Forwarding

## Routing avanzado

- [Routing](./routing.md)

## Ejercicio routing avanzado

- Creación de página para mostrar ficha de un fondo

## El componente Security

- [Autenticación y Autorización. Roles](./seguridad.md)
- Voters
- El bundle FOSUserBundle

## La consola de symfony

- Comandos predefinidos.
- Creación de comandos de consola personalizados.

## Ajax

## Creación de APIs REST con Symfony

- JsonResponse
- LexitJwtBundle

## El serializer de symfony

- Cómo manejar referencias circulares
- Cómo manejar la profundidad de la serialización
- Normalizers
- Encoders
- Cómo configurar qué atributos se serializan
- Cómo convertir nombres de propiedades al serializar y des-serializar 

## Twig Avanzado

- Sobreescribir plantillas de bundles de terceros
- Crear plantillas sin controladores

## Configuración del servidor web

https://symfony.com/doc/current/setup/web_server_configuration.html

## Proyecto Final

Programación de un proyecto a elección del alumno.

Los requisitos mínimos que debe cumplir este proyecto son los siguientes:

- En la base de datos debemos tener al menos una relación 1 a muchos y al menos otra relación muchos a muchos.
- Los usuarios deben poder registrarse y hacer login.
- Debe haber al menos 2 tipos de usuarios.

