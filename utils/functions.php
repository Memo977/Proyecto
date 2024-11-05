<?php
function getConnection() {
    $connection = mysqli_connect("localhost", "root", "", "Proyecto");
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $connection;
}

function login($email, $password) {
    $conn = getConnection();
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    
    $query = "SELECT id, nombre, email, rol_id FROM usuarios 
              WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['rol_id'] = $user['rol_id'];
        return true;
    }
    return false;
}

function registerFriend($nombre, $apellidos, $email, $password, $telefono, $direccion, $pais) {
    $conn = getConnection();
    $nombre = mysqli_real_escape_string($conn, $nombre);
    $apellidos = mysqli_real_escape_string($conn, $apellidos);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $telefono = mysqli_real_escape_string($conn, $telefono);
    $direccion = mysqli_real_escape_string($conn, $direccion);
    $pais = mysqli_real_escape_string($conn, $pais);
    
    $check_query = "SELECT id FROM usuarios WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        return false;
    }
    
    $query = "INSERT INTO usuarios (nombre, apellidos, email, password, telefono, direccion, pais, rol_id, created_at) 
              VALUES ('$nombre', '$apellidos', '$email', '$password', '$telefono', '$direccion', '$pais', 2, NOW())";
    
    return mysqli_query($conn, $query);
}

function checkAuth() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }
}

function checkAdminRole() {
    if (!isset($_SESSION['rol_id']) || $_SESSION['rol_id'] != 1) {
        header('Location: ../../pages/shared/unauthorized.php');
        exit();
    }
}

function getDashboardStats() {
    $conn = getConnection();
    $stats = array();
    
    $query = "SELECT COUNT(*) as amigos FROM usuarios WHERE rol_id = 2";
    $result = mysqli_query($conn, $query);
    $stats['amigos'] = mysqli_fetch_assoc($result)['amigos'];
    
    $query = "SELECT COUNT(*) as disponibles FROM arboles WHERE estado = 'Disponible'";
    $result = mysqli_query($conn, $query);
    $stats['arboles_disponibles'] = mysqli_fetch_assoc($result)['disponibles'];
    
    $query = "SELECT COUNT(*) as vendidos FROM arboles WHERE estado = 'Vendido'";
    $result = mysqli_query($conn, $query);
    $stats['arboles_vendidos'] = mysqli_fetch_assoc($result)['vendidos'];
    
    return $stats;
}

function getAllSpecies() {
    $conn = getConnection();
    $query = "SELECT * FROM especies ORDER BY id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function addSpecies($nombre_comercial, $nombre_cientifico) {
    $conn = getConnection();
    $nombre_comercial = mysqli_real_escape_string($conn, $nombre_comercial);
    $nombre_cientifico = mysqli_real_escape_string($conn, $nombre_cientifico);
    
    $query = "INSERT INTO especies (nombre_comercial, nombre_cientifico) VALUES ('$nombre_comercial', '$nombre_cientifico')";
    return mysqli_query($conn, $query);
}

function updateSpecies($id, $nombre_comercial, $nombre_cientifico) {
    $conn = getConnection();
    $id = mysqli_real_escape_string($conn, $id);
    $nombre_comercial = mysqli_real_escape_string($conn, $nombre_comercial);
    $nombre_cientifico = mysqli_real_escape_string($conn, $nombre_cientifico);
    
    $query = "UPDATE especies SET nombre_comercial = '$nombre_comercial', nombre_cientifico = '$nombre_cientifico' WHERE id = $id";
    return mysqli_query($conn, $query);
}

function deleteSpecies($id) {
    $conn = getConnection();
    $id = mysqli_real_escape_string($conn, $id);
    
    $query = "DELETE FROM especies WHERE id = $id";
    return mysqli_query($conn, $query);
}

