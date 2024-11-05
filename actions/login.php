<?php
session_start();
require_once '../utils/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (login($email, $password)) {
        if ($_SESSION['rol_id'] == 1) {
            header('Location: ../../pages/admin/dashboard.php');
        } else {
            header('Location: ../../pages/amigo/dashboard.php');
        }
        exit();
    } else {
        header('Location: ../pages/shared/login.php?error=1');
        exit();
    }
}