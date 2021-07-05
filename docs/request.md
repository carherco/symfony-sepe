El objeto Request
=================

Toda la información sobre la petición, es accesible desde el objeto Request.

Basta con incluirlo como argumento del controlador para tener acceso a él.

```php
use Symfony\Component\HttpFoundation\Request;

public function index(Request $request)
{
    $request->isXmlHttpRequest(); // is it an Ajax request?

    $request->getPreferredLanguage(array('en', 'fr'));

    // obtener variables enviadas por GET y por POST respectivamente
    $request->query->get('page');
    $request->request->get('page');

    // obtener variables $_SERVER
    $request->server->get('HTTP_HOST');

    // obtener una instancia de la clase UploadedFile con el fichero enviado
    $request->files->get('fichero');

    // obtener el valor de una COOKIE 
    $request->cookies->get('PHPSESSID');

    // obtener una cabecera HTTP
    $request->headers->get('host');
    $request->headers->get('content_type');
}
```

