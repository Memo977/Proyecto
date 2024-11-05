<?php
session_start();
require_once '../utils/functions.php';
checkAuth();
checkAdminRole();

if (!isset($_POST['action']) && !isset($_GET['action'])) {
    $_SESSION['error_message'] = "Error al procesar la operación.";
    header('Location: ../../pages/admin/especies.php');
    exit();
}

$action = $_POST['action'] ?? $_GET['action'];

switch ($action) {
    case 'create':
        if (!isset($_POST['nombre_comercial']) || !isset($_POST['nombre_cientifico'])) {
            $_SESSION['error_message'] = "Faltan datos requeridos.";
            header('Location: ../../pages/admin/especies.php');
            exit();
        }
        
        $nombre_comercial = trim($_POST['nombre_comercial']);
        $nombre_cientifico = trim($_POST['nombre_cientifico']);
        
        if (empty($nombre_comercial) || empty($nombre_cientifico)) {
            $_SESSION['error_message'] = "Los campos no pueden estar vacíos.";
            header('Location: ../../pages/admin/especies.php');
            exit();
        }
        
        if (addSpecies($nombre_comercial, $nombre_cientifico)) {
            $_SESSION['success_message'] = "Especie creada exitosamente.";
        } else {
            $_SESSION['error_message'] = "Error al crear la especie.";
        }
        header('Location: ../../pages/admin/especies.php');
        break;

    case 'update':
        if (!isset($_POST['id']) || !isset($_POST['nombre_comercial']) || !isset($_POST['nombre_cientifico'])) {
            $_SESSION['error_message'] = "Faltan datos requeridos.";
            header('Location: ../../pages/admin/especies.php');
            exit();
        }
        
        $id = trim($_POST['id']);
        $nombre_comercial = trim($_POST['nombre_comercial']);
        $nombre_cientifico = trim($_POST['nombre_cientifico']);
        
        if (empty($id) || empty($nombre_comercial) || empty($nombre_cientifico)) {
            $_SESSION['error_message'] = "Los campos no pueden estar vacíos.";
            header('Location: ../../pages/admin/especies.php');
            exit();
        }
        
        if (updateSpecies($id, $nombre_comercial, $nombre_cientifico)) {
            $_SESSION['success_message'] = "Especie actualizada exitosamente.";
        } else {
            $_SESSION['error_message'] = "Error al actualizar la especie.";
        }
        header('Location: ../../pages/admin/especies.php');
        break;

    case 'delete':
        if (!isset($_GET['id'])) {
            $_SESSION['error_message'] = "ID de especie no proporcionado.";
            header('Location: ../../pages/admin/especies.php');
            exit();
        }
        
        $id = trim($_GET['id']);
        
        if (empty($id)) {
            $_SESSION['error_message'] = "ID de especie no válido.";
            header('Location: ../../pages/admin/especies.php');
            exit();
        }
        
        if (deleteSpecies($id)) {
            $_SESSION['success_message'] = "Especie eliminada exitosamente.";
        } else {
            $_SESSION['error_message'] = "Error al eliminar la especie.";
        }
        header('Location: ../../pages/admin/especies.php');
        break;

    default:
        $_SESSION['error_message'] = "Acción no válida.";
        header('Location: ../../pages/admin/especies.php');
        break;
}
exit();