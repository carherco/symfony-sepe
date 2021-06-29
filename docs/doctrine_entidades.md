# Entidades

## Creación de una entidad

> php bin/console make:entity

## Generación de las SQL necesarias para crear las tablas

> php bin/console make:migration

## Ejecución de las SQL

> php bin/console doctrine:migrations:migrate

## Alternativa a migrations

> php bin/console doctrine:schema:update --force

Este comando compara la base de datos actual con las entidades y ejecuta las sentencias necesarias para que actualizar la base de datos.
