<?php
require_once("Conn_bd.php");

$conn = connexion_bd();
$user = $_GET['user'];
if (!isset($_SESSION['user']))
    header("Location: Login.php");

afficher_entete("Publications");

echo "<h1>Publications de <a href='Profil.php?user=" . $user . "'>" . $user . "</a> </h1>";
$req = "SELECT * FROM Publication WHERE username = '$user' ORDER BY id DESC ";      //Selectionne toutes les publication d'un utilisateur précis puis les affiches
$result = mysqli_query($conn, $req);

mysqli_close($conn);
if (mysqli_num_rows($result) == 0) {

    echo "Aucune Publication.";
} else {

    afficher_feed2($result);
}
afficher_pied_page();
