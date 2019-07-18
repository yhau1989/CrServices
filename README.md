# CrServices
Recycling plant Services


## Methods

### User

#### Insertar usuario: http://localhost/CrServices/api/usr/usradd.php

Parametros de entrada:
```javascript
{
    "user":
    {
        "nombres": "Orlando",  //campo obligatotio 
        "apellidos": "Wong",  //campo obligatotio 
        "email": "dirección de correo",  //campo obligatotio 
        "password": "xxx", //campo obligatotio 
        "estado": 3 //campo obligatotio 
    }
}
```

Parametros de Salida:
```javascript
{
    "error": 0,
    "mensaje": "Datos grabados con éxito..!!",
    "data": "8"
}
```


#### Editar usuario: http://localhost/CrServices/api/usr/usredit.php

Parametros de entrada:
```javascript
// Solo enviar los campos que desee editar
{
    "user":
    {
        "id": 8, //campo obligatotio 
        "nombres": "Orlando",  //campo obligatotio 
        "apellidos": "Wong",  //campo obligatotio 
        "email": "dirección de correo",  //campo obligatotio 
        "password": "xxxx", //campo obligatotio 
        "estado": 3 //campo obligatotio 
    }
}
```

Parametros de Salida:
```javascript
{
    "error": 0,
    "mensaje": "Datos grabados con éxito..!!",
    "data": "8"
}
```


#### Login usuario: http://localhost/CrServices/api/usr/usrlogin.php

Parametros de entrada:
```javascript
// Solo enviar los campos que desee editar
{
    "login":{
        "user": "dirección de correo", //campo obligatotio 
        "password":"xxx" //campo obligatotio 
    }
}
```

Parametros de Salida:
```javascript
{
    "error": 0,
    "mensaje": "ok",
    "data": null
}
```



#### Reset password usuario: http://localhost/CrServices/api/usr/usrpwsreset.php

Parametros de entrada:
```javascript
// Solo enviar los campos que desee editar
{
    "reset":{
        "email": "xxxx" //campo obligatotio 
    }
}
```

Parametros de Salida:
```javascript
{
    "error": 0,
    "mensaje": null,
    "data": "http://localhost/crsite/tmp/rst/09d547c0d8fa35c3a845c6a5aa19935f"
}
```
