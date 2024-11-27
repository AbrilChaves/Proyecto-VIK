window.addEventListener('load', function () {
    // Ahora que la página y sus recursos han sido completamente cargados
    document.getElementById('form-comentar').addEventListener('submit', function (e) {
        e.preventDefault(); // Evitar el envío tradicional del formulario

        const comentario = document.getElementById('comentario').value;
        const postId = document.querySelector('.post').id; // Suponiendo que el id del post está en el div con clase 'post'

        // Verifica si el comentario tiene texto
        if (comentario.trim() === '') {
            alert('Por favor, escribe un comentario.');
            return;
        }

        // Enviar los datos con fetch
        fetch('../PHP/comentar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `comentario=${encodeURIComponent(comentario)}&id_post=${postId}`
        })
        .then(response => response.json()) // Espera la respuesta en formato JSON
        .then(data => {
            if (data.success) {
                alert('Comentario enviado con éxito.');
            } else {
                alert(data.message); // Muestra el mensaje de error o éxito
            }
        })
        .catch(error => {
            alert('Hubo un error al enviar el comentario.');
        });
    });
});
