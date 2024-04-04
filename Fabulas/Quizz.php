<?php
require_once("Conn_bd.php");

$donnees = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $donnees = $_POST;
    choixstyle($donnees);
    header('Location:Home.php');
}
page_quizz();
