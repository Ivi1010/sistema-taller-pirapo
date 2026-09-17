<?php

namespace App\Models;

use CodeIgniter\Model;

class MovimientoInventarioModel extends Model
{
    protected $table = 'movimiento_inventario';
    protected $primaryKey = 'id_movimiento';

    protected $allowedFields = [
        'id_producto',
        'tipo_movimiento',
        'cantidad',
        'fecha'
    ];

    protected $returnType = 'array';
}