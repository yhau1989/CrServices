# CrServices
Recycling plant Services


## Methods

### Usuarios

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


### Materiales

#### List Materiales: http://localhost/CrServices/api/mtr/mtrlist.php

No tiene Parametros de entrada:

Parametros de Salida:
```javascript
{
    "error": 0,
    "mensaje": null,
    "data": [
        {
            "id": "1",
            "tipo": "Plastico Soplado"
        },
        {
            "id": "2",
            "tipo": "Plastico Hogar"
        },
        {
            "id": "3",
            "tipo": "Plastico Silla"
        },
        {
            "id": "4",
            "tipo": "Metal (Hierro)"
        },
        {
            "id": "5",
            "tipo": "Metal (Aluminio)"
        },
        {
            "id": "6",
            "tipo": "Metal (Cobre)"
        },
        {
            "id": "7",
            "tipo": "Papel"
        }
    ]
}

```

#### Add Materiales: http://localhost/CrServices/api/mtr/mtradd.php

Parametros de entrada:
```javascript
{
    "mtr":{
        "tipo": "tipo de material"
    }
}
```

Parametros de Salida:
```javascript
{
    "error": 0,
    "mensaje": "Datos grabados con éxito..!!",
    "data": null
}
```


#### Edit Materiales: http://localhost/CrServices/api/mtr/mtredit.php

Parametros de entrada:
```javascript
{
    "mtr":{
        "id" : 8,
        "tipo": "carton2"
    }
}
```

Parametros de Salida:
```javascript
{
    "error": 0,
    "mensaje": "Datos grabados con éxito..!!",
    "data": null
}
```


### Clientes


#### List Clientes: http://localhost/CrServices/api/cli/clientlist.php

No hay Parametros de entrada:


Parametros de Salida:
```javascript
{
    "error": 0,
    "mensaje": null,
    "data": [
        {
            "id": "1",
            "ruc": "0926327917002",
            "nombres": "Emaulme",
            "apellidos": "Tanhis",
            "direccion": "Garzota 2 calle principa #2",
            "telefono": "xxx"
        }
    ]
}
```


#### Add Clientes: http://localhost/CrServices/api/cli/clientadd.php

Parametros de entrada:
```javascript
{
    "cliente":{
        "ruc": "99999999999", 
        "nombres": "Emaulme", 
        "apellidos": "Tanhis", 
        "direccion": "Garzota 2 calle principa #2", 
        "telefono": "xxx"
    }
}
```

Parametros de Salida:
```javascript
{
    "error": 0,
    "mensaje": "Datos grabados con éxito..!!",
    "data": null
}
```


#### Edit Clientes: http://localhost/CrServices/api/cli/clientedit.php

Parametros de entrada:
```javascript
{
    "cliente":{
        "id":1,
        "ruc": "0926327917002", 
        "nombres": "Emaulme", 
        "apellidos": "Tanhis", 
        "direccion": "Garzota 2 calle principa #2", 
        "telefono": "0959556489"
    }
}
```

Parametros de Salida:
```javascript
{
    "error": 0,
    "mensaje": "Datos grabados con éxito..!!",
    "data": null
}
```


### Proveedores



#### List Proveedores: http://localhost/CrServices/api/prov/proveelist.php

No tiene Parametros de entrada:

Parametros de Salida:
```javascript
{
    "error": 0,
    "mensaje": null,
    "data": [
        {
            "id": "1",
            "ruc": "0926327917005",
            "nombres": "Kiara",
            "apellidos": "Reyna Torres",
            "direccion": "Garzota 2 calle principa #2",
            "telefono": "0959556489"
        }
    ]
}
```


#### Add Proveedores: http://localhost/CrServices/api/prov/proveeadd.php

Parametros de entrada:
```javascript
{
    "proveedor":{
        "ruc": "0926327917005", 
        "nombres": "Kiara", 
        "apellidos": "Reyna", 
        "direccion": "Garzota 2 calle principa #2", 
        "telefono": "0959556489"
    }
}
```

Parametros de Salida:
```javascript
{
    "error": 0,
    "mensaje": "Datos grabados con éxito..!!",
    "data": null
}
```

#### Edit Proveedores: http://localhost/CrServices/api/prov/proveeedit.php

Parametros de entrada:
```javascript
{
    "proveedor":{
        "id":1 ,
        "ruc": "0926327917005", 
        "nombres": "Kiara", 
        "apellidos": "Reyna Torres", 
        "direccion": "Garzota 2 calle principa #2", 
        "telefono": "0959556489"
    }
}
```

Parametros de Salida:
```javascript
{
    "error": 0,
    "mensaje": "Datos grabados con éxito..!!",
    "data": null
}
```