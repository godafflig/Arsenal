<?php

namespace App\Controller;

require 'vendor/autoload.php';


use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class HomeController
{

    protected $twig;
    private $loader;

    public function __construct()
    {
        // Utilisez le chemin absolu depuis la racine du serveur pour le répertoire de modèles
        $this->loader = new FilesystemLoader(__DIR__ . '/../vue');
        $this->twig = new Environment($this->loader);
        $this->twig->display('Home/index.html.twig');
    }
}
