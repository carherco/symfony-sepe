El objeto Response
==================

Un controlador en Symfony tiene un objetivo principal: Devolver un objeto response.

Ya sea una página html, o una respuesta en formato json, o una página de error, o un archivo para descargar... deberíamos acabar siempre haciendo un return de un objeto de tipo Response.

Un ejemplo sencillo sería el siguiente:

```php
use Symfony\Component\HttpFoundation\Response;

...

$response = new Response(
    'Contenido de la respuesta',
    Response::HTTP_OK,
    array('content-type' => 'text/html')
);

return $response;
```


El objeto response tiene métodos para establecer los valores del content, del código de estado, de los headers...

```php
$response->setContent('<h1>Hello World</h1>');

$response->headers->set('Content-Type', 'text/plain');

$response->headers->setCookie(new Cookie('foo', 'bar'));

$response->setStatusCode(Response::HTTP_NOT_FOUND);

$response->setCharset('ISO-8859-1');
```



NOTA: Desde la versión 3.1, no se puede configurar el charset por defecto de las respuestas en el config.yml. Se debe hacer en la clase AppKernel. (Symony utiliza por defecto UTF-8).

```php
class AppKernel extends Kernel
{
    public function getCharset()
    {
        return 'ISO-8859-1';
    }
}
```

Renderizando plantillas
-----------------------

Cuando utilizamos el método $this->render(), internamente symfony construye y nos devuelve un objeto Response.

Al hacer return $this->render() estamos por lo tanto cumpliendo la norma de symfony de hacer un return de un objeto Response.


Ejemplo de una respuesta JSON
-----------------------------

El siguiente ejemplo muestra cómo se haría una respuesta json:

```php
$response = new Response();
$response->setContent(json_encode(array(
    'data' => 123,
)));
$response->headers->set('Content-Type', 'application/json');
return $response;
```


Objetos que extienden de Response
---------------------------------

Symfony dispone de objetos que extienden de Response para facilitar tipos de respuesta muy comunes:

- RedirectResponse
- JsonResponse
- BinaryFileResponse
- StreamedResponse

Además si extendemos nuestra clase de Controller o de AbstractController, tenemos disponibles funciones helper que facilitan la generación de los objetos Response correspondientes:

- $this->redirect('http://symfony.com/doc');

- $this->json(array('data' => 123));

- $this->file('/path/to/some_file.pdf');


https://symfony.com/doc/current/components/http_foundation.html#component-http-foundation-serving-files

https://symfony.com/doc/current/components/http_foundation.html#streaming-response