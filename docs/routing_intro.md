# Routing

El sistema de routing es el encargado de asociar rutas con acciones.

Las rutas se pueden configurar de 5 modos distintos:

- En archivos de configuración con formato YAML
- En archivos de configuración con formato XML
- En archivos de configuración con formato PHP
- En los controladores con anotaciones
- En los controladores con atributos

Ejemplos:

```yaml
blog_list:
    path: /blog
    controller: App\Controller\BlogController::list
```

```php
class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog_list")
     */
    public function list()
    {
        // ...
    }
}
```

https://symfony.com/doc/current/routing.html