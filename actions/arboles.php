<?php
session_start();
require_once '../utils/functions.php';
checkAuth();
checkAdminRole();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
    switch ($action) {
        case 'create':
            $photo = '';
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '../uploads/arboles/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $photoName = uniqid() . '_' . basename($_FILES['photo']['name']);
                $uploadFile = $uploadDir . $photoName;
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
                    $photo = $photoName;
                } else {
                    error_log("Failed to move uploaded file to $uploadFile");
                }
            }
            
            $especie_id = $_POST['especie_id'];
            $ubicacion = $_POST['ubicacion'];
            $estado = $_POST['estado'];
            $precio = $_POST['precio'];
            
            if (createTree($especie_id, $ubicacion, $estado, $precio, $photo)) {
                $_SESSION['success_message'] = "Árbol creado exitosamente.";
            } else {
                $_SESSION['error_message'] = "Error al crear el árbol.";
            }
            header('Location: ../../pages/admin/arboles.php');
            break;
            
        case 'update':
            $id = $_POST['id'];
            $especie_id = $_POST['especie_id'];
            $ubicacion = $_POST['ubicacion'];
            $estado = $_POST['estado'];
            $precio = $_POST['precio'];
            $usuario_id = isset($_POST['usuario_id']) ? $_POST['usuario_id'] : null;
                
            $photo = null;
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '../uploads/arboles/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                    
                $currentTree = getTree($id);
                if ($currentTree && !empty($currentTree['foto_url'])) {
                    $oldPhotoPath = $uploadDir . $currentTree['foto_url'];
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                }
                    
                $photoName = uniqid() . '_' . basename($_FILES['photo']['name']);
                $uploadFile = $uploadDir . $photoName;
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
                    $photo = $photoName;
                } else {
                    error_log("Failed to move uploaded file to $uploadFile");
                }
            }
                
            if (updateFullTree($id, $especie_id, $ubicacion, $estado, $precio, $photo)) {
                $_SESSION['success_message'] = "Árbol editado exitosamente.";
                if ($usuario_id) {
                    header('Location: ../../pages/admin/arbolesAmigo.php?id=' . $usuario_id);
                } else {
                    header('Location: ../../pages/admin/arboles.php');
                }
            } else {
                $_SESSION['error_message'] = "Error al actualizar el árbol.";
                header('Location: ../../pages/admin/arboles.php');
            }
            break;

        case 'update_status':
            $id = $_POST['id'];
            $estado = $_POST['estado'];
            
            if (updateTreeStatus($id, $estado)) {
                $_SESSION['success_message'] = "Estado actualizado exitosamente.";
            } else {
                $_SESSION['error_message'] = "Error al actualizar el estado.";
            }
            header('Location: ../../pages/admin/arboles.php');
            break;
            
        case 'delete':
            $id = $_POST['id'];
            
            if (deleteTree($id)) {
                $_SESSION['success_message'] = "Árbol eliminado exitosamente.";
            } else {
                $_SESSION['error_message'] = "Error al eliminar el árbol.";
            }
            header('Location: ../../pages/admin/arboles.php');
            break;

    }
    exit();
}

header('Location: ../../pages/admin/arboles.php');
exit();
?>