<?php



namespace App\Controller;

// session_start();

require 'vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ProfilController 
{

    protected $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    public function profil()
    {
        
        var_dump($_SESSION);
        // Assurez-vous que la session est démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $context = [
            'displayName' => $_SESSION['username'] ?? 'Invité',
            'email' => $_SESSION['email'] ?? 'Non spécifié',
        ];

        // Rendre la vue avec Twig
        echo $this->twig->display('Profil/profil.html.twig', $context);
    }
}
