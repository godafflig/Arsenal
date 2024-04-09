<?php
namespace App\Controller;

class ProfilModel
{
    private $titleId = '697EF';

    public function getProfileInfo($sessionTicket)
    {
        // Correction: Incorporation du titleId dans l'URL de la requête
        $url = "https://{$this->titleId}.playfabapi.com/Client/GetAccountInfo";

        // Ajout: Passer le TitleId dans le corps de la requête si nécessaire. 
        // Cependant, pour GetAccountInfo, cela n'est généralement pas requis.
        $data = [
            // 'TitleId' => $this->titleId // Normalement, pas nécessaire pour GetAccountInfo
        ];

        // Correction: Passer le sessionTicket dans les en-têtes HTTP
        $response = $this->httpPost($url, $data, $sessionTicket);
        // return json_decode($response);
        return json_decode($response, true); // Dans ProfilModel.php

    }
    public function httpPost($url, $data, $sessionTicket)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // Correction: Ajout de l'en-tête 'X-Authorization' pour l'authentification avec le sessionTicket
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            "X-Authorization: {$sessionTicket}" // Authentification nécessaire
        ]);
        $response = curl_exec($curl);
        if (curl_errno($curl)) { // Ajout: Gestion des erreurs de cURL
            throw new \Exception('cURL error: ' . curl_error($curl));
        }
        curl_close($curl);
        return $response;
    }
}
