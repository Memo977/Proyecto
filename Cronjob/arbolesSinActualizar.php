<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proyecto";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the list of trees that haven't been updated in over a month
$sql = "SELECT 
        a.id, 
        a.ubicacion_geografica,
        e.nombre_comercial,
        MAX(act.fecha_actualizacion) as last_update
    FROM actualizaciones_arboles act
    JOIN arboles a ON act.arbol_id = a.id
    JOIN especies e ON a.especie_id = e.id
    GROUP BY a.id
    HAVING MAX(act.fecha_actualizacion) < DATE_SUB(NOW(), INTERVAL 1 MONTH)";

$result = $conn->query($sql);

$outdated_trees = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $outdated_trees[] = array(
            'id' => $row["id"],
            'ubicacion' => $row["ubicacion_geografica"],
            'especie' => $row["nombre_comercial"],
            'last_update' => $row["last_update"]
        );
    }
}

// Send email to admin if there are any outdated trees
if (!empty($outdated_trees)) {
    $to = "proyectoprueba07@gmail.com";
    $subject = "Árboles desactualizados";
    $message = "Los siguientes árboles no han sido actualizados desde hace 1 mes:\n\n";

    foreach ($outdated_trees as $tree) {
        $message .= "- Árbol ID: {$tree['id']}, Especie: {$tree['especie']}, Ubicación: {$tree['ubicacion']}, Última actualización: {$tree['last_update']}\n";
    }

    $headers = "From: memooochoa097@gmail.com";

    if (mail($to, $subject, $message, $headers)) {
        echo "Email sent successfully.";
    } else {
        echo "Error sending email.";
    }
} else {
    echo "No outdated trees found.";
}

$conn->close();