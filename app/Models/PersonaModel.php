<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonaModel extends Model
{
    protected $table = 'persona';
    protected $primaryKey = 'id_persona';

    protected $allowedFields = [
        'cedula',
        'nombre',
        'apellido',
        'telefono',
        'direccion'
    ];
}