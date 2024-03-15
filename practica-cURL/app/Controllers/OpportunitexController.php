<?php

namespace App\Controllers;

use App\Services\ApiService;
use App\Services\OportunitexApi;
use CodeIgniter\API\ResponseTrait;

class OpportunitexController extends BaseController
{
    use ResponseTrait;

    protected $oportunitexApi;

    public function __construct()
    {
        $this->oportunitexApi = new OportunitexApi();
    }

    public function parseLead($lead=null){
        if($lead==null){
            return null;
        }
        $data=array();
        $data['names']=$lead->name;
        $data['first_surname']=$lead->first_lastname;
        $data['second_surname']=$lead->second_lastname;
        $data['email']=$lead->email;
        $data['country']='es';
        $data['mobile']= $lead->phone;
        $data['phone']= $lead->phone;
        $data['postal_code'] = (isset($lead->zipcode)) ? $lead->zipcode : "";
        $data['state']=(isset($lead->province)) ? $lead->province : "";
        $data['contact_by']="EMAIL";
        $data['contact_by_wa'] = true;
        $data['terms_conditions'] = true;
        $mkt = array(
          "utm_source" => "pub3_es",
          "utm_campaign" => "mrfinanes",
          "utm_medium" => "paid",
          "utm_channel" => "api",
          "landing" => "",
          "utm_term" => "bravo_es"
        );
        $debts = array(
          array("borrower_institute" => 'Bank',
                "debt_amount" => $lead->amount,
                "months_behind" => 0)
        );
        $data2 = array(
            "system_id" => "4" ,
            "user" => $data,
            "mkt" => $mkt,
            "debts" => $debts
        );
        $record = array("data" => $data2);
        $req = array("record" => $record);
        return $req;
    } 

    public function enviarOportunidad()
    {
        $jsonInput = $this->request->getJSON(true);
        $lead = (object)$jsonInput['record']['data']['user'];
        $datosSolicitud = $this->parseLead($lead);

        try {
            $respuesta = $this->oportunitexApi->enviarDatos($datosSolicitud);
            return $this->respond(['message' => $respuesta], 200);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    private function procesarRespuesta($respuesta)
    {
        $statusCode = $respuesta->getStatusCode();

        if ($statusCode == 200) {
            $body = $respuesta->getBody();
            return $this->respond(json_decode($body), $statusCode);
        } elseif ($statusCode == 400) {
            return $this->manejarErrores($respuesta);
        } else {
            return $this->failServerError('Error en la solicitud');
        }
    }

    private function manejarErrores($respuesta)
    {
        $body = $respuesta->getBody();
        $errorResponse = json_decode($body, true);
        $statusCode = $respuesta->getStatusCode();

        foreach ($errorResponse['record']['errors'] as $error) {
            switch ($error['error']) {
                case 'invalid_names':
                    break;
                case 'invalid_debt_amount':
                    break;
                case 'invalid_phones':
                    break;
            }
        }

        return $this->respond($errorResponse, $statusCode);
    }
}