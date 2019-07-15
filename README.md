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
        "email": "thewong26@hotmail.com",  //campo obligatotio 
        "password": "samo562966", //campo obligatotio 
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
        "nombres": "Orlando", 
        "apellidos": "Wong", 
        "email": "thewong26@hotmail.com", 
        "password": "samo562966",
        "estado": 3
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
