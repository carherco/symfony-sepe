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
    // store an attribute for reuse during a later user request
    $session->set('foo', 'bar');

    // get the attribute set by another controller in another request
    $foobar = $session->get('foobar');

    $foobar = $session->has('foobar');

    // use a default value if the attribute doesn't exist
    $filters = $session->get('filters', array());

    //Destruye la sesión y crea otra nueva
    $foobar = $session->invalidate();

    //Borra todos los atributos de la sesión actual
    $foobar = $session->clear();
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

