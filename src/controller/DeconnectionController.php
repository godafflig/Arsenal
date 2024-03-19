<?php


namespace App\Controller;
class DeconnectionController
{
    private $twig;

    public function __construct($_twig)
    {
        // Utilisez le chemin absolu depuis la racine du serveur pour le répertoire de modèles
        // $this->loader = new FilesystemLoader(__DIR__ . '/../vue');
        // $this->twig = new Environment($this->loader);
        $this->twig = $_twig;
    }
    public function logout()
    {

        session_destroy();

        if (headers_sent()) {
            die("Redirect failed. Please click on this link: <a href='/login'>");
        } else {
            exit(header("Location: /"));
        }
    }
}
