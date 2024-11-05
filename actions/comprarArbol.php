<?php
session_start();
require_once '../utils/functions.php';
checkAuth();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tree_id'])) {
    $tree_id = $_POST['tree_id'];
    
    if (purchaseTree($tree_id, $_SESSION['user_id'])) {
        $_SESSION['success_message'] = "¡Árbol adquirido exitosamente!";
    } else {
        $_SESSION['error_message'] = "Error al intentar adquirir el árbol. Es posible que ya no esté disponible.";
    }
}

header('Location: ../../pages/amigo/arbolesDisponibles.php');
exit();