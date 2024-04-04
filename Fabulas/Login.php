<?php
require_once("Conn_bd.php");

if (isset($_SESSION['user']))
    header("Location: Home.php");

$donnees = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $donnees = $_POST;
    if (verif_login($donnees)) {        //Vérifie si les données rentrée par l'utilisateur lors de la connexion son correcte et si oui le conecte
        header('Location:Home.php');
        exit;
    }
    page_login($donnees, 1);
} else {
    page_login($donnees, 0);
}
