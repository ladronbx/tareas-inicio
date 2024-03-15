<?php namespace App\Services;

use Config\Services;

class ApiService
{
    private $url = 'https://opportunitex.sandbox.resuelve.io/api/v2/records'; // URL del API

    public function postRecord($datosSolicitud)
    {
        $clienteCurl = Services::curlrequest();
        $respuesta = $clienteCurl->request('POST', $this->url, [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'json' => $datosSolicitud
        ]);

        return $respuesta;
    }
}