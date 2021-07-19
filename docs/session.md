Sesión
======

Symfony cuenta con un servicio para almacenar la información relacionada con la sesión del usuario

Para utilizarla, debemos activarla en la configuración del framework


```yml
# config/packages/framework.yaml
framework:
    # ...

    session:
        # The native PHP session handler will be used
        handler_id: ~
    # ...
```

Para acceder a la sesión basta con tipar un argumento con el tipo **SessionInterface**

```php
use Symfony\Component\HttpFoundation\Session\SessionInterface;

public function index(SessionInterface $session)
{
    // Guardar un dato en la sesión para utilizarlo en una petición posterior
    $session->set('filters', ['title'=> 'Venecia', 'autor'=>'Reverte']);

    // Obtener el valor de un dato de la sesión
    $filters = $session->get('filters');

    // Preguntar si existe un dato en la sesión
    $hasFilters = $session->has('filters');

    // Usar un valor por defecto si no existe
    $filters = $session->get('filters', []);

    //Destruye la sesión y crea otra nueva
    $session->invalidate();

    //Borra todos los atributos de la sesión actual
    $session->clear();
}
```

Acceder a la sesión desde Twig
------------------------------

Recordemos que desde twig tenemos acceso a la variable app, que no permite acceder a la request, la sesión, etc

- app.user
- app.request
- app.session
- app.environment
- app.debug

