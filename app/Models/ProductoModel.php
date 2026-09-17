<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table = 'producto';
    protected $primaryKey = 'id_producto';

    protected $allowedFields = [
        'id_categoria',
        'nombre_producto',
        'unidad_medida',
        'precio_compra',
        'precio_venta'
    ];

    protected $returnType = 'array';
}