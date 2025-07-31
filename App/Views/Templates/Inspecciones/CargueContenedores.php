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
            <td>F-177</td>
        </tr>
        <tr>
            <th>FECHA:</th>
            <td>28/08/2024</td>
        </tr>
        <tr>
            <th>VERSIÓN:</th>
            <td>4</td>
        </tr>
    </thead>
</table>

<table border="1">
    <tbody>
        <tr>
            <th class="Texto-Izquierda">FECHA DE INICIO:</th>
            <td class="Texto-Izquierda"><?= $FechaHoy ?></td>
            <th class="Texto-Izquierda">NOMBRE DEL OPERADOR:</th>
            <td class="Texto-Izquierda"><?= $_SESSION['NombreCompleto'] ?></td>
            <th class="Texto-Izquierda">No.EQUIPO: <button id="Buscar-Montacargas-Evaluada">Buscar</button></th>
            <td class="Texto-Izquierda">
                <p id="montacargas-evaluada"></p>
            </td>
        </tr>
        <tr>
            <th class="Texto-Izquierda">CENTRO DE TRABAJO:</th>
            <td class="Texto-Izquierda"><?= $_SESSION['Centro'] ?></td>
            
            <th class="Texto-Izquierda">NOMBRE DEL SUPERVISOR:<button id="Buscar-Persona-Evaluada">Buscar</button></th>
            <td class="Texto-Izquierda">
                <p id="persona-evaluada"></p>
            </td>
            <th class="Texto-Izquierda">HORA INICIO:</th>
            <td class="Texto-Izquierda"><?= $HoraActual ?></td>
        </tr>
    </tbody>
</table>

<table border="1">
    <tr>
        <th class="Texto-Izquierda">DESCRIPCIÓN DE LA TAREA:</th>
        <td style="width: 500px;">
            <input type="radio" name="tarea" value="Cargue"> Cargue
            <input type="radio" name="tarea" value="Descargue"> Descargue
            <input type="radio" name="tarea" value="Nacional"> Nacional
            <input type="radio" name="tarea" value="Importación/Exportación"> Importación/Exportación
        </td>
        <th class="Texto-Izquierda">Masa unitaria:</th>
        <td style="width: 90px;"><input type="text" name="masaunitaria"></td>
        <th class="Texto-Izquierda">Orden de cargue/descargue:</th>
        <td><input type="text" name="ordendecargue/descargue"></td>
    </tr>
    <tr>
        <th class="Texto-Izquierda">Tipo de material a cargar/descargar</th>
        <td><textarea name="tipodematerialacargar/descargar" placeholder="Tipo de material a cargar/descargar:" cols="60%" required></textarea></td>
        <th class="Texto-Izquierda">Masa total</th>
        <th style="width: 100px;"><input type="text" name="masatotal"></th>
        <th class="Texto-Izquierda">¿El cargue se va a hacer ingresando al contenedor?</th>
        <td >
            <input type="radio" name="elcarguesevaahacerigresandoalcontenedor" value="Si"> Sí
            <input type="radio" name="elcarguesevaahacerigresandoalcontenedor" value="No"> No
        </td>
    </tr>
</table>

<table border="1">
    <tr>
        <td class="Texto-Izquierda">Si el montacargas ingresará al contenedor, reponda la pregunta 11, 12 y 13, si la respuesta es no, registre No aplica.</td>
    </tr>
    <tr>
        <td class="Texto-Izquierda">Si alguna de las condiciones abajo descritas, no se cumplen, absténganse de realizar el cargue, hastatanto se establezcan las acciones correctivas pertinentes, por parte de las áreas encargas. El hecho de omitir las disposiciones aquí establecidas y demás procedimiento establecidos por la empresa, son consideradas como faltas graves.</td>  
    </tr>
    <tr>
        <td class="Texto-Izquierda">Si algún campo no cumple, se deberá especificar en el campo de observaciones, las acciones correctivas implementadas, para continuar con el cargue.</td>
    </tr>
</table>

