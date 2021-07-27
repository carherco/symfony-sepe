# Commands

Para ver una lista de todos los comandos, basta con ejecutar simplemente bin/console o bin/console list

> bin/console list

El comando help seguido de un nombre de comando, nos proporciona la ayuda de dicho comando.

> bin/console help list

El último de los comandos genéricos de la consola es about, que nos da información sobre el proyecto actual

> bin/console about

## Entorno de ejecución

Por defecto, los comandos de consola se ejecutan en el entorno definido en la variable de entorno APP_ENV.

Con los modificadores --env y --no-debug podemos modificar el comportamiento por defecto

```sh
 bin/console comando


 bin/console comando --env=prod


 bin/console comando --env=test --no-debug
 ```

## Creación de comandos personalizados

Symfony permite crear comandos que se pueden lanzar desde la consola con bin/console.

Para definir un comando, hay que crear una clase que extienda de **Command**.

Esta clase debe definir al menos dos métodos: **configure()** y **execute()**.

Se pueden crear a mano o con el maker:

> php bin/console make:command ejemplo:prueba

```php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DemoArgsCommand extends Command
{
    protected function configure()
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
       // ...
    }
}
```

## Configuración del comando

La configuración del comando se realiza dentro del método **execute()**.

```php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DemoArgsCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('demo:args')
            ->setDescription('Describe args behaviors')
            ->setDefinition(
                new InputDefinition(array(
                    new InputOption('foo', 'f'),
                    new InputOption('bar', 'b', InputOption::VALUE_REQUIRED),
                    new InputOption('cat', 'c', InputOption::VALUE_OPTIONAL),
                ))
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
       // ...
    }
}
```

La clase *Command* tiene disponibles varios métodos de configuración:

- setName()
- setDescription()
- setHelp()
- setDefinition()
- addArgument()
- addOption()

```php
$this
        // El nombre del comando (la parte que va después de "bin/console")
        ->setName('demo:args')

        // El texto mostrado cuando se ejecuta "bin/console list"
        ->setDescription('Es un comando de prueba')

        // El texto mostrado cuando se ejecuta el comando con la opción --help
        ->setHelp('Este comando te permite ...')
    ;
```

### OPCIONES

Hay que distinguir entre opciones (InputOption) y argumentos (InputArgument), aunque luego comunmente se mezclan los conceptos 

Dentro del método **configure()**, las opciones se definen como se ve en el ejemplo anterior, dentro del **setDefinition()** o también como se ve en el siguiente ejemplo, mediante el método **addOption()**:

```php
$this
    // ...
    ->addOption(
        'iterations',
        'i',
        InputOption::VALUE_REQUIRED,
        'How many times should the message be printed?',
        1
    );
```

El primer parámetro es el nombre de la opción, el segundo es el nombre abreviado de la opción (puede ser null si no queremos forma abreviada), el tercero es el tipo de opción, el cuarto es el texto de ayuda sobre la opción y el quinto es el valor por defecto.

Únicamente el primer parámetro es obligatorio.

Al utilizar el comando, se especifican con **--opcion** o **-o** siendo *opcion* el nombre de la opcion y *o* el nombre abreviado de la opcion. 

Las siguientes 6 formas de uso son equivalentes:

> bin/console demo:args --iterations=5

> bin/console demo:args --iterations 5

> bin/console demo:args --iterations5

> bin/console demo:args -i=5

> bin/console demo:args -i 5

> bin/console demo:args -i5


#### InputOption::VALUE_NONE

La opción *foo* puede existir o no existir, pero no se le puede pasar ningún valor. Si existe, su valor será *true*. Si no existe, su valor será *false*. El el tipo de opción por defecto si no se indica ningún tipo.

> demo:args 

> demo:args --foo

> demo:args -f


#### InputOption::VALUE_REQUIRED


La opción *bar* necesita un valor obligatorio, por lo tanto, las tres ejecuciones anteriores darían error. El valor del argumento será el que le pasemos:

> demo:args --bar=Hello

> demo:args --bar Hello

> demo:args -b=Hello

> demo:args -b Hello


#### InputOption::VALUE_OPTIONAL

La opción *cat* puede exisitir o no existir. Pero en caso de existir se le debe pasar un valor.

Si existe y no se le pasa ningún valor, su valor acabará siendo *null*, lo mismo que si no hubiera existido.

#### InputOption::VALUE_IS_ARRAY

Esta opción acepta múltiples valores

> demo:args --dir=/src --dir=/templates

Se puede combinar VALUE_IS_ARRAY con VALUE_REQUIRED o con VALUE_OPTIONAL:

```php
$this
    // ...
    ->addOption(
        'colors',
        null,
        InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
        'Which colors do you like?',
        array('blue', 'red')
    );
```

### ARGUMENTOS

Los argumentos son strings separados por espacios. Se asignar por orden de declaración.

Se pueden definir como las opciones o bien mediante el método **setDefinition()** o bien mediante el método **addArgument()**.

La definición adminte hasta tres parámetros: el nombre del argumento, el tipo de argumento y el texto de ayuda sobre el argumento.

Únicamente el primer parámetro es obligatorio en la definición de un argumento.

```php
// ...

new InputDefinition(array(
    // ...
    new InputArgument('arg1', InputArgument::REQUIRED),
    new InputArgument('arg2', InputArgument::IS_ARRAY),
));
```

#### InputArgument::OPTIONAL

