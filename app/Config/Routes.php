<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
// =====================================================
// LOGIN
// =====================================================
$routes->get('/', 'Login::index');
$routes->get('login', 'Login::index');
$routes->post('login/ingresar', 'Login::ingresar');
$routes->get('/dashboard', 'Dashboard::index');
// =====================================================
// PERSONAS
// =====================================================
$routes->get('personas', 'Personas::index');
$routes->get('personas/nueva', 'Personas::nueva');
$routes->post('personas/guardar', 'Personas::guardar');
$routes->get('personas/editar/(:num)', 'Personas::editar/$1');
$routes->post('personas/actualizar/(:num)', 'Personas::actualizar/$1');
$routes->get('personas/eliminar/(:num)', 'Personas::eliminar/$1');
$routes->get('cursos', 'Cursos::index');
$routes->get('cursos/nuevo', 'Cursos::nuevo');
$routes->post('cursos/guardar', 'Cursos::guardar');
// =====================================================
// MENSUALIDADES
// =====================================================
$routes->get('mensualidades','Mensualidades::index');
$routes->get('mensualidades/registrar/(:num)','Mensualidades::registrar/$1');
$routes->post('mensualidades/guardar-varios','Mensualidades::guardarVarios');
$routes->get('mensualidades/alumna/(:num)','Mensualidades::alumna/$1');
$routes->get('mensualidades/editar/(:num)','Mensualidades::editar/$1');
$routes->post('mensualidades/actualizar/(:num)','Mensualidades::actualizar/$1');
$routes->post('mensualidades/anular/(:num)', 'Mensualidades::anular/$1');
// =====================================================
// INVENTARIO
// =====================================================
// Listado de productos
$routes->get('inventario', 'Inventario::index');
// Registrar nuevo producto
$routes->get('inventario/nuevo', 'Inventario::nuevo');
$routes->post('inventario/guardar', 'Inventario::guardar');
// Editar producto
$routes->get('inventario/editar/(:num)', 'Inventario::editar/$1');
$routes->post('inventario/actualizar/(:num)', 'Inventario::actualizar/$1');
// Registrar entrada de stock
$routes->get('inventario/entrada/(:num)', 'Inventario::entrada/$1');
$routes->post('inventario/guardar-entrada', 'Inventario::guardarEntrada');
// Registrar salida de stock
$routes->get('inventario/salida/(:num)', 'Inventario::salida/$1');
$routes->post('inventario/guardar-salida', 'Inventario::guardarSalida');
// Historial de movimientos
$routes->get('inventario/movimientos/(:num)', 'Inventario::movimientos/$1');
// Boton de cargar nueva categoría
$routes->post('inventario/guardarCategoria', 'Inventario::guardarCategoria');
