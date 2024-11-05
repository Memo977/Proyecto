<?php
session_start();
require_once '../utils/functions.php';
checkAuth();
checkAdminRole();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'UpdateFriendTree':
            $arbol_id = $_POST['arbol_id'];
            $tamanio = $_POST['tamanio'];
            $estado = $_POST['estado'];
            $descripcion = $_POST['descripcion'];
            
            $photo = null;
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '../uploads/actualizaciones/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $photoName = uniqid() . '_' . basename($_FILES['photo']['name']);
                $uploadFile = $uploadDir . $photoName;
                
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
                    $photo = $photoName;
                } else {
                    error_log("Failed to move uploaded file to $uploadFile");
                    $_SESSION['error_message'] = "Error al subir la foto.";
                    header('Location: ../../pages/admin/arbolesAmigo.php?id=' . $_POST['usuario_id']);
                    exit();
                }
            }

            $tree = getTree($arbol_id);
            $usuario_id = $tree['usuario_id'];
            
            if (updateTreeWithPhoto($arbol_id, $tamanio, $estado, $descripcion, $photo)) {
                $_SESSION['success_message'] = "Actualización registrada exitosamente.";
            } else {
                $_SESSION['error_message'] = "Error al registrar la actualización.";
                if ($photo && file_exists($uploadDir . $photo)) {
                    unlink($uploadDir . $photo);
                }
            }
            header('Location: ../../pages/admin/arbolesAmigo.php?id=' . $usuario_id);
            break;      
    }
} else {
    header('Location: ../../pages/admin/amigos.php');
    exit();
}