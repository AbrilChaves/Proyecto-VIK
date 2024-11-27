window.addEventListener('DOMContentLoaded', (event) => {
    fetch('../PHP/verificar_login.php') // Llama al archivo PHP para verificar el estado de la sesión
        .then(response => response.json())
        .then(data => {
            console.log(data.usuario_rol);
            if (data.usuario_rol === "admin") {
                return;
            } else {
                // Si no está logueado, te redirige a la comunidad
                window.location.href = 'comunidad.html';
            }
        })
        .catch(error => {
            console.error('Error al verificar la sesión:', error);
            window.location.href = 'comunidad.html';
        });
});