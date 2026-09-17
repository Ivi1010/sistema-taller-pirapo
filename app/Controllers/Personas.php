<?php 

namespace App\Controllers; 

use App\Models\PersonaModel; 
use App\Models\RolModel; 
use App\Models\PersonaRolModel; 
use App\Models\CursoModel;
use App\Models\InscripcionModel;

class Personas extends BaseController 
{ 
    protected $personaModel; 
    protected $rolModel; 
    protected $personaRolModel; 
    protected $cursoModel;
    protected $inscripcionModel;

    public function __construct() 
    { 
        $this->personaModel = new PersonaModel(); 
        $this->rolModel = new RolModel(); 
        $this->personaRolModel = new PersonaRolModel(); 
        $this->cursoModel = new CursoModel();
        $this->inscripcionModel = new InscripcionModel();
    } 

public function index()
{
    $personas = $this->personaModel
        ->select('
            persona.*,
            GROUP_CONCAT(DISTINCT rol.nombre_rol SEPARATOR ", ") AS roles,
            MAX(curso.nombre_curso) AS nombre_curso,
            MAX(inscripcion.estado) AS estado_inscripcion
        ')
        ->join(
            'persona_rol',
            'persona_rol.id_persona = persona.id_persona',
            'left'
        )
        ->join(
            'rol',
            'rol.id_rol = persona_rol.id_rol',
            'left'
        )
        ->join(
            'inscripcion',
            'inscripcion.id_persona = persona.id_persona',
            'left'
        )
        ->join(
            'curso',
            'curso.id_curso = inscripcion.id_curso',
            'left'
        )
        ->groupBy('persona.id_persona')
        ->findAll();

    $data = [
        'personas' => $personas
    ];

    return view('personas/index', $data);
}
public function nueva()
{
    $data = [
        'roles'  => $this->rolModel->findAll(),
        'cursos' => $this->cursoModel->findAll()
    ];

    return view('personas/nueva', $data);
}

public function guardar()
{
    // ==========================================
    // 1. GUARDAR PERSONA
    // ==========================================

    $datos = [
        'cedula'    => $this->request->getPost('cedula'),
        'nombre'    => $this->request->getPost('nombre'),
        'apellido'  => $this->request->getPost('apellido'),
        'telefono'  => $this->request->getPost('telefono'),
        'direccion' => $this->request->getPost('direccion')
    ];

    $this->personaModel->insert($datos);

    // Obtener ID de la persona recién creada
    $idPersona = $this->personaModel->getInsertID();


    // ==========================================
    // 2. OBTENER LOS ROLES SELECCIONADOS
    // ==========================================

    $roles = $this->request->getPost('roles');


    // ==========================================
    // 3. GUARDAR LOS ROLES EN PERSONA_ROL
    // ==========================================

    if (!empty($roles)) {

        foreach ($roles as $idRol) {

            $this->personaRolModel->insert([
                'id_persona' => $idPersona,
                'id_rol'     => $idRol
            ]);


            // ==========================================
            // 4. COMPROBAR SI EL ROL ES ALUMNA
            // ==========================================

            $rol = $this->rolModel->find($idRol);

            if (
                $rol &&
                isset($rol['nombre_rol']) &&
                strtolower($rol['nombre_rol']) === 'alumna'
            ) {

                // ==========================================
                // 5. GUARDAR INSCRIPCIÓN
                // ==========================================

                $idCurso = $this->request->getPost('id_curso');

                if (!empty($idCurso)) {

                    $datosInscripcion = [
                        'id_persona'        => $idPersona,
                        'id_curso'          => $idCurso,
                        'fecha_inscripcion' => $this->request->getPost('fecha_inscripcion'),
                        'estado'            => 'Activa'
                    ];

                    $this->inscripcionModel->insert($datosInscripcion);
                }
            }
        }
    }


    // ==========================================
    // 6. VOLVER AL LISTADO
    // ==========================================

    return redirect()->to('/personas');
}

    // ==========================================
    // EDITAR PERSONA
    // ==========================================

public function editar($id)
{
    $persona = $this->personaModel->find($id);

    if (!$persona) {
        return redirect()->to('/personas');
    }

    // Obtener los roles actuales de la persona
    $rolesPersona = $this->personaRolModel
        ->where('id_persona', $id)
        ->findAll();

    // Obtener la inscripción actual, si existe
    $inscripcion = $this->inscripcionModel
        ->where('id_persona', $id)
        ->first();

    $data = [
        'persona'       => $persona,
        'roles'         => $this->rolModel->findAll(),
        'rolesPersona'  => $rolesPersona,
        'cursos'        => $this->cursoModel->findAll(),
        'inscripcion'   => $inscripcion
    ];

    return view('personas/editar', $data);
}

    // ==========================================
    // ACTUALIZAR PERSONA
    // ==========================================

public function actualizar($id)
{
    // ==========================================
    // 1. ACTUALIZAR DATOS DE LA PERSONA
    // ==========================================

    $datos = [
        'cedula'    => $this->request->getPost('cedula'),
        'nombre'    => $this->request->getPost('nombre'),
        'apellido'  => $this->request->getPost('apellido'),
        'telefono'  => $this->request->getPost('telefono'),
        'direccion' => $this->request->getPost('direccion')
    ];

    $this->personaModel->update($id, $datos);


    // ==========================================
    // 2. ELIMINAR ROLES ANTERIORES
    // ==========================================

    $this->personaRolModel
        ->where('id_persona', $id)
        ->delete();


    // ==========================================
    // 3. GUARDAR LOS NUEVOS ROLES
    // ==========================================

    $roles = $this->request->getPost('roles');

    if (!empty($roles)) {

        foreach ($roles as $idRol) {

            $this->personaRolModel->insert([
                'id_persona' => $id,
                'id_rol'     => $idRol
            ]);

        }

    }


    // ==========================================
    // 4. COMPROBAR SI ES ALUMNA
    // ==========================================

    $esAlumna = false;

    if (!empty($roles)) {

        foreach ($roles as $idRol) {

            $rol = $this->rolModel->find($idRol);

            if (
                $rol &&
                strtolower($rol['nombre_rol']) === 'alumna'
            ) {

                $esAlumna = true;
                break;

            }

        }

    }


    // ==========================================
    // 5. SI ES ALUMNA, GUARDAR/ACTUALIZAR
    //    LA INSCRIPCIÓN
    // ==========================================

    $inscripcion =
        $this->inscripcionModel
            ->where('id_persona', $id)
            ->first();


    if ($esAlumna) {

        $datosInscripcion = [

            'id_persona' =>
                $id,

            'id_curso' =>
                $this->request->getPost('id_curso'),

            'fecha_inscripcion' =>
                $this->request->getPost('fecha_inscripcion'),

            'estado' =>
                $this->request->getPost('estado_inscripcion')

        ];


        if ($inscripcion) {

            // Ya existe → actualizar

            $this->inscripcionModel
                ->update(
                    $inscripcion['id_inscripcion'],
                    $datosInscripcion
                );

        } else {

            // No existe → crear

            $this->inscripcionModel
                ->insert($datosInscripcion);

        }

    } else {

        // ==========================================
        // 6. SI YA NO ES ALUMNA,
        //    ELIMINAR SU INSCRIPCIÓN
        // ==========================================

        if ($inscripcion) {

            $this->inscripcionModel
                ->delete(
                    $inscripcion['id_inscripcion']
                );

        }

    }


    // ==========================================
    // 7. VOLVER AL LISTADO
    // ==========================================

    return redirect()->to('/personas');
}

    // ==========================================
    // ELIMINAR PERSONA
    // ==========================================

    public function eliminar($id)
    {
        $this->personaRolModel
            ->where('id_persona', $id)
            ->delete();

        $this->personaModel->delete($id);

        return redirect()->to('/personas');
    }
}