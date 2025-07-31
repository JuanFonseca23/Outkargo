function checkInternetConnection() {
    fetch('https://www.google.com/', { mode: 'no-cors' })
        .then(() => {
        })
        .catch(() => {
            Swal.fire({
                title: 'Error!',
                text: 'No se puede conectar a Internet.',
                icon: 'error'
            })
        });
}

// Ejecutar la verificación cada 20 segundos
setInterval(checkInternetConnection, 5000);

