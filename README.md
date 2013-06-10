is2
===
**Ingeniera de software 2 - Proyecto**

Configuración
============
Para andar el proyecto se necesita tener los servicios **PHP**, **MySQL** y **Apache** funcionando. Yo recomiendo [WampServer](http://sourceforge.net/projects/wampserver/?source=directory)

**WampServer** va a aparecer al lado del reloj de Window su iconito, donde desde ahi le vamos a meter mano para hacer andar la aplicación.

httpd.conf
-------------
Hay que congiurar el archivo `httpd.conf` de la aplicación Apache, este se abre desde el icono del WampServer haciendole click izquierdo, opcion `Apache` -> `httpd.conf`

Ubicar esta línea (yo la tengo en la linea numero **116**)

`#LoadModule rewrite_module modules/mod_rewrite.so`

Solo hay que quitarle el numeral al principio de la línea, nada mas que eso.

Siguiente, ubicar la linea ( **178** )

`DocumentRoot "c:\wamp\bla..."`

Aca lo que hay que hacer es poner como direccion donde va a estar ubicado los archivos que hacen la aplicacion, es decir, todo este repositorio.

Y tambien hay que hacer lo mismo con esta linea ( **205** )

`<Directory "c:\wamp\bla...">`

MySQL credenciales
-------------------------
Corran el archivo `mysql.credenciales.bat`, este les creara un archivo llamdo `mysql.ini` necesario para que PHP pueda acceder a la base de datos, si estan usando WampServer, las credenciales que deben usar son:

1. usuario: `root`
2. clave: ` ` (nada)
	
Creando la base de datos y sus tablas
------------------------------------------------
Para crear la base de datos que usara la aplicacion con sus respectivas tablas tiene que correr el siguiente comando desde la consola

`mysql --local-infile -u %usuario% -p%clave% < _init_db.sql`

**ES PROBABLE QUE EL COMANDO mysql NO SEA RECONOCIDO**
Para este caso y si estan con WampServer, mysql esta (en mi caso) aca
	`C:\wamp\bin\mysql\mysql5.5.8\bin\mysql` 

* Tiene que reemplazar el `%usuario%` y `%clave%` por los datos de usuario y contraseña que se usan para acceder a la base de datos, por ejemplo **root** como usuario y si **no hay password** omitan el `-p`
* Sepan que deben estar ubicado desde la consola en la carpeta donde esta el archivo `_init_db.sql`

Por ejemplo le quedaria algo como esto:

`mysql --local-infile -u root -p123456 < _init_db.sql`

*Listo ya estamos!*

Pongan desde su navegador la direccion `localhost` ó `127.0.0.1`, van a tener que ver la pantalla de login de la aplicacion.

Los usuarios son dos:

1. root
2. admin
	
Para ambos sus password son **123456**

DEBUG
======
Para debuggear la aplicacion tienen que:

1. Usar Firefox
2. Tenerle instalado el plugin [FireBug](https://addons.mozilla.org/es/firefox/addon/firebug/)
3. Tener instalado el addon para FireBug, [FirePHP](https://addons.mozilla.org/en-US/firefox/addon/firephp/)
3. Listo

Para tirarle mensajes a FirePHP y que estos se vean en la consola de FireBug, deben llamar a la funcion `__log` en donde mas lo quieran en su codigo PHP.