function getAllTrees() {
    $conn = getConnection();
    $query = "SELECT a.*, e.nombre_comercial, e.nombre_cientifico 
              FROM arboles a 
              JOIN especies e ON a.especie_id = e.id 
              WHERE a.usuario_id IS NULL
              ORDER BY a.created_at DESC";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function createTree($especie_id, $ubicacion, $estado, $precio, $foto) {
    $conn = getConnection();
    $especie_id = mysqli_real_escape_string($conn, $especie_id);
    $ubicacion = mysqli_real_escape_string($conn, $ubicacion);
    $estado = mysqli_real_escape_string($conn, $estado);
    $precio = mysqli_real_escape_string($conn, $precio);
    $foto = mysqli_real_escape_string($conn, $foto);
    
    $query = "INSERT INTO arboles 
              (especie_id, ubicacion_geografica, estado, precio, foto_url, created_at)
              VALUES ($especie_id, '$ubicacion', '$estado', $precio, '$foto', NOW())";
    return mysqli_query($conn, $query);
}

function updateTreeStatus($id, $estado) {
    $conn = getConnection();
    $id = mysqli_real_escape_string($conn, $id);
    $estado = mysqli_real_escape_string($conn, $estado);
    
    $query = "UPDATE arboles SET estado = '$estado' WHERE id = $id";
    return mysqli_query($conn, $query);
}

function deleteTree($id) {
    $conn = getConnection();
    $id = mysqli_real_escape_string($conn, $id);
    
    $query = "SELECT foto_url FROM arboles WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $tree = mysqli_fetch_assoc($result);
    
    if ($tree) {
        if (!empty($tree['foto_url'])) {
            $photoPath = $_SERVER['DOCUMENT_ROOT'] . '../uploads/trees/' . $tree['foto_url'];
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }
        
        $query = "DELETE FROM arboles WHERE id = $id";
        return mysqli_query($conn, $query);
    }
    return false;
}

