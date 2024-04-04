<?php

require_once("Verification.php");
verif_log();

function afficher_entete($titre)    //Fonction d'entete pour toutes les pages
{ ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title> <?= $titre ?> - Fabulas </title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style<?php echo $_SESSION['style'] ?>.css" media="screen" type="text/css" />
        <link rel="icon" href="logo.png" type="image/icon type" width="30">
    </head>

    <body>
        <?php if ($titre != "Login" && $titre != "Sign Up" && $titre != "Quizz") { ?>
            <div class="header">
                <div class="header-left">
                    <a href="Deconnexion.php">Deconnexion</a><br><br>
                    <?php $titlePro = explode(" ", $titre);
                    if ($titlePro[0] != "Profil" || ($titlePro[0] == "Profil" && $titlePro[1] != $_SESSION['user'])) { ?>
                        <a href="Profil.php?user=<?php if (isset($_SESSION['user'])) {
                                                        echo $_SESSION['user'];
                                                    } ?>">Mon Profil</a><br><br>
                    <?php }
                    if ($titre != "Home") { ?>
                        <a href="Home.php" id="left">Acceuil</a><br><br>
                        <?php }
                    if ($titre != "Reception") {
                        if ($_SESSION['style'] == 'N') {
                        ?><a href="Reception.php"><img src='message_white.png' width='28' alt='Message priver'></a><br><br><?php } else { ?>
                            <a href="Reception.php"><img src='message.png' width='28' alt='Message priver'></a><br><br>
                    <?php }
                                                                                                                    } ?>
                </div>
                <form action="Search.php" method="post">
                    <input type="text" class="form-recherche" name="search" placeholder="Search">
                    <input type="hidden" name="page" value="<?php $usr = "";
                                                            if (isset($_GET['user'])) {
                                                                $usr = "?user=" . $_GET['user'];
                                                            }
                                                            echo basename($_SERVER['PHP_SELF']) . $usr ?>">
                    <input type="image" class="form-image" width="28" src="loupe.png" alt="submit" name="submit-search">
                </form>
            </div>
        <?php } ?>
        <main class="form-signin">
        <?php
    }

    function afficher_pied_page()   //Fonction de pied de page pour toutes les pages
    { ?>
        </main>
    </body>

    </html>
<?php
    }


    function afficher_formulaire(&$donnees, &$erreurs)  //Fonction qui affiche le formulaire d'inscription
    {
?>
    <form method="POST">

        <h1 class="Titre">INSCRIPTION</h1>
        <input type="text" class="form-control" placeholder="Pseudo" name="user" size=20 value="<?php if (isset($donnees['user']) && !isset($erreurs['user'])) {
                                                                                                    echo htmlspecialchars($donnees['user']);
                                                                                                } ?>">
        <span class=" error"> <?php if (isset($erreurs['user'])) {
                                    echo $erreurs['user'];
                                } ?></span>
        <input type="text" class="form-control" placeholder="Adresse Mail" name="email" value="<?php if (isset($donnees['email']) && !isset($erreurs['email'])) {
                                                                                                    echo htmlspecialchars($donnees['email']);
                                                                                                } ?>">
        <span class="error"> <?php if (isset($erreurs['email'])) {
                                    echo $erreurs['email'];
                                }
                                ?></span>
        <input type="password" class="form-control" placeholder="Mot de Passe" name="mdp">
        <span class="error"> <?php if (isset($erreurs['mdp'])) {
                                    echo $erreurs['mdp'];
                                } ?></span>
        <input type="password" class="form-control" placeholder="Confirmer le Mot de Passe" name="mdp2">
        <span class="error"> <?php if (isset($erreurs['mdp2'])) {
                                    echo $erreurs['mdp2'];
                                } ?></span>
        <input type="submit" name="send" class="form-button" value="S'enregistrer" />

    </form>
