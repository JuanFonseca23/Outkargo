<?php
include_once "App/Controllers/MontacargasController.php";
require_once "App/Views/Templates/Layouts/Header.php";
if (empty($_SESSION['ID'])) {
    header("location:../IniciarSesion");
    exit;
}
$DotacionController = new MontacargasController;
$ID_Centro = $_SESSION['NoCentro'];
$Listas = $DotacionController->Leer($ID_Centro);
?>

<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Montacargas Actuales</h6>
            <a href="#">Descargar Excel</a>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-dark">
                        <th scope="col" class="text-center">#</th>
                        <th scope="col" class="text-center">Año</th>
                        <th scope="col" class="text-center">Marca</th>
                        <th scope="col" class="text-center">Modelo</th>
                        <th scope="col" class="text-center">Capacidad</th>
                        <th scope="col" class="text-center">Tipo</th>
                        <th scope="col" class="text-center">Llantas</th>
                        <th scope="col" class="text-center">Combustible</th>
                        <th scope="col" class="text-center">Altura Reducida</th>
                        <th scope="col" class="text-center">Altura Elevada</th>
                        <th scope="col" class="text-center">Clase Carri</th>
                        <th scope="col" class="text-center">Voltaje</th>
                        <th scope="col" class="text-center">Horquillas</th>
                        <th scope="col" class="text-center">Aditamento</th>
                        <th scope="col" class="text-center">Ubicación</th>
                        <th scope="col" class="text-center">Horometro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($Listas) {
                        foreach ($Listas as $Lista) {
                    ?>
                            <tr data-id="<?= htmlspecialchars($Lista['ID']) ?>">
                                <td width="100" class="text-center">
                                    <p class="bg-primary text-white"><?= htmlspecialchars($Lista['Numero']) ?></p>
                                    <div class="zoom-container">
                                        <a class="image-link" data-bs-toggle="modal" data-bs-target="#imageModal" data-id="<?= $Lista['ID'] ?>">
                                            <img src="../App/Views/Upload/Img/Montacargas/<?= $Lista['ID'] ?>_1.png" alt="Montacargas" style="width: 100px; height: auto;">
                                        </a>
                                    </div>
                                </td>
                                <td width="100" class="text-center"><?= htmlspecialchars($Lista['Ano']) ?></td>
                                <td width="100" class="text-center"><?= htmlspecialchars($Lista['Marca']) ?></td>
                                <td width="100" class="text-center"><?= htmlspecialchars($Lista['Modelo']) ?></td>
                                <td width="100" class="text-center"><?= htmlspecialchars($Lista['Capacidad']) ?> Toneladas</td>
                                <td width="100" class="text-center">
                                    <?php
                                    switch ($Lista['Tipo']) {
                                        case '1':
                                            echo "Electrica Contrabalanceada";
                                            break;
                                        case '2':
                                            echo "Electrica Pasillo Angosto";
                                            break;
                                        case '3':
                                            echo "Electrica Toma Pedido";
                                            break;
                                        case '4':
                                            echo "Combustion Interna Contrabalanceada";
                                            break;
                                        case '5':
                                            echo "Manlift";
                                            break;
                                    }
                                    ?>
                                </td>
                                <td width="100" class="text-center"><?= htmlspecialchars($Lista['Neumaticos']) ?></td>
                                <td width="100" class="text-center"><?= htmlspecialchars($Lista['Combustible']) ?></td>
                                <td width="100" class="text-center"><?= htmlspecialchars($Lista['Altura_Reducida']) ?></td>
                                <td width="100" class="text-center"><?= htmlspecialchars($Lista['Altura_Elevada']) ?></td>
                                <td width="100" class="text-center"><?= htmlspecialchars($Lista['Clase_Carri']) ?></td>
                                <td width="100" class="text-center"><?= htmlspecialchars($Lista['Voltaje']) ?> V</td>
                                <td width="100" class="text-center"><?= htmlspecialchars($Lista['Horquillas']) ?></td>
                                <td width="100" class="text-center"><?= htmlspecialchars($Lista['Aditamentos']) ?></td>
                                <td width="100" class="text-center"><?= htmlspecialchars($Lista['Ubicacion']) ?></td>
                                <td width="100" class="text-center"><?= htmlspecialchars($Lista['Horometro']) ?></td>
                            </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para mostrar la imagen grande -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Imagen Montacargas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="viewer">
                    <img id="currentImage" src="" alt="Lado 1" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentImageIndex = 0;
    let isDragging = false;
    let startX = 0;
    let images = []; // Inicializamos el array de imágenes vacío
    const imageElement = document.getElementById('currentImage'); // Imagen mostrada en el modal

    // Función para cambiar la imagen
    function changeImage(direction) {
        if (direction === 'next') {
            currentImageIndex = (currentImageIndex + 1) % images.length;
        } else if (direction === 'prev') {
            currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
        }
        imageElement.src = images[currentImageIndex];
    }

    // Eventos de arrastre con el mouse
    imageElement.addEventListener('mousedown', (e) => {
        isDragging = true;
        startX = e.pageX;
    });

    imageElement.addEventListener('mousemove', (e) => {
        if (!isDragging) return;
        if (e.pageX < startX - 50) { // Arrastre hacia la izquierda
            changeImage('next');
            startX = e.pageX;
        } else if (e.pageX > startX + 50) { // Arrastre hacia la derecha
            changeImage('prev');
            startX = e.pageX;
        }
    });

    imageElement.addEventListener('mouseup', () => {
        isDragging = false;
    });

    // Eventos táctiles para pantallas móviles
    imageElement.addEventListener('touchstart', (e) => {
        isDragging = true;
        startX = e.touches[0].pageX;
    });

    imageElement.addEventListener('touchmove', (e) => {
        if (!isDragging) return;
        if (e.touches[0].pageX < startX - 50) { // Desplazamiento hacia la izquierda
            changeImage('next');
            startX = e.touches[0].pageX;
        } else if (e.touches[0].pageX > startX + 50) { // Desplazamiento hacia la derecha
            changeImage('prev');
            startX = e.touches[0].pageX;
        }
    });

    imageElement.addEventListener('touchend', () => {
        isDragging = false;
    });

    // Mostrar las imágenes correspondientes cuando se haga clic en los enlaces
    document.querySelectorAll('.image-link').forEach(link => {
        link.addEventListener('click', function() {
            const id = this.getAttribute('data-id');

            // Cargar las imágenes con el ID correspondiente
            images = [
                `../App/Views/Upload/Img/Montacargas/${id}_1.png`,
                `../App/Views/Upload/Img/Montacargas/${id}_2.png`,
                `../App/Views/Upload/Img/Montacargas/${id}_3.png`,
                `../App/Views/Upload/Img/Montacargas/${id}_4.png`,
                `../App/Views/Upload/Img/Montacargas/${id}_5.png`,
                `../App/Views/Upload/Img/Montacargas/${id}_6.png`,
                `../App/Views/Upload/Img/Montacargas/${id}_7.png`,
                `../App/Views/Upload/Img/Montacargas/${id}_8.png`
            ];

            // Mostrar la primera imagen
            currentImageIndex = 0; // Opcional: empieza con la primera imagen
            imageElement.src = images[currentImageIndex];
            console.log(images); // Para verificar las rutas en la consola
        });
    });
</script>

<?php require_once "App/Views/Templates/Layouts/Footer.php"; ?>