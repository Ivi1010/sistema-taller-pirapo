<?php

namespace App\Models;

use CodeIgniter\Model;

class MensualidadModel extends Model
{
    protected $table = 'mensualidad';

    protected $primaryKey = 'id_mensualidad';

    protected $allowedFields = [
        'id_inscripcion',
        'mes',
        'anio',
        'monto',
        'fecha_vencimiento',
        'estado'
    ];
}