<?php
    }

    function afficher_formulaire_login(&$donnees, &$erreurs)    //Fonction qui affiche le formuaire de connexion
    {
?>
    <form method="POST">

        <h1 class="Titre">CONNEXION</h1>
        <input type="text" class="form-control" placeholder="Pseudo ou Adresse mail" name="user">
        <span class=" error"> <?php if (isset($erreurs['user'])) {
                                    echo $erreurs['user'];
                                } ?></span>
        <input type="password" class="form-control" placeholder="Mot de Passe" name="mdp">
        <span class="error"> <?php if (isset($erreurs['mdp'])) {
                                    echo $erreurs['mdp'];
                                } ?></span>
        <input type="submit" name="send" class="form-button" value="Se connecter" />

        <a href="SignUp.php">Aucun compte ? Inscrivez vous !</a>


    </form>
<?php
    }

    function afficher_formulaire_edit(&$donnees, &$erreurs)     // Fonction qui affiche le formulaire d'edition du profil
    { ?>
    <form method="POST" action="" enctype="multipart/form-data">
        <h1 class="Titre">Edition Profil</h1>
        <input type="text" name="user" class="form-control" placeholder="Pseudo" value="<?php if (isset($donnees['user'])) {
                                                                                            echo htmlspecialchars($donnees['user']);
                                                                                        } ?>">
        <span class=" error"> <?php if (isset($erreurs['user'])) {
                                    echo $erreurs['user'];
                                } ?></span>
        <input type="text" name="email" class="form-control" placeholder="Adresse Mail" value="<?php if (isset($donnees['email'])) {
                                                                                                    echo htmlspecialchars($donnees['email']);
                                                                                                } ?>">
        <span class=" error"> <?php if (isset($erreurs['email'])) {
                                    echo $erreurs['email'];
                                }
                                ?></span>
        <input type="password" name="mdp" class="form-control" placeholder="Mot de Passe" />
        <span class="error"> <?php if (isset($erreurs['mdp'])) {
                                    echo $erreurs['mdp'];
                                } ?></span>
        <input type="password" name="mdp2" class="form-control" placeholder="Confirmer le Mot de Passe" />
        <span class="error"> <?php if (isset($erreurs['mdp2'])) {
                                    echo $erreurs['mdp2'];
                                } ?></span>
        <div class="input-file-container">
            <input type="file" class="input-file" id="my-file" name="avatar">
            <label for="my-file" class="input-file-trigger" tabindex="0">
                Choisir une photo
            </label>
            <br>
        </div>
        <span class="error"> <?php if (isset($erreurs['avatar'])) {
                                    echo $erreurs['avatar'];
                                } ?></span>

        <select name="style" class="form-style" size="1">
            <option value="">Choisir un thème</option>
            <option value="N">Style nordique</option>
            <option value="G">Style grec</option>
            <option value="E">Style egyptien</option>
        </select>
        <input type="submit" name="send" class="form-button" value="Metre a jour mon profil">

    </form>
