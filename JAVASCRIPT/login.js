window.addEventListener('DOMContentLoaded', (event) => {
    fetch('../PHP/verificar_login.php') // Llama al archivo PHP para verificar el estado de la sesión
        .then(response => response.json())
        .then(data => {
            const login = document.getElementById('login');
            const sesionIniciada = document.getElementById('sesionIniciada');
            const nombre = document.getElementById('nombre');
            const rol = document.getElementById('rol');

            if (data.is_logged_in) {
                // Oculta el formulario de login
                login.style.display = 'none';
                
                // Muestra el mensaje de bienvenida
                sesionIniciada.style.display = 'flex';

                // Muestra el nombre y rol del usuario
                nombre.textContent = data.usuario_nombre;
                rol.textContent = data.usuario_rol;
            } else {
                // Si no está logueado, muestra el formulario
                login.style.display = 'flex';
                sesionIniciada.style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error al verificar la sesión:', error);
        });
});