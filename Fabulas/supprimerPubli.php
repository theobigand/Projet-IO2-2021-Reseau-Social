<?php
require_once("Conn_bd.php");

$conn = connexion_bd();
$idpost = $_GET['id'];
$userpost = $_GET['user'];
$userco = $_SESSION['user'];
$req = "SELECT * FROM users WHERE username = '$userco' AND admin > '0'";
$result = mysqli_query($conn, $req);

if ($_SESSION['user'] == $_GET['user'] or ($result && mysqli_num_rows($result) == 1)) {     //Vérifie si un post appartient a l'utilisateur connecter ou si l'utilisateur est admin ou non pour ensuite supprimer la publication
    mysqli_free_result($result);
    $req = "DELETE  FROM Publication WHERE id = '$idpost' ";
    $result = mysqli_query($conn, $req);
    $userp = "mesPubli.php?user=" . $userpost;
    header("Location: $userp");
}
mysqli_close($conn);
