# Repositorios

## Select

Para realizar selects se utilizan los Repository. Hay un Repository asociado a cada Entity.

![Doctrine](./images/select.png)

## Ejemplos

```php
// Buscar por la clave primaria
$fondos = $repository->find(57);

// Argumentos de findBy
findBy($where, $orderBy, $limit, $startAt);

// Argumentos de findOneBy
findBy($where, $orderBy);

// Buscar por un campo
$fondos = $repository->findBy(
    ['titulo' => 'La casa de Bernarda Alba']
);
// o también
$fondos = $repository->findByTitulo('La casa de Bernarda Alba');


// Buscar por dos campos
$fondos = $repository->findBy(
    ['titulo' => 'La casa de Bernarda Alba', 'edicion' => 1997]
);

// Filtrar por 1 campo y ordenar por 1 campo
$fondos = $repository->findBy(
    ['titulo' => 'La casa de Bernarda Alba'], 
    ['edicion' => 'ASC']
);

// Límite de 10 resultados empezando por el registro 0, sin ordenar
$fondos = $repository->findBy(['titulo' => 'La casa de Bernarda Alba'], [], 10, 0);
 
// Recuperar TODOS los fondos
$fondos = $repository->findAll();
```

## Consultas con DQL

DQL es el lenguaje de consultas de Doctrine.

```php
/**
    * @return Product[]
    */
public function findAllGreaterThanPrice(int $price): array
{
    $entityManager = $this->getEntityManager();

    $query = $entityManager->createQuery(
        'SELECT p
        FROM App\Entity\Product p
        WHERE p.price > :price
        ORDER BY p.price ASC'
    )->setParameter('price', $price);

    // returns an array of Product objects
    return $query->getResult();
}
```

https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/dql-doctrine-query-language.html#doctrine-query-language

## Consultas con Query Builder

Query Builder permite ir modificando una consulta sobre la marcha.

```php
public function findAllGreaterThanPrice(int $price, bool $includeUnavailableProducts = false): array
{
    // automatically knows to select Products
    // the "p" is an alias you'll use in the rest of the query
    $qb = $this->createQueryBuilder('p')
        ->where('p.price > :price')
        ->setParameter('price', $price)
        ->orderBy('p.price', 'ASC');

    if (!$includeUnavailableProducts) {
        $qb->andWhere('p.available = TRUE');
    }

    $query = $qb->getQuery();

    return $query->execute();

    // to get just one result:
    // $product = $query->setMaxResults(1)->getOneOrNullResult();
}
```

https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/query-builder.html#the-querybuilder

## Consultas con SQL

```php
public function findAllGreaterThanPrice(int $price): array
{
    $conn = $this->getEntityManager()->getConnection();

    $sql = '
        SELECT * FROM product p
        WHERE p.price > :price
        ORDER BY p.price ASC
        ';
    $stmt = $conn->prepare($sql);
    $result = $stmt->executeQuery(['price' => $price]);

    // returns an array of arrays (i.e. a raw data set)
    return $result->fetchAllAssociative();
}
```



## Enlaces de interés

https://symfony.com/doc/current/doctrine.html
