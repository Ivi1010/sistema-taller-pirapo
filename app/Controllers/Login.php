<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Login extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function ingresar()
    {
        $usuario = $this->request->getPost('nombre_usuario');
        $contrasena = $this->request->getPost('contrasena');

        $modelo = new UsuarioModel();

        $usuarioEncontrado = $modelo
            ->where('nombre_usuario', $usuario)
            ->where('estado', 'Activo')
            ->first();

        if ($usuarioEncontrado) {

            if (password_verify($contrasena, $usuarioEncontrado['contrasena'])) {

                session()->set([
                    'id_usuario' => $usuarioEncontrado['id_usuario'],
                    'nombre_usuario' => $usuarioEncontrado['nombre_usuario'],
                    'logueado' => true
                ]);

                return redirect()->to('/dashboard');

            }
        }

        return redirect()->back()->with('error', 'Usuario o contraseña incorrectos.');
    }
}