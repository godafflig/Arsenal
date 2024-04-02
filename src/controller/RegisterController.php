<?php

namespace App\Controller;

require 'vendor/autoload.php';
require_once __DIR__ . '/../modele/RegisterModel.php';
class RegisterController
{
    protected $twig;

    private $registerModel;

    public function __construct($_twig)
    {
        //----------------------------logique twig -----------------------------------
        $this->twig = $_twig;
        $this->registerModel = new RegisterModel();
        $context = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Récupération des données du formulaire
            $username = $_POST['username'] ?? ''; // Utilisation de l'opérateur de coalescence nulle
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $displayname = $_POST['displayname'] ?? '';
            $response = $this->registerModel->register($email, $displayname, $password, $username);
            // var_dump($response);
            if ($response->code == 200) {
                $context = ['message' => "success", 'type' => "success"];
            } else if ($response->code == 400 && isset($response->errorDetails)) { {
                    $errors = [];
                    foreach ($response->errorDetails as $field => $messages) {
                        foreach ($messages as $message) {
                            $errors[] = $message; // Ajoute chaque message d'erreur à un tableau
                        }
                    }
                    $context['errors'] = $errors; // Ajoute le tableau d'erreurs au contexte pour Twig
                }
            } else {
                $context = ['message' => $response->errorMessage, 'type' => "error"];
            }
        }
        $this->twig->display('Register/register.html.twig', $context);
    }
}
