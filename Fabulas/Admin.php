<?php
require_once("Conn_bd.php");
$conn = connexion_bd();
$userinf = $_GET["user"];
$req = "SELECT * FROM users WHERE username = '$userinf' AND admin = '1'";
$result = mysqli_query($conn, $req);
$isadmin = mysqli_num_rows($result);
mysqli_free_result($result);
if ($isadmin != 0) {    //Verifie si l'utilisateur est déjà admin ou non
    $req = "UPDATE Users  SET admin ='0' WHERE username='$userinf'";
    mysqli_query($conn, $req);
} else {
    $req = "UPDATE Users SET admin ='1' WHERE username='$userinf'";
    mysqli_query($conn, $req);
}
mysqli_close($conn);
header('Location: ' . $_SERVER['HTTP_REFERER']);
