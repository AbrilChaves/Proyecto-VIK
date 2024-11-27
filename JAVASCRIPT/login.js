// Al cargar la página, verifica si el usuario está logueado
window.addEventListener('DOMContentLoaded', (event) => {
    if (isLoggedIn) {
        // Oculta el formulario de login
        document.getElementById('login').style.display = 'none';
        
        // Muestra el mensaje de bienvenida
        document.getElementById('sesionIniciada').style.display = 'block';

        // Opcional: Si quieres mostrar el nombre y el rol, puedes obtenerlo desde PHP en una variable JavaScript
        // Si se quiere hacer dinámico, puedes usar las variables de sesión en PHP y asignarlas al frontend.
        document.getElementById('nombre').textContent = "<?php echo $_SESSION['nombre']; ?>";
        document.getElementById('rol').textContent = "<?php echo $_SESSION['rol']; ?>";
    } else {
        // Si no está logueado, muestra el formulario
        document.getElementById('login').style.display = 'block';
        document.getElementById('sesionIniciada').style.display = 'none';
    }
});
