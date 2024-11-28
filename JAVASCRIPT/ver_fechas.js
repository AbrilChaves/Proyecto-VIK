async function cargarFechas() {
    try {
        const response = await fetch('../PHP/fechas.php'); // Archivo PHP que devuelve el HTML de los eventos
        if (!response.ok) throw new Error('Error al cargar las fechas.');

        const fechasHTML = await response.text(); // Obtener las fechas como HTML
        const contenedor = document.querySelector('.fechas'); // Seleccionar el contenedor
        if (fechasHTML) {
            contenedor.innerHTML = fechasHTML; // Insertar el contenido en el contenedor
        } else {
            contenedor.innerHTML = '<p>No hay fechas para mostrar...</p>';
        }
    } catch (error) {
        console.error(error);
        const contenedor = document.querySelector('.fechas');
        contenedor.innerHTML = '<p>Error al cargar las fechas.</p>';
    }
}

// Llamar a la función cuando la página esté cargada
window.onload = () => {
    cargarFechas(); // Cargar los posts dinámicamente
};