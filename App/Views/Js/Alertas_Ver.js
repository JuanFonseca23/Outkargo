function handleButtonClick(event, ID) {
    event.preventDefault();
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Quieres continuar con la acción?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, continuar',
        cancelButtonText: 'No, cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'ContactosRegistrar?ID='+ID;
        }
    });
}

//Confirmar Eliminar Familiar
function confirmAction(ID, ID_Usuario) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar' 
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'EliminarContacto?ID=' + ID + '&ID_Usuario=' + ID_Usuario;
        }
    });
}

//Confirmar Eliminar
function confirmarDesactivacion(ID_Usuario) {
    Swal.fire({
        title: "<strong>Confirmación de Eliminar</strong>",
        icon: "warning",
        html: `¿Estás seguro de que quieres eliminar este usuario?`,
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: `<i class="fa fa-thumbs-up"></i> Si, Eliminar`,
        confirmButtonAriaLabel: "Eliminar usuario",
        cancelButtonText: `<i class="fa fa-thumbs-down"></i> No, Cancelar`,
        cancelButtonAriaLabel: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'Eliminar?ID=' + ID_Usuario;
        }
    });
}

//Confirmar Editar
function confirmarEditar(ID_Usuario) {
    Swal.fire({
        title: "<strong>Confirmación de Editar</strong>",
        icon: "warning",
        html: `¿Estás seguro de que quieres Editar este usuario?`,
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: `<i class="fa fa-thumbs-up"></i> Si, Editar`,
        confirmButtonAriaLabel: "Editar usuario",
        cancelButtonText: `<i class="fa fa-thumbs-down"></i> No, Cancelar`,
        cancelButtonAriaLabel: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'Editar?ID=' + ID_Usuario;
        }
    });
}

//Visualizar
function previewPDF(input) {
    const file = input.files[0];
    if (file && file.type === 'application/pdf') {
        const reader = new FileReader();
        reader.onload = function (e) {
            const pdfPreview = document.getElementById('pdfPreview');
            pdfPreview.innerHTML = `<embed src="${e.target.result}" width="95%" height="200%" type="application/pdf">`;
        };
        reader.readAsDataURL(file);
    } else {
        alert('Por favor, sube un archivo PDF.');
    }
}

function previewPDFHojaDeVida(input) {
    const file = input.files[0];
    if (file && file.type === 'application/pdf') {
        const reader = new FileReader();
        reader.onload = function (e) {
            const pdfPreview = document.getElementById('previewPDFHojaDeVida'); // ID corregido
            pdfPreview.innerHTML = `<embed src="${e.target.result}" width="100%" height="500px" type="application/pdf">`;
        };
        reader.readAsDataURL(file);
    } else {
        alert('Por favor, sube un archivo PDF válido.');
    }
}

function previewPDFAfiliaciones(input) {
    const file = input.files[0];
    if (file && file.type === 'application/pdf') {
        const reader = new FileReader();
        reader.onload = function (e) {
            const pdfPreview = document.getElementById('previewPDFHojaDeVida'); // ID corregido
            pdfPreview.innerHTML = `<embed src="${e.target.result}" width="100%" height="500px" type="application/pdf">`;
        };
        reader.readAsDataURL(file);
    } else {
        alert('Por favor, sube un archivo PDF válido.');
    }
}
