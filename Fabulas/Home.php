<?php
require_once("Conn_bd.php");

afficher_entete("Home");

echo '<h1>Bonjour ' . $_SESSION["user"] . '</h1>';
?>
<div class="form-control">
    <?php
    $erreur = "";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $donnees = $_POST;
        if (verif_post($donnees)) {     //Vérifie si le post est correct et le met dans la base de données
            insert_publi($donnees);
            header('Location: Home.php');   //'Rafraichit' la page pour éviter de renvoyer le message si l'utilisateur rafraitchit la page lui-même
        } else {
            $erreur = erreurs_post($donnees);
        }
    }
    $conn = connexion_bd();
    $req = 'SELECT * FROM Publication ORDER BY id DESC';
    $result = mysqli_query($conn, $req);

    mysqli_close($conn);
    afficher_createPost($erreur);       //Affiche la zone pour écrire et envoyer son post et affiche le fil d'actualiter de l'utilisateur
    afficher_feed($result);
    afficher_pied_page();
    ?>
</div>