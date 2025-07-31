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
<table border="1">
    <thead>
        <tr>
            <th rowspan="3"><img src="../App/Views/Img/Outkargo.png" width="200px"></th>
            <th rowspan="3" class="Titulo" style="font-size: 20px;">Inspeccion de <?= $TipoInspeccion ?></th>
            <th>CODIGO:</th>
            <td>F-84</td>
        </tr>
        <tr>
            <th>FECHA:</th>
            <td>08/11/2024</td>
        </tr>
        <tr>
            <th>VERSIÓN:</th>
            <td>3</td>
        </tr>
    </thead>
</table>
<table border="1">
    <tbody>
        <tr>
            <th class="Texto-Izquierda">CENTRO DE TRABAJO:</th>
            <td class="Texto-Izquierda"><?= $_SESSION['Centro'] ?></td>
            <th class="Texto-Izquierda">Fecha:</th>
            <td class="Texto-Izquierda"><?= $FechaHoy ?></td>
        </tr>
        <tr>
            <th class="Texto-Izquierda">No. Montacargas: <button id="Buscar-Montacargas-Evaluada">Buscar</button></th>
            <td class="Texto-Izquierda">
                <p id="montacargas-evaluada"></p>
            </td>
            <th class="Texto-Izquierda">Tipo:</th>
            <td class="Texto-Izquierda">
                <p id="tipo-montacargas-evaluado"></p>
            </td>
        </tr>
        <tr>
            <th class="Texto-Izquierda">REALIZA:</th>
            <td class="Texto-Izquierda"><?= $_SESSION['NombreCompleto'] ?></td>
            <th class="Texto-Izquierda">Cargo:</th>
            <td class="Texto-Izquierda"><?= $_SESSION['Cargo'] ?></td>
        </tr>
        <tr>
            <th class="Texto-Izquierda">EVALUADA: <button id="Buscar-Persona-Evaluada">Buscar</button></th>
            <td class="Texto-Izquierda">
                <p id="persona-evaluada"></p>
            </td>
            <th class="Texto-Izquierda">Cargo:</th>
            <td class="Texto-Izquierda">
                <p id="cargo-evaluado"></p>
            </td>
        </tr>
    </tbody>
</table>
<!-- Formulario para enviar datos al controlador -->

