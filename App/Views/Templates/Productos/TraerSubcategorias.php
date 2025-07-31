<?php
include_once "App/Controllers/ProductosController.php";
$ProductosController = new ProductosController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Usar $_GET para obtener el valor de la categoría
    $ID_Categoria = intval($_GET['ID_Categoria']);

    if ($ID_Categoria) {
        echo json_encode($ProductosController->TraerSubcategorias($ID_Categoria));
    } else {
        echo json_encode([
            "error" => "ID de categoría no proporcionado."
        ]);
    }
}
?>

