<?php
namespace App\Controller;

require 'vendor/autoload.php';
require_once __DIR__ . '/../modele/LoginModel.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class LoginController
{
    protected $twig;
    private $loginModel;

    public function __construct($_twig)
    {
        $this->twig = $_twig;
        $this->loginModel = new LoginModel();
    }

    public function showLoginForm()
    {
        // Afficher le formulaire de connexion
        $this->twig->display('Login/login.html.twig');
    }

    public function processLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $response = $this->loginModel->login($username, $password);

            if (isset($response->code) && $response->code === 200 && isset($response->data->SessionTicket)) {
                
                $_SESSION['sessionTicket'] = $response->data->SessionTicket;
                $_SESSION['username'] = $username;

                // Rediriger l'utilisateur vers la page d'accueil
                if (headers_sent()) {
                    die("Redirect failed. Please click on this link: <a href='/login'>");
                } else {
                    exit(header("Location: /"));
                }

                // header('Location:/');
                // exit(); // Arrêter l'exécution du script après la redirection
            } else {
                // Afficher un message d'erreur si la connexion a échoué
                $context = ['error' => 'Identifiants incorrects. Veuillez réessayer.'];
                $this->twig->display('Login/login.html.twig', $context);
            }
        } else {
            // Si la méthode HTTP n'est pas POST, rediriger l'utilisateur vers le formulaire de connexion
            $this->showLoginForm();
        }
    }
}
