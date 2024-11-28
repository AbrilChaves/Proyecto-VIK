// Función para cargar los posts desde el servidor
async function cargarPosts() {
    try {
        const response = await fetch('../PHP/get_posts.php'); // Archivo PHP que devuelve el HTML de los posts
        if (!response.ok) throw new Error('Error al cargar los posts.');
        
        const postsHTML = await response.text(); // Obtener los posts como HTML
        const contenedor = document.getElementById('contenedor-posts'); 
        if (postsHTML) {
            contenedor.innerHTML = postsHTML; // Insertar el contenido en el contenedor
            asignarPostId(); // Llamar a asignarPostId después de cargar los posts
        } else {
            contenedor.innerHTML = '<p>No hay posts para ver...</p>';
        }
    } catch (error) {
        console.error(error);
        const contenedor = document.getElementById('contenedor-posts'); 
        contenedor.innerHTML = '<p>Error al cargar los posts.</p>';
    }
}

// Función para asignar el ID del post al campo oculto del formulario
function asignarPostId() {
    const posts = document.querySelectorAll(".post");

    posts.forEach(post => {
        // Captura el ID del contenedor
        const postId = post.id;

        // Encuentra el formulario dentro de este post
        const form = post.querySelector("form.comentar");

        // Asigna el ID al campo oculto en el formulario
        if (form) {
            const hiddenInput = form.querySelector(".post_id");
            if (hiddenInput) {
                hiddenInput.value = postId; // Asigna el ID del post
            }
        }
    });
}

// Llamar a la función para cargar los posts cuando se cargue la página
window.onload = () => {
    cargarPosts(); // Cargar los posts dinámicamente
};
