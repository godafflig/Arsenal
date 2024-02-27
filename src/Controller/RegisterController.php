<?php

namespace App\Controller;

require 'vendor/autoload.php';
require_once __DIR__ . '/../Modele/RegisterModel.php';


use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class RegisterController
{
    protected $twig;
    private $loader;
    private $registerModel;

    public function __construct()
    {
        //----------------------------logique twig -----------------------------------
        $this->loader = new FilesystemLoader(__DIR__ . '/../Vue/Template');
        $this->twig = new Environment($this->loader);
        $this->registerModel = new RegisterModel();



        $context = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Récupération des données du formulaire
            $username = $_POST['username'] ?? ''; // Utilisation de l'opérateur de coalescence nulle
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $displayname = $_POST['displayname'] ?? '';


            // Vous pouvez ajouter une validation supplémentaire ici
            // Envoi de la demande d'enregistrement
            $response = $this->registerModel->register($email, $displayname, $password, $username);
            // Traiter la réponse et effectuer des actions en fonction de celle-ci
            // Par exemple, afficher un message ou rediriger l'utilisateur

            print_r($response);

            //REDIRECTION EN FONCTION DE LA REPONSE->
        }
        $this->twig->display('Register/register.html.twig', []);
    }
}
