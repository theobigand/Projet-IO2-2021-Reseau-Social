<?php

function verif_log()    //Fonction qui vérifie l'utilisteur est conencter ou non
{
    if (!isset($_SESSION['user']) && (basename($_SERVER['REQUEST_URI'], ".php") != "Login" && basename($_SERVER['REQUEST_URI'], ".php") != "SignUp" && basename($_SERVER['REQUEST_URI'], ".php") != "Quizz")) {
        $_SESSION['style'] = "T";
        header("Location: Login.php");
    }
}

function verif_login(&$donnees)     //Fonction qui vérifie s'il n'y a pas d'erreur dans ce qu'a rentrer l'utilisteur pour se connecter
{
    $err = erreurs_login($donnees);
    foreach ($donnees as $i => $val) {
        if (!empty($err[$i])) {
            return false;
        }
    }
    return true;
}

function verif_signup(&$donnees)    //Fonction qui vérifie s'il n'y a pas d'erreur dans ce qu'a rentrer l'utilisteur pour se s'inscrire
{
    $err = erreurs($donnees);
    foreach ($donnees as $i => $val) {
        if (!empty($err[$i])) {
            return false;
        }
    }
    return true;
}

function verifier_login_bd($user, $mdp)     //Fonction qui vérifie si les identifiants donner par l'utilisateur correspondent à un utilisateur dans la base de donnée
{
    $conn = connexion_bd();
    $user = mysqli_real_escape_string($conn, $user);
    $mdp = mysqli_real_escape_string($conn, $mdp);
    $req = "SELECT * FROM Users WHERE username = '$user' OR email ='$user'";
    $resultat = mysqli_query($conn, $req);
    if ($resultat && mysqli_num_rows($resultat) == 1) {
        $ligne = mysqli_fetch_assoc($resultat);
        $hash = $ligne['mdp'];
        if (password_verify($mdp, $hash)) {
            $_SESSION['user'] = $ligne['username'];
            $_SESSION['email'] = $ligne['email'];
            $_SESSION['style'] = $ligne['style'];
        } else {
            mysqli_close($conn);
            return !$resultat;
        }
    }
    mysqli_close($conn);
    return mysqli_num_rows($resultat) == 1;
}

function verif_requis($donnees, &$erreur)       //Fonction qui vérifie si l'utilisteur à bien remplis tous les champs requis
{
    $requis = true;
    foreach ($donnees as $i => $val) {
        if (empty(trim($donnees[$i]))) {
            $requis = false;
        } else {
            $erreur[$i] = "";
        }
    }
    return $requis;
}

function erreurs($donnees)      //Fonction qui renvoie toutes les possibles erreurs dans ce que l'utilisateur à rentrer pendant son inscription
{
    $erreur = array("user" => "Ce champ est requis !", "mdp" => "Ce champ est requis !", "mdp2" => "Ce champ est requis !", "email" => "Ce champ est requis !");
    if (verif_requis($donnees, $erreur)) {
        $erreur = array();
        $conn = connexion_bd();
        $user = mysqli_real_escape_string($conn, $donnees['user']);
        $req = "SELECT * FROM Users WHERE username ='$user'";
        $resultat = mysqli_query($conn, $req);
        if (strlen($donnees["user"]) > 20)
            $erreur["user"] = "Ce pseudo dépasse la limite de 20 charactères !";
        else if (!$resultat || mysqli_num_rows($resultat) != 0)
            $erreur["user"] = "Ce pseudo n'est pas disponible !";
        mysqli_free_result($resultat);
        if (!preg_match('/(?=.*\W)(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,32}/', $donnees["mdp"])) {
            $erreur["mdp"] = "Le mot de passe doit être entre 8 et 24 charactères et contenir au moins une minuscule, une majuscule, un chiffre et un charactère spécial !";
        }
        if (($donnees["mdp"] != $donnees["mdp2"])) {
            $erreur["mdp2"] = "Les mots de passe sont differents !";
        }
        if (!filter_var($donnees["email"], FILTER_VALIDATE_EMAIL)) {
            $erreur["email"] = "Le format de l'email n'est pas valide";
        } else {
            $email = mysqli_real_escape_string($conn, $donnees['email']);
            $req = "SELECT * FROM Users WHERE email ='$email'";
            $resultat = mysqli_query($conn, $req);
            if (!$resultat || mysqli_num_rows($resultat) != 0)
                $erreur["email"] = 'Ce mail est déjà utilisé. <br/> <a href="Login.php">Voulez-vous vous connecter ?</a>';
        }
        mysqli_close($conn);
    }
    return $erreur;
}

