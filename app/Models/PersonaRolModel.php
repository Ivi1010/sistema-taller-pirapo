<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonaRolModel extends Model
{
    protected $table = 'persona_rol';
    protected $primaryKey = 'id_persona_rol';

    protected $allowedFields = [
        'id_persona',
        'id_rol'
    ];
}