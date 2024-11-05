<?php
session_start();
require_once '../utils/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $pais = $_POST['pais'] ?? '';
    
    if ($password !== $confirm_password) {
        header('Location: ../pages/shared/signup.php?error=' . urlencode('Las contraseñas no coinciden'));
        exit();
    }
    
    if (registerFriend( $nombre, $apellidos, $email, $password, $telefono, $direccion, $pais)) {
        header('Location: ../pages/shared/login.php?registered=1');
        exit();
    } else {
        header('Location: ../pages/shared/signup.php?error=' . urlencode('Error al registrar el usuario. El correo electrónico podría estar en uso.'));
        exit();
    }
}

header('Location: ../pages/shared/signup.php');
exit();