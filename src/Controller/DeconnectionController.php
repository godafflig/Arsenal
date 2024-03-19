<?php


namespace App\Controller;




class DeconnectionController
{
    public function logout()
    {
        session_destroy();
        header('Location: /');
        exit(); // Assurez-vous d'arrêter le script après la redirection
    }
}
