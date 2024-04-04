<?php
require_once("Conn_bd.php");
$conn = connexion_bd();
$userco = $_SESSION["user"];
$id = $_GET["idPost"];
$req = ("SELECT * FROM Favoris WHERE id_post = '$id' AND liked_by = '$userco'");
$dejaliked = mysqli_query($conn, $req);

if (mysqli_num_rows($dejaliked) == 0) {     //Vérifie si un utilistaeur a aimé le post ou non puis like ou enlève le like en conséquence
    $req = "INSERT INTO Favoris value ('$id','$userco')";
    mysqli_query($conn, $req);
} else if (mysqli_num_rows($dejaliked) == 1) {
    $req = "DELETE FROM Favoris WHERE id_post = '$id' AND liked_by = '$userco' ";
    mysqli_query($conn, $req);
}
mysqli_close($conn);
header('Location: ' . $_SERVER['HTTP_REFERER']);
