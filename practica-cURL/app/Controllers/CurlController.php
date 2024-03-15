<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\URI;

class CurlController extends Controller

// El primer fragmento de código utiliza la clase CurlRequest proporcionada por CodeIgniter. 
// Esta clase es una abstracción de alto nivel sobre cURL que proporciona una interfaz más 
// amigable y orientada a objetos para hacer solicitudes HTTP.
{
    //Utilizando la clase proporcionada por CodeIgniter
    public function index()
    {
        $client = \Config\Services::curlrequest();

        $response = $client->request('GET', 'https://jsonplaceholder.typicode.com/posts/1');

        $data = json_decode($response->getBody(), true);

        echo 'Título de la publicación: ' . $data['title'];
        echo 'Contenido de la publicación: ' . $data['body'];
    }
    
    //Utilizando la clase proporcionada por CodeIgniter
    public function postExample()
    {
        $client = \Config\Services::curlrequest();

        $data = [
            'title' => 'Mi título',
            'body' => 'Este es el contenido de mi publicación',
            'userId' => 1
        ];

        $response = $client->request('POST', 'https://jsonplaceholder.typicode.com/posts', [
            'json' => $data
        ]);

        $responseData = json_decode($response->getBody(), true);

        echo 'ID de la nueva publicación: ' . $responseData['id'];
    }

    //utilizando la librería cURL directamente
    public function curlExample()
    {
        // Para una solicitud GET
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://jsonplaceholder.typicode.com/posts/1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);

        if ($output === FALSE) {
            echo 'cURL Error: ' . curl_error($ch);
        }

        $data = json_decode($output, true);

        echo 'Título de la publicación: ' . $data['title'];
        echo 'Contenido de la publicación: ' . $data['body'];

        curl_close($ch);

        // Para una solicitud POST
        $ch = curl_init();

        $data = [
            'title' => 'Mi título',
            'body' => 'Este es el contenido de mi publicación',
            'userId' => 1
        ];

        curl_setopt($ch, CURLOPT_URL, 'https://jsonplaceholder.typicode.com/posts');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if ($response === FALSE) {
            echo 'cURL Error: ' . curl_error($ch);
        }

        $responseData = json_decode($response, true);

        echo 'ID de la nueva publicación: ' . $responseData['id'];

        curl_close($ch);
    }
}