<?php }

    function afficher_createPost($erreur)   //Fonction qui affiche le formulaire pour faire un post
    {
?> <form method="POST">
        <p class="form-feed">Publier du contenu.</p>
        <input type="text" class="form-publi" name="publi" placeholder="Publication">
        <span class="error"> <?php if (isset($erreur['publi'])) {
                                    echo $erreur['publi'];
                                } ?></span>
        <input class="form-publier" type="submit" name="send-publi" value="Publier">
    </form>
    <?php }

    function afficher_feed($resultat)   //Fonction qui affiche le fil des posts des gens que l'on suis dans la page accueil
    {
        $conn = connexion_bd();
        $userco = $_SESSION['user'];
        $req = "SELECT * FROM follow WHERE username = '$userco'";
        $result = mysqli_query($conn, $req);
        while ($follow = mysqli_fetch_assoc($result)) {
            $tabfollow[] = $follow['following'];
        }
        if (!empty($tabfollow) || mysqli_num_rows($resultat) > 0) {
            while ($post = mysqli_fetch_assoc($resultat)) {
                if (empty($tabfollow)) {
                    $tabfollow = array();
                }
                if (in_array($post['username'], $tabfollow) or $post['username'] == $_SESSION['user']) { ?>
                <div class="form-feed"><?php echo '<b>' . htmlspecialchars($post["username"]) . '</b>' . ": " . htmlspecialchars($post["post"]) . "<br />";
                                        $id = $post['id'];
                                        $req = "SELECT * FROM Favoris WHERE id_post = '$id' ";
                                        $result = mysqli_query($conn, $req);
                                        $nblike = mysqli_num_rows($result);
                                        mysqli_free_result($result);

                                        $req = ("SELECT * FROM Favoris WHERE id_post = '$id' AND liked_by = '$userco'");
                                        $resultat2 = mysqli_query($conn, $req);
                                        $isliked = mysqli_num_rows($resultat2);
                                        mysqli_free_result($resultat2);
                                        if ($isliked != 0) {
                                            echo "<a href='Like.php?idPost=" . $id . "'><img src ='liked.png' width='28' alt='Unlike'></a>" . $nblike . "<br>";
                                        } else {
                                            echo "<a href='Like.php?idPost=" . $id . "'><img src ='like.png'width='28' alt='Like'></a>" . $nblike . "<br>";
                                        } ?> </div>
        <?php }
            }
        } else {
            echo "Vous ne suivez personne.";
        }
    }
    function afficher_feed2($resultat)      //Fonction qui affiche le fil des posts d'une certaine personne
    {
        while ($post = mysqli_fetch_assoc($resultat)) { ?>
        <div class="form-feed"> <?= htmlspecialchars($post["post"]); ?> </div>
        <?php $id = $post['id'];
            $conn = connexion_bd();
            $userco = $_SESSION['user'];
            $req = "SELECT * FROM users WHERE username = '$userco' AND admin > '0'";
            $result = mysqli_query($conn, $req);
            if ($_SESSION['user'] == $post['username'] or ($result && mysqli_num_rows($result) == 1)) { ?>
            <a href="supprimerPubli.php?id=<?php echo $id . "&user=" . $post['username']; ?>">Supprimer ce post.</a>
        <?php }
        }
    }

    function afficher_pm($resultat)     //Fonction qui affiche les messages priver entre 2 personnes
    {
        while ($post = mysqli_fetch_assoc($resultat)) { ?>
        <div class="form-feed"><?php echo '<b>' . htmlspecialchars($post["envoyeur"]) . '</b>' . ": " . htmlspecialchars($post["message"]) . "<br />"; ?> </div>
        <?php $id = $post['id'];
            $conn = connexion_bd();
            $userco = $_SESSION['user'];
            if ($_SESSION['user'] == $post['envoyeur']) { ?>
            <a href="SupprimerMessage.php?id=<?php echo $id . "&userE=" . $post['envoyeur'] . "&userD=" . $post['destinataire']; ?>">Supprimer ce message.</a>
    <?php }
        }
    }

    function page_signUp(&$donnees, $time)      //Fonction qui fait les appels pour afficher toute la page d'enregistrement
    {
        Afficher_entete("Sign Up");
        if ($time != 0) {
            $erreurs = erreurs($donnees);
        }
        afficher_formulaire($donnees, $erreurs);
        echo 'Déjà un compte ? <a href="Login.php" >Se connecter</a>';
        afficher_pied_page();
    }

    function page_login(&$donnees, $time)       //Fonction qui fait les appels pour afficher toute la page de connexion
    {
        Afficher_entete("Login");
        if ($time != 0) {
            $erreurs = erreurs_login($donnees);
        }
        afficher_formulaire_login($donnees, $erreurs);
        afficher_pied_page();
    }

    function page_edit(&$donnees, $time)        //Fonction qui fait les appels pour afficher toute la page d'édition dur profil
    {
        Afficher_entete("Edit");
        if ($time != 0) {
            $erreurs = erreurs_edit($donnees);
        }
        afficher_formulaire_edit($donnees, $erreurs);
        afficher_pied_page();
    }

    function liste_follow()     //Fonction qui affiche la liste des gens que l'on suit pour pouvoir leur envoyer un message priver
    {
        $conn = connexion_bd();
        $userco = $_SESSION['user'];
        $req = "SELECT * FROM Follow WHERE username = '$userco'";
        $result = mysqli_query($conn, $req);
        while ($follow = mysqli_fetch_assoc($result)) {
            $tabfollow[] = $follow['following'];
        }
        mysqli_free_result($result);
        $req = "SELECT * FROM Follow WHERE following = '$userco'";
        $result = mysqli_query($conn, $req);
        while ($follower = mysqli_fetch_assoc($result)) {
            $tabfollower[] = $follower['username'];
        }
        if (!empty($tabfollow) && !empty($tabfollower)) {
            echo "<h1>Voici la liste des personnes avec qui vous pouvez envoyer un message.</h1>";
            foreach ($tabfollow as $i => $var) {
                if (in_array($var, $tabfollower)) {
                    echo '<h2><a href="Chat.php?userE=' . $userco . '&userD=' . $var . '">' . $var . '</a></h2>';
                }
            }
        }
        $c = 0;
        if (empty($tabfollow))
            $tabfollow = array();
        foreach ($tabfollow as $i => $var) {
            if (in_array($var, $tabfollower))
                $c++;
        }
        if ($c == 0)
            echo "<h1>Vous n'avez personne à qui envoyer un message.</h1>";
    }

    function afficher_quizz()   //Fonction qui affiche le quizz pour choisir un thème pendant l'inscription
    { ?>
    <form method="POST">

        <h1 class="Titre">QUIZZ</h1>
        <p>Voici quelques questions qui vont permettre de choisir votre thème de base (vous pourrez le changez pas la suite).</p>

        <p>Appréciez vous le bricolage, la construction ou autre activité manuelle créatives ? </p>
        Non:<input type="radio" name="q1" value="0" checked> Oui:<input type="radio" name="q1" value="1">


        <p>Aimez-vous l'art, les peintures et autres chef d'oeuvres ? </p>
        Non:<input type="radio" name="q2" value="0" checked> Oui:<input type="radio" name="q2" value="1">


        <p>Etes vous contre la chasse des animaux ? </p>
        Non:<input type="radio" name="q3" value="0" checked> Oui:<input type="radio" name="q3" value="1">


        <p>Aimez-vous le travail collectif basé sur l'entraide ? </p>
        Non:<input type="radio" name="q4" value="0" checked> Oui:<input type="radio" name="q4" value="1">


        <p>Si une créature fantastique surgis devant vous, tenter vous de devenir son ami ? </p>
        Non:<input type="radio" name="q5" value="0" checked> Oui:<input type="radio" name="q5" value="1"><br><br>
        <input class="form-publier" type="submit" name="send-style" value="Envoyer">

    </form>
<?php }

    function page_quizz()   //Fonction qui fait les appels pour afficher toute la page de quizz
    {
        afficher_entete("Quizz");
        afficher_quizz();
        afficher_pied_page();
    }
