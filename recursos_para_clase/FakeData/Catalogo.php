<?php

namespace App\FakeData;

class Catalogo 
{
  public static $fondos = [
    [
      'titulo' => 'El sol de Breda',
      'autores' => [
        ['tipo' => 'PERSONA', 'nombre' => 'Pérez-Reverte, Arturo']
      ],
      'isbn' => '84-204-8312-5',
      'editorial' => ['nombre' => 'Alfaguara'],
      'edicion' => 1998,
      'publicacion' => 1998,
      'categoria' => 'novela'
    ],
    [
      'titulo' => 'La biblioteca de la Luna',
      'autores' => [
        ['tipo' => 'PERSONA', 'nombre' => 'Miralles, Francesc']
      ],
      'isbn' => '84-204-8312-5',
      'editorial' => ['nombre' => 'Espasa'],
      'edicion' => 1998,
      'publicacion' => 1998,
      'categoria' => 'novela'
    ],
    [
      'titulo' => 'Papel y tinta',
      'autores' => [
        ['tipo' => 'PERSONA', 'nombre' => 'Reig, Maria']
      ],
      'isbn' => '84-204-8312-5',
      'editorial' => ['nombre' => 'Espasa'],
      'edicion' => 1998,
      'publicacion' => 1998,
      'categoria' => 'novela'
    ],
    [
      'titulo' => 'Guía del autoestopista galáctico',
      'autores' => [
        ['tipo' => 'PERSONA', 'nombre' => 'Adams, Douglas']
      ],
      'isbn' => '84-204-8312-5',
      'editorial' => ['nombre' => 'Anagrama'],
      'edicion' => 1998,
      'publicacion' => 1998,
      'categoria' => 'humor'
    ],
    [
      'titulo' => 'Frankenstein o el moderno Prometeo',
      'autores' => [
        ['tipo' => 'PERSONA', 'nombre' => 'Shelley, Mary']
      ],
      'isbn' => '84-204-8312-5',
      'editorial' => ['nombre' => 'Anagrama'],
      'edicion' => 1818,
      'publicacion' => 1818,
      'categorias' => 'ficcion'
    ]
  ];
}