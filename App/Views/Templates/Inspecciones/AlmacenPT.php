<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    textarea {
        width: 100%;
        height: 100%;
        box-sizing: border-box;
        border: 1px solid #ccc;
        resize: none;
    }

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

    .Fondo-gris {
        background-color: #b2b2b2;
    }
</style>
<table border="1">
    <thead>
        <tr>
            <th rowspan="3" colspan="2"><img src="../App/Views/Img/Outkargo.png" width="200px"></th>
            <th rowspan="3" colspan="6" class="Titulo" style="font-size: 20px;">Inspeccion de <?= $TipoInspeccion ?></th>
            <th>CODIGO:</th>
            <td>F-192-C</td>
        </tr>
        <tr>
            <th>FECHA:</th>
            <td>08/11/2024</td>
        </tr>
        <tr>
            <th>VERSIÓN:</th>
            <td>4</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="Texto-Izquierda" colspan="8"><b>NOMBRE DEL RESPONSABLE DE LA INSPECCIÓN: </b><?= $_SESSION['NombreCompleto'] ?></td>
            <th class="Texto-Izquierda">Fecha:</th>
            <td class="Texto-Izquierda"><?= $FechaHoy ?></td>
        </tr>
        <tr>
            <td class="Texto-Izquierda" colspan="7"><b>NOMBRE DEL RESPONSABLE DEL AREA: </b><button id="Buscar-Persona-Area">Buscar</button></td>
            <th class="Texto-Izquierda">Area:</th>
            <td class="Texto-Izquierda" colspan="2"><b>Almacén PT</b></td>
        </tr>
        <tr>
            <th class="Texto-Izquierda" colspan="2">HORA DE INICIO DE INSPECCIÓN: </th>
            <td class="Texto-Izquierda" colspan="3"><?= date('g:i:s A'); ?></td>
            <th class="Texto-Izquierda" colspan="3">HORA FINAL DE INSPECCIÓN:</th>
            <td class="Texto-Izquierda" id="Hora_actual" colspan="2"></td>
            <script>
                function actualizarHora() {
                    const fecha = new Date();
                    let horas = fecha.getHours();
                    let minutos = fecha.getMinutes();
                    let segundos = fecha.getSeconds();
                    let periodo = "AM";
                    if (horas >= 12) {
                        periodo = "PM";
                        if (horas > 12) {
                            horas -= 12;
                        }
                    } else if (horas === 0) {
                        horas = 12;
                    }
                    minutos = minutos < 10 ? '0' + minutos : minutos;
                    segundos = segundos < 10 ? '0' + segundos : segundos;
                    const horaActual = horas + ':' + minutos + ':' + segundos + ' ' + periodo;
                    document.getElementById("Hora_actual").textContent = horaActual;
                }
                setInterval(actualizarHora, 1000);
                actualizarHora();
            </script>
        </tr>
        <tr>
            <td colspan="10">
                <b>Objetivo.</b> Evaluar las condiciones de seguridad locativas. En caso de identificarse condiciones peligrosas que pongan en riesgo la seguridad de las personas, informe inmediatamente al área de Seguridad y Salud en el Trabajo. Evalúe la situación y si es necesario, solicite suspensión del paso por el área, hasta que la condición de riesgo sea resuelta.
            </td>
        </tr>
        <!-- Formulario para enviar datos al controlador -->
        <tr>
            <td colspan="10">
                Marque con una "X" en la columna de ESTADO la condición encontrada para cada uno de los aspectos evaluados.
                <br>
                <b>C</b>=CUMPLE <b>NC</b>=NO CUMPLE <b>N/A</b>=NO APLICA
            </td>
        </tr>
        <tr>
            <th colspan="10" class="Fondo-gris">
                INSPECCIÓN LOCATIVA
            </th>
        </tr>
        <form method="POST">
            <tr>
                <th rowspan="2" width="5px">N°</th>
                <th rowspan="2" colspan="2">Descripción</th>
                <th colspan="3">Estado</th>
                <th rowspan="2">
                    Intervención segun grado de peligrosidad
                    <br>
                    (ver indicaciones)
                </th>
                <th rowspan="2" colspan="3">
                    Observaciones
                </th>
            </tr>
            <tr>
                <th width="5px">C</th>
                <th width="5px">NC</th>
                <th width="5px">N/A</th>
            </tr>
            <tr>
                <th colspan="10" class="Fondo-gris Texto-Izquierda">
                    SEÑALIZACIONES, DEMARCACIONES Y ESPEJOS
                </th>
            </tr>
            <tr>
                <th>1</th>
                <td colspan="2">¿Las rutas de evacuación se encuentran señalizadas?</td>
                <td><input type="radio" name="Criterio_1" value="Cumple"></td>
                <td><input type="radio" name="Criterio_1" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_1" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_1">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_1"></textarea>
                </td>
            </tr>
            <tr>
                <th>2</th>
                <td colspan="2">¿Las salidas de emergencia se encuentran señalizadas?</td>
                <td><input type="radio" name="Criterio_2" value="Cumple"></td>
                <td><input type="radio" name="Criterio_2" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_2" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_2">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_2"></textarea>
                </td>
            </tr>
            <tr>
                <th>3</th>
                <td colspan="2">¿Los elementos de atención de emergencia se encuentran señalizados?</td>
                <td><input type="radio" name="Criterio_3" value="Cumple"></td>
                <td><input type="radio" name="Criterio_3" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_3" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_3">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_3"></textarea>
                </td>
            </tr>
            <tr>
                <th>4</th>
                <td colspan="2">¿La señalización es clara, legible y se encuentra en buen estado?</td>
                <td><input type="radio" name="Criterio_4" value="Cumple"></td>
                <td><input type="radio" name="Criterio_4" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_4" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_4">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_4"></textarea>
                </td>
            </tr>
            <tr>
                <th>5</th>
                <td colspan="2">¿Se tienen demarcados senderos peatonales?</td>
                <td><input type="radio" name="Criterio_5" value="Cumple"></td>
                <td><input type="radio" name="Criterio_5" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_5" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_5">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_5"></textarea>
                </td>
            </tr>
            <tr>
                <th>6</th>
                <td colspan="2">¿Se tiene demarcado áreas de tránsito de montacargas?</td>
                <td><input type="radio" name="Criterio_6" value="Cumple"></td>
                <td><input type="radio" name="Criterio_6" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_6" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_6">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_6"></textarea>
                </td>
            </tr>
            <tr>
                <th>7</th>
                <td colspan="2">¿Se tienen demarcadas áreas para el almacenamiento de materiales?</td>
                <td><input type="radio" name="Criterio_7" value="Cumple"></td>
                <td><input type="radio" name="Criterio_7" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_7" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_7">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_7"></textarea>
                </td>
            </tr>
            <tr>
                <th>8</th>
                <td colspan="2">¿Se respeta la demarcación y señalización existente?</td>
                <td><input type="radio" name="Criterio_8" value="Cumple"></td>
                <td><input type="radio" name="Criterio_8" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_8" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_8">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_8"></textarea>
                </td>
            </tr>
            <tr>
                <th>9</th>
                <td colspan="2">¿Se tienen ubicados espejos de medialuna en puntos ciegos?</td>
                <td><input type="radio" name="Criterio_9" value="Cumple"></td>
                <td><input type="radio" name="Criterio_9" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_9" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_9">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_9"></textarea>
                </td>
            </tr>
            <tr>
                <th colspan="10" class="Fondo-gris Texto-Izquierda">
                    ESTADO DE LOS PISOS Y OTROS
                </th>
            </tr>
            <tr>
                <th>10</th>
                <td colspan="2">¿Existe presencia de huecos, baches y otros elementos que originan daños en las ruedas de los montacargas?</td>
                <td><input type="radio" name="Criterio_10" value="Cumple"></td>
                <td><input type="radio" name="Criterio_10" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_10" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_10">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_10"></textarea>
                </td>
            </tr>
            <tr>
                <th>11</th>
                <td colspan="2">¿Las tapas de sistema eléctricos y drenajes se encuentran completas, ubicadas correctamente y no presentan daños?</td>
                <td><input type="radio" name="Criterio_11" value="Cumple"></td>
                <td><input type="radio" name="Criterio_11" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_11" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_11">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_11"></textarea>
                </td>
            </tr>
            <tr>
                <th>12</th>
                <td colspan="2">¿Las tapas de sistema eléctricos y drenajes soportan el paso de montacargas?</td>
                <td><input type="radio" name="Criterio_12" value="Cumple"></td>
                <td><input type="radio" name="Criterio_12" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_12" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_12">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_12"></textarea>
                </td>
            </tr>
            <tr>
                <th>13</th>
                <td colspan="2">¿La rampa de acceso a vehículos proporciona la resistencia necesaria para el ingreso del montacargas y se encuentra en adecuadas condiciones de funcionamiento?</td>
                <td><input type="radio" name="Criterio_13" value="Cumple"></td>
                <td><input type="radio" name="Criterio_13" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_13" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_13">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_13"></textarea>
                </td>
            </tr>
            <tr>
                <th>14</th>
                <td colspan="2">¿Las vías de acceso se encuentran libres de derrames, residuos y otros elementos que dificultan el paso?</td>
                <td><input type="radio" name="Criterio_14" value="Cumple"></td>
                <td><input type="radio" name="Criterio_14" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_14" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_14">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_14"></textarea>
                </td>
            </tr>
            <tr>
                <th>15</th>
                <td colspan="2">¿El área cuenta con iluminación en los pasillos?</td>
                <td><input type="radio" name="Criterio_15" value="Cumple"></td>
                <td><input type="radio" name="Criterio_15" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_15" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_15">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_15"></textarea>
                </td>
            </tr>
            <tr>
                <th>16</th>
                <td colspan="2">¿El área cuenta con rampas retractiles para el cargue de contenedores?</td>
                <td><input type="radio" name="Criterio_16" value="Cumple"></td>
                <td><input type="radio" name="Criterio_16" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_16" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_16">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_16"></textarea>
                </td>
            </tr>
            <tr>
                <th>17</th>
                <td colspan="2">¿El área posee sistema de ventilación?</td>
                <td><input type="radio" name="Criterio_17" value="Cumple"></td>
                <td><input type="radio" name="Criterio_17" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_17" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_17">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_17"></textarea>
                </td>
            </tr>
            <tr>
                <th colspan="10" class="Fondo-gris Texto-Izquierda">
                    ALMACENAMIENTO DE PRODUCTO TERMINADO
                </th>
            </tr>
            <tr>
                <th>18</th>
                <td colspan="2">¿La estructura de la estantería (base, travesaños, bastidores, largueros, diagonales, pines, tubos), están libres de fisuras, endiduras, dobleces, y en general otros daños que limiten su capacidad?</td>
                <td><input type="radio" name="Criterio_18" value="Cumple"></td>
                <td><input type="radio" name="Criterio_18" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_18" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_18">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_18"></textarea>
                </td>
            </tr>
            <tr>
                <th>19</th>
                <td colspan="2">¿Se cuenta con protectores contra golpes en los bastidores (parales) de la estantería y estos se encuentran en buen estado y asegurados al piso?</td>
                <td><input type="radio" name="Criterio_19" value="Cumple"></td>
                <td><input type="radio" name="Criterio_19" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_19" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_19">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_19"></textarea>
                </td>
            </tr>
            <tr>
                <th>20</th>
                <td colspan="2">¿Se cuenta con tablas y/u otros elementos de soporte de carga resistencia en la cantidad y ubicación necesaria?</td>
                <td><input type="radio" name="Criterio_20" value="Cumple"></td>
                <td><input type="radio" name="Criterio_20" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_20" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_20">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_20"></textarea>
                </td>
            </tr>
            <tr>
                <th>21</th>
                <td colspan="2">¿Las estibas en la que se encuentra almacenado los materiales se encuentran en buen estado y se encuentra correctamente almacenadas en la estantería?</td>
                <td><input type="radio" name="Criterio_21" value="Cumple"></td>
                <td><input type="radio" name="Criterio_21" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_21" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_21">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_21"></textarea>
                </td>
            </tr>
            <tr>
                <th>22</th>
                <td colspan="2">¿La carga almacenada se encuentra identificada y embalada (asegurada) para prevenir el riesgo de caída?</td>
                <td><input type="radio" name="Criterio_22" value="Cumple"></td>
                <td><input type="radio" name="Criterio_22" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_22" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_22">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_22"></textarea>
                </td>
            </tr>
            <tr>
                <th>23</th>
                <td colspan="2">¿Si hay estantería golpeada, esta ha sido identificada para prevenir su uso y esta medida se respeta?</td>
                <td><input type="radio" name="Criterio_23" value="Cumple"></td>
                <td><input type="radio" name="Criterio_23" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_23" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_23">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_23"></textarea>
                </td>
            </tr>
            <tr>
                <th>24</th>
                <td colspan="2">¿El producto almacenado cumple con las disposiciones de almacenamiento establecidas en los estándares documentados?</td>
                <td><input type="radio" name="Criterio_24" value="Cumple"></td>
                <td><input type="radio" name="Criterio_24" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_24" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_24">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_24"></textarea>
                </td>
            </tr>
            <tr>
                <th>25</th>
                <td colspan="2">¿Se tiene identificado la capacidad de las estanterías por cada estante (kg) y se cumple con la disposición?</td>
                <td><input type="radio" name="Criterio_25" value="Cumple"></td>
                <td><input type="radio" name="Criterio_25" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_25" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_25">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_25"></textarea>
                </td>
            </tr>
            <tr>
                <th>26</th>
                <td colspan="2">¿En caso de almacenamiento de productos químicos, estos se encuentran identificados y almacenados según criterios de seguridad y compatibilidad química, no hay presencia de derrames o fugas?</td>
                <td><input type="radio" name="Criterio_26" value="Cumple"></td>
                <td><input type="radio" name="Criterio_26" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_26" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_26">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_26"></textarea>
                </td>
            </tr>
            <tr>
                <th>27</th>
                <td colspan="2">¿Los pallet cuentan con los perfiles y estos se encuentran en buen estado?</td>
                <td><input type="radio" name="Criterio_27" value="Cumple"></td>
                <td><input type="radio" name="Criterio_27" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_27" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_27">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_27"></textarea>
                </td>
            </tr>
            <tr>
                <th>28</th>
                <td colspan="2">¿El producto almacenado dentro de Taghleef y de exportación cumple con los estándares de inocuidad?</td>
                <td><input type="radio" name="Criterio_28" value="Cumple"></td>
                <td><input type="radio" name="Criterio_28" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_28" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_28">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_28"></textarea>
                </td>
            </tr>
            <tr>
                <th colspan="10" class="Fondo-gris Texto-Izquierda">
                    ILUMINACIÓN, VENTILACIÓN Y SISTEMAS ELÉCTRICOS
                </th>
            </tr>
            <tr>
                <th>29</th>
                <td colspan="2">¿La iluminación (natural o artificial) en el área de trabajo facilita el desarrollo de las labores y se encuentra homogéneamente distribuida, previniendo el deslumbramiento o penumbra?</td>
                <td><input type="radio" name="Criterio_29" value="Cumple"></td>
                <td><input type="radio" name="Criterio_29" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_29" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_29">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_29"></textarea>
                </td>
            </tr>

            <tr>
                <th>30</th>
                <td colspan="2">¿Las instalaciones eléctricas cuentan con polo a tierra?</td>
                <td><input type="radio" name="Criterio_30" value="Cumple"></td>
                <td><input type="radio" name="Criterio_30" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_30" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_30">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_30"></textarea>
                </td>
            </tr>

            <tr>
                <th>31</th>
                <td colspan="2">¿Los cables, conexiones, extensiones, enchufes, tomacorriente, interruptores y otros elementos del sistema eléctrico se encuentran en buen estado, organizados correctamente, libre de deterioro aparente o cualquier otro indicio de daño?</td>
                <td><input type="radio" name="Criterio_31" value="Cumple"></td>
                <td><input type="radio" name="Criterio_31" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_31" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_31">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_31"></textarea>
                </td>
            </tr>

            <tr>
                <th>32</th>
                <td colspan="2">¿En caso de acumulación de material particulado, gases, humos y/o vapores en el área, se cuenta con un sistema de extracción natural o mecanizado eficiente que reduzca la concentración a límites permisibles?</td>
                <td><input type="radio" name="Criterio_32" value="Cumple"></td>
                <td><input type="radio" name="Criterio_32" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_32" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_32">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_32"></textarea>
                </td>
            </tr>
            <tr>
                <th colspan="10" class="Fondo-gris Texto-Izquierda">
                    ORDEN Y ASEO EN EL ÁREA DE TRABAJO
                </th>
            </tr>
            <tr>
                <th>33</th>
                <td colspan="2">¿El área de trabajo se encuentra organizada, según estándares de ubicación de los diversos elementos, el área se encuentra limpia, libre de residuos en el piso, se retiran los residuos del área oportunamente?</td>
                <td><input type="radio" name="Criterio_33" value="Cumple"></td>
                <td><input type="radio" name="Criterio_33" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_33" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_33">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_33"></textarea>
                </td>
            </tr>

            <tr>
                <th>34</th>
                <td colspan="2">¿Se respeta la demarcación de franja blanca?</td>
                <td><input type="radio" name="Criterio_34" value="Cumple"></td>
                <td><input type="radio" name="Criterio_34" value="No Cumple"></td>
                <td><input type="radio" name="Criterio_34" value="No Aplica"></td>
                <td>
                    <select name="Grado_Criterio_34">
                        <option value="">Ninguna</option>
                        <option value="A">A - Inmediata</option>
                        <option value="B">B - Pronta</option>
                        <option value="C">C - Posterior</option>
                    </select>
                </td>
                <td colspan="3">
                    <textarea name="Observaciones_Criterio_34"></textarea>
                </td>
            </tr>
            <tr>
                <th colspan="10">
                    REPORTE DE LOS TRABAJADORES DE LAS CONDICIONES Y ACTOS PELIGROSOS IDENTIFICADOS EN EL ÁREA DE TRABAJO
                </th>
            </tr>
            <tr id="nuevaFila">
                <td colspan="10"><textarea id="Criterio_35" name="Criterio_35"></textarea></td>
            </tr>
            <tr>
                <th colspan="10">
                    UBICACIONES CON RECTRICCIÓN PARA UBICACIÓN EN DOBLE PROFUDIDAD  
                </th>
            </tr>
            <tr>
                <!--Plano -->
                <td colspan="10">
                    <table border="1" style="width: 100%; table-layout: auto;">
                        <tr>
                            <td colspan="5" rowspan="18">
                                <img src="https://extintorescamein.com/wp-content/uploads/2020/08/zona-de-carga-y-descarga.png" width="50%">
                            </td>
                            <td colspan="2" rowspan="3" class="Fondo-gris">
                                Oficina Coordinador De Despachos
                            </td>
                            <td colspan="2" rowspan="3">
                                <img src="https://www.jmcprl.net/senal%2001/EQUIPOS%20CONTRA%20INCENDIOS%203.jpg" width="50%">
                            </td>
                            <td colspan="3" rowspan="3">
                                Ubicaciones L- 03
                            </td>
                            <td colspan="6" rowspan="3">
                                Ubicaciones L- 04
                            </td>
                            <td colspan="3" rowspan="3">
                                <img src="https://www.jmcprl.net/senal%2001/EQUIPOS%20CONTRA%20INCENDIOS%203.jpg" width="50%">
                            </td>
                            <td>
                                N.088
                            </td>
                            <td>
                                N.089
                            </td>
                            <td colspan="2" rowspan="3" class="Fondo-gris">
                                Entrada Almacen Empaque
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.087
                            </td>
                            <td>
                                N.090
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.086
                            </td>
                            <td>
                                N.091
                            </td>
                        </tr>
                        <tr>
                            <th colspan="20" rowspan="2">
                                Pasillo Principal
                            </th>
                        </tr>
                        <tr>   
                        </tr>
                        <tr>
                            <td rowspan="2">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ2VYK8-a_FCvHDgLmWfM0UCrbteEzYkwiYSg&s" width="50%">
                            </td>
                            <td rowspan="14"></td>
                            <td>
                                N.016
                            </td>
                            <td>
                                N.017
                            </td>
                            <td rowspan="14"></td>
                            <td>
                                N.042
                            </td>
                            <td>
                                N.043
                            </td>
                            <td colspan="2" rowspan="14"></td>
                            <td>
                                N.065
                            </td>
                            <td>
                                N.066
                            </td>
                            <td rowspan="5"></td>
                            <td>
                                N.075
                            </td>
                            <td>
                                N.076
                            </td>
                            <td colspan="2" rowspan="5"></td>
                            <td>
                                N.085
                            </td>
                            <td>
                                N.092
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>
                                N.015
                            </td>
                            <td>
                                N.018
                            </td>
                            <td>
                                N.041
                            </td>
                            <td>
                                N.044
                            </td>
                            <td>
                                N.064
                            </td>
                            <td>
                                N.067
                            </td>
                            <td>
                                N.074
                            </td>
                            <td>
                                N.077
                            </td>
                            <td>
                                N.084
                            </td>
                            <td>
                                N.093
                            </td>
                            <td rowspan="3"></td>
                            <td>
                                N.099
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="4"> 
                                <img src="https://www.jmcprl.net/senal%2001/EQUIPOS%20CONTRA%20INCENDIOS%203.jpg" width="50%">
                            </td>
                            <td>
                                N.014
                            </td>
                            <td>
                                N.019
                            </td>
                            <td>
                                N.040
                            </td>
                            <td>
                                N.045
                            </td>
                            <td>
                                N.063
                            </td>
                            <td>
                                N.068
                            </td>
                            <td>
                                N.073
                            </td>
                            <td>
                                N.078
                            </td>
                            <td>
                                N.083
                            </td>
                            <td>
                                N.094
                            </td>
                            <td>
                                N.098
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.013
                            </td>
                            <td>
                                N.020
                            </td>
                            <td>
                                N.039
                            </td>
                            <td>
                                N.046
                            </td>
                            <td>
                                N.062
                            </td>
                            <td>
                                N.069
                            </td>
                            <td>
                                N.072
                            </td>
                            <td>
                                N.079
                            </td>
                            <td>
                                N.082
                            </td>
                            <td>
                                N.095
                            </td>
                            <td>
                                N.097
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.012
                            </td>
                            <td>
                                N.021
                            </td>
                            <td>
                                N.038
                            </td>
                            <td>
                                N.047
                            </td>
                            <td>
                                N.061
                            </td>
                            <td>
                                N.070
                            </td>
                            <td>
                                N.071
                            </td>
                            <td>
                                N.080
                            </td>
                            <td>
                                N.081
                            </td>
                            <td colspan="2"></td>
                            <td>
                                N.096
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.011
                            </td>
                            <td>
                                N.022
                            </td>
                            <td>
                                N.037
                            </td>
                            <td>
                                N.048
                            </td>
                            <td>
                                N.060
                            </td>
                            <td colspan="10" rowspan="9" style="text-align: center;">
                                <b>Area de productos en proceso.</b>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.001
                            </td>
                            <td>
                                N.010
                            </td>
                            <td>
                                N.023
                            </td>
                            <td>
                                N.036
                            </td>
                            <td>
                                N.049
                            </td>
                            <td>
                                N.059
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.002
                            </td>
                            <td>
                                N.009
                            </td>
                            <td>
                                N.024
                            </td>
                            <td>
                                N.035
                            </td>
                            <td>
                                N.050
                            </td>
                            <td>
                                N.058
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.003
                            </td>
                            <td>
                                N.008
                            </td>
                            <td>
                                N.025
                            </td>
                            <td>
                                N.034
                            </td>
                            <td>
                                N.051
                            </td>
                            <td>
                                N.057
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.004
                            </td>
                            <td>
                                N.007
                            </td>
                            <td>
                                N.026
                            </td>
                            <td>
                                N.033
                            </td>
                            <td>
                                N.052
                            </td>
                            <td>
                                N.056
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.005
                            </td>
                            <td>
                                N.006
                            </td>
                            <td>
                                N.027
                            </td>
                            <td>
                                N.032
                            </td>
                            <td>
                                N.053
                            </td>
                            <td rowspan="4" class="Fondo-gris" style="text-align: center;">
                                Estanteria Vacia.
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="3" class="Fondo-gris" style="text-align: center;">
                                Estanteria Vacia.
                            </td>
                            <td rowspan="2" class="Fondo-gris" style="text-align: center;">
                                Estanteria Vacia.
                            </td>
                            <td>
                                N.028
                            </td>
                            <td>
                                N.031
                            </td>
                            <td>
                                N.054
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.029
                            </td>
                            <td>
                                N.030
                            </td>
                            <td>
                                N.055
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ2VYK8-a_FCvHDgLmWfM0UCrbteEzYkwiYSg&amp;s" height="50px">
                            </td>
                            <td colspan="2" class="Fondo-gris" style="text-align: center;">
                                Estanteria Vacia.
                            </td>
                            <td colspan="2" class="Fondo-gris" style="text-align: center;">
                                Estanteria Vacia.
                            </td>
                        </tr>
                        <tr>
                            <td colspan="25" style="padding: 10px;"></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="Fondo-gris" >
                                Salida Taller De Montacargas
                            </td>
                            <td colspan="21" style="text-align: center;">NO SACAR EN DOBLE PROFUNDIDAD</td>
                        </tr>
                        <tr>
                            <td rowspan="12"></td>
                            <td colspan="3" rowspan="2"></td>
                            <td>
                                N.146
                            </td>
                            <td rowspan="12"></td>
                            <td>
                                N.147
                            </td>
                            <td>
                                N.180
                            </td>
                            <td rowspan="12"></td>
                            <td>
                                N.181
                            </td>
                            <td>
                                N.209
                            </td>
                            <td rowspan="12"></td>
                            <td>
                                N.210
                            </td>
                            <td colspan="15" rowspan="6" class="Fondo-gris"></td>
                        </tr>
                        <tr>
                            <td>
                                N.145
                            </td>
                            <td>
                                N.148
                            </td>
                            <td>
                                N.179
                            </td>
                            <td>
                                N.182
                            </td>
                            <td>
                                N.208
                            </td>
                            <td>
                                N.211
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.114
                            </td>
                            <td rowspan="10"></td>
                            <td>
                                N.115
                            </td>
                            <td>
                                N.144
                            </td>
                            <td>
                                N.149
                            </td>
                            <td>
                                N.178
                            </td>
                            <td>
                                N.183
                            </td>
                            <td>
                                N.207
                            </td>
                            <td>
                                N.212
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.113
                            </td>
                            <td>
                                N.116
                            </td>
                            <td>
                                N.143
                            </td>
                            <td>
                                N.150
                            </td>
                            <td>
                                N.177
                            </td>
                            <td>
                                N.184
                            </td>
                            <td>
                                N.206
                            </td>
                            <td>
                                N.213
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.112
                            </td>
                            <td>
                                N.117
                            </td>
                            <td>
                                N.142
                            </td>
                            <td>
                                N.151
                            </td>
                            <td>
                                N.176
                            </td>
                            <td>
                                N.185
                            </td>
                            <td>
                                N.205
                            </td>
                            <td>
                                N.214
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.111
                            </td>
                            <td>
                                N.118
                            </td>
                            <td>
                                N.141
                            </td>
                            <td>
                                N.152
                            </td>
                            <td>
                                N.175
                            </td>
                            <td>
                                N.186
                            </td>
                            <td>
                                N.204
                            </td>
                            <td>
                                N.215
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.110
                            </td>
                            <td>
                                N.119
                            </td>
                            <td>
                                N.140
                            </td>
                            <td>
                                N.153
                            </td>
                            <td>
                                N.174
                            </td>
                            <td>
                                N.187
                            </td>
                            <td>
                                N.203
                            </td>
                            <td>
                                N.216
                            </td>
                            <td>
                                N.232
                            </td>
                            <td rowspan="6"></td>
                            <td>
                                N.233
                            </td>
                            <td>
                                N.254
                            </td>
                            <td rowspan="6"></td>
                            <td>
                                N.255
                            </td>
                            <td>
                                N.276
                            </td>
                            <td rowspan="6"></td>
                            <td>
                                N.277
                            </td>
                            <td>
                                N.296
                            </td>
                            <td rowspan="6"></td>
                            <td>
                                N.297
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.109
                            </td>
                            <td>
                                N.120
                            </td>
                            <td>
                                N.139
                            </td>
                            <td>
                                N.154
                            </td>
                            <td>
                                N.173
                            </td>
                            <td>
                                N.188
                            </td>
                            <td>
                                N.202
                            </td>
                            <td>
                                N.217
                            </td>
                            <td>
                                N.231
                            </td>
                            <td>
                                N.234
                            </td>
                            <td>
                                N.253
                            </td>
                            <td>
                                N.256
                            </td>
                            <td>
                                N.275
                            </td>
                            <td>
                                N.278
                            </td>
                            <td>
                                N.295
                            </td>
                            <td>
                                N.298
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.108
                            </td>
                            <td>
                                N.121
                            </td>
                            <td>
                                N.138
                            </td>
                            <td>
                                N.155
                            </td>
                            <td>
                                N.172
                            </td>
                            <td>
                                N.189
                            </td>
                            <td>
                                N.201
                            </td>
                            <td>
                                N.218
                            </td>
                            <td>
                                N.230
                            </td>
                            <td>
                                N.235
                            </td>
                            <td>
                                N.252
                            </td>
                            <td>
                                N.257
                            </td>
                            <td>
                                N.274
                            </td>
                            <td>
                                N.279
                            </td>
                            <td>
                                N.294
                            </td>
                            <td>
                                N.299
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.107
                            </td>
                            <td>
                                N.122
                            </td>
                            <td>
                                N.137
                            </td>
                            <td>
                                N.156
                            </td>
                            <td>
                                N.171
                            </td>
                            <td>
                                N.190
                            </td>
                            <td>
                                N.200
                            </td>
                            <td>
                                N.219
                            </td>
                            <td>
                                N.229
                            </td>
                            <td>
                                N.236
                            </td>
                            <td>
                                N.251
                            </td>
                            <td>
                                N.258
                            </td>
                            <td>
                                N.273
                            </td>
                            <td>
                                N.280
                            </td>
                            <td>
                                N.293
                            </td>
                            <td>
                                N.300
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.106
                            </td>
                            <td>
                                N.123
                            </td>
                            <td>
                                N.136
                            </td>
                            <td>
                                N.157
                            </td>
                            <td>
                                N.170
                            </td>
                            <td>
                                N.191
                            </td>
                            <td>
                                N.199
                            </td>
                            <td>
                                N.220
                            </td>
                            <td>
                                N.228
                            </td>
                            <td>
                                N.237
                            </td>
                            <td>
                                N.250
                            </td>
                            <td>
                                N.259
                            </td>
                            <td>
                                N.272
                            </td>
                            <td>
                                N.281
                            </td>
                            <td>
                                N.292
                            </td>
                            <td>
                                N.301
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.105
                            </td>
                            <td>
                                N.124
                            </td>
                            <td>
                                N.135
                            </td>
                            <td>
                                N.158
                            </td>
                            <td>
                                N.169
                            </td>
                            <td>
                                N.192
                            </td>
                            <td>
                                N.198
                            </td>
                            <td>
                                N.221
                            </td>
                            <td>
                                N.227
                            </td>
                            <td>
                                N.238
                            </td>
                            <td>
                                N.249
                            </td>
                            <td>
                                N.260
                            </td>
                            <td>
                                N.271
                            </td>
                            <td>
                                N.282
                            </td>
                            <td>
                                N.291
                            </td>
                            <td>
                                N.302
                            </td>
                        </tr>
                        <tr>
                            <td colspan="25" style="padding: 10px;"></td>
                        </tr>
                        <tr>
                            <td rowspan="5"></td>
                            <td>
                                N.104
                            </td>
                            <td rowspan="5"></td>
                            <td>
                                N.125
                            </td>
                            <td>
                                N.134
                            </td>
                            <td rowspan="5"></td>
                            <td>
                                N.159
                            </td>
                            <td>
                                N.168
                            </td>
                            <td rowspan="5"></td>
                            <td>
                                N.193
                            </td>
                            <td rowspan="5" colspan="2" style="text-align: center;">
                                Ubicacion L-10
                            </td>
                            <td rowspan="5"></td>                            
                            <td>
                                N.226
                            </td>
                            <td rowspan="5"></td>
                            <td>
                                N.239
                            </td>
                            <td>
                                N.248
                            </td>
                            <td rowspan="5"></td>
                            <td>
                                N.261
                            </td>
                            <td>
                                N.270
                            </td>
                            <td rowspan="5"></td>
                            <td rowspan="2">
                                N.283
                            </td>
                            <td rowspan="2">
                                N.290
                            </td>
                            <td rowspan="5" colspan="2">
                                Ubicacion L-02
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.103
                            </td>
                            <td>
                                N.126
                            </td>
                            <td>
                                N.133
                            </td>
                            <td>
                                N.160
                            </td>
                            <td>
                                N.167
                            </td>
                            <td>
                                N.194
                            </td>
                            <td>
                                N.225
                            </td>
                            <td>
                                N.240
                            </td>
                            <td>
                                N.247
                            </td>
                            <td>
                                N.262
                            </td>
                            <td>
                                N.269
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.102
                            </td>
                            <td>
                                N.127
                            </td>
                            <td>
                                N.132
                            </td>
                            <td>
                                N.161
                            </td>
                            <td>
                                N.166
                            </td>
                            <td>
                                N.195
                            </td>
                            <td>
                                N.224
                            </td>
                            <td>
                                N.241
                            </td>
                            <td>
                                N.246
                            </td>
                            <td>
                                N.263
                            </td>
                            <td>
                                N.268
                            </td>
                            <td>
                                N.284
                            </td>
                            <td>
                                N.289
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.101
                            </td>
                            <td>
                                N.128
                            </td>
                            <td>
                                N.131
                            </td>
                            <td>
                                N.162
                            </td>
                            <td>
                                N.165
                            </td>
                            <td>
                                N.196
                            </td>
                            <td>
                                N.223
                            </td>
                            <td>
                                N.242
                            </td>
                            <td>
                                N.245
                            </td>
                            <td>
                                N.264
                            </td>
                            <td>
                                N.267
                            </td>
                            <td>
                                N.285
                            </td>
                            <td>
                                N.288
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N.100
                            </td>
                            <td>
                                N.129
                            </td>
                            <td>
                                N.130
                            </td>
                            <td>
                                N.163
                            </td>
                            <td>
                                N.164
                            </td>
                            <td>
                                N.197
                            </td>
                            <td>
                                N.222
                            </td>
                            <td>
                                N.243
                            </td>
                            <td>
                                N.244
                            </td>
                            <td>
                                N.265
                            </td>
                            <td>
                                N.266
                            </td>
                            <td>
                                N.286
                            </td>
                            <td>
                                N.287
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            <tr>
                <th colspan="10">
                    REGISTRO DE EVIDENCIAS FOTOGRAFICAS                    
                </th>
            </tr>
            <tr>
                <td colspan="10">
                    <textarea name="Criterio_36" id="Criterio_36"></textarea>
                </td>
            </tr>
        </form>
    </tbody>    
