Twig
====

Output escaping
---------------

Para evitar ataques Cross Site Scripting (XSS) y/o para evitar roturas del código html, twig tiene activado por defecto el output escaping.

Veamos un ejemplo clásico:

Dado el siguiente twig

```html
Hello {{ name }}
```

si el usuario introduce el siguiente texto para su nombre

```html
<script>alert('hello!')</script>
```

Si no hubiera output escaping, el resultado renderizado sería el siguiente

```html
Hello <script>alert('hello!')</script>
```

Es decir, el usuario habría conseguido ejecutar código javascript en nuestra aplicación.

Sin embargo, con output escaping, el renderizado sería el siguiente

```html
Hello &lt;script&gt;alert(&#39;hello!&#39;)&lt;/script&gt;
```


NOTA: Si utilizas sistema de plantillas PHP entonces el output escaping NO es automático.


Deshabilitar el output escaping
-------------------------------

Si quieres deshabilitar el output escaping en una variable concreta, basta con aplicarle el filtro *raw*.

```html
Hello {{ name | raw }}
```


