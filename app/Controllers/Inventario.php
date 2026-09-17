<?php

namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\CategoriaProductoModel;
use App\Models\MovimientoInventarioModel;

class Inventario extends BaseController
{
    protected $productoModel;
    protected $categoriaModel;
    protected $movimientoModel;

    public function __construct()
    {
        $this->productoModel = new ProductoModel();
        $this->categoriaModel = new CategoriaProductoModel();
        $this->movimientoModel = new MovimientoInventarioModel();
    }

    // =====================================================
    // LISTADO DE PRODUCTOS
    // =====================================================

    public function index()
    {
        $productos = $this->productoModel
            ->select('producto.*, categoria_producto.nombre_categoria')
            ->join(
                'categoria_producto',
                'categoria_producto.id_categoria = producto.id_categoria',
                'left'
            )
            ->orderBy('producto.nombre_producto', 'ASC')
            ->findAll();

        foreach ($productos as &$producto) {
            $producto['stock_actual'] = $this->obtenerStock(
                $producto['id_producto']
            );
        }

        $data = [
            'productos' => $productos
        ];

        return view('inventario/index', $data);
    }


    // =====================================================
    // FORMULARIO NUEVO PRODUCTO
    // =====================================================

    public function nuevo()
    {
        $data = [
            'categorias' => $this->categoriaModel
                ->orderBy('nombre_categoria', 'ASC')
                ->findAll()
        ];

        return view('inventario/nuevo', $data);
    }


    // =====================================================
    // GUARDAR PRODUCTO
    // =====================================================

    public function guardar()
    {
        $nombre = trim($this->request->getPost('nombre_producto'));

        if ($nombre === '') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Debe ingresar el nombre del producto.');
        }

        $datos = [
            'id_categoria'   => $this->request->getPost('id_categoria'),
            'nombre_producto' => $nombre,
            'unidad_medida'  => $this->request->getPost('unidad_medida'),
            'precio_compra'  => $this->request->getPost('precio_compra'),
            'precio_venta'   => $this->request->getPost('precio_venta')
        ];

        $this->productoModel->insert($datos);

