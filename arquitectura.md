\# Arquitectura del Sistema Web del Taller de Confección Municipal de Pirapó



\## 1. Descripción general



El sistema web del Taller de Confección Municipal de Pirapó se desarrolla como un prototipo orientado a apoyar la gestión administrativa mediante la centralización de la información y el control de los principales procesos del taller.



El sistema permite gestionar información relacionada con personas, gestión académica, inventario, compras, ventas, pagos, deudas, finanzas y reportes.



La aplicación se desarrolla utilizando el patrón de arquitectura \*\*Modelo-Vista-Controlador (MVC)\*\* mediante el framework \*\*CodeIgniter 4\*\*.



\## 2. Arquitectura MVC



El sistema utiliza una arquitectura Modelo-Vista-Controlador, que separa las responsabilidades principales de la aplicación:



\### Modelo



Los modelos se encargan de la comunicación con la base de datos y del manejo de la información correspondiente a cada entidad del sistema.



Entre los modelos desarrollados se encuentran:



\* PersonaModel

\* UsuarioModel

\* RolModel

\* PersonaRolModel

\* CursoModel

\* InscripcionModel

\* MensualidadModel

\* PagoMensualidadModel

\* CategoriaProductoModel

\* ProductoModel

\* MovimientoInventarioModel



Los modelos permiten realizar operaciones de consulta, registro, modificación y eliminación de información según las necesidades de cada módulo.



\### Vista



Las vistas corresponden a las interfaces que permiten al usuario interactuar con el sistema.



Actualmente se cuenta con vistas relacionadas con:



\* Inicio de sesión.

\* Panel principal.

\* Personas.

\* Cursos.

\* Inventario.

\* Mensualidades.

\* Pagos.

\* Movimientos de inventario.



Las vistas se encuentran principalmente dentro del directorio `app/Views`.



\### Controlador



Los controladores reciben las solicitudes realizadas desde las interfaces, procesan la lógica correspondiente y coordinan la comunicación entre los modelos y las vistas.



Entre los controladores desarrollados se encuentran:



\* Login

\* Dashboard

\* Personas

\* Cursos

\* Inventario

\* Mensualidades



Los controladores se encuentran dentro del directorio `app/Controllers`.



\## 3. Estructura principal del proyecto



La estructura principal del sistema se organiza de la siguiente manera:



```text

sistema-taller-pirapo/

│

├── app/

│   ├── Config/

│   ├── Controllers/

│   ├── Database/

│   ├── Filters/

│   ├── Models/

│   ├── Views/

│   └── ...

│

├── public/

│   ├── index.php

│   └── ...

│

├── tests/

│

├── writable/

│

├── composer.json

├── composer.lock

├── env

├── README.md

├── arquitectura.md

└── spark

```



\## 4. Comunicación entre componentes



El funcionamiento general del sistema sigue el siguiente flujo:



1\. El usuario accede al sistema mediante un navegador web.

2\. La solicitud llega a CodeIgniter 4.

3\. El controlador correspondiente recibe y procesa la solicitud.

4\. El controlador utiliza el modelo cuando necesita consultar o modificar información.

5\. El modelo se comunica con la base de datos.

6\. Los datos obtenidos son enviados nuevamente al controlador.

7\. El controlador selecciona la vista correspondiente.

8\. La vista presenta la información al usuario.



De esta manera, la interfaz, la lógica de procesamiento y el acceso a los datos permanecen separados.



\## 5. Persistencia de datos



La persistencia del sistema se realiza mediante una base de datos relacional \*\*MySQL/MariaDB\*\*.



La base de datos almacena información relacionada con:



\* Usuarios.

\* Personas.

\* Roles.

\* Cursos.

\* Inscripciones.

\* Mensualidades.

\* Pagos.

\* Categorías de productos.

\* Productos.

\* Movimientos de inventario.

\* Compras.

\* Ventas.

\* Cuentas por cobrar.

\* Pagos de cuentas.

\* Aportes municipales.

\* Gastos.



Las relaciones entre las entidades permiten mantener la integridad y consistencia de la información utilizada por los diferentes módulos.



\## 6. Tecnologías utilizadas



El desarrollo del sistema utiliza las siguientes tecnologías y herramientas:



\* \*\*PHP:\*\* lenguaje utilizado para la lógica del sistema.

\* \*\*CodeIgniter 4:\*\* framework utilizado para implementar la arquitectura MVC.

\* \*\*MySQL/MariaDB:\*\* sistema de gestión de base de datos relacional.

\* \*\*HTML5:\*\* estructura de las interfaces.

\* \*\*CSS3:\*\* estilos y presentación.

\* \*\*JavaScript:\*\* interactividad y validaciones.

\* \*\*Bootstrap 5:\*\* diseño y adaptación de las interfaces.

\* \*\*Font Awesome:\*\* iconografía.

\* \*\*XAMPP:\*\* entorno de servidor local.

\* \*\*Visual Studio Code:\*\* entorno de desarrollo.

\* \*\*MySQL Workbench:\*\* modelado y administración de la base de datos.

\* \*\*Git y GitHub:\*\* control de versiones y almacenamiento del código fuente.



\## 7. Seguridad y acceso



El sistema incorpora un módulo de inicio de sesión para controlar el acceso al sistema.



El usuario debe proporcionar sus credenciales para acceder a las funcionalidades administrativas disponibles.



La separación entre las diferentes capas de la arquitectura también permite organizar de forma adecuada la lógica de acceso a los datos y la presentación de la información.



\## 8. Entorno de ejecución



Durante el desarrollo, el sistema se ejecuta de manera local utilizando XAMPP como entorno de servidor.



El proyecto puede iniciarse mediante el servidor de desarrollo proporcionado por CodeIgniter 4 y accederse desde un navegador web.



La aplicación utiliza PHP como lenguaje de programación y MySQL/MariaDB para la persistencia de los datos.



\## 9. Control de versiones



El código fuente del proyecto se administra mediante \*\*Git\*\* y se almacena en un repositorio público de \*\*GitHub\*\*.



Los cambios realizados durante el desarrollo se registran mediante commits, permitiendo mantener un historial de las modificaciones realizadas en el proyecto.



El repositorio contiene el código fuente, documentación y archivos necesarios para identificar la estructura del prototipo.



