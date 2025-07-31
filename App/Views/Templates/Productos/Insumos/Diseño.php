<?php
require_once 'vendor/autoload.php';
use Picqer\Barcode\BarcodeGeneratorPNG;

// Obtener el código de barras y el nombre desde el parámetro GET
$codigo = isset($_GET['Codigo']) ? $_GET['Codigo'] : '';
$nombre = isset($_GET['Nombre']) ? $_GET['Nombre'] : '';

if (!$codigo) {
    die('Código de barras no proporcionado.');
}

$generator = new BarcodeGeneratorPNG();
$barcode = $generator->getBarcode($codigo, $generator::TYPE_CODE_128);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Código de Barra</title>
    <style>
        @page {
            margin-left: 7mm;
            margin-top: 0mm;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .fila {
            display: table;
            width: 100%;
            height: calc(100% - 10mm);
            border-collapse: collapse;
        }
        .fila-izquierda {
            display: table-row;
        }
        .fila-derecha {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }
        .container {
            border: 2px solid black;
            padding: 1mm;
            width: 40mm;  
            height: 17mm; 
            box-sizing: border-box;
            font-size: 6pt;
        }
        .name-container {
            border: 1px solid black;
            padding: 0.5mm;
            text-align: center;
            font-weight: bold;
            font-size: 6pt;            
        }
        .divider {
            border-bottom: 1px solid black;
            margin-bottom: 1mm;
            margin-top: 0.5mm;
        }
        .table-container {
            display: table;
            width: 100%;
            height: calc(100% - 10mm);
            border-collapse: collapse;
        }
        .table-row {
            display: table-row;
        }
        .table-cell {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }
        .barcode-container img {
            display: block;
            margin: 0.5mm;
            width: 18mm;
            height: 3mm;
        }
        .logo img {
            max-width: 20mm;
            max-height: 6mm;
        }
    </style>
</head>
<body>
    <div class="fila">
        <div claa="fila-izquierda">
            <div class="container">
                <div class="name-container">
                    <?php echo htmlspecialchars($nombre); ?>
                </div>
                <div class="divider"></div>
                <div class="table-container">
                    <div class="table-row">
                        <div class="table-cell barcode-container">
                            <img src="data:image/png;base64,<?php echo base64_encode($barcode); ?>" alt="Código de barras">
                            <div><?php echo htmlspecialchars($codigo); ?></div>
                        </div>
                        <div class="table-cell logo">
                            <?php
                                $host = $_SERVER['HTTP_HOST'];
                                if ($host === 'localhost') {
                                    echo '<img src="http://localhost/Outkargo2/App/Views/Img/Outkargo.png" />';
                                } else {
                                    echo '<img src="https://' . $host . '/App/Views/Img/Outkargo.png" />';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fila-derecha">
            <div class="container">
                <div class="name-container">
                    <?php echo htmlspecialchars($nombre); ?>
                </div>
                <div class="divider"></div>
                <div class="table-container">
                    <div class="table-row">
                        <div class="table-cell barcode-container">
                            <img src="data:image/png;base64,<?php echo base64_encode($barcode); ?>" alt="Código de barras">
                            <div><?php echo htmlspecialchars($codigo); ?></div>
                        </div>
                        <div class="table-cell logo">
                            <?php
                                $host = $_SERVER['HTTP_HOST'];
                                if ($host === 'localhost') {
                                    echo '<img src="http://localhost/Outkargo2/App/Views/Img/Outkargo.png" />';
                                } else {
                                    echo '<img src="https://' . $host . '/App/Views/Img/Outkargo.png" />';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>