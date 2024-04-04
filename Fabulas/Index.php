<?php
session_set_cookie_params(3600 * 24 * 7);
session_start();
if (isset($_SESSION['user'])) {     //Vérifie si l'utilisateur est connecter ou non pour l'envoyer automatiquement soit sur la page d'acceuil soit sur la page de connexion
    header("Location: Home.php");
} else {
    $_SESSION['style'] = "T";
    header("Location: Login.php");
}
