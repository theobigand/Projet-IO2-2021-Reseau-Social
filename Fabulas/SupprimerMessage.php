<?php
require_once("Conn_bd.php");

$conn = connexion_bd();
$idpost = $_GET['id'];
$user1 = $_GET['userE'];
$user2 = $_GET['userD'];
$userco = $_SESSION['user'];
$req = "SELECT * FROM users WHERE username = '$userco'";
$result = mysqli_query($conn, $req);

if ($_SESSION['user'] == $_GET['userE'] or ($result && mysqli_num_rows($result) == 1)) {        //Vérifie si l'utilisateur connecter est celui à qui appartient le message et le supprime
    mysqli_free_result($result);
    $req = "DELETE  FROM Chat WHERE id = '$idpost' ";
    $result = mysqli_query($conn, $req);
    $userp = "Chat.php?userE=" . $user1 . "&userD=" . $user2;
    header("Location: $userp");
}
mysqli_close($conn);
