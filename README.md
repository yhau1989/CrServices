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


#### Editar usuario

