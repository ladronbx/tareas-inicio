<?php

namespace App\Controllers;

use App\Services\OportunitexApi;

class HomeController extends BaseController
{
    public function form() {
        return view('Opportunitex/Opportunitex');
    }
    public function index()
    {
        $api = new OportunitexApi();

        // Obtengo los datos del formulario
        $datos = $this->request->getPost();

        $resultado = $api->enviarDatos($datos);

        if ($resultado == 'Success') {
            echo 'Los datos se enviaron con éxito.';
        } elseif ($resultado == 'Error') {
            echo 'Hubo un error al enviar los datos.';
        } elseif ($resultado == 'Duplicated') {
            echo 'El usuario ya existe.';
        }
    }
}
