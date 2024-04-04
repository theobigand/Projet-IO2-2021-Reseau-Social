<?php
session_start();
require_once("Affichage.php");

function connexion_bd()         //Fonction qui permet de se connecter à la base de données
{
    $serv = "localhost";
    $username = "root";
    $pwd = "";
    $bd = "dbProject";
    $conn = mysqli_connect($serv, $username, $pwd, $bd);
    if (!$conn) {
        die("Connexion impossible: " . mysqli_connect_error());
        exit;
    }
    return $conn;
}


function enregistrement(&$donnees)      //Fonction qui met les données d'un utilisateur dans la base de données lorsqu'il s'inscrit
{
    $conn = connexion_bd();
    $user = mysqli_real_escape_string($conn, $donnees['user']);
    $email = mysqli_real_escape_string($conn, $donnees['email']);
    $mdp = mysqli_real_escape_string($conn, $donnees['mdp']);
    $mdp = password_hash($mdp, PASSWORD_DEFAULT);
    $req = "INSERT INTO Users VALUES ('$user','$mdp','$email','Default.jpg', '0','T')";
    $resultat = mysqli_query($conn, $req);
    if (!$resultat)
        die("Erreur dans l'exectution de la requete: " . mysqli_error($conn));
    $_SESSION['user'] = $user;
    $_SESSION['email'] = $email;

    mysqli_close($conn);
}

function choixstyle($donnees)       //Fonction qui choisie le style qui correspond au résultat du questionaire lors de l'inscription
{
    $conn = connexion_bd();
    $userco = $_SESSION['user'];
    $c = 0;
    foreach ($donnees as $i => $var) {
        if ($var == 1) {
            $c++;
        }
    }
    if ($c >= 4) {
        $style = "E";
    } else if ($c >= 2) {
        $style = "G";
    } else {
        $style = "N";
    }
    $req = "UPDATE Users SET style='$style' WHERE username = '$userco'";
    $resultat = mysqli_query($conn, $req);
    if (!$resultat)
        die("Erreur dans l'exectution de la requete: " . mysqli_error($conn));
    $_SESSION['style'] = $style;

    mysqli_close($conn);
}

function changement($donnees)       //Fonction qui modifie les données d'un utilisateur après qu'il ai modifier son profil
{
    $conn = connexion_bd();
    $userco = $_SESSION['user'];
    $user = mysqli_real_escape_string($conn, $donnees['user']);
    $email = mysqli_real_escape_string($conn, $donnees['email']);
    $avatar = mysqli_real_escape_string($conn, $donnees['avatar']);
    $req = "UPDATE chat SET envoyeur='$user' WHERE envoyeur='$userco'";
    $result = mysqli_query($conn, $req);
    mysqli_free_result($result);
    $req = "UPDATE chat SET destinataire='$user' WHERE destinataire='$userco'";
    $result = mysqli_query($conn, $req);
    mysqli_free_result($result);
    $req = "UPDATE Favoris SET liked_by='$user' WHERE liked_by='$userco'";
    $result = mysqli_query($conn, $req);
    mysqli_free_result($result);
    $req = "UPDATE Follow SET username='$user' WHERE username='$userco'";
    $result = mysqli_query($conn, $req);
    mysqli_free_result($result);
    $req = "UPDATE Follow SET following='$user' WHERE following='$userco'";
    $result = mysqli_query($conn, $req);
    mysqli_free_result($result);
    $req = "UPDATE Publication SET username='$user' WHERE username='$userco'";
    $result = mysqli_query($conn, $req);
    mysqli_free_result($result);
    if ($donnees['style'] != "") {
        $style = $donnees['style'];
        $req = "UPDATE Users SET style='$style' WHERE username= '$userco'";
        $result = mysqli_query($conn, $req);
        mysqli_free_result($result);
        $_SESSION['style'] = $style;
    }
    if ($donnees['mdp'] != "") {
        $mdp = mysqli_real_escape_string($conn, $donnees['mdp']);
        $mdp = password_hash($mdp, PASSWORD_DEFAULT);
        $req = "UPDATE Users SET username = '$user', mdp = '$mdp', email = '$email', avatar = '$avatar' WHERE username = '$userco'";
    } else {
        $req = "UPDATE Users SET username = '$user', email = '$email', avatar = '$avatar' WHERE username = '$userco'";
    }
    $resultat = mysqli_query($conn, $req);
    if (!$resultat)
        die("Erreur dans l'exectution de la requete: " . mysqli_error($conn));
    $_SESSION['user'] = $user;
    $_SESSION['email'] = $email;


    mysqli_close($conn);
}

function insert_publi($donnee)      //Fonction qui met dans la base de données la publication d'un utilisateur
{
    $conn = connexion_bd();
    $publi = mysqli_real_escape_string($conn, $donnee['publi']);
    $username = mysqli_real_escape_string($conn, $_SESSION["user"]);
    $last_id = mysqli_insert_id($conn);
    $req = "INSERT INTO Publication VALUES ('$last_id','$username','$publi')";
    $result = mysqli_query($conn, $req);
    if (!$result)
        die("Erreur dans l'exectution de la requete: " . mysqli_error($conn));
    mysqli_close($conn);
}


function insert_message($donnee)    //Fonction qui met dans la base de données le message priver d'un utilisateur
{
    $conn = connexion_bd();
    $msg = mysqli_real_escape_string($conn, $donnee['msg']);
    $user1 = mysqli_real_escape_string($conn, $_SESSION["user"]);
    $user2 = mysqli_real_escape_string($conn, $donnee['user2']);
    $last_id = mysqli_insert_id($conn);
    $req = "INSERT INTO Chat VALUES ('$last_id','$user1','$user2','$msg')";
    $result = mysqli_query($conn, $req);
    if (!$result)
        die("Erreur dans l'exectution de la requete: " . mysqli_error($conn));
    mysqli_close($conn);
}