<form method="POST">
    <input type="hidden" name="Tipo" value="<?= $TipoInspeccion ?>">
    <input type="hidden" name="ID_Centro" value="<?= $_SESSION['NoCentro'] ?>">
    <input type="hidden" name="Fecha" value="<?= $FechaHoy ?>">
    <input type="hidden" name="ID_Montacargas" id="ID_Montacargas">
    <input type="hidden" name="ID_PersonaRegistra" value="<?= $_SESSION['ID'] ?>">
    <input type="hidden" name="ID_PersonaEvaluada" id="ID_PersonaEvaluada">

    <table border="1">
        <tr>
            <td rowspan="3" colspan="2">
                <textarea name="RecomendacionesMedicasDeLaPersonaEvaluada" id="RecomendacionesMedicasDeLaPersonaEvaluada" placeholder="Recomendaciones médicas de la persona evaluada:" rows="10" cols="70%" required></textarea>
            </td>
            <td colspan="2">Se cumplen las recomendaciones médicas por parte del trabajador:</td>
        </tr>
        <tr>
            <td>
                Si: <input type="checkbox" id="criterio1Si" name="criterio1" value="Si" onclick="alternarCheckbox('criterio1No')">
            </td>
            <td>
                No: <input type="checkbox" id="criterio1No" name="criterio1" value="No" onclick="alternarCheckbox('criterio1Si')">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <textarea name="ObservacionesSeCumplenLasRecomendacionesMedicasPorParteDelTrabajador" id="ObservacionesSeCumplenLasRecomendacionesMedicasPorParteDelTrabajador" placeholder="Observaciones:" rows="5" cols="100%" required></textarea>
            </td>
        </tr>
    </table>

    <table border="1">
        <tr>
            <td rowspan="2">
                <textarea name="UsoCorrectoDeLosElementosDeProteccionPersonal" id="UsoCorrectoDeLosElementosDeProteccionPersonal" placeholder="Uso correcto de los elementos de protección personal (ver matriz EPP):" rows="10" cols="70%" required></textarea>
            </td>
            <td>
                Casco con barbuquejo <input type="checkbox" id="criterio2" value="Si" name="criterio2">
            </td>
            <td>
                Mono Gafas <input type="checkbox" id="criterio3" value="Si" name="criterio3">
            </td>
            <td>
                Protección respiratoria <input type="checkbox" id="criterio4" value="Si" name="criterio4">
            </td>
            <td>
                Protección auditiva <input type="checkbox" id="criterio5" value="Si" name="criterio5">
            </td>
        </tr>
        <tr>
            <td>
                Camisa manga larga con reflectivos <input type="checkbox" id="criterio6" value="Si" name="criterio6">
            </td>
            <td>
                Pantalón con reflectivo <input type="checkbox" id="criterio7" value="Si" name="criterio7">
            </td>
            <td>
                Guantes de poliuretano <input type="checkbox" id="criterio8" value="Si" name="criterio8">
            </td>
            <td>
                Botas punta de acero <input type="checkbox" id="criterio9" value="Si" name="criterio9">
            </td>
        </tr>
    </table>

    <table border="1">
        <tr>
            <td>
                Criterio de evaluación Outkargo
            </td>
            <td colspan="2">
                Cumplimiento
            </td>
        </tr>
        <tr>
            <th colspan="3">
                INSPECCIÓN PREOPERACIONAL
            </th>
        </tr>
        <tr>
            <td>
                1. Se realiza la inspección preoperacional antes de iniciar labores con el equipo, incluyendo el cambio de turno y se registra la información de forma legible y completa en el formato correspondiente
            </td>
            <td>
                SI <input type="checkbox" id="criterio10Si" name="criterio10" value="Si" onclick="alternarCheckbox('criterio10No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio10No" name="criterio10" value="No" onclick="alternarCheckbox('criterio10Si')">
            </td>
        </tr>
        <tr>
            <td>
                2. El operador realiza correctamente la inspección preoperacional del equipo. Los registros de la inspección corresponden a las condiciones del equipo (realizar la inspección preoperacional junto con el operador)
            </td>
            <td>
                SI <input type="checkbox" id="criterio11Si" name="criterio11" value="Si" onclick="alternarCheckbox('criterio11No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio11No" name="criterio11" value="No" onclick="alternarCheckbox('criterio11Si')">
            </td>
        </tr>
        <tr>
            <td>
                3. Reporta inmediatamente al supervisor las fallas presentadas en la máquina
            </td>
            <td>
                SI <input type="checkbox" id="criterio12Si" name="criterio12" value="Si" onclick="alternarCheckbox('criterio12No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio12No" name="criterio12" value="No" onclick="alternarCheckbox('criterio12Si')">
            </td>
        </tr>
        <tr>
            <td>
                4. El equipo no es operado si presenta alguna(s) de las siguiente(s) características: daños en las ruedas que puedan originar el desbalanceo de la máquina, fugas de gas propano, líquido de frenos, aceite hidráulico, combustible, electrolito, extintor de incendios vencido. Otros daños evidentes que puedan afectar la seguridad en la operación.
            </td>
            <td>
                SI <input type="checkbox" id="criterio13Si" name="criterio13" value="Si" onclick="alternarCheckbox('criterio13No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio13No" name="criterio13" value="No" onclick="alternarCheckbox('criterio13Si')">
            </td>
        </tr>
        <tr>
            <td>
                5. El operador mantiene su área de trabajo en óptimas condiciones de orden y aseo
            </td>
            <td>
                SI <input type="checkbox" id="criterio14Si" name="criterio14" value="Si" onclick="alternarCheckbox('criterio14No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio14No" name="criterio14" value="No" onclick="alternarCheckbox('criterio14Si')">
            </td>
        </tr>
        <tr>
            <th colspan="3">RECOLECCIÓN DE UNA CARGA</th>
        </tr>
        <tr>
            <td>6. Conoce y respeta la capacidad nominal del montacargas</td>
            <td>
                SI <input type="checkbox" id="criterio15Si" name="criterio15" value="Si" onclick="alternarCheckbox('criterio15No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio15No" name="criterio15" value="No" onclick="alternarCheckbox('criterio15Si')">
            </td>
        </tr>
        <tr>
            <td>7. Centra la montacarga al frente de la carga. Detiene la montacarga cuando la punta de las horquillas se acerca a unos 30 cm de la carga. Solicita el retiro de personal cercano, que pudiera verse afectado por la operación. Nivela las horquillas y las introduce lentamente en el soporte de la carga. Lleva la carga lo más cerca al mástil sin que se presente daño de ésta y/o de la montacarga. Levanta suavemente la carga, inclina ligeramente el mástil hacia atrás. Mira hacia atrás por encima de los hombros. Retira la carga del lugar de apilamiento en línea recta, frena y desciende la carga hasta la altura en que se realizará el traslado.</td>
            <td>
                SI <input type="checkbox" id="criterio16Si" name="criterio16" value="Si" onclick="alternarCheckbox('criterio16No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio16No" name="criterio16" value="No" onclick="alternarCheckbox('criterio16Si')">
            </td>
        </tr>
        <tr>
            <th colspan="3">DESPLAZAMIENTO</th>
        </tr>
        <tr>
            <td>8. El operador respeta los límites de velocidad máxima de 5km/h establecidos por la empresa</td>
            <td>
                SI <input type="checkbox" id="criterio17Si" name="criterio17" value="Si" onclick="alternarCheckbox('criterio17No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio17No" name="criterio17" value="No" onclick="alternarCheckbox('criterio17Si')">
            </td>
        </tr>
        <tr>
            <td>9. Moviliza la carga lo más bajo posible (10 cm a 15 cm aproximadamente)</td>
            <td>
                SI <input type="checkbox" id="criterio18Si" name="criterio18" value="Si" onclick="alternarCheckbox('criterio18No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio18No" name="criterio18" value="No" onclick="alternarCheckbox('criterio18Si')">
            </td>
        </tr>
        <tr>
            <td>10. Realiza los giros de la carga lo más cercano posible al piso. Sube y baja la carga únicamente con la montacargas detenida.</td>
            <td>
                SI <input type="checkbox" id="criterio19Si" name="criterio19" value="Si" onclick="alternarCheckbox('criterio19No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio19No" name="criterio19" value="No" onclick="alternarCheckbox('criterio19Si')">
            </td>
        </tr>
        <tr>
            <td>11. Respeta la señalización existente</td>
            <td>
                SI <input type="checkbox" id="criterio20Si" name="criterio20" value="Si" onclick="alternarCheckbox('criterio20No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio20No" name="criterio20" value="No" onclick="alternarCheckbox('criterio20Si')">
            </td>
        </tr>
        <tr>
            <td>12. Frena y pita en las intersecciones; da prioridad al paso de peatones</td>
            <td>
                SI <input type="checkbox" id="criterio21Si" name="criterio21" value="Si" onclick="alternarCheckbox('criterio21No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio21No" name="criterio21" value="No" onclick="alternarCheckbox('criterio21Si')">
            </td>
        </tr>
        <tr>
            <td>13. El operador lleva todo el cuerpo dentro del montacargas y usa el cinturón de seguridad</td>
            <td>
                SI <input type="checkbox" id="criterio22Si" name="criterio22" value="Si" onclick="alternarCheckbox('criterio22No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio22No" name="criterio22" value="No" onclick="alternarCheckbox('criterio22Si')">
            </td>
        </tr>
        <tr>
            <td>14. El operador se desplaza en reversa, en los casos en que la carga bloquea su visibilidad</td>
            <td>
                SI <input type="checkbox" id="criterio23Si" name="criterio23" value="Si" onclick="alternarCheckbox('criterio23No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio23No" name="criterio23" value="No" onclick="alternarCheckbox('criterio23Si')">
            </td>
        </tr>
        <tr>
            <td>15. El operador mantiene una distancia de al menos tres (3) montacargas entre su montacargas y cualquier otro que se desplace delante suyo</td>
            <td>
                SI <input type="checkbox" id="criterio24Si" name="criterio24" value="Si" onclick="alternarCheckbox('criterio24No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio24No" name="criterio24" value="No" onclick="alternarCheckbox('criterio24Si')">
            </td>
        </tr>
        <tr>
            <td>16. El operador se mantiene concentrado durante la operación del montacargas, no utiliza ningún tipo de dispositivo que limite su concentración, capacidad visual y auditiva (celular, iPod).</td>
            <td>
                SI <input type="checkbox" id="criterio25Si" name="criterio25" value="Si" onclick="alternarCheckbox('criterio25No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio25No" name="criterio25" value="No" onclick="alternarCheckbox('criterio25Si')">
            </td>
        </tr>
        <tr>
            <td>17. El operador toma los controles necesarios para impedir que las personas caminen o trabajen debajo de las horquillas del cargador izado, sin importar si el cargador lleva o no carga</td>
            <td>
                SI <input type="checkbox" id="criterio26Si" name="criterio26" value="Si" onclick="alternarCheckbox('criterio26No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio26No" name="criterio26" value="No" onclick="alternarCheckbox('criterio26Si')">
            </td>
        </tr>
        <tr>
            <td>18. El operador verifica que haya suficiente espacio entre el piso y las vigas, luces, rociadores, tubos y obstáculos para que pase el montacargas y la carga.</td>
            <td>
                SI <input type="checkbox" id="criterio27Si" name="criterio27" value="Si" onclick="alternarCheckbox('criterio27No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio27No" name="criterio27" value="No" onclick="alternarCheckbox('criterio27Si')">
            </td>
        </tr>
        <tr>
            <td>19. Asciende y desciende pendientes con la carga en la parte superior</td>
            <td>
                SI <input type="checkbox" id="criterio28Si" name="criterio28" value="Si" onclick="alternarCheckbox('criterio28No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio28No" name="criterio28" value="No" onclick="alternarCheckbox('criterio28Si')">
            </td>
        </tr>
        <tr>
            <td>20. Verifica la integridad de la carga y que las condiciones de embalaje y estibado de ésta sean adecuadas para realizar una operación segura.</td>
            <td>
                SI <input type="checkbox" id="criterio29Si" name="criterio29" value="Si" onclick="alternarCheckbox('criterio29No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio29No" name="criterio29" value="No" onclick="alternarCheckbox('criterio29Si')">
            </td>
        </tr>
        <tr>
            <th colspan="3">ESTACIONAMIENTO Y PARQUEO</th>
        </tr>
        <tr>
            <td>21. La montacargas no se deja desatendida por parte del operador (a más de 7.5 m de distancia entre el operador y el equipo) encendido y/o con las llaves puestas.</td>
            <td>
                SI <input type="checkbox" id="criterio30Si" name="criterio30" value="Si" onclick="alternarCheckbox('criterio30No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio30No" name="criterio30" value="No" onclick="alternarCheckbox('criterio30Si')">
            </td>
        </tr>
        <tr>
            <td>22. La montacargas es ubicada en lugares de estacionamiento autorizados por la empresa</td>
            <td>
                SI <input type="checkbox" id="criterio31Si" name="criterio31" value="Si" onclick="alternarCheckbox('criterio31No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio31No" name="criterio31" value="No" onclick="alternarCheckbox('criterio31Si')">
            </td>
        </tr>
        <tr>
            <td>23. Las horquillas son ubicadas al piso. Se neutralizan los controles. Se aplica el freno de mano. Se apaga la montacargas. Se ubican tacos en las ruedas, en caso de pendientes. Se cierra la llave del gas.</td>
            <td>
                SI <input type="checkbox" id="criterio32Si" name="criterio32" value="Si" onclick="alternarCheckbox('criterio32No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio32No" name="criterio32" value="No" onclick="alternarCheckbox('criterio32Si')">
            </td>
        </tr>
        <tr>
            <td>24. El operador de montacargas sube y baja del equipo, empleando la técnica de los tres puntos de apoyo.</td>
            <td>
                SI <input type="checkbox" id="criterio33Si" name="criterio33" value="Si" onclick="alternarCheckbox('criterio33No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio33No" name="criterio33" value="No" onclick="alternarCheckbox('criterio33Si')">
            </td>
        </tr>
        <tr>
            <th colspan="3">SUMINISTRO DE COMBUSTIBLE/CAMBIO DE PIPETA DE GAS PROPANO/CARGA DE BATERÍA</th>
        </tr>
        <tr>
            <td>25. Se apaga el motor. Ubicación del extintor. Uso de los Elementos de Protección Personal (EPP). Cumple con los procedimientos de suministro de combustible / cambio de pipeta de gas propano o carga de la batería. Limpia derrames de líquido de la batería, combustible y/o aceite.</td>
            <td>
                SI <input type="checkbox" id="criterio34Si" name="criterio34" value="Si" onclick="alternarCheckbox('criterio34No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio34No" name="criterio34" value="No" onclick="alternarCheckbox('criterio34Si')">
            </td>
        </tr>
    </table>

    <table border="1">
        <tr>
            <td>
                Criterio de evaluación establecidos por el cliente / otros criterios de evaluación
            </td>
            <td colspan="2">
                Cumplimiento
            </td>
        </tr>
        <tr>
            <td>Cumple con los estándares de operación y almacenamiento definidos por el cliente y/o documentados por la empresa. Limpia derrames de líquido de la batería, combustible y/o aceite.</td>
            <td>
                SI <input type="checkbox" id="criterio35Si" name="criterio35" onclick="alternarCheckbox('criterio35No')">
            </td>
            <td>
                NO <input type="checkbox" id="criterio35No" name="criterio35" onclick="alternarCheckbox('criterio35Si')">
            </td>
        </tr>
    </table>
    <table border="1" id="tablaCondiciones">
        <tr>
            <th colspan="3">Durante la inspección se identificaron condiciones peligrosas</th>
        </tr>
        <tr>
            <td>Consecutivo</td>
            <td>Descripción</td>
            <td>Acción</td>
        </tr>
    </table>
    <button type="button" onclick="agregarCondicion()">Agregar Condición</button>
    <script>
        let contador = 1;
        let datos = []; // Array para almacenar los datos

        function agregarCondicion() {
            // Crear nueva fila
            const tabla = document.getElementById("tablaCondiciones");
            const nuevaFila = tabla.insertRow(-1);

            // Celda para el número consecutivo
            const celdaConsecutivo = nuevaFila.insertCell(0);
            celdaConsecutivo.innerHTML = contador;

            // Celda para la descripción (con textarea)
            const celdaDescripcion = nuevaFila.insertCell(1);
            celdaDescripcion.innerHTML = `<textarea name="DescripcionCondicion${contador}" id="DescripcionCondicion${contador}" cols="100%" rows="2"></textarea>`;

            // Celda para el botón de eliminar
            const celdaEliminar = nuevaFila.insertCell(2);
            celdaEliminar.innerHTML = '<button type="button" onclick="eliminarFila(this)">Eliminar</button>';

            // Incrementar contador
            contador++;
        }

        function eliminarFila(boton) {
            const fila = boton.parentNode.parentNode;
            fila.remove(); // Elimina la fila
            actualizarConsecutivos(); // Actualiza los números consecutivos
        }

        function actualizarConsecutivos() {
            const filas = document.querySelectorAll("#tablaCondiciones tr");
            contador = 1; // Reset contador para recalcular desde 1
            for (let i = 1; i < filas.length; i++) {
                filas[i].cells[0].innerHTML = contador++; // Actualiza el número consecutivo
            }
        }

        function enviarFormulario() {
            datos = []; // Reiniciar el array
            const filas = document.querySelectorAll("#tablaCondiciones tr");
            for (let i = 1; i < filas.length; i++) {
                const consecutivo = filas[i].cells[0].innerHTML;
                const descripcion = filas[i].cells[1].querySelector("textarea").value; // Obtener el valor del textarea
                datos.push({ consecutivo, descripcion }); // Guardar en el array
            }
            console.log(datos); // Mostrar en consola (puedes enviarlo a un servidor)
            alert("Datos guardados en el array. Revisa la consola para verlos.");
        }
    </script>

    <table border="1">
        <tr>
            <td>
                <b>Nota.</b>
                En caso de que se evidencie incumplimiento por parte del operador de alguno de los aspectos arriba evaluados, debe hacer la observación de forma inmediata al trabajador y dejar por escrito el reporte con la novedad correspondiente.
                En caso de identificar condiciones inseguras durante la inspección, se debe diligenciar el formato respectivo, relacionar el consecutivo y describirla en el presente formato.
            </td>
        </tr>
    </table>
    <input type="submit" value="Enviar">
</form>

<script>
    function alternarCheckbox(id) {
        var otroCheckbox = document.getElementById(id);
        otroCheckbox.checked = false;
    }
</script>
<script src="../App/Views/Js/Inspecciones/PuestoDeTrabajo.js"></script>
<script>
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