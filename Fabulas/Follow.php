<?php
require_once("Conn_bd.php");
$conn = connexion_bd();
$userco = $_SESSION["user"];
$userinf = $_GET["user"];
$req = "SELECT * FROM Users WHERE username='$userco'";
$result = mysqli_query($conn, $req);
$userco = mysqli_fetch_assoc($result);
mysqli_free_result($result);
$req = "SELECT * FROM Users WHERE username ='$userinf'";
$result = mysqli_query($conn, $req);
$userinfo = mysqli_fetch_assoc($result);


if ($userinfo['username'] != $userco['username']) {
    $usrco = $userco['username'];
    $usrinf = $userinfo['username'];

    $req = ("SELECT * FROM follow WHERE username = '$usrco' AND following = '$usrinf'");
    $dejafollowed = mysqli_query($conn, $req);

    if (mysqli_num_rows($dejafollowed) == 0) {      //Vérifie si un utilistaeur a follow un autre utilisateur ou non puis le follow ou enlève l'unfollow en conséquence
        $req = "INSERT INTO Follow value ('$usrco','$usrinf')";
        mysqli_query($conn, $req);
    } else if (mysqli_num_rows($dejafollowed) == 1) {
        $req = "DELETE FROM Follow WHERE username = '$usrco' AND following = '$usrinf' ";
        mysqli_query($conn, $req);
    }
}
mysqli_close($conn);
header('Location: ' . $_SERVER['HTTP_REFERER']);
