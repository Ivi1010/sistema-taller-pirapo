<?php

namespace App\Models;

use CodeIgniter\Model;

class InscripcionModel extends Model
{
    protected $table = 'inscripcion';
    protected $primaryKey = 'id_inscripcion';

    protected $allowedFields = [
        'id_persona',
        'id_curso',
        'fecha_inscripcion',
        'estado'
    ];
}