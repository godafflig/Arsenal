<?php

namespace App\Controller;

require 'vendor/autoload.php';
require_once __DIR__ . '/../modele/ProfileModel.php';
class ProfileController
{
    protected $twig;
    private $profileModel;

    public function __construct($_twig)
    {
        $this->twig = $_twig;
        $this->profileModel = new ProfilModel();
    }
    public function showProfile()
    {
        // session_start(); // Assurez-vous que la session est démarrée
        // Vérifiez si l'utilisateur est connecté
        if (!isset($_SESSION['sessionTicket'])) {
            // Utilisateur non connecté, rediriger vers le formulaire de connexion
            header("Location: /login");
            exit;
        }
        $sessionTicket = $_SESSION['sessionTicket'];
        // Utiliser ProfileModel pour récupérer les informations de profil
        $profileInfo = $this->profileModel->getProfileInfo($sessionTicket);
        // Dans ProfileController.php, si vous utilisez des objets
        if (isset($profileInfo->error)) {
            $context = ['error' => $profileInfo->error];
        } else {
            function formatDateTime($dateString) {
                return $dateString ? (new \DateTime($dateString))->format('d/m/Y') : '';
            }
            
            $context = [
                'isConnected' => true,
                'playFabId' => $profileInfo['data']['AccountInfo']['PlayFabId'] ?? '',
                'created' => formatDateTime($profileInfo['data']['AccountInfo']['Created']),
                'username' => $profileInfo['data']['AccountInfo']['Username'] ?? '',
                'displayName' => $profileInfo['data']['AccountInfo']['TitleInfo']['DisplayName'] ?? '',
                'origination' => $profileInfo['data']['AccountInfo']['TitleInfo']['Origination'] ?? '',
                'titleCreated' => formatDateTime($profileInfo['data']['AccountInfo']['TitleInfo']['Created']),
                'lastLogin' => formatDateTime($profileInfo['data']['AccountInfo']['TitleInfo']['LastLogin']),
                'firstLogin' => formatDateTime($profileInfo['data']['AccountInfo']['TitleInfo']['FirstLogin']),
                'isBanned' => $profileInfo['data']['AccountInfo']['TitleInfo']['isBanned'] ?? false,
                'email' => $profileInfo['data']['AccountInfo']['PrivateInfo']['Email'] ?? '',
            ];
            
        }
        // var_dump($context);
        $this->twig->display('Profile/profile.html.twig', $context);
    }
}
