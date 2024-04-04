<?php

require_once("Conn_bd.php");

$research = $_POST['search'];
$conn = connexion_bd();
$user = mysqli_real_escape_string($conn, $research);
$req = "SELECT * FROM Users WHERE username = '$user' OR email ='$user'";    //Recherche si le nom d'un utilisateur est dans la base de données ou non et va sur son profil s'il existe ou alors reste sur la même page.
$resultat = mysqli_query($conn, $req);
mysqli_close($conn);
if ($resultat && mysqli_num_rows($resultat) == 1) {
    header("Location: Profil.php?user=$research");
} else {
    $page = $_POST['page'];
    header("Location: $page");
}