</table>
<!-- Formulario para enviar datos al controlador -->
<script src="../App/Views/Js/Inspecciones/PuestoDeTrabajo.js"></script>
<script>
    const textarea = document.getElementById("textArea");

    function ajustarAltura() {
        textarea.style.height = 'auto';
        textarea.style.height = `${textarea.scrollHeight}px`;
    }
    textarea.addEventListener("input", ajustarAltura);
    ajustarAltura();

    $(document).ready(function() {
        $('#Buscar-Persona-Evaluada').on('click', function() {
            alertify.confirm('Buscar Persona Evaluada',
                `<div>
                <label for="cedula">Cédula:</label>
                <input type="text" id="cedula-modal" placeholder="Ingrese cédula">
                <table border="1" id="tabla-resultados" style="display:none; margin-top: 10px;">
                    <thead>
                        <tr>
                            <th>Nombre Completo</th>
                            <th>Cargo</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="resultados"></tbody>
                </table>
            </div>`,
                function() {},
                function() {
                    alertify.error('Búsqueda cancelada');
                }
            );

            $('#cedula-modal').on('input', function() {
                var cedula = $(this).val();
                if (cedula.length >= 1) {
                    $.ajax({
                        url: 'BuscarPersonaEvaluada',
                        method: 'POST',
                        data: {
                            cedula: cedula
                        },
                        dataType: 'json',
                        success: function(response) {
                            var resultados = $('#resultados');
                            resultados.empty();
                            if (response.length > 0) {
                                $('#tabla-resultados').show();
                                response.forEach(function(usuario) {
                                    resultados.append(
                                        `<tr>
                                        <td>${usuario.NombreCompleto}</td>
                                        <td>${usuario.Cargo}</td>
                                        <td style="display:none;">${usuario.ID}</td>
                                        <td>
                                            <button class="agregar">+</button>
                                        </td>
                                    </tr>`
                                    );
                                });
                            } else {
                                $('#tabla-resultados').hide();
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alertify.error('Error en la búsqueda: ' + textStatus + ' - ' + errorThrown);
                        }
                    });
                } else {
                    $('#tabla-resultados').hide();
                }
            });

            $(document).on('click', '.agregar', function() {
                var fila = $(this).closest('tr');
                var nombre = fila.find('td:eq(0)').text();
                var cargo = fila.find('td:eq(1)').text();
                var ID = fila.find('td:eq(2)').text();

                if ($('#persona-evaluada').text() != '') {
                    alertify.confirm('Cambiar Persona Evaluada',
                        `¿Desea cambiar la persona evaluada por ${nombre}?`,
                        function() {
                            $('#persona-evaluada').text(nombre);
                            $('#cargo-evaluado').text(cargo);
                            $('#ID_PersonaEvaluada').val(ID);
                            alertify.confirm().close();
                        },
                        function() {
                            alertify.error('Cambio cancelado');
                        }
                    );
                } else {
                    $('#persona-evaluada').text(nombre);
                    $('#cargo-evaluado').text(cargo);
                    $('#ID_PersonaEvaluada').val(ID);
                    alertify.confirm().close();
                }
            });
        });

        $('#Buscar-Montacargas-Evaluada').on('click', function() {
            alertify.confirm('Buscar Montacargas Evaluada',
                `<div>
                <label for="montacargas">Numero:</label>
                <input type="text" id="montacargas-modal" placeholder="Ingrese número">
                <table border="1" id="tabla-resultados-montacargas" style="display:none; margin-top: 10px;">
                    <thead>
                        <tr>
                            <th>Numero</th>
                            <th>Modelo</th>
                            <th>Marca</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="resultados-montacargas"></tbody>
                </table>
            </div>`,
                function() {
                    alertify.message('Búsqueda completada');
                },
                function() {
                    alertify.error('Búsqueda cancelada');
                }
            );

            $('#montacargas-modal').on('input', function() {
                var numero = $(this).val();
                var ID_Centro = '<?php echo $_SESSION["NoCentro"]; ?>';

                if (numero.length >= 1) {
                    $.ajax({
                        url: 'BuscarMontacargasEvaluada',
                        method: 'POST',
                        data: {
                            numero: numero,
                            ID_Centro: ID_Centro
                        },
                        dataType: 'json',
                        success: function(response) {
                            var resultados = $('#resultados-montacargas');
                            resultados.empty();
                            if (response.length > 0) {
                                $('#tabla-resultados-montacargas').show();
                                response.forEach(function(montacarga) {
                                    resultados.append(
                                        `<tr>
                                        <td>${montacarga.Numero}</td>
                                        <td>${montacarga.Modelo}</td>
                                        <td>${montacarga.Marca}</td>
                                        <td style="display:none;">${montacarga.ID}</td>
                                        <td><button class="agregar-montacargas">+</button></td>
                                    </tr>`
                                    );
                                });
                            } else {
                                $('#tabla-resultados-montacargas').hide();
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alertify.error('Error en la búsqueda: ' + textStatus + ' - ' + errorThrown);
                        }
                    });
                } else {
                    $('#tabla-resultados-montacargas').hide();
                }
            });

            $(document).on('click', '.agregar-montacargas', function() {
                var fila = $(this).closest('tr');
                var numero = fila.find('td:eq(0)').text();
                var modelo = fila.find('td:eq(1)').text();
                var marca = fila.find('td:eq(2)').text();
                var ID = fila.find('td:eq(3)').text();

                if ($('#montacargas-evaluada').text() != '') {
                    alertify.confirm('Cambiar Montacargas',
                        `¿Desea cambiar el montacargas seleccionado por ${numero}?`,
                        function() {
                            $('#montacargas-evaluada').text(numero);
                            $('#tipo-montacargas-evaluado').text(modelo + ' - ' + marca);
                            $('#ID_Montacargas').val(ID);
                            alertify.confirm().close();
                        },
                        function() {
                            alertify.error('Cambio cancelado');
                        }
                    );
                } else {
                    $('#montacargas-evaluada').text(numero);
                    $('#tipo-montacargas-evaluado').text(modelo + ' - ' + marca);
                    $('#ID_Montacargas').val(ID);
                    alertify.confirm().close();
                }
            });
        });
    });
</script>