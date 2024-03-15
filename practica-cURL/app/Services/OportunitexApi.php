<?php

namespace App\Services;

use Config\Services;

class OportunitexApi
{
    private $url = 'https://opportunitex.sandbox.resuelve.io/api/v2/records';

    public function validarDatos($datos)
    {
        // user
        $user = $datos['record']['data']['user'];
        $requiredUserFields = ['names', 'first_surname', 'email', 'mobile', 'country', 'contact_by', 'contact_by_wa', 'terms_conditions'];
        foreach ($requiredUserFields as $field) {
            if (!isset($user[$field])) {
                throw new \Exception("Falta el campo obligatorio del usuario: $field");
            }
        }

        //  system_id
        if (!isset($datos['record']['data']['system_id']) || !in_array($datos['record']['data']['system_id'], ['4', '9', '10'])) {
            throw new \Exception('system_id inválido');
        }

        //  información del usuario
        $user = $datos['record']['data']['user'];
        if (!isset($user['names'], $user['first_surname'], $user['email'], $user['mobile'], $user['country'], $user['contact_by'], $user['contact_by_wa'], $user['terms_conditions'])) {
            throw new \Exception('Faltan datos obligatorios del usuario');
        }

        //  deudas
        foreach ($datos['record']['data']['debts'] as $debt) {
            if (!isset($debt['debt_amount'])) {
                throw new \Exception('Faltan datos obligatorios de la deuda');
            }
        }

        //  datos de marketing
        $mkt = $datos['record']['data']['mkt'];
        if (!isset($mkt['utm_source'], $mkt['utm_campaign'], $mkt['utm_channel'], $mkt['landing'])) {
            throw new \Exception('Faltan datos obligatorios de marketing');
        }

        //  monto mínimo de deuda por producto
        $minDebtAmount = [
            'mx' => 35000,
            'co' => 5000000,
            'ar' => 100000,
            'es' => 4000
        ];
        foreach ($datos['record']['data']['debts'] as $debt) {
            if ($debt['debt_amount'] < $minDebtAmount[$user['country']]) {
                throw new \Exception('El monto de la deuda es menor al mínimo permitido para el producto seleccionado');
            }
        }
    }

    public function enviarDatos($datos)
    {
        $this->validarDatos($datos);
    
        $clienteCurl = Services::curlrequest();
        $respuesta = $clienteCurl->request('POST', $this->url, [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'json' => $datos
        ]);
    
        $statusCode = $respuesta->getStatusCode();
        if ($statusCode == 200) {
            $body = $respuesta->getBody();
            $json = json_decode($body, true);
            if (isset($json['record']['lead']['duplicated']) && $json['record']['lead']['duplicated']) {
                return "Duplicated";
            }
            return "Success";
        } else if ($statusCode == 400) {
            return "Error";
        }
    }
}