<?php
require_once("Conn_bd.php");

$conn = connexion_bd();
$userco = $_SESSION["user"];
$userinf = $_GET["user"];
$req = "SELECT * FROM Users WHERE username ='$userinf'";
$result = mysqli_query($conn, $req);
$userinfo = mysqli_fetch_assoc($result);
mysqli_free_result($result);


$req = "SELECT * FROM users WHERE username = '$userco' AND admin = '2'";
$result = mysqli_query($conn, $req);
$isadminplus = mysqli_num_rows($result);
mysqli_free_result($result);
$req = "SELECT * FROM users WHERE username = '$userinf' AND admin = '2'";
$result = mysqli_query($conn, $req);
$isadminp = mysqli_num_rows($result);
mysqli_free_result($result);


afficher_entete("Profil " . $userinf);
echo "<h1>" . $userinf . "</h1>";
echo "<img src='membres/avatar/" . $userinfo['avatar'] . "' width='150' alt='' /> <br><br>";
if (strcasecmp($userinf, $userco) != 0) {
    $req = ("SELECT * FROM follow WHERE username = '$userco' AND following = '$userinf'");
    $result = mysqli_query($conn, $req);
    $isfollowing = mysqli_num_rows($result);
    mysqli_free_result($result);
    if ($isfollowing != 0) {        //Vérifie si l'utilisateur follow un autre ou non
        echo "<a href='Follow.php?user=" . $userinf . "'>Se désabonner</a><br><br>";
    } else {
        echo "<a href='Follow.php?user=" . $userinf . "'>S'abonner</a><br><br>";
    }
} else {
    echo "<a href='EditProfil.php'>Editer mon profil</a><br><br>";
}

if ($isadminplus != 0 && $isadminp != 1 && $userco != $userinf) {
    $req = "SELECT * FROM users WHERE username = '$userinf' AND admin = '1'";
    $result = mysqli_query($conn, $req);
    $isadmin = mysqli_num_rows($result);
    mysqli_free_result($result);
    if ($isadmin != 0) {        //Vérifie si un utilisateur est admin ou non
        echo "<a href='Admin.php?user=" . $userinf . "'>Enlever l'admin</a><br><br>";
    } else {
        echo "<a href='Admin.php?user=" . $userinf . "'>Rendre admin</a><br><br>";
    }
}

$req = "SELECT * FROM follow WHERE following = '$userinf' ";
$result = mysqli_query($conn, $req);
$nbfollow = mysqli_num_rows($result);
mysqli_free_result($result);
$req = "SELECT * FROM follow WHERE username = '$userinf' ";
$result = mysqli_query($conn, $req);
$nbfollowing = mysqli_num_rows($result);
mysqli_free_result($result);
?>
<p class='form-abo'><a href="Liste_abonne.php?user=<?= $userinf ?>">Abonné(s)</a> : <?= $nbfollow ?></p>
<p class='form-abo'><a href="Liste_abonnement.php?user=<?= $userinf ?>">Abonnement(s)</a> : <?= $nbfollowing ?></p>
<p class="form-control">Pseudo: <?= $userinfo['username']; ?></p>
<p class="form-control">Mail: <?= $userinfo['email']; ?></p><br />
<a href="mesPubli.php?user=<?= $_GET['user']; ?>" class="form-control">Publication(s)</a>

<?php
mysqli_close($conn);
afficher_pied_page();
