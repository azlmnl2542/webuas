<?php
require 'function.php';
 
if(!isset($_SESSION["email"]) && !isset($_SESSION["password"])) { 
header('location: login.php'); 
} 
else { 
} 

// session_start();
// require 'function.php';

// if (isset($_POST['btn_login'])) {
//     $data_email = $_POST['email'];
//     $data_password = $_POST['password'];

//     // Menggunakan prepared statement untuk keamanan
//     $stmt = $conn->prepare("SELECT * FROM penulis WHERE email = ? AND password = ?");
//     $stmt->bind_param("ss", $data_email, $data_password);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     if ($result->num_rows > 0) {
//         $row = $result->fetch_assoc();
//         $_SESSION['idpenulis'] = $row['id_penulis'];
//         $_SESSION['email'] = $row['email'];
//         $_SESSION['username'] = $row['nama_penulis']; // Pastikan kolom ini ada di tabel
//         header('Location: index.php');
//         exit();
//     } else {
//         header('Location: login.php?error=1');
//         exit();
//     }
// }
?>