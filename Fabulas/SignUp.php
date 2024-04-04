<?php
require_once("Conn_bd.php");

if (isset($_SESSION['user']))
    header("Location: Home.php");

$donnees = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $donnees = $_POST;
    if (verif_signup($donnees)) {       //Vérifie si ce qu'a rentré l'utilisateur est conforme puis met les données dans la base de données
        enregistrement($donnees);
        header('Location:Quizz.php');
        exit;
    }
    page_signUp($donnees, 1);
} else {
    page_signUp($donnees, 0);
}
