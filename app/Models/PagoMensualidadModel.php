<?php

namespace App\Models;

use CodeIgniter\Model;

class PagoMensualidadModel extends Model
{
    protected $table = 'pago_mensualidad';

    protected $primaryKey = 'id_pago';

    protected $allowedFields = [
        'id_mensualidad',
        'fecha_pago',
        'monto_pagado',
        'estado',
        'motivo_anulacion',
        'fecha_anulacion'
    ];
}