function erreurs_login($donnees)        //Fonction qui renvoie toutes les possibles erreurs dans ce que l'utilisateur à rentrer pendant sa connexion
{
    $erreur = array("user" => "Ce champ est requis !", "mdp" => "Ce champ est requis !");
    if (verif_requis($donnees, $erreur)) {
        $erreur = array();
        if (!verifier_login_bd($donnees['user'], $donnees['mdp']))
            $erreur = array("mdp" => "Username ou mot de passe faux !");
    }
    return $erreur;
}

function erreurs_edit($donnees)         //Fonction qui renvoie toutes les possibles erreurs dans ce que l'utilisateur à rentrer pendant la modification de son profil
{
    $erreur = array();
    $conn = connexion_bd();
    $user = mysqli_real_escape_string($conn, $donnees['user']);
    $req = "SELECT * FROM Users WHERE username ='$user'";
    $resultat = mysqli_query($conn, $req);

    if (strlen($donnees["user"]) > 20)
        $erreur["user"] = "Ce pseudo dépasse la limite de 20 charactères !";
    else if ((!$resultat || mysqli_num_rows($resultat) != 0) && $donnees['user'] != $_SESSION['user'])
        $erreur["user"] = "Ce pseudo n'est pas disponible !";
    mysqli_free_result($resultat);

    if ($donnees['mdp'] != "") {
        if (!preg_match('/(?=.*\W)(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,32}/', $donnees["mdp"])) {
            $erreur["mdp"] = "Le mot de passe doit être entre 8 et 24 charactères et contenir au moins une minuscule, une majuscule, un chiffre et un charactère spécial !";
        }
        if (($donnees["mdp"] != $donnees["mdp2"])) {
            $erreur["mdp2"] = "Les mots de passe sont differents !";
        }
    }

    if (!filter_var($donnees["email"], FILTER_VALIDATE_EMAIL)) {
        $erreur["email"] = "Le format de l'email n'est pas valide";
    } else {
        $email = mysqli_real_escape_string($conn, $donnees['email']);
        $req = "SELECT * FROM Users WHERE email ='$email'";
        $resultat = mysqli_query($conn, $req);
        if ((!$resultat || mysqli_num_rows($resultat) != 0) && $donnees['email'] != $_SESSION['email'])
            $erreur["email"] = 'Ce mail est déjà utilisé.';
    }


    $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
    $extensionUpload = substr(strrchr($donnees['avatar'], '.'), 1);
    if (!in_array($extensionUpload, $extensionsValides)) {
        $erreur["avatar"] = "Le format de l'image n'est pas conforme.";
    }
    mysqli_close($conn);
    return $erreur;
}

function verif_edit($donnees)   //Fonction qui vérifie s'il n'y a pas d'erreur dans ce qu'a rentrer l'utilisteur lorsqu'il modifie son profil
{
    $err = erreurs_edit($donnees);
    foreach ($donnees as $i => $val) {
        if (!empty($err[$i])) {
            return false;
        }
    }
    return true;
}

function verif_post($donnees)       //Fonction qui vérifie s'il n'y a pas d'erreur dans le post d'un utilisateur
{
    $err = erreurs_post($donnees);
    foreach ($donnees as $i => $val) {
        if (!empty($err[$i])) {
            return false;
        }
    }
    return true;
}

function erreurs_post($donnees)     //Fonction qui renvoie les possibles erreurs d'un utilisateur peut avoir fait dans son post
{
    $erreur = array("publi" => "Un post doit faire entre 1 et 300 charactères.");
    if (strlen($donnees['publi']) > 0 && strlen($donnees['publi']) < 301)
        $erreur = array();
    return $erreur;
}