function getTree($id) {
    $conn = getConnection();
    $id = mysqli_real_escape_string($conn, $id);
    
    $query = "SELECT a.*, e.nombre_comercial, e.nombre_cientifico, a.usuario_id 
              FROM arboles a 
              JOIN especies e ON a.especie_id = e.id 
              WHERE a.id = $id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

function updateFullTree($id, $especie_id, $ubicacion, $estado, $precio, $photo = null) {
    try {
        $conn = getConnection();
        
        if ($photo) {
            $query = "UPDATE arboles SET especie_id = ?, ubicacion_geografica = ?, estado = ?, precio = ?, foto_url = ?, last_edit = NOW() WHERE id = ?";
            $params = [$especie_id, $ubicacion, $estado, $precio, $photo, $id];
        } else {
            $query = "UPDATE arboles SET especie_id = ?, ubicacion_geografica = ?, estado = ?, precio = ?, last_edit = NOW() WHERE id = ?";
            $params = [$especie_id, $ubicacion, $estado, $precio, $id];
        }
        
        $stmt = $conn->prepare($query);
        $result = $stmt->execute($params);
        
        if ($result) {
            $_SESSION['success_message'] = "Datos del árbol actualizados exitosamente.";
        }
        
        return $result;
    } catch (PDOException $e) {
        error_log("Error en updateFullTree: " . $e->getMessage());
        return false;
    }
}

function getTreesByFriend($usuario_id) {
    $conn = getConnection();
    $usuario_id = mysqli_real_escape_string($conn, $usuario_id);
    
    $query = "SELECT a.*, e.nombre_comercial, e.nombre_cientifico 
              FROM arboles a 
              JOIN especies e ON a.especie_id = e.id 
              WHERE a.usuario_id = $usuario_id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getTreeWithDetails($arbol_id) {
    $conn = getConnection();
    $arbol_id = intval($arbol_id);
    
    $query = "SELECT a.*, e.nombre_comercial, e.nombre_cientifico, u.nombre as amigo_nombre
              FROM arboles a 
              JOIN especies e ON a.especie_id = e.id
              LEFT JOIN usuarios u ON a.usuario_id = u.id
              WHERE a.id = $arbol_id";
    
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

function verifyTreeOwnership($arbol) {
    if (!$arbol || !$arbol['usuario_id']) {
        $_SESSION['error_message'] = "Árbol no encontrado o no pertenece a ningún amigo.";
        header('Location: amigos.php');
        exit();
    }
    return true;
}

function updateTreeWithPhoto($arbol_id, $tamanio, $estado, $descripcion, $photo = null) {
    try {
        $conn = getConnection();
        
        $query = "UPDATE arboles SET tamanio = ?, estado = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$tamanio, $estado, $arbol_id]);
        
        $query = "INSERT INTO actualizaciones_arboles (arbol_id, tamanio_actual, estado, descripcion, foto, fecha_actualizacion) 
                 VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->execute([$arbol_id, $tamanio, $estado, $descripcion, $photo]);
        
        $_SESSION['success_message'] = "Actualización del árbol registrada exitosamente.";
        
        return true;
    } catch (PDOException $e) {
        error_log("Error en updateTreeWithPhoto: " . $e->getMessage());
        return false;
    }
}

function getTreeUpdateHistory($arbol_id) {
    $conn = getConnection();
    $arbol_id = intval($arbol_id);
    
    $query = "SELECT * FROM actualizaciones_arboles 
              WHERE arbol_id = $arbol_id 
              ORDER BY fecha_actualizacion DESC";
    
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getFriendDashboardStats($usuario_id) {
    $conn = getConnection();
    $usuario_id = mysqli_real_escape_string($conn, $usuario_id);
    $stats = array();
    
    $query = "SELECT COUNT(*) as arboles_propios FROM arboles WHERE usuario_id = $usuario_id";
    $result = mysqli_query($conn, $query);
    $stats['arboles_propios'] = mysqli_fetch_assoc($result)['arboles_propios'];

    $query = "SELECT COUNT(*) as disponibles FROM arboles WHERE estado = 'Disponible'";
    $result = mysqli_query($conn, $query);
    $stats['arboles_disponibles'] = mysqli_fetch_assoc($result)['disponibles'];

    $query = "SELECT MAX(fecha_actualizacion) as ultima_actualizacion 
              FROM actualizaciones_arboles a 
              JOIN arboles t ON a.arbol_id = t.id 
              WHERE t.usuario_id = $usuario_id";
    $result = mysqli_query($conn, $query);
    $stats['ultima_actualizacion'] = mysqli_fetch_assoc($result)['ultima_actualizacion'];
    
    return $stats;
}

function purchaseTree($tree_id, $user_id) {
    $conn = getConnection();
    $tree_id = mysqli_real_escape_string($conn, $tree_id);
    $user_id = mysqli_real_escape_string($conn, $user_id);
    
    // Verificar que el árbol esté disponible
    $check_query = "SELECT estado FROM arboles WHERE id = $tree_id AND estado = 'Disponible'";
    $result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($result) > 0) {
        $query = "UPDATE arboles SET 
                  estado = 'Vendido',
                  usuario_id = $user_id,
                  fecha_venta = NOW()
                  WHERE id = $tree_id";
                  
        return mysqli_query($conn, $query);
    }
    return false;
}

function getUserProfile($user_id) {
    $conn = getConnection();
    $user_id = mysqli_real_escape_string($conn, $user_id);
    
    $query = "SELECT u.*, r.nombre as rol_nombre 
              FROM usuarios u 
              JOIN roles r ON u.rol_id = r.id 
              WHERE u.id = $user_id";
    
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

function getAllUpdatesWithDetails() {
    $conn = getConnection();
    
    $query = "SELECT 
                act.*,
                u.nombre,
                e.nombre_comercial,
                a.ubicacion_geografica
              FROM actualizaciones_arboles act
              JOIN arboles a ON act.arbol_id = a.id
              JOIN especies e ON a.especie_id = e.id
              JOIN usuarios u ON a.usuario_id = u.id
              ORDER BY act.fecha_actualizacion DESC";
    
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}