# Novedades PHP

## Novedades PHP 7.4

### Arrow Functions

Antes:

```php
$prices = array_map(
  function (Product $product) {      
    return $product->getPrice();  
  }, $products
);
```

Ahora:

```php
$prices = array_map(
  fn($product) => $product->getPrice(),                   $products
);
```

Entre las principales características de esta nueva sintaxis tenemos:

- Es necesario que comiencen con fn (esta es la principal diferencia con Javascript donde no es necesario “marcarlas” con un prefijo).
- Están restringidas a una instrucción, cuyo resultado se considerará el return.
- Permite tipado

```php
$prices = array_map(
  fn(Product $product): float => $product->getPrice(), $products
);
```

#### Ejemplo arrow function

Transformar array de objetos Producto en array numérico de precios.

#### Ejercicio arrow function

Filtrar un array de Personas para que solamente aparezcan los mayores de 18 años.

### Tipado de propiedades

Ya se pueden tipar las propiades de las clases:

```php
class User {
  public string $name;
  public ?int $age;
  public ContactInfo $contactInfo;
}
```

### “Type variance” mejorada

Una clase hija puede sobrescribir el tipo de retorno de un método de la clase padre si ese tipo extiende del tipo que devuelve el padre.

```php
class Parent {};
class Child extends Parent {};

class A 
{
  public function covariant(): Parent {};
}

class B extends A
{
  public function covariant(): Child {};
}
```

Esto se conoce en el argot como “covariant return types”.

También se han introducido “contravariant arguments” de modo que:

```php
class Parent {};
class Child extends Parent {};

class A 
{
  public function contravariant(Child $value) {};
}

class B extends A
{
  public function contravariant(Parent $value) {};
}
```

Esto cumple el 3er principio SOLID, el de Liskov, con lo cual no tendremos problemas en nuestro código.

### Operador Null coalescing assignment

Esto

```php
$someArray['key'] = $someArray['key'] ?? 'foo';
```

Se puede reescribir con el nuevo operador

```php
$someArray['key'] ??= 'foo';
```

### Operador spread

```php
$foo = [1, 2, 3];
$bar = ['a', 'b', 'c'];
$result = [0, ...$foo, ...$bar, 'd'];
// 0, 1, 2, 3, 'a', 'b', 'c', 'd'
```

De momento sólo es posible usarlo con arrays que tengan claves numéricas.

### Numeric literal separator

Podemos utilizar guiones bajos para separar hacer más legibles los números grandes sin afectar al valor de dichos números

```php
$numeroGrande = 299_792_458;
```

Lo anterior equivale a

```php
$numeroGrande = 299792458;
```

### Preloading

Esta nueva característica permite al servidor cargar los archivos PHP en memoria al principio de modo que estén permanentemente disponibles para todas las “requests” posteriores a la carga.

Evidentemente esto supone una mejora muy significativa en la velocidad a la que se ejecutarán las peticiones pero que sin embargo nos obligará a reiniciar el servidor cada vez que modifiquemos el código fuente.

Debe activarse desde el archivo php.ini con la directiva opcache.preload.

## Novedades PHP 8.0

### Atributos

Se introduce el concepto de atributos para añadir metadatos a un código.

```php
class BlogController extends AbstractController
{
    #[Route('/blog', name: 'blog_list')]
    public function list()
    {
        // ...
    }
}
```

Veremos cómo los usa Symfony en el componente de routing.

### Constructor promotion (aka. constructores breves)

```php
class Point {
    protected int $x;
    protected int $y;

    public function __construct(int $x, int $y = 0) {
      $this->x = $x;
      $this->y = $y
    }
}
```

Se puede escribir ahora así

```php
class Point {
    public function __construct(protected int $x, protected int $y = 0) {
    }
}
```

### Union Types

```php
public function foo(Foo|Bar $input): int|float;
```

### Operador nullsafe

```php
$universidad =  null;
if ($session !== null) {
 
    $usuario = $session->usuario;
  
    if ($usuario !== null) {
        $estudios = $usuario->getEstudios();
  
        if ($estudios !== null) {
            $universidad = $estudios->universidad;
        }
    }
}
```

Ahora

```php
$universidad = $session?->usuario?->getEstudios()?->universidad;
```

### Named arguments

Esta característica permite alterar el orden de los argumentos de una función al ser invocada.

Supongamos esta función:

```php
function mostrarCurso($nombre, $profesor, $horas){
   return "Bienvenido al $nombre, impartido por $profesor, que tiene $horas horas de contenido :)";
}
```

Puede ser llamada de esta manera

```php
echo mostrarCurso(horas: 200, nombre: 'Curso de Symfony en PHP', profesor: 'Carlos Herrera');
```

## Referencias

https://www.php.net/manual/es/appendices.php