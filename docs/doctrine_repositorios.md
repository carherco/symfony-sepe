# Repositorios

## Select

Para realizar selects se utilizan los Repository. Hay un Repository asociado a cada Entity.

![Doctrine](./images/select.png)

Algunos métodos de los objetos respository son:

![Doctrine](./images/repository_methods.png)

## Ejemplos

```php
// look for a single Product by its primary key (usually "id")
$product = $repository->find($id);

// look for a single Product by name
$product = $repository->findOneBy(['name' => 'Keyboard']);
// or find by name and price
$product = $repository->findOneBy([
    'name' => 'Keyboard',
    'price' => 1999,
]);

// look for multiple Product objects matching the name, ordered by price
$products = $repository->findBy(
    ['name' => 'Keyboard'],
    ['price' => 'ASC']
);

// look for *all* Product objects
$products = $repository->findAll();


## Enlaces de interés

https://symfony.com/doc/current/doctrine.html
