# Mensajes flash

Los mensajes flash son internamente atributos de sesión que pueden ser utilizados una única vez. Desaparecen de la sesión automáticamente cuando recuperamos su valor.

Son útiles para mostrar notificaciones al usuario.

Veamos un ejemplo:

```php
use Symfony\Component\HttpFoundation\Request;

public function updateAction(Request $request)
{
    // ...

    if ($form->isSubmitted() && $form->isValid()) {
        // do some sort of processing

        $this->addFlash(
            'notice',
            'Your changes were saved!'
        );

        return $this->redirectToRoute(...);
    }

    return $this->render(...);
}
```

En una plantilla concreta o incluso en una plantilla base, podemos acceder a los mensajes flash utilizando app.flashes().

```html
{# app/Resources/views/base.html.twig #}

{# Podemos recuperar solamente un tipo de mensajes #}
{% for message in app.flashes('notice') %}
    <div class="flash-notice">
        {{ message }}
    </div>
{% endfor %}

{# ...o recuperarlos todos #}
{% for label, messages in app.flashes %}
    {% for message in messages %}
        <div class="flash-{{ label }}">
            {{ message }}
        </div>
    {% endfor %}
{% endfor %}
```

NOTA: Es muy común utilizar tres claves de mensajes flash: notice, warning y error, pero realmente podemos utilizar los que queramos sin ningún problema.

NOTA: Existe el método peek() para obtener los mensajes SIN ELIMINARLOS de la sesión.

```html
{% for message in app.peek('notice') %}
```

