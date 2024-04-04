<?php
require_once("Conn_bd.php");

$conn = connexion_bd();
$userco = $_SESSION['user'];
$req = "SELECT * FROM Users WHERE username ='$userco'";
$result = mysqli_query($conn, $req);
if ($result)
    $donneesUser = mysqli_fetch_assoc($result);
mysqli_close($conn);

$donnees = array('user' => $donneesUser['username'], 'email' => $donneesUser['email'], 'avatar' => $donneesUser['avatar']);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $donnees = $_POST;
    if (isset($_FILES['avatar']['name']) && $_FILES['avatar']['name'] != "") {      //Copie de l'image choisi pour l'avatar et change son nom en la mettant dans le bon dossier
        $filext = substr(strrchr($_FILES['avatar']['name'], '.'), 0);
        $d = new DateTime();
        $timezone = new DateTimeZone('Europe/Paris');
        $d->setTimezone($timezone);
        $date = $d->format("Y-m-d H:i:s.v");
        move_uploaded_file($_FILES['avatar']['tmp_name'], "membres/avatar/" . $donnees['user'] . $date . $filext);
        $donnees['avatar'] = $donnees['user'] . $date . $filext;
    } else {
        $donnees['avatar'] = $donneesUser['avatar'];
    }
    if (verif_edit($donnees)) {     //Verifie si les changement du profil son correct et si c'est le cas fait le changement dans la base de donnée
        print_r($donnees);
        changement($donnees);
        header('Location: Profil.php?user=' . $donnees['user']);
        exit;
    }
    page_edit($donnees, 1);
} else {
    page_edit($donnees, 0);
}