El argumento es opcional. Es el comportamiento por defecto si no se indica el tipo de argumento.

#### InputArgument::REQUIRED

El comando no funciona si no se le pasa ningún valor a todos los argumentos obligatorios

#### InputArgument::IS_ARRAY

El argumento puede contener cualquier número de valores. Por esta razón, un argumento de este tipo debe de ser el último de la lista de argumentos.

### Utilizando opciones y argumentos

Las siguientes dos ejecuciones del comando demo:args son equivalentes

> demo:args World --bar Hello

> demo:args --bar Hello World

En caso de necesidad, se puede utilizar el símbolo *--* para separar los argumentos de las opciones

> demo:args --bar Hello --cat -- World

En este último ejemplo, la opción *cat* valdrá *null* y *World* será el valor del argumento.

## Ciclo de vida de un comando

Los comandos tienen 3 métodos que son invocados durante su ejecución:

- initialize()

Se ejecuta antes de interact() y de execute(). El propósito de este método es inicializar variables que necesiten el resto de métodos.

- interact()

Este método se ejecuta después de initialize() y antes de execute(). El propósito es comprobar si falta alguna de las opciones y/o argumentos y preguntarlas al usuario de forma interactiva. Después de este método si faltan argumentos u opciones obligatorias se producirá un error.

- execute()

Es el último en ejecutarse. Contiene la lógica del comando.

```php
<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ExampleCommand extends Command
{
    // Nombre del comando
    protected static $defaultName = 'ejemplo:prueba';
    // Descripción corta que se muestra en "php bin/console list"
    protected static $defaultDescription = 'Add a short description';

    protected function configure(): void
    {
        $this
            // Otra forma de poner el nombre
            ->setName('ejemplo:prueba')
            // Otra forma de poner la descripción corta "php bin/console list"
            ->setDescription('Add a short description from config')

            // Texto de ayuda que aparece si se ejecuta el comando con la opción "--help"
            ->setHelp('This command allows you to ...')

            // Argumentos: sin nombre y separados por espacios en blanco
            ->addArgument('origin', InputArgument::REQUIRED, 'Origen')
            ->addArgument('destination', InputArgument::REQUIRED, 'Destino')
            
            // Opciones: esta sería o bien --con-escalas o con su alias -o
            ->addOption('only-direct-flights', 'odf', InputOption::VALUE_NONE, 'Si se restringe a vuelos sin escalas')
        ;
    }

    /**
     * (opcional)
     */
    protected function initialize(InputInterface $input, OutputInterface $output) {}

    /**
     * (opcional)
     */
    protected function interact(InputInterface $input, OutputInterface $output) {}

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $origin = $input->getArgument('origin');
        $destination = $input->getArgument('destination');
        $onlyDirectFlights = $input->getOption('only-direct-flights');

        $io->note(sprintf('Buscar vuelos con origen %s y destino %s', $origin, $destination));

        if($onlyDirectFlights) {
            $io->note('Se deben descartar los vuelos con escalas');
        }

        // Aquí hacer la búsqueda y presentar los resultados

        $io->success('Comando terminado con éxito');

        return Command::SUCCESS;
    }
}
```

Para lanzar el comando anterior sería

> php bin/console ejemplo:prueba MAL MAD --only-direct-flights

## Input y optput

Además contamos con los objetos **InputInterface $input** (equivalente al Request de los controladores) y **OutputInterface $output** (equivalente al Response de los controladores) para, respectivamente, leer los datos que hayan llegado a través de la terminal y para mostrar información a los usuarios en la terminal.

## Helpers

También contamos con varios helpers:

- [Question Helper](https://symfony.com/doc/current/components/console/helpers/questionhelper.html)

    Para pedir información al usuario de forma interactiva

- [Formatter Helper](https://symfony.com/doc/current/components/console/helpers/formatterhelper.html)

    Para personalizar el formato (principalmente colores) de la salida

- [Progress Bar](https://symfony.com/doc/current/components/console/helpers/progressbar.html)

    Para mostrar una barra de progreso que podemos ir actualizando

- [Table](https://symfony.com/doc/current/components/console/helpers/table.html)

    Para mostrar información en una tabla

- [Debug Formatter Helper](https://symfony.com/doc/current/components/console/helpers/debug_formatter.html)

    Para mostrar información que solamente es relevante si el comando se lanza con nivel de verbosity debug (-vvv)

- [Cursor Helper](https://symfony.com/doc/current/components/console/helpers/cursor.html)

    Para poder cambiar la posición del cursor en la consola.

## Verbosity

```sh
# Sin mensajes. OutputInterface::VERBOSITY_QUIET
 php bin/console ejemplo:prueba MAL MAD -q
 php bin/console ejemplo:prueba MAL MAD --quiet

# Comportamiento normal. OutputInterface::VERBOSITY_NORMAL
 php bin/console ejemplo:prueba MAL MAD

# OutputInterface::VERBOSITY_VERBOSE
 php bin/console ejemplo:prueba MAL MAD -v

# OutputInterface::VERBOSITY_VERY_VERBOSE
 php bin/console ejemplo:prueba MAL MAD -vv

# OutputInterface::VERBOSITY_DEBUG
 php bin/console ejemplo:prueba MAL MAD -vvv
```

## Inyección de dependencias

En los constructores de los comandos podemos inyectar servicios, con lo que desde un comando podemos hacer cualquier cosa que ya tengamos programada en los servicios del proyecto.
