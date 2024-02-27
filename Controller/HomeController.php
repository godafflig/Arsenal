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
    { {
            //----------------------------logique twig -----------------------------------
            $this->loader = new FilesystemLoader(__DIR__ . '/../Vue/Template');
            $this->twig = new Environment($this->loader);

            $this->twig->display('Home/home.html.twig');
        }
    }
}
