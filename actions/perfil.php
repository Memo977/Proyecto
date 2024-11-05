<?php
session_start();
require_once '../utils/functions.php';
checkAuth();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = getConnection();
    $user_id = $_SESSION['user_id'];
    
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $apellidos = mysqli_real_escape_string($conn, $_POST['apellidos']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $telefono = mysqli_real_escape_string($conn, $_POST['telefono']);
    $direccion = mysqli_real_escape_string($conn, $_POST['direccion']);
    $pais = mysqli_real_escape_string($conn, $_POST['pais']);
    
    $check_query = "SELECT id FROM usuarios WHERE email = '$email' AND id != $user_id";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['error_message'] = "El email ya está en uso por otro usuario.";
        header('Location: ../../pages/amigo/perfil.php');
        exit();
    }
    
    $query = "UPDATE usuarios SET 
              nombre = '$nombre',
              apellidos = '$apellidos',
              email = '$email',
              telefono = '$telefono',
              direccion = '$direccion',
              pais = '$pais'";
    
    if (!empty($_POST['new_password'])) {
        $password = mysqli_real_escape_string($conn, $_POST['new_password']);
        $query .= ", password = '$password'";
    }
    
    $query .= " WHERE id = $user_id";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['success_message'] = "Perfil actualizado exitosamente.";
        $_SESSION['nombre'] = $nombre;
        $_SESSION['email'] = $email;
    } else {
        $_SESSION['error_message'] = "Error al actualizar el perfil.";
    }
    
    header('Location: ../../pages/amigo/perfil.php');
    exit();
}

header('Location: ../pages/amigo/perfil.php');
exit();