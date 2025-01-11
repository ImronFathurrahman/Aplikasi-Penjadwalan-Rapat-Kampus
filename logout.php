<?php
session_start();

// Tentukan tipe user yang logout
if (isset($_GET['type']) && $_GET['type'] == 'Admin') {
    // Hapus hanya session Admin
    unset($_SESSION['Admin']);
    unset($_SESSION['role']);
    unset($_SESSION['nama']);
    unset($_SESSION['jabat']);
} elseif (isset($_GET['type']) && $_GET['type'] == 'User') {
    // Hapus hanya session User
    unset($_SESSION['User']);
    unset($_SESSION['role']);
    unset($_SESSION['nama']); 
    unset($_SESSION['jabat']);
} else {
    // Hapus semua session jika tidak ada tipe yang ditentukan
    session_destroy();
}

header("location:index.php");
exit();
?>