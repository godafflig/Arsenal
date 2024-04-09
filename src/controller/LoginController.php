<?php
namespace App\Controller;

require 'vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ProfileController
{
    protected $twig;

    public function __construct($_twig)
    {
        $this->twig = $_twig;
    }

    public function showProfile()
    {
        session_start(); // Assurez-vous que la session est démarrée

        // Vérifiez si l'utilisateur est connecté
        if (isset($_SESSION['sessionTicket'])) {
            $sessionTicket = $_SESSION['sessionTicket'];

            // Effectuer la requête à PlayFab pour obtenir les informations de profil
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://697EF.playfabapi.com/Client/GetAccountInfo",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => "{}", // Corps de la requête. Ajustez selon les besoins.
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "X-Authorization: $sessionTicket",
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                $context = ['error' => "Erreur lors de la récupération des informations de profil: $err"];
            } else {
                // Convertir la réponse en un tableau associatif
                $data = json_decode($response, true);

                // Ici, ajustez les clés selon la structure de la réponse de PlayFab
                $context = [
                    'username' => $_SESSION['username'] ?? 'Invité',
                    'profile' => $data['data']['AccountInfo'] ?? [],
                ];
            }
        } else {
            // Utilisateur non connecté, rediriger vers le formulaire de connexion
            header("Location: /login");
            exit;
        }

        $this->twig->display('Profile/profile.html.twig', $context);
    }
}
