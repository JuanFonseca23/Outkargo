<?php

try {
    // Verificar si se ha enviado la cédula
    if (!isset($_POST['cedula'])) {
        throw new Exception("Cédula no proporcionada");
    }

    // Cargar la conexión
    require 'App/Models/Conexion.php';
    $conexion = new Conexion();
    $pdo = $conexion->Conexion();

    // Obtener el valor de la cédula
    $cedula = $_POST['cedula'];

    // Preparar y ejecutar la consulta
    $query = "
        SELECT u.ID, u.NombreCompleto, c.Cargo 
        FROM usuario u 
        INNER JOIN cargos c ON u.ID_Cargo = c.ID 
        WHERE u.Documento LIKE :cedula LIMIT 10
    ";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':cedula', '%' . $cedula . '%');
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($usuarios)) {
        echo json_encode([]);
    } else {
        echo json_encode($usuarios);
    }

} catch (Exception $e) {
    // Enviar un mensaje de error en formato JSON
    echo json_encode(['error' => $e->getMessage()]);
}
?>
