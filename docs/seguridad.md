# Seguridad

## Autenticación vs. autorización

En el proceso de autenticación la aplicación intenta identificar al usuario (saber quién es).

En el proceso de autorización la aplicación decide si el usuario una vez identificado tiene permiso para entrar a una página concreta, solicitar un recurso concreto, realizar una operación concreta… y si no tiene permiso, le deniega el acceso.

Un error en la autenticación (en el login) se debe responder con un 401 Unauthorized.

Un error de autorización se debe responder con un 403 Forbidden.

## El comando make:user

El comando make:user nos asiste en la creación de una entidad que gestione los usuarios de nuestra aplicación.

> php bin/console make:user


Los roles deben empezar por “ROLE_”, excepto los roles especiales de symfony.

Todos los usuarios deben tener el rol ROLE_USER.

Incluiremos un campo “token” de tipo string para almacenar los tokens de acceso y un campo token_expiration de tipo datetime para definir la validez del token.

## El comando security:encode-password

El comando security:encode-password nos asiste a la hora de dar de alta manualmente usuarios en la base de datos, ya que le pasamos una contraseña y nos la devuelve encriptada.

> php bin/console security:encode-password mypassword

## El comando make:auth

El comando make:auth nos permite crear y configurar un método de autenticación.

> php bin/console make:auth

## Control de acceso

```yml
# config/packages/security.yaml
security:
    # ...

    access_control:
        
        - { path: '^/admin', roles: ROLE_ADMIN }

        # ROLE_ADMIN or IS_AUTHENTICATED_FULLY
        - { path: '^/admin', roles: [IS_AUTHENTICATED_FULLY, ROLE_ADMIN] }


        - { path: ‘^/login', roles: IS_AUTHENTICATED_ANONYMOUSLY }
```

https://symfony.com/doc/current/security.html


## Roles 

Los nombres de los roles en Symfony empiezan con el prefijo ROLE_

### Roles especiales

IS_AUTHENTICATED_REMEMBERED: Cualquier usuario logueado tiene este “rol”, incluso si están logueados por una “remember me cookie”. Aunque no uses la funcionalidad “remember me”, puedes usar este rol para saber si el usuario está logueado.

IS_AUTHENTICATED_FULLY: Los usuarios logueados por una  “remember me cookie” tienen IS_AUTHENTICATED_REMEMBERED pero no tienen  IS_AUTHENTICATED_FULLY.

IS_AUTHENTICATED_ANONYMOUSLY: TODOS tiene este rol, aunque no estén logueados.

IS_ANONYMOUS: Solamente los anónimos.

IS_REMEMBERED: Solamente los autenticados con una remember me cookie.

IS_IMPERSONATOR: Cuando el usuario actual está impersonando (suplantando) a otro usuario.

## Login para API JSON

Para hacer un login para una api hay que:

1) Configurar el security.yaml

```yml
# config/packages/security.yaml
security:
    # ...

    firewalls:
        main:
            anonymous: true
            lazy: true
            json_login:
                check_path: /login
```

https://symfony.com/doc/current/security/json_login_setup.html

2) Crear la ruta /login con su Action:

```php
namespace App\Controller;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(Request $request)
    {
        $user = $this->getUser();

        return $this->json([
            'username' => $user->getUsername(),
            'token’ => ‘vp8395f4h39gp9w37wh94g7hg3gonjs8ro8’
        ]);
    }
}
```

### Generación de un token temporal

Para generar tokens criptográficamente seguros a partir de php 7.0 se recomienda la función random_bytes indicando la longitud del token.

Para evitar bytes que se lleven mal con las urls de http, se recomienda combianarlo con una función de hash (sha1 o md5).

$random = sha1(random_bytes(12));

### JSON Web Token (JWT)

https://jwt.io

Para trabajar con JWT nos instalaremos el bundle LexikJWTAuthenticationBundle

https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md

#### Envío del token

```js
const userToken = .....;
const object: { 
    method: 'GET’, 
    headers: { 
        'Accept': 'application/json’,
        'Content-Type': 'application/json’, 
        'Authorization': 'Bearer ' + userToken, 
    } 
};

fetch(‘endpoint_url’, object)
    .then((response) => response.json())
    .then((responseData) => { console.log(responseData); });
```



## Enlaces de interés

- https://symfony.com/doc/current/security.html

- https://symfony.com/doc/current/security/json_login_setup.html
