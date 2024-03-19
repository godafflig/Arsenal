<?php

namespace App\Controller;


class LoginModel
{
    private $titleId = '697EF';


    public function login($username, $password)
    {
        $data = [
            'Username' => $username,
            'Password' => $password,
            'TitleId' => $this->titleId
        ];

        $response = $this->httpPost("https://titleId.playfabapi.com/Client/LoginWithPlayFab", $data);
        return json_decode($response);
    }




    public function httpPost($url, $data)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
