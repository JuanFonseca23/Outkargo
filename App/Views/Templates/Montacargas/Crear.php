<?php
    date_default_timezone_set('America/Bogota');
    session_start();
    include_once "App/Controllers/MontacargasController.php";
    include_once "App/Controllers/CentroDeTrabajoController.php";
    include_once "App/Controllers/AreaController.php";
    $MontacargasController = new MontacargasController();
    $CentroTrabajoController = new CentroDeTrabajoController();
    $AreaController = new AreaController();
    if (empty($_SESSION['ID'])) {
        header("location:../IniciarSesion");
        exit;
    }
    $FechaHoy = date("d/m/Y");
    $HoraActual = date("H:i:s");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha Tecnica</title>
</head>

<body>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .Texto-Izquierda {
            text-align: left;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .agregar,
        .agregar-montacargas,
        .cambiar {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .cambiar {
            background-color: #ff8c00;
        }

        .agregar:hover,
        .agregar-montacargas:hover,
        .cambiar:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .alertify .ajs-header {
            background-color: #ff5000;
            color: white;
            font-size: 18px;
            padding: 10px;
            font-weight: bold;
        }

        #tabla-resultados,
        #tabla-resultados-montacargas {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        #tabla-resultados th,
        #tabla-resultados td,
        #tabla-resultados-montacargas th,
        #tabla-resultados-montacargas td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        #tabla-resultados th,
        #tabla-resultados-montacargas th {
            background-color: #ff5000;
            color: white;
            font-size: 16px;
            text-transform: uppercase;
        }

        #tabla-resultados tr:nth-child(even),
        #tabla-resultados-montacargas tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        #tabla-resultados tr:nth-child(odd),
        #tabla-resultados-montacargas tr:nth-child(odd) {
            background-color: #fff;
        }

        #tabla-resultados tr:hover,
        #tabla-resultados-montacargas tr:hover {
            background-color: #f1f1f1;
        }

        #cedula-modal,
        #montacargas-modal {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: border-color 0.3s;
        }

        #cedula-modal:focus,
        #montacargas-modal:focus {
            border-color: #ff5000;
        }

        .ajs-button.ajs-ok {
            background-color: #ff5000 !important;
            color: white !important;
            border: none !important;
            padding: 10px 20px !important;
            font-size: 16px !important;
            border-radius: 5px !important;
        }

        .ajs-button.ajs-ok:hover {
            background-color: #e24e00 !important;
        }
    </style>
    <table border="1" width="100%">
        <thead>
            <tr>
                <th rowspan="3"><img src="../App/Views/Img/Outkargo.png" width="200px"></th>
                <th rowspan="3" class="Titulo" style="font-size: 20px;"> FICHA TECNICA EQUIPOS</th>
                <th>CODIGO:</th>
                <td>F-171</td>
            </tr>
            <tr>
                <th>FECHA:</th>
                <td>17/07/2025</td>
            </tr>
            <tr>
                <th>VERSIÓN:</th>
                <td>2</td>
            </tr>
        </thead>
    </table>
    <table border="1" width="100%">
        <tbody>
            <tr>
                <th class="Texto-Izquierda">MARCA:</th>
                <td class="Texto-Izquierda">
                    <?php
                        $Marcas = $MontacargasController->TraerMarca();
                        if ($Marcas) {
                            echo '<select name="ID_Marca" id="ID_Marca">';
                            foreach ($Marcas as $Marca) {
                                echo '<option value="' . $Marca['ID'] . '">' . $Marca['Nombre'] . '</option>';
                            }
                            echo '</select>';
                        } else {
                            echo 'No hay marcas disponibles.';
                        }
                    ?>
                </td>
                <th class="Texto-Izquierda">CENTRO DE TRABAJO:</th>        
                <td class="Texto-Izquierda">
                    <select name="ID_Centro" id="ID_Centro">
                    <?php                        
                        $Centros = $CentroTrabajoController->TraerCentrosDeTrabajo();
                        if ($Centros) {
                            foreach ($Centros as $Centro) {
                                echo '<option value="' . $Centro['ID'] . '">' . $Centro['Nombre'] . '</option>';
                            }
                        } else {
                            echo '<option value="">No hay centros disponibles</option>';
                        }
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th class="Texto-Izquierda">CAPACIDAD (Toneladas):</th>
                <td class="Texto-Izquierda"><input type="number" name="Capacidad" id="Capacidad"></td>
                <th class="Texto-Izquierda">AREA:</th>
                <td class="Texto-Izquierda">
                    <select name="ID_Area" id="ID_Area">
                    <?php
                        $Areas = $AreaController->Leer($_SESSION['NoCentro']);
                        if ($Areas) {
                            foreach ($Areas as $Area) {
                                echo '<option value="' . $Area['ID'] . '">' . $Area['Nombre'] . '</option>';
                            }
                        } else {
                            echo '<option value="">No hay áreas disponibles</option>';
                        }
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th class="Texto-Izquierda">SERIE:</th>
                <td class="Texto-Izquierda"><input type="text" name="Serie" id="Serie" required></td>
                <th class="Texto-Izquierda">ESTADO DEL EQUIPO:</th>
                <td class="Texto-Izquierda"><input type="text" name="Estado_Equipo" id="Estado_Equipo">
                    
                </td>
            </tr>
            <tr>
                <th class="Texto-Izquierda">MODELO:</th>
                <td class="Texto-Izquierda"><input type="text" name="" id=""></td>
                <th class="Texto-Izquierda">NUMERO INTERNO:</th>
                <td class="Texto-Izquierda"><input type="text" name="" id=""></td>
            </tr>
            <tr>
                <th class="Texto-Izquierda">AÑO FABRICACION:</th>
                <td class="Texto-Izquierda"><input type="text" name="" id=""></td>
                <th class="Texto-Izquierda">MANIFIESTO:</th>
                <td class="Texto-Izquierda"><input type="text" name="" id=""></td>
            </tr>
        </tbody>
    </table>
</body>
<script>
    $(document).ready(function () {
        $('#ID_Centro').change(function () {
            var centroID = $(this).val();

            $.ajax({
                url: 'ObtenerAreas',
                type: 'POST',
                data: { ID_Centro: centroID },
                dataType: 'json',
                success: function (data) {
                    var areaSelect = $('#ID_Area');
                    areaSelect.empty();

                    if (data.length > 0) {
                        $.each(data, function (index, area) {
                            areaSelect.append('<option value="' + area.ID + '">' + area.Nombre + '</option>');
                        });
                    } else {
                        areaSelect.append('<option value="">No hay áreas disponibles</option>');
                    }
                },
                error: function () {
                    alert('Error al cargar las áreas.');
                }
            });
        });
    });
</script>

</html>