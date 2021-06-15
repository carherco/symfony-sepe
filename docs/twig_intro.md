# Twig

Twig es un motor de plantillas para PHP.

Para activar el sistema de plantillas twig, si no lo tenemos instalado, hay que instalarlo.

> composer require twig

## Delimitadores

Su sintaxis incluye 3 delimitadores:

- Cometarios: {# ... #}

```twig
{# Esto es un comentario #}
```

- Para mostrar contenido (echo): {{ ... }}

```twig
<td>{{ fondo.editorial }}</td>
```

- Para ejecutar lógica: {% ... %}

```twig
{% for fondo in fondos %}
  ...
{% endfor %}
```

```twig
{% if autor.tipo == 'PERSONA' %}
  ...
{% endif %}
```

Todo lo que esté fuera de estos 3 delimitadores no será procesado por Twig.

## Acceso a variables

Las variables de tipo simple se acceden sin más.

Para acceder a atributos de objetos, elementos de arrays, etc, se utiliza el operador punto (.)

```twig
{{ fondo.titulo }}
```

El operador . es muy potente: probará por orden las siguientes alternativas

- Al elemento titulo del array fondo ($fondo['titulo'])
- A la propiedad titulo del objeto fondo ($fondo->titulo])
- Al método titulo() del objeto fondo ($fondo->titulo()])
- Al método getTitulo() del objeto fondo ($fondo->getTitulo()])
- Al método isTitulo() del objeto fondo ($fondo->isTitulo()])
- Al método hasTitulo() del objeto fondo ($fondo->hasTitulo()])

Si ninguna de estas alternativas es válida, devolverá un error en el entorno dev y un null en producción (está configurado así por la opción *strict_variables*).

Twig también acepta acceder a elementos de arrays con corchetes

```twig
{{ fondo[titulo] }}
```

En el caso de que el nombre de un atributo tenga caracteres especiales o sea un campo dinámico, existe la alternativa attribute().

```twig
{# fondo.titulo-original no funcionaría #}
{{ attribute(fondo, 'titulo-original' }}
```

```twig
{# desde php se eligiría el atributo: $campo = 'titulo' #}
{{ attribute(fondo, campo }}
```

## Set

Puedes crear y asignar valores a variables con set:

```twig
{% set campo = 'titulo' %}
{% set numeros = [1, 2] %}
{% set fondo = {'titulo': 'El quijote'} %}
```

## Variables globales

Twig incluye las siguientes variables globales:

_self: hace referencia al nombre de la plantilla actual
_context: hace referencia al contexto actual
_charset: hace referencia al charset actual

Symfony además incluye otra variable global en twig:

- app

La variable app es un objeto que contiene los siguientes atributos:

- app.user

- app.request
- app.session
- app.flashes
- app.environment
- app.debug
- app.token

https://symfony.com/doc/current/templates.html#the-app-global-variable

## Expresiones y Operadores

Twig incluye muchos operadores que permiten crear expresiones lógicas de forma sencilla y muy legible (de concatenación de strings, de comparación, operadores matemáticos...)

https://twig.symfony.com/doc/3.x/templates.html#expressions

## Filtros

Las variables pueden ser modificadas por unos elementos denominados *filtros*. 

Los filtros se aplican con el operador | y se pueden encadenar.

```twig
{{ name|striptags|title }}
```

Si algún filtro necesita argumentos, se ponen mediantes paréntesis separándolos con comas:

```twig
{{ list|join(', ') }}
```

Se puede aplicar un filtro a una sección de código mediante el operador *apply*:

```twig
{% apply upper %}
    This text becomes uppercase
{% endapply %}
```

La lista completa de filtros se puede consultar en: https://twig.symfony.com/doc/3.x/filters/index.html

## Funciones

Twig también incorpora algunas funciones.

```twig
{% for i in range(0, 3) %}
    {{ i }},
{% endfor %}
```

La lista completa de funciones se puede consultar en: https://twig.symfony.com/doc/3.x/functions/index.html

## Named arguments

Las funciones y los filtros permiten los denominados *named arguments* para facilitar la lectura y conocer el significado de los argumentos

```twig
{% for i in range(1, 10, 2) %}
    {{ i }},
{% endfor %}
```

Mejor:

```twig
{% for i in range(low=1, high=10, step=2) %}
    {{ i }},
{% endfor %}
```

```twig
{{ data|convert_encoding('UTF-8', 'iso-2022-jp') }}

{# versus #}

{{ data|convert_encoding(from='iso-2022-jp', to='UTF-8') }}
```

Además, permiten ignorar argumentos si no queremos cambiar su valor por defecto:

```twig
{# the first argument is the date format, which defaults to the global date format if null is passed #}
{{ "now"|date(null, "Europe/Paris") }}

{# or skip the format value by using a named argument for the time zone #}
{{ "now"|date(timezone="Europe/Paris") }}
```

Se pueden mezclar argumentos posicionales con argumentos nombrados. En caso de hacerlo, los posicionales deben ir siempre primero:

```twig
{{ "now"|date('d/m/Y H:i', timezone="Europe/Paris") }}
```

## Cómo depurar variables en twig

En el componente **VarDumper** existe una función llamada *dump()* muy útil para la depuración de variables tanto en twig como en los controladores.

Para utilizar esta función antes de nada tenemos que asegurarnos de tener el componente isntalado:

> composer require var-dumper

La función dump() renderiza el valor de la variable en la barra de depuración.

En twig tenemos dos formas de utilizar dump:

- {% dump fondo.titulo %}
- {{ dump(fondo.titulo) }}

La primera de ellas, renderiza el valor de la variable en la barra de depuración, pero la segunda, renderiza el valor de la variable en el propio html.

La función dump() por defecto solamente está disponible en los entornos dev y test. Utilizarla en el entorno de producción provocaría un error de PHP.

## Include

Desde un twig se puede incluir otro twig con la función include:

```twig
{{ include('menu.html') }}
```

```twig
{% for fondo in fondos %}
  {{ include('render_fondo.html') }}
{% endfor %}
```

La plantilla incluida tiene acceso a todas las variables (context) presentes en la plantilla incluyente.

Se pueden pasar variables adicionales a la plantilla incluida e incluso se puede deshabilitar el acceso al contexto (que no pueda acceder a las variables de la plantilla incluyente).

https://twig.symfony.com/doc/3.x/functions/include.html

## Extends y block

La parte más potente de Twig es la herencia de plantillas.

La herencia de plantillas permite definir una plantilla base que podrán heredar otras plantillas.

La plantilla base definirá bloques NO modificables y bloques que SÍ podrán ser modificados por las plantillas hijas.

Los bloques modificables se definen con la etiqueta **block**.

Con la etiqueta **extends** una plantilla hija extiende de otra y mediante etiquetas block puede reescribir los bloques correspondientes.

La función **parent()**, usada en un bloque de una plantilla hija, incluye el bloque declarado en el padre.

## Configuración de Twig

Lista de todas las opciones de configuración, con sus valores por defecto

> php bin/console config:dump-reference twig

Lista de los actuales valores de configuración

> php bin/console debug:config twig

## El comando lint:twig

https://symfony.com/doc/current/templates.html#linting-twig-templates

## El comando debug:twig

https://symfony.com/doc/current/templates.html#inspecting-twig-information


## Enlaces de interés

https://twig.symfony.com/doc/3.x/templates.html

https://symfony.com/doc/current/templates.html