<form method="POST">
    <table border="1">
        <tr>
            <td>
                Criterio de inspección y verificación
            </td>
            <td colspan="3">
                Cumplimiento
            </td>
        </tr>
        <tr>
            <td>
                1. ¿Se hizo la inspección preoperacional del equipo, antes de iniciar la jornada de trabajo?
            </td>
            <td>
                Cumple <input type="radio" name="Criteriosdeinspeccionyverificacion1" id="Cumple1" value="Cumple">
            </td>
            <td>
                No cumple <input type="radio" name="Criteriosdeinspeccionyverificacion1" id="Nocumple1" value="No cumple">
            </td>
            <td>
                No aplica <input type="radio" name="Criteriosdeinspeccionyverificacion1" id="Noaplica1" value="No aplica">
            </td>
        </tr>
        <tr>
            <td>
                2. ¿El equipo no presenta ninguna falla que pueda poner en riesgo la seguridad de la operación?
            </td>
            <td>
                Cumple <input type="radio" name="Criteriosdeinspeccionyverificacion2" id="Cumple2" value="Cumple">
            </td>
            <td>
                No cumple <input type="radio" name="Criteriosdeinspeccionyverificacion2" id="Nocumple2" value="No cumple">
            </td>
            <td>
                No aplica <input type="radio" name="Criteriosdeinspeccionyverificacion2" id="Noaplica2" value="No aplica">
            </td>
        </tr>
        <tr>
            <td>
                3. ¿El personal de seguridad física verificó el estado del contenedor?
            </td>
            <td>
                Cumple <input type="radio" name="Criteriosdeinspeccionyverificacion3" id="Cumple3" value="Cumple">
            </td>
            <td>
                No cumple <input type="radio" name="Criteriosdeinspeccionyverificacion3" id="Nocumple3" value="No cumple">
            </td>
            <td>
                No aplica <input type="radio" name="Criteriosdeinspeccionyverificacion3" id="Noaplica3" value="No aplica">
            </td>
        </tr>
        <tr>
            <td>
                4. ¿El contenedor presenta elementos extraños, olores y/o daños que impidan realizar el cargue?
            </td>
            <td>
                Cumple <input type="radio" name="Criteriosdeinspeccionyverificacion4" id="Cumple4" value="Cumple">
            </td>
            <td>
                No cumple <input type="radio" name="Criteriosdeinspeccionyverificacion4" id="Nocumple4" value="No cumple">
            </td>
            <td>
                No aplica <input type="radio" name="Criteriosdeinspeccionyverificacion4" id="Noaplica4" value="No aplica">
            </td>
        </tr>
        <tr>
            <td>
                5. ¿El operador de montacargas verificó estado exterior del contenedor?
            </td>
            <td>
                Cumple <input type="radio" name="Criteriosdeinspeccionyverificacion5" id="Cumple5" value="Cumple">
            </td>
            <td>
                No cumple <input type="radio" name="Criteriosdeinspeccionyverificacion5" id="Nocumple5" value="No cumple">
            </td>
            <td>
                No aplica <input type="radio" name="Criteriosdeinspeccionyverificacion5" id="Noaplica5" value="No aplica">
            </td>
        </tr>
        <tr>
            <td>
                6. ¿Se impide el paso peatonal en el área de cargue?
            </td>
            <td>
                Cumple <input type="radio" name="Criteriosdeinspeccionyverificacion6" id="Cumple6" value="Cumple">
            </td>
            <td>
                No cumple <input type="radio" name="Criteriosdeinspeccionyverificacion6" id="Nocumple6" value="No cumple">
            </td>
            <td>
                No aplica <input type="radio" name="Criteriosdeinspeccionyverificacion6" id="Noaplica6" value="No aplica">
            </td>
        </tr>
        <tr>
            <td>
                7. ¿El conductor esté por fuera del vehículo?
            </td>
            <td>
                Cumple <input type="radio" name="Criteriosdeinspeccionyverificacion7" id="Cumple7" value="Cumple">
            </td>
            <td>
                No cumple <input type="radio" name="Criteriosdeinspeccionyverificacion7" id="Nocumple7" value="No cumple">
            </td>
            <td>
                No aplica <input type="radio" name="Criteriosdeinspeccionyverificacion7" id="Noaplica7" value="No aplica">
            </td>
        </tr>
        <tr>
            <td>
                8. ¿El vehículo se encuentra apagado, bloqueado con tacos de seguridad, con freno de mano y con cambio?
            </td>
            <td>
                Cumple <input type="radio" name="Criteriosdeinspeccionyverificacion8" id="Cumple8" value="Cumple">
            </td>
            <td>
                No cumple <input type="radio" name="Criteriosdeinspeccionyverificacion8" id="Nocumple8" value="No cumple">
            </td>
            <td>
                No aplica <input type="radio" name="Criteriosdeinspeccionyverificacion8" id="Noaplica8" value="No aplica">
            </td>
        </tr>
        <tr>
            <td>
                9. ¿En el área de cargue se encuentran únicamente las personas autorizadas?
            </td>
            <td>
                Cumple <input type="radio" name="Criteriosdeinspeccionyverificacion9" id="Cumple9" value="Cumple">
            </td>
            <td>
                No cumple <input type="radio" name="Criteriosdeinspeccionyverificacion9" id="Nocumple9" value="No cumple">
            </td>
            <td>
                No aplica <input type="radio" name="Criteriosdeinspeccionyverificacion9" id="Noaplica9" value="No aplica">
            </td>
        </tr>
        <tr>
            <td>
                10. ¿Se cuenta con el orden de cargue autorizada por el área encargada?
            </td>
            <td>
                Cumple <input type="radio" name="Criteriosdeinspeccionyverificacion10" id="Cumple10" value="Cumple">
            </td>
            <td>
                No cumple <input type="radio" name="Criteriosdeinspeccionyverificacion10" id="Nocumple10" value="No cumple">
            </td>
            <td>
                No aplica <input type="radio" name="Criteriosdeinspeccionyverificacion10" id="Noaplica10" value="No aplica">
            </td>
        </tr>
        <tr>
            <th colspan="4">EL MONTACARGAS INGRESA AL CONTENEDOR</th>
        </tr>
        <tr>
            <td>
                11. ¿El operador de montacargas verificó estado interior del contenedor?
            </td>     
            <td>
                Cumple <input type="radio" name="Criteriosdeinspeccionyverificacion11" id="Cumple11" value="Cumple">
            </td>
            <td>
                No cumple <input type="radio" name="Criteriosdeinspeccionyverificacion11" id="Nocumple11" value="No cumple">
            </td>
            <td>
                No aplica <input type="radio" name="Criteriosdeinspeccionyverificacion11" id="Noaplica11" value="No aplica">
            </td>
        </tr>
        <tr>
            <td>
                12. ¿El operador verifica que la rampa y/o elementos de anclaje del contenedor al muelle, estén funcionando correctamente?
            </td>     
            <td>
                Cumple <input type="radio" name="Criteriosdeinspeccionyverificacion12" id="Cumple">
            </td>
            <td>
                No cumple <input type="radio" name="Criteriosdeinspeccionyverificacion12" id="No cumple">
            </td>
            <td>
                No aplica <input type="radio" name="Criteriosdeinspeccionyverificacion12" id="No aplica">
            </td>
        </tr>
        <tr>
            <td>
                13. ¿El operador verifica en compañía del coordinador de despacho, que el contenedor no cuenta con olores y otros aspectos que pongan en riesgo la inocuidad del producto?
            </td>     
            <td>
                Cumple <input type="radio" name="Criteriosdeinspeccionyverificacion13" id="Cumple">
            </td>
            <td>
                No cumple <input type="radio" name="Criteriosdeinspeccionyverificacion13" id="No cumple">
            </td>
            <td>
                No aplica <input type="radio" name="Criteriosdeinspeccionyverificacion13" id="No aplica">
            </td>
        </tr>
        <tr>
            <th colspan="4">EL MONTACARGAS NO INGRESA AL CONTENEDOR</th>
        </tr>
        <tr>
            <td>
                14. ¿El operador verifica que las esponjas laterales se encuentren en buen estado y eviten el ingreso de plagas?
            </td>     
            <td>
                Cumple <input type="radio" name="Criteriosdeinspeccionyverificacion14" id="Cumple">
            </td>
            <td>
                No cumple <input type="radio" name="Criteriosdeinspeccionyverificacion14" id="No cumple">
            </td>
            <td>
                No aplica <input type="radio" name="Criteriosdeinspeccionyverificacion14" id="No aplica">
            </td>
        </tr>
        <tr>
            <td>
                15. El cargue se va a hacer desde el nivel del piso, mediante el uso de boom
            </td>     
            <td>
                Cumple <input type="radio" name="Criteriosdeinspeccionyverificacion15" id="Cumple">
            </td>
            <td>
                No cumple <input type="radio" name="Criteriosdeinspeccionyverificacion15" id="No cumple">
            </td>
            <td>
                No aplica <input type="radio" name="Criteriosdeinspeccionyverificacion15" id="No aplica">
            </td>
        </tr>
        <tr>
            <td>
                16. ¿Se cuenta con buena iluminación dentro del contenedor (propia del equipo o del contenedor) para realizar el cargue?
            </td>     
            <td>
                Cumple <input type="radio" name="Criteriosdeinspeccionyverificacion16" id="Cumple">
            </td>
            <td>
                No cumple <input type="radio" name="Criteriosdeinspeccionyverificacion16" id="No cumple">
            </td>
            <td>
                No aplica <input type="radio" name="Criteriosdeinspeccionyverificacion16" id="No aplica">
            </td>
        </tr>
        <tr>
            <td>
                17. En caso de que sea necesario que alguien ingrese al contenedor, ¿éste cuenta con chaleco reflectivo?
            </td>     
            <td>
                Cumple <input type="radio" name="Criteriosdeinspeccionyverificacion17" id="Cumple">
            </td>
            <td>
                No cumple <input type="radio" name="Criteriosdeinspeccionyverificacion17" id="No cumple">
            </td>
            <td>
                No aplica <input type="radio" name="Criteriosdeinspeccionyverificacion17" id="No aplica">
            </td>
        </tr>
        <tr>
            <td>
                18. En caso de que sea necesario que alguien ingrese al contenedor, ¿éste ha sido capacitado referente a los riesgos y los controles. La persona conoce que mientras el montacargas cargue o empuje carga, no se debe haber nadie dentro del contenedor?
            </td>     
            <td>
                Cumple <input type="radio" name="Criteriosdeinspeccionyverificacion18" id="Cumple">
            </td>
            <td>
                No cumple <input type="radio" name="Criteriosdeinspeccionyverificacion18" id="No cumple">
            </td>
            <td>
                No aplica <input type="radio" name="Criteriosdeinspeccionyverificacion18" id="No aplica">
            </td>
        </tr>
        <tr>
            <td>
                19. ¿Se ha establecido un plan de comunicación entre operador de montacargas y personas involucradas?
            </td>     
            <td>
                Cumple <input type="radio" name="Criteriosdeinspeccionyverificacion19" id="Cumple">
            </td>
            <td>
                No cumple <input type="radio" name="Criteriosdeinspeccionyverificacion19" id="Nocumple">
            </td>
            <td>
                No aplica <input type="radio" name="Criteriosdeinspeccionyverificacion19" id="No aplica">
            </td>
        </tr>
    </table>

    <table border="1">
        <tr>
            <td>Si alguna de las preguntas anteriores No Cumple ¿indique cuál o cuáles fueron las acciones implementadas para minimizar el riesgo?</td>
            <td><textarea name="Observaciones" id="Observaciones" style="width: 99%;" placeholder="Indique cuál o cuáles fueron las acciones implementadas para minimizar el riesgo:"></textarea></td>
        </tr>
        <tr>
            <th style="width: 50%;">Firma del operador</th>
            <th style="width: 50%;">Firma del coordinador de area</th>
        </tr>
        <tr height="100px">
            <td style="width: 50vh;"></td>
            <td style="width: 50vh;"></td>
        </tr>
        <tr>
            <th><?= $_SESSION['NombreCompleto'] ?></th>
            <th></th>
        </tr>
    </table>  
    <input type="submit" value="Enviar">  
</form>

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