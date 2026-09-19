# Sistema Web del Taller de Confección Municipal de Pirapó

## Descripción del proyecto

El presente proyecto consiste en el desarrollo de un prototipo de sistema web para apoyar la gestión administrativa del Taller de Confección Municipal de Pirapó.

El sistema busca centralizar la información administrativa y facilitar el control de inventarios, compras, ventas, pagos y deudas.

## Objetivo general

Desarrollar un prototipo de sistema web para apoyar la gestión administrativa del Taller de Confección Municipal de Pirapó, mediante la centralización de información y el control de inventarios, pagos y deudas.

## Problemática

Actualmente, parte de la información administrativa puede encontrarse registrada en cuadernos, anotaciones informales o documentos separados.

Esta situación puede dificultar:

- El control exacto del inventario.
- El control de las mensualidades de las alumnas.
- La consulta de las cantidades disponibles.
- El registro de compras y ventas.
- El seguimiento de pagos.
- El control de deudas.
- La organización de la información administrativa.

Por este motivo, se propone desarrollar un prototipo de sistema web que permita centralizar y consultar la información de manera más organizada.

## Módulos del sistema

El sistema está compuesto por los siguientes módulos:

1. Inicio de sesión.
2. Dashboard principal.
3. Gestión de personas.
4. Gestión de mensualidades por parte de las alumnas.
5. Inventario.
6. Compras.
7. Ventas.
8. Pagos y deudas.
9. Finanzas.
10. Reportes.

## Descripción de los módulos

### 1. Inicio de sesión

Permite el acceso de la encargada del taller mediante un usuario y una contraseña.

### 2. Dashboard principal

Muestra un resumen de la información administrativa del sistema, como:

- Cantidad de alumnas activas.
- Deudas pendientes.
- Mensualidades.
- Estado de la caja.
- Valor del inventario.
- Resultado del período.

### 3. Gestión de personas

Permite registrar y administrar los datos de:

- Alumnas.
- Clientes (Me refiero a clientes externos).

### 4. Gestión académica

Permite administrar información relacionada con:

- Cursos.
- Inscripciones.
- Estados académicos.
- Alumnas activas.
- Alumnas que finalizaron.
- Alumnas que abandonaron.

### 5. Inventario

Permite registrar y controlar:

- Telas.
- Hilos.
- Agujas.
- Tijeras.
- Cierres.
- Reglas.
- Cintas métricas.
- Otros materiales.

También permite controlar las cantidades disponibles y los movimientos de inventario.

### 6. Compras

Permite registrar las compras de materiales y productos utilizados por el taller.

### 7. Ventas

Permite registrar las ventas de materiales y productos a alumnas y clientes externos.

### 8. Pagos y deudas

Permite controlar:

- Mensualidades.
- Pagos realizados.
- Pagos parciales.
- Deudas pendientes.
- Cuentas por cobrar.

### 9. Finanzas

Permite consultar:

- Ingresos.
- Egresos.
- Caja.
- Gastos.
- Aportes municipales.
- Resultado del período.

### 10. Reportes

Permite consultar información administrativa del sistema para facilitar el seguimiento de las actividades del taller.

## Tecnologías utilizadas

- PHP 8.2.33.
- CodeIgniter 4.7.4.
- MySQL/MariaDB.
- HTML5.
- CSS3.
- JavaScript.
- Bootstrap 5.3.3.
- Font Awesome.
- XAMPP.
- Visual Studio Code.
- MySQL Workbench.
- Git.
- GitHub.

## Arquitectura del sistema

El sistema utiliza el patrón de arquitectura MVC, que significa:

- Modelo.
- Vista.
- Controlador.

### Modelo

Los modelos se encargan de administrar los datos y realizar la comunicación con la base de datos.

### Vista

Las vistas muestran las pantallas y formularios que utiliza la encargada del taller.

### Controlador

Los controladores reciben las solicitudes del usuario y coordinan el funcionamiento entre los modelos y las vistas.

## Base de datos

La base de datos utiliza MySQL/MariaDB.

Entre las tablas principales se encuentran:

- Usuario.
- Persona.
- Rol.
- Persona_Rol.
- Curso.
- Inscripcion.
- Mensualidad.
- Pago_Mensualidad.
- Categoria_Producto.
- Producto.
- Movimiento_Inventario.
- Compra.
- Detalle_Compra.
- Venta.
- Detalle_Venta.
- Cuenta_Cobrar.
- Pago_Cuenta.
- Aporte_Municipal.
- Gasto.

## Entorno de desarrollo

El proyecto se desarrolla de forma local utilizando:

- Sistema operativo Windows.
- XAMPP.
- PHP.
- CodeIgniter 4.
- MySQL/MariaDB.
- Visual Studio Code.
- MySQL Workbench.

## Instalación del proyecto

Para ejecutar el proyecto localmente, se deben realizar los siguientes pasos:

1. Instalar XAMPP.
2. Activar Apache y MySQL/MariaDB.
3. Tener instalado PHP.
4. Tener instalado Composer.
5. Clonar o descargar el repositorio.
6. Configurar el archivo `.env`.
7. Configurar la conexión con la base de datos.
8. Ejecutar el proyecto con CodeIgniter.
