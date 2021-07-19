# El serializer de symfony

El componente Serializer se utiliza para convertir objetos en cadenas de texto con formato específico (JSON, YAML, XML... ) y viceversa.

![Diagrama de flujo del Serializer](./serializer_workflow.png "Imagen extraída de symfony.com")

Para instalar el componente con Flex:

> composer require symfony/serializer

## Uso básico del Serializer

Para utilizar el Serializador, hay que configurarlo con los normalizadores y codificadores que queramos que soporte:

```php
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

$encoders = array(new XmlEncoder(), new JsonEncoder());
$normalizers = array(new ObjectNormalizer());

$serializer = new Serializer($normalizers, $encoders);
```

## Serializar un objeto

```php
$person = new App\Entity\Producto();
$person->setNombre('nombre del producto');
$person->setPrecio(99);

$jsonContent = $serializer->serialize($person, 'json');

// $jsonContent contiene {"nombre":"nombre del producto","precio":99}
```

## Desserializar un objeto

```php
use App\Model\Person;

$data = <<<EOF
<person>
    <name>foo</name>
    <age>99</age>
    <sportsperson>false</sportsperson>
</person>
EOF;

$person = $serializer->deserialize($data, Person::class, 'xml');
```

Si hay atributos que no son de la clase, el comportamiento por defecto es ignorarlos. Pero se puede configurar el método deserialize para que lance un error en caso de encontrar atributos desconocidos: 

```php
$data = <<<EOF
<person>
    <name>foo</name>
    <age>99</age>
    <city>Paris</city>
</person>
EOF;

// Lanza una excepción Symfony\Component\Serializer\Exception\ExtraAttributesException
// porque "city" no es un atributo de la clase Person
$person = $serializer->deserialize($data, 'Acme\Person', 'xml', array(
    'allow_extra_attributes' => false,
));
```

Se puede utilizar el serializar para actualizar un objeto existente:

```php
$person = new Person();
$person->setName('bar');
$person->setAge(99);
$person->setSportsperson(true);

$data = <<<EOF
<person>
    <name>foo</name>
    <age>69</age>
</person>
EOF;

$serializer->deserialize($data, Person::class, 'xml', array('object_to_populate' => $person));
// $person = App\Model\Person(name: 'foo', age: '69', sportsperson: true)
```

Si estamos des-serializando un array de objetos, entonces se le indica al método deserialize con []

```php
$persons = $serializer->deserialize($data, 'Acme\Person[]', 'json');
```

## Manejo de referencias circulares

Pongamos un ejemplo de una referencia circular entre 2 objetos:

```php
class Organization
{
    private $name;
    private $members;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setMembers(array $members)
    {
        $this->members = $members;
    }

    public function getMembers()
    {
        return $this->members;
    }
}

class Member
{
    private $name;
    private $organization;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setOrganization(Organization $organization)
    {
        $this->organization = $organization;
    }

    public function getOrganization()
    {
        return $this->organization;
    }
}
```

Para evitar un bucle infinito, los normalizadores,  GetSetMethodNormalizer y ObjectNormalizer lanzan una Excepción CircularReferenceException cuando se encuentran con referencias circulares.

```php
$member = new Member();
$member->setName('Kévin');

$organization = new Organization();
$organization->setName('Les-Tilleuls.coop');
$organization->setMembers(array($member));

$member->setOrganization($organization);

echo $serializer->serialize($organization, 'json'); // Lanza una CircularReferenceException
```

El método **setCircularReferenceLimit()** de estos normalizadores establecen el máximo número de veces que se va a serializar un mismo objeto antes de considerarlo una referencia circular. Por defecto este valor es de 1.

En vez de lanzar una excepción, se pueden manejar con un *callable* para ejecutar el código que queramos.

En el siguiente objeto, se "cambia" el objeto que provoca la referencia circular por un string que lo representa, de forma que se corta el bucle infinito.

```php
$encoder = new JsonEncoder();
$normalizer = new ObjectNormalizer();

$normalizer->setCircularReferenceHandler(function ($object) {
    return $object->getName();
});

$serializer = new Serializer(array($normalizer), array($encoder));
```

## Manejo de la profundidad de serialización

El componente Serializer es capaz de detectar y limitar la profundidad de la serialización. 

Vamos a verlo con un ejemplo:

```php
namespace Acme;

class MyObj
{
    public $foo;

    /**
     * @var self
     */
    public $child;
}

$level1 = new MyObj();
$level1->foo = 'level1';

$level2 = new MyObj();
$level2->foo = 'level2';
$level1->child = $level2;

$level3 = new MyObj();
$level3->foo = 'level3';
$level2->child = $level3;
```

El serializador se puede configurar para establecer una profundidad máxima para una propiedad concreta.


```php
use Symfony\Component\Serializer\Annotation\MaxDepth;

namespace Acme;

class MyObj
{
    /**
     * @MaxDepth(2)
     */
    public $child;

    // ...
}
```

Para que el serializador tenga en cuenta la limitación de profundidad, hay que indicárselo con la clave **enable_max_depth**.


```php
$result = $serializer->normalize($level1, null, array('enable_max_depth' => true));
/*
$result = array(
    'foo' => 'level1',
    'child' => array(
            'foo' => 'level2',
            'child' => array(
                    'child' => null,
                ),
        ),
);
*/
```

## Normalizadores

En Symfony tenemos varios normalizadores disponibles:

- **ObjectNormalizer**

Este normalizador es capaz de acceder a las propiedades directamente y también a través de getters, setters, hassers, adders y removers.

Soporta la llamada al constructor durante la denormalización.

El renombrado de método a propiedad es como se ve en este ejemplo:

getFirstName() -> firstName

Es el normalizador más potente de los que vienen con Symfony.

- **GetSetMethodNormalizer**

Este normalizador lee el contenido de la clase llamando a los *getters* (métodos públicos que empiecen por *get*) y denormaliza llamando al constructor de la clase y a los *setters* (métodos públicos que empiecen por *set*).

El renombrado de método a propiedad es como se ve en este ejemplo:

getFirstName() -> firstName

- **PropertyNormalizer**

Este normalizador lee y escribe todas las propiedades públicas, privadas y protected de la propia clase y de sus clases padre.


- **JsonSerializableNormalizer**

Este normalizador trabaja con clases que implementan JsonSerializable.

- **DateTimeNormalizer**

Convierte objetos DateTimeInterface (por ejemplo: DateTime y DateTimeImmutable) en strings. Por defecto utiliza el formato RFC3339.

- **DataUriNormalizer**

Convierte objetos SplFileInfo en *data URI string* (data:...) permitiendo embeber ficheros en datos serializados.

- **DateIntervalNormalizer**

Convierte objetos DateInterval en strings. Por defecto utiliza el formato P%yY%mM%dDT%hH%iM%sS.

## Codificadores

Los codificadores convierten arrays en XML, JSON... y viceversa.

Todos implementan el interfaz **EncoderInterface** para codificar (array a formato) y **DecoderInterface** para decodificar (formato a array).

### Built-in Encoders

Symfony viene con unos cuantos Encoders:

- JsonEncoder

- XmlEncoder

- YamlEncoder

- CsvEncoder

```php
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

$encoders = array(new XmlEncoder(), new JsonEncoder());
$serializer = new Serializer(array(), $encoders);
```











