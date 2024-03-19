<?php

namespace App\Controller;

require 'vendor/autoload.php';



class HomeController
{

    protected $twig;

    public function __construct($_twig)
    {
        $this->twig = $_twig;

        // Utilisez le chemin absolu depuis la racine du serveur pour le répertoire de modèles
        // $this->loader = new FilesystemLoader(__DIR__ . '/../vue');
        // $this->twig = new Environment($this->loader);
        $this->twig->display('Home/index.html.twig');
    }
}
