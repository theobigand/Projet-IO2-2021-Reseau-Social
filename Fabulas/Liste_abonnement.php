<?php
require_once("Conn_bd.php");
afficher_entete("Abonné(s)");
$conn = connexion_bd();
$user = $_GET['user'];
$req = "SELECT * FROM Follow WHERE username = '$user'";
$result = mysqli_query($conn, $req);
while ($follow = mysqli_fetch_assoc($result)) {
    $tabfollow[] = $follow['following'];
}
if (!empty($tabfollow)) {
    echo "<h1>Voici la liste des personnes que " . $user . " suis.</h1>";
    foreach ($tabfollow as $i => $var) {
        echo '<h2><a href="Profil.php?user=' . $var . '">' . $var . '</a></h2>';
    }
} else {
    echo "<h1>" . $user . " ne suis personne.<h1>";
}

afficher_pied_page();
