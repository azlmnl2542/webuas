<?php
if (!isset($_SESSION["email"]) || empty($_SESSION["email"])) {

    header('location: login.php');

}

// session_start();
// if (!isset($_SESSION['idpenulis'])) {
//     header('Location: login.php');
//     exit();
// }
?>