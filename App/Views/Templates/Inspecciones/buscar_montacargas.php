<?php

try {
    // Verificar si se ha enviado el número y el ID_Centro
    if (!isset($_POST['numero']) || !isset($_POST['ID_Centro'])) {
        throw new Exception("Datos no proporcionados");
    }

    // Cargar la conexión
    require 'App/Models/Conexion.php';
    $conexion = new Conexion();
    $pdo = $conexion->Conexion();

    // Obtener los valores de número e ID_Centro
    $numero = $_POST['numero'];
    $ID_Centro = $_POST['ID_Centro'];

    // Preparar y ejecutar la consulta
    $query = "
        SELECT ID, Numero, Modelo, Marca 
        FROM montacargas 
        WHERE Numero = :numero AND ID_Centro = :ID_Centro
    ";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':numero', $numero);
    $stmt->bindValue(':ID_Centro', $ID_Centro);
    $stmt->execute();
    $montacargas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($montacargas)) {
        echo json_encode([]);
    } else {
        echo json_encode($montacargas);
    }

} catch (Exception $e) {
    // Enviar un mensaje de error en formato JSON
    echo json_encode(['error' => $e->getMessage()]);
}
?>
