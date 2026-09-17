<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriaProductoModel extends Model
{
    protected $table = 'categoria_producto';
    protected $primaryKey = 'id_categoria';

    protected $allowedFields = [
        'nombre_categoria'
    ];

    protected $returnType = 'array';
}