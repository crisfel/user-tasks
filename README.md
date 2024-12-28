# Pasos para ejecutar el aplicativo

## Prerequisitos
* PHP 8.2
* MySQL

## Pasos para ejecutar
* Crear base de datos y llamarla
```
alianza_test_db
```
* Cambiar las variables de entorno (.env), añadir variables de entorno para la base de datos, cambiar la variable de entorno APP_URL para que apunte al servidor de ejecución si es en local colocar http://127.0.0.1:8000.

* Ejecutar comando 1:
```
php artisan optimize
```

* Ejecutar comando 2:
```
php artisan confing:clear
```

* Ejecutar comando 3:
```
php artisan migrate:fresh --seed
```

* Ejecutar comando 4:
```
php artisan serve
```
* Una vez ejecutados estos comandos iniciar sesión con las siguientes credenciales:
```
email: administrator@gmail.com
contraseña: 1234
```

