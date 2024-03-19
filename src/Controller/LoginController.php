<?php

namespace App\Controller;

require 'vendor/autoload.php';
require_once __DIR__ . '/../Modele/LoginModel.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class LoginController
{
    protected $twig;
    private $loader;
    private $LoginModel;


    public function __construct()
    {
        //----------------------------logique twig -----------------------------------
        $this->loader = new FilesystemLoader(__DIR__ . '/../Vue/Template');
        $this->twig = new Environment($this->loader);
        $this->LoginModel = new LoginModel();

        $context = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $username = $_POST['username']  ?? '';
            $password = $_POST['password'] ?? '';



            $response = $this->LoginModel->login($username, $password);

            if ($response->code == 200) {
                $_SESSION['username'] = $username;
                echo 'le joueur est connecte ';
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
        $this->twig->display('Login/login.html.twig');
    }
}
