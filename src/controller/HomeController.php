<?php

namespace App\Controller;

require 'vendor/autoload.php';



class HomeController
{

    protected $twig;

    public function __construct($_twig)
    {
        $this->twig = $_twig;

        $this->twig->display('Home/index.html.twig');
    }
}
