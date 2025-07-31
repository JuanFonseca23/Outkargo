<?php
include_once "App/Controllers/DotacionController.php";
include_once "App/Controllers/TicketsController.php";
require_once "App/Views/Templates/Layouts/Header.php";

if (empty($_SESSION['ID'])) {
    header("location:../IniciarSesion");
    exit;
}
$TicketsController = new TicketsController;
$ID_Usuario = $_SESSION['ID'];
$ID_Ticket = $_GET['ID'];
$Descripcion = $TicketsController->ObtenerDescripcionTicket($ID_Ticket);
$Mensajes = $TicketsController->Obtenermensajes($ID_Ticket);
$DataUsuarios = $TicketsController->ObtenerDatos($ID_Ticket);
$Evidencias = $Descripcion['Evidencias'] ? explode(', ', $Descripcion['Evidencias']) : [];

if ($_SESSION['ID'] == $DataUsuarios['ID_Gestiona']){
    $ID_Destinatario = $DataUsuarios['ID_Solicitante'];
}else{
    $ID_Destinatario = $DataUsuarios['ID_Gestiona'];
}

?>

<style>
    #chat-box {
        display: flex;
        flex-direction: column;
        gap: 15px;
        padding: 10px;
        height: 300px;
        overflow-y: auto;
        border: 1px solid #ddd;
        background-color: #f9f9f9;
    }

    .message-container {
        border-radius: 15px;
        padding: 10px 15px;
        margin: 5px 0;
        max-width: 70%;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .message-container-left {
        background-color: #f1f1f1;
        align-self: flex-start;
    }

    .message-container-right {
        background-color: #e0f7fa;
        align-self: flex-end;
        margin-left: auto;
    }

    .message-container span.user-name {
        font-weight: bold;
        display: block;
    }

    .message-container span.time {
        color: #888;
        font-size: 0.85em;
        margin-top: 5px;
        display: block;
    }
</style>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <h5 class="mb-4">Detalles del Ticket</h5>
            <h6 for="floatingTextarea">Descripcion</h6>
            <div class="form-floating mb-3">
                <?php if ($Descripcion): ?>
                    <p><?= htmlspecialchars($Descripcion['Descripcion']) ?></p>
                <?php else: ?>
                    <p>No se ha encontrado la descripción del ticket.</p>
                <?php endif; ?>
            </div>

            <h6 for="floatingTextarea">Evidencias</h6>
            <div class="form-floating mb-3">
                <?php if (!empty($Evidencias)): ?>
                    <div class="row">
                        <?php foreach ($Evidencias as $index => $evidencia): ?>
                            <div class="col-4 col-md-2 p-1">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal<?= $index ?>">
                                    <img src="../<?= htmlspecialchars($evidencia) ?>" alt="Evidencia" class="img-fluid img-thumbnail mb-1" style="height: 100px; width: 100%; object-fit: cover; padding: 1px;" />
                                </a>
                            </div>
                            <div class="modal fade" id="imageModal<?= $index ?>" tabindex="-1" aria-labelledby="imageModalLabel<?= $index ?>" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="../<?= htmlspecialchars($evidencia) ?>" alt="Evidencia" class="img-fluid" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>No se encontraron evidencias.</p>
                <?php endif; ?>
            </div>

            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-3">Chat</h5>
                <div id="chat-box" class="chat-box">
                    <div id="Datos-chat">
                    </div>
                </div>
                <form id="sendMessage" method="post" enctype="multipart/form-data"> <!-- Agregar enctype -->
                    <input type="hidden" name="ID_Ticket" value="<?= $ID_Ticket ?>">
                    <input type="hidden" name="ID_Remitente" value="<?= $_SESSION['ID'] ?>">
                    <input type="hidden" name="ID_Destinatario" value="<?= $ID_Destinatario ?>">
                    <div class="mb-3">
                        <textarea class="form-control" id="message" name="Mensaje" rows="3" placeholder="Escribe tu mensaje..."></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="file" id="file-input" class="form-control" name="Evidencia_Fotografica[]" multiple>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="chatImageModal" tabindex="-1" aria-labelledby="chatImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="chatModalImage" src="" alt="Evidencia" class="img-fluid" />
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        function loadMessages() {
            $.get('AjaxNosotros?id_ticket=<?= $ID_Ticket ?>', function(data) {
                const messages = JSON.parse(data);
                const chatBox = document.getElementById('chat-box');
                const isAtBottom = chatBox.scrollHeight - chatBox.scrollTop === chatBox.clientHeight;

                $('#Datos-chat').empty(); // Limpiar mensajes anteriores
                messages.forEach(msg => {
                    const messageClass = msg.ID_Remitente == <?= $ID_Usuario ?> ? 'message-container-right' : 'message-container-left';
                    // Comienza a construir el HTML del mensaje
                    let messageHtml = `
                        <div class="message-container ${messageClass}">
                            <span class="user-name" style="color: #ff5000">${msg.NombreUsuario}:</span>
                            <span>${msg.Mensaje || ''}</span>
                    `;

                    // Verificar si hay evidencias fotográficas
                    if (msg.Evidencias) {
                        const images = msg.Evidencias.split(', ');
                        images.forEach(img => {
                            messageHtml += `
                                <img src="../${img}" alt="Imagen" class="chat-image" style="max-width: 80px; height: 80px; cursor: pointer;" data-img="../${img}">
                            `;
                        });
                    }
                    messageHtml += `<span class="time">${msg.Hora}</span></div>`;
                    $('#Datos-chat').append(messageHtml);
                });
            });
        }

        $('#sendMessage').on('submit', function(e) {
        e.preventDefault();  
        const formData = new FormData(this); 
        const messageText = $('#message').val().trim();
        const hasImages = $('#file-input')[0].files.length > 0;
        if (messageText === '' && !hasImages) {
            alert('Por favor, escribe un mensaje o adjunta una imagen.');
            return; 
        }

        $.ajax({
                url: 'AjaxNosotros',
                type: 'POST',
                data: formData,
                processData: false, 
                contentType: false, 
                success: function() {
                    $('#message').val('');
                    $('#file-input').val('');
                    loadMessages(); 
                }
            });
        });

        $(document).on('click', '.chat-image', function() {
            const imgSrc = $(this).data('img');
            $('#chatModalImage').attr('src', imgSrc);
            $('#chatImageModal').modal('show'); 
        });

        setInterval(loadMessages, 2000); // Cargar los mensajes cada 2 segundos
    });
</script>

<?php require "App/Views/Templates/Layouts/Footer.php"; ?>