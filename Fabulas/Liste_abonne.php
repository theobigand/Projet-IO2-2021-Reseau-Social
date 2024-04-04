<?php
require_once("Conn_bd.php");
afficher_entete("Abonné(s)");
$conn = connexion_bd();
$user = $_GET['user'];
$req = "SELECT * FROM Follow WHERE following = '$user'";
$result = mysqli_query($conn, $req);
while ($follower = mysqli_fetch_assoc($result)) {
    $tabfollower[] = $follower['username'];
}
if (!empty($tabfollower)) {
    echo "<h1>Voici la liste des personnes qui suivent " . $user . ".</h1>";
    foreach ($tabfollower as $i => $var) {
        echo '<h2><a href="Profil.php?user=' . $var . '">' . $var . '</a></h2>';
    }
} else {
    echo "<h1>Personne ne suis " . $user . ".<h1>";
}

afficher_pied_page();
