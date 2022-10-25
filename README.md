# TRABAJO PRÁCTICO INTEGRADOR
### Profesora: MARÍA BELÉN ALEGRE

### Alumno:
    Facundo Esteban Palermo
    Legajo: 0112674

### Framework Laravel:
    dependencias: segun composer.json

### Instalación:
~~~
> composer install
~~~

### Ejecución:
~~~
> php artisan serve
~~~

## Endpoints

`tap.test/api/register`

**POST**
~~~
{
    "name": "Juan",
    "email": "juan@mailfalso.com",
    "password": "1234",
    "password_confirmation": "1234",
    "surname": "Falso",
    "dni": 12345678,
    "address": "calle falsa 123",
    "phone": "+54911123456789"
}
~~~
---
`tap.test/api/login`

**POST**
~~~
{
    "email": "juan2@mailfalso.com",
    "password": "1234"
}
~~~
---
`tap.test/api/user-profile` 

**GET**
 *requiere cookie/token*

---
`tap.test/api/logout`

**POST**
*requiere cookie/token*

---
