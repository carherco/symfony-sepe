# Routing

## Parametros

Podemos parametrizar las rutas con {}.

```php
#[Route('/fondo/{id}', name: 'ver_detalles_fondo')]
public function show(string $id) {
  // ...
}
```

Symfony nos pasará el valor del parámetro como argumento de la función.

### Restricciones de parámetros (requirements)

```yml
user_edit:
  path:  /user/edit/{id}
  controller: App\Controller\UsersController:edit
  requirements:
    id: '\d+'
```

El \d+ es una expresión regular.

### Valor por defecto de un parámetro

```yml
user_edit:
  path:  /user/edit/{id}
  controller: App\Controller\UsersController:edit
  id: 1
  requirements:
    id: '\d+'
```

### Parámetros extra

Es posible pasar parámetros extra en la ruta:

```yml
# config/routes.yaml
blog:
    path:       /usuarios/{page}
    controller: App\Controller\UsuariosController:index
    defaults:
        page: 1
        title: "Listado de usuarios"
```

### Parámetros especiales

El componente de routing tiene estos 4 parámetros especiales:

- **_controller**: Este parámetro determina qué controlador se ejecutará. La sintaxis es bundle:controller:action

- **_locale**: Establece el idioma de la petición

- **_format**: Establece el formato de la request (Ej: Content-Type:application/json).

- **_fragment**: Establece el *fragment* de la url

Ejemplo:

```yml
# config/routes.yaml
article_search:
  path:        /articles/{_locale}/search.{_format}
  controller:  App\Controller\ArticleController::search
  locale:      en
  format:      html
  requirements:
      _locale: en|fr
      _format: html|xml
```

```php
class ArticleController extends Controller
{
    /**
     * @Route(
     *     "/articles/{slug}.{_format}",
     *     defaults={"_format": "html"},
     *     requirements={
     *         "_format": "html|rss",
     *     }
     * )
     */
    public function showAction($_locale, $year, $slug)
    {
    }
}
```

## Route Groups and Prefixes

```php
// src/Controller/BlogController.php

/**
 * @Route("/blog", name="blog_")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        // ...
    }

    /**
     * @Route("/posts/{slug}", name="show")
     */
    public function show(Post $post): Response
    {
        // ...
    }
}
```

https://symfony.com/doc/current/routing.html#route-groups-and-prefixes

## Restricción de rutas por método HTTP

```yml
api_user_show:
    path:     /api/users/{id}
    controller: App\Controller\UsersApi:show
    methods:  [GET, HEAD]

api_user_edit:
    path:     /api/users/{id}
    controller: App\Controller\UsersApi:edit
    methods:  [PUT]
```

```php
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
// ...

class UsersApiController extends Controller
{
    /**
     * @Route("/api/users/{id}")
     * @Method({"GET","HEAD"})
     */
    public function showAction($id)
    {
        // ... return a JSON response with the post
    }

    /**
     * @Route("/api/users/{id}")
     * @Method("PUT")
     */
    public function editAction($id)
    {
        // ... edit a post
    }
}
```

## Rutas especiales

Symfony tiene acciones preprogramadas para tareas típicas.

### Redireccionar a otra url

```yml
homepage:
    path: /
    controller: Symfony\Bundle\FrameworkBundle\Controller\RedirectController
    defaults:
        path: /app
        permanent: true
```

### Redireccionar a otra ruta

```yml
admin:
    path: /wp-admin
    controller: Symfony\Bundle\FrameworkBundle\Controller\RedirectController
    defaults:
        route: sonata_admin_dashboard
        permanent: true
```

Ejercicio: investigar la diferencia entre poner permanent: true o false.

### Rutas sin controlador

```yaml
# config/routes.yaml
acme_privacy:
    path:          /privacy
    controller:    Symfony\Bundle\FrameworkBundle\Controller\TemplateController
    defaults:
        # Obligatorio: La ruta a la plantilla
        template:  'static/privacy.html.twig'

        # Opcionalmente puedes indicar al navegador opciones de cacheo
        maxAge:    86400
        sharedAge: 86400

        # opcionalmente puedes pasar datos a la plantilla
        context:
            site_name: 'ACME'
            theme: 'dark'
```

https://symfony.com/doc/current/templates.html#templates-render-from-route

## Rutas localizadas

```yaml
# config/routes.yaml
about_us:
    path:
        en: /about-us
        fr: /over-ons
        es: /sobre-nosotros
    controller: App\Controller\CompanyController::about
```

En el ejemplo anterior se definen 3 rutas que van a la misma acción, pero además se setea el valor _locale al idioma correspondiente. Ese valor es el que usará Symfony para elegir el diccionario de idioma correcto.

También es muy recurrida la técnica de poner las urls prefijadas con el idioma. En ese caso se configura así:

```yml
# config/routes/annotations.yaml
controllers:
    resource: '../../src/Controller/'
    type: annotation
    prefix:
        en: '' # Si no hay prefijo en la ruta, _locale valdrá 'en'
        fr: '/fr'
        es: '/es'
```

## Depuración de rutas

Listado de las todas las rutas:

> php bin/console debug:router

Información sobre una ruta específica:

> php bin/console debug:router catalogo_index

Testear una URL:

> php bin/console router:match /blog/my-latest-post


## Cambiar la prioridad de las rutas

El orden de las rutas importa. La primera ruta que haga *match* con la petición, será la ruta escogida por symfony.

Pero desde la versión 5.1 es posible cambiar las prioridades de las rutas para alterar el orden en el que symfony las busca.

```php
class BlogController extends AbstractController
{
    /**
     * @Route("/blog/{slug}", name="blog_show")
     */
    public function show(string $slug)
    {
        // ...
    }

    /**
     * @Route("/blog/list", name="blog_list", priority=2)
     */
    public function list()
    {
        // ...
    }
}
```

El parámetro _priority_ espera un valor numérico. Si no se indica ninguno, el valor es 0. 

Las rutas con prioridad mayor, se evaluarán antes que las de prioridad menor.

## Parameter Conversion

Una necesidad muy típica es utilizar un parámetro de la ruta (por ejemplo, el id) para obtener la entidad correspondiente.

Symfony puede hacer este trabajo automáticamente mediante los llamados “Param Converters” siempre que el parámetro coincida con un campo único de la entidad.

Esta característica solamente está disponible si se utilizan anotaciones para definir las rutas.

```php
class BlogController extends AbstractController
{
    // ...

    /**
     * @Route("/blog/{slug}", name="blog_show")
     */
    public function show(BlogPost $post): Response
    {
        // $post is the object whose slug matches the routing parameter

        // ...
    }
}
```

Esta funcionalidad está en SensioFrameworkExtraBundle:

> composer require sensio/framework-extra-bundle

Es posible realizar conversiones más complejas:

https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/converters.html