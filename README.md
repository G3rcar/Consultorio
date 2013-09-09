#Consultorio Médico Cerna y Alvarado

###Proyecto de ASI 2 <br>
**UFG** <br>
El Salvador



##Descripción de la estructura

* **bd.sql**				  Script de la Base de Datos provisional
 <br>
* **encabezado.php**	Contiene el HTML que se necesita para el encabezado, el menú y los archivos css que se usan <br>
* **piepagina.php**		Contiene el HTML del cierre de la pagina <br>
* **pestanas.php**		Contiene el menú botones-pestanas-tabs o lo que vayan a ser al final <br>
* **logout.php**			Script que elimina la sesión activa, usado para cerrar sesión <br>
* **sesion.php**			Script que verifica si el usuario se ha logueado <br>
 <br>
* **index.php**			  Ejemplo de la primera página, contiene la estructura base de "includes" para copiar en los siguientes scripts <br>
* **login.php**			  Frontend para iniciar sesión, tiene la interfaz del login <br>
* **login_store.php**	Backend para iniciar sesión, tiene el proceso de verificación del usuario <br>
 <br>
 <br>
* **libs/js/**  			Contiene las librerías javascript que usaremos <br>
* **libs/php/**			  Contiene archivos PHP importantes, como la conexión y las constantes (por el momento) <br>
* **res/**				    Contiene los recursos CSS e imagenes para el sitio <br>


##Además

* El archivo bd.sql permite montar la BD provisional para que funcione el login, no hay nada más aún <br>
* Para que funcione en otra máquina, es necesario configurar el usuario local, el password y el nombre de la BD en el archivo class.connection.php <br>
* Es recomendable no cambiarle nombre a la BD y mantener los usuarios que aparecen actualmente para que no le de problemas a nadie más <br>