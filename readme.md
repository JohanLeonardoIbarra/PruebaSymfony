# Api Docs

## Users

- 137.184.205.29/user/ Registro de usuarios ``POST``

Todos los valores son obligatorios, los permisos de manejo de datos personales deben ser `_true_`.

``body``

    "name": "johan",
    "surname": "ibarra",
    "email": "johanleon950@gmail.com",
    "password": "johan1234",
    "address": "Av 1 #20-30",
    "phone": "301 1235678",
    "personalDataPermission": true

``response``

    [204] El usuario fue registrado correctamente, Se envia un correo de bienvenida
    [400] Error en la peticion, se retornan los errores cometidos

---

- 137.184.205.29/user/login Login de usuarios ``POST``

Todos los valores son obligatorios.

``body``

    "email": "johanleon950@gmail.com",
    "password": "johan1234",

``response``

    [204] El usuario se ha logueado correctamente, retorna token de acceso
    [400] Error en la peticion, se retornan los errores cometidos

## Products

- 137.184.205.29/product/ Registro de productos ``POST``

Todos los valores son obligatorios. EL nombre es un valor unico.

``body``

    "name": "Chocoramo",
    "quantity": 20,
    "unitPrice": 2000

``response``

    [200] Nombre cantidad y precio unitario del producto registado
    [400] Error en la peticion, se retornan los errores cometidos

---

- 137.184.205.29/product?limit=`int`&q=`string` Registro de productos ``GET``

Todos los valores son obligatorios. Si no indica el limite retorna 20 productos, si no indica el query retorna todos los productos.

``response``

    [200] Listado de productos
    [400] Error en la peticion, se retornan los errores cometidos

## Orders

- 137.184.205.29/order/ Registro de productos ``POST``

La direccion es obligatoria, se debe asignar como minimo un producto.

``headers``

    token : 809000c6a7294a1bf4b550485ed4ff05

``body``

    "address": "My House #10-20",
    "orderDetails": 
    [
        {
            "product": "633ecb7994c709927207f397",
            "quantity": 1
        },
        {
            "product": "633ec8d094c709927207f396",
            "quantity": 4
        }
    ]

``response``

    [200] Id de la orden registrada, se envia un correo con los detalles de la orden
    [400] Error en la peticion, se retornan los errores cometidos