        return redirect()->to(base_url('inventario'))
            ->with('success', 'Producto registrado correctamente.');
    }


    // =====================================================
    // FORMULARIO EDITAR
    // =====================================================

    public function editar($id)
    {
        $producto = $this->productoModel->find($id);

        if (!$producto) {
            return redirect()->to(base_url('inventario'))
                ->with('error', 'Producto no encontrado.');
        }

        $data = [
            'producto' => $producto,
            'categorias' => $this->categoriaModel
                ->orderBy('nombre_categoria', 'ASC')
                ->findAll()
        ];

        return view('inventario/editar', $data);
    }


    // =====================================================
    // ACTUALIZAR PRODUCTO
    // =====================================================

    public function actualizar($id)
    {
        $producto = $this->productoModel->find($id);

        if (!$producto) {
            return redirect()->to(base_url('inventario'))
                ->with('error', 'Producto no encontrado.');
        }

        $datos = [
            'id_categoria'    => $this->request->getPost('id_categoria'),
            'nombre_producto' => trim($this->request->getPost('nombre_producto')),
            'unidad_medida'   => $this->request->getPost('unidad_medida'),
            'precio_compra'   => $this->request->getPost('precio_compra'),
            'precio_venta'    => $this->request->getPost('precio_venta')
        ];

        $this->productoModel->update($id, $datos);

        return redirect()->to(base_url('inventario'))
            ->with('success', 'Producto actualizado correctamente.');
    }


    // =====================================================
    // REGISTRAR ENTRADA
    // =====================================================

    public function entrada($id)
    {
        $producto = $this->productoModel->find($id);

        if (!$producto) {
            return redirect()->to(base_url('inventario'))
                ->with('error', 'Producto no encontrado.');
        }

        return view('inventario/entrada', [
            'producto' => $producto
        ]);
    }


    // =====================================================
    // GUARDAR ENTRADA
    // =====================================================

    public function guardarEntrada()
    {
        $idProducto = $this->request->getPost('id_producto');
        $cantidad = (float) $this->request->getPost('cantidad');
        $fecha = $this->request->getPost('fecha');

        if ($cantidad <= 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'La cantidad debe ser mayor que cero.');
        }

        $producto = $this->productoModel->find($idProducto);

        if (!$producto) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Producto no encontrado.');
        }

        $this->movimientoModel->insert([
            'id_producto'     => $idProducto,
            'tipo_movimiento' => 'Entrada',
            'cantidad'        => $cantidad,
            'fecha'           => $fecha
        ]);

        return redirect()->to(base_url('inventario'))
            ->with('success', 'Entrada de inventario registrada correctamente.');
    }


    // =====================================================
    // REGISTRAR SALIDA
    // =====================================================

    public function salida($id)
    {
        $producto = $this->productoModel->find($id);

        if (!$producto) {
            return redirect()->to(base_url('inventario'))
                ->with('error', 'Producto no encontrado.');
        }

        $stock = $this->obtenerStock($id);

        return view('inventario/salida', [
            'producto' => $producto,
            'stock' => $stock
        ]);
    }


    // =====================================================
    // GUARDAR SALIDA
    // =====================================================

    public function guardarSalida()
    {
        $idProducto = $this->request->getPost('id_producto');
        $cantidad = (float) $this->request->getPost('cantidad');
        $fecha = $this->request->getPost('fecha');

        if ($cantidad <= 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'La cantidad debe ser mayor que cero.');
        }

        $producto = $this->productoModel->find($idProducto);

        if (!$producto) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Producto no encontrado.');
        }

        $stockActual = $this->obtenerStock($idProducto);

        if ($cantidad > $stockActual) {
            return redirect()->back()
                ->withInput()
                ->with(
                    'error',
                    'No hay suficiente stock. Stock disponible: ' .
                    number_format($stockActual, 2)
                );
        }

        $this->movimientoModel->insert([
            'id_producto'     => $idProducto,
            'tipo_movimiento' => 'Salida',
            'cantidad'        => $cantidad,
            'fecha'           => $fecha
        ]);

        return redirect()->to(base_url('inventario'))
            ->with('success', 'Salida de inventario registrada correctamente.');
    }


    // =====================================================
    // HISTORIAL DE MOVIMIENTOS
    // =====================================================

    public function movimientos($id)
    {
        $producto = $this->productoModel->find($id);

        if (!$producto) {
            return redirect()->to(base_url('inventario'))
                ->with('error', 'Producto no encontrado.');
        }

        $movimientos = $this->movimientoModel
            ->where('id_producto', $id)
            ->orderBy('fecha', 'DESC')
            ->orderBy('id_movimiento', 'DESC')
            ->findAll();

        $stock = $this->obtenerStock($id);

        return view('inventario/movimientos', [
            'producto' => $producto,
            'movimientos' => $movimientos,
            'stock' => $stock
        ]);
    }


    // =====================================================
    // CALCULAR STOCK ACTUAL
    // =====================================================

    private function obtenerStock($idProducto)
    {
        $movimientos = $this->movimientoModel
            ->where('id_producto', $idProducto)
            ->findAll();

        $stock = 0;

        foreach ($movimientos as $movimiento) {

            if ($movimiento['tipo_movimiento'] === 'Entrada') {
                $stock += (float) $movimiento['cantidad'];
            }

            if ($movimiento['tipo_movimiento'] === 'Salida') {
                $stock -= (float) $movimiento['cantidad'];
            }
        }

        return $stock;
    }
    // =====================================================
// GUARDAR NUEVA CATEGORÍA
// =====================================================

public function guardarCategoria()
{
    $nombre = trim($this->request->getPost('nombre_categoria'));

    if ($nombre === '') {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Debe ingresar el nombre de la categoría.');
    }

    // Verificar si ya existe
    $existe = $this->categoriaModel
        ->where('nombre_categoria', $nombre)
        ->first();

    if ($existe) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'La categoría ya existe.');
    }

    $this->categoriaModel->insert([
        'nombre_categoria' => $nombre
    ]);

    return redirect()->to(base_url('inventario/nuevo'))
        ->with('success', 'Categoría registrada correctamente.');
}
}