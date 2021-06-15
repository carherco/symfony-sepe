# Controladores

Los **Controllers** o Controladores son los puntos de entrada a nuestra aplicación.

Físicamente son clases que opcionalmente pueden extender de la clase *Symfony\Bundle\FrameworkBundle\Controller\AbstractController*.

Un controlador tendrá uno o más métodos llamados **Actions** o Acciones cuya misión será recibir una petición y generar una respuesta.

Cada acción se debe asociar a una **Ruta**.

Una acción debe terminar siempre realizando un **return de un objeto Response**.

```php
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class EjemploController extends AbstractController
{
    /**
     * @Route("/hola", name="hola")
     */
    public function saludo()
    {
        $name = 'Carlos';
        return new Response('<html><body>Hola, ' . $name . '</body><html>');
    }
}
```

https://symfony.com/doc/current/controller.html