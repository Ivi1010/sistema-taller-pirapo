<?php

namespace App\Controllers;

use App\Models\CursoModel;

class Cursos extends BaseController
{
    protected $cursoModel;

    public function __construct()
    {
        $this->cursoModel = new CursoModel();
    }

    public function index()
    {
        $data = [
            'cursos' => $this->cursoModel->findAll()
        ];

        return view('cursos/index', $data);
    }

    public function nuevo()
    {
        return view('cursos/nuevo');
    }

    public function guardar()
    {
        $datos = [
            'nombre_curso' => $this->request->getPost('nombre_curso'),
            'descripcion'  => $this->request->getPost('descripcion')
        ];

        $this->cursoModel->insert($datos);

        return redirect()->to('/cursos');
    }
}