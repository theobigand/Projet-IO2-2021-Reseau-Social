<?php

require_once("Conn_bd.php");
afficher_entete("Chat");

$user1 = $_GET['userE'];
$user2 = $_GET['userD'];

?>

<div class="form-control">
    <?php
    $erreur = "";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $donnees = $_POST;
        if (verif_post($donnees)) {     //Vérifie si le message est correct puis le met dans la base de données des messages priver
            $donnees = array("user1" => $user1, "user2" => $user2, "msg" => $_POST['publi']);
            insert_message($donnees);
            header('Location: Chat.php?userE=' . $user1 . '&userD=' . $user2);
        } else {
            $erreur = erreurs_post($donnees);
        }
    }
    $conn = connexion_bd();     //Séletionne les messages priver entre 2 utilisateurs précis puis les affiches
    $req = "SELECT * FROM Chat WHERE (envoyeur = '$user1' AND destinataire = '$user2') OR (envoyeur = '$user2' AND destinataire = '$user1') ORDER BY id DESC";
    $result = mysqli_query($conn, $req);

    mysqli_close($conn);
    afficher_createPost($erreur);
    afficher_pm($result);
    afficher_pied_page();
    ?>
</div>