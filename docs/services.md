# Servicios

Una aplicación está llena de objetos útiles: Un objeto "Mailer" es útil para enviar correos, el "EntityManager" para hacer operaciones con las entidades de Doctrine...

En Symfony, estos "objetos útiles" se llaman servicios, y viven dentro de un objeto especial llamado contenedor de servicios. El contenedor nos permite centralizar el modo en el que los objetos son construidos. Simplifica el desarrollo, ayuda a construir una arquitectura robusta y es muy rápido.

El contenedor de servicios actúa mediante el patrón de inyección de dependencias cuando tipamos la clase en un parámetro de entrada de un controlador o de un constructor. 

Los servicios son simplemente clases con métodos. Pero con la particularidad de que son INYECTABLES.

Podemos pedir a Symfony cualquier servicio en:

- El constructor de otro servicio
- En el constructor y en las acciones de un controlador.

```php
public function index(Doctrine\ORM\EntityManagerInterface $em)
{
    
}
```

El siguiente comando nos da una lista de los servicios que tenemos disponibles:

> bin/console debug:autowiring

Se puede ejecutar el comando para buscar algo específico:

> bin/console debug:autowiring cache

Para obtener la lista completa con más detalles, tenemos otro comando:

> bin/console debug:container


NOTA: El contenedor de dependecias utiliza la técnica de lazy-loading: no instancia un servicio hasta que se pide dicho servicio. Si no se pide, no se instancia.

NOTA: Un servicio se crea una única vez. Si en varias partes de la aplicación se le pide a Symfony un mismo servicio, Symfony devolverá siempre la misma instancia del servicio.

