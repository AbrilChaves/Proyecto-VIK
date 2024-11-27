<?php
// get_posts.php

// Conexión a la base de datos
$host = "localhost"; // o la dirección de tu servidor
$dbname = "Vik_database";
$username = "root"; // tu usuario de base de datos
$password = ""; // tu contraseña de base de datos

session_start(); // Asegúrate de iniciar la sesión al inicio del archivo


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

// Función para obtener los posts
function obtenerPosts() {
    global $pdo;
    $query = "
        SELECT p.id_post, p.titulo, p.fecha_publicacion, p.contenido, u.nombre AS autor
        FROM Posts p
        JOIN Usuarios u ON p.id_usuario = u.id_usuario
        ORDER BY p.fecha_publicacion DESC
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener los comentarios de un post
function obtenerComentarios($post_id) {
    global $pdo;
    $query = "
        SELECT c.id_comentario, c.contenido, c.fecha_comentario, u.nombre AS autor
        FROM Comentarios c
        JOIN Usuarios u ON c.id_usuario = u.id_usuario
        WHERE c.id_post = :post_id
        ORDER BY c.fecha_comentario DESC
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['post_id' => $post_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Obtener los posts
$posts = obtenerPosts();

// Función para generar el HTML de los posts
function generarPostHTML($posts) {
    $html = '';
    if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
        $html .= '<div class="centrar"><a href="./crear_post.html"><button id="btn-crear-post">Crear Post</button></a></div>';
    }

    foreach ($posts as $post) {
        $comentarios = obtenerComentarios($post['id_post']);
        
        // HTML de cada post
        $html .= '<div id="'.htmlspecialchars($post['id_post']).'" class="post">';
        $html .= '<div class="post_info">';
        $html .= '<div class="post_titulo"><h3>' . htmlspecialchars($post['titulo']) . '</h3></div>';
        $html .= '<div class="post_img"><img src="'.htmlspecialchars($post['contenido']).'" alt="Imagen del post"></div>';
        $html .= '<div><h4>Publicado el ' . date('d/m/Y', strtotime($post['fecha_publicacion'])) . '</h4></div>';

        if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
        $html .= '<form action="../PHP/eliminar_post.php" method="POST" onsubmit="return confirm(\"¿Estás seguro de que quieres eliminar este post?\")">';
        $html .= '<input type="hidden" name="id_post" value="' . $post['id_post'] . '">';
        $html .= '<input type="submit" value="Eliminar Post"></form>';
        }

        $html .= '</div>';
        $html .= '<div class="post_comentarios">';
        $html .= '<div class="titulo_comentarios"><h3>Comentarios</h3></div>';
        $html .= '<ul class="comentarios">';


        if (count($comentarios) > 0) {
            foreach ($comentarios as $comentario) {
                $html .= '<li><b>' . htmlspecialchars($comentario['autor']) . '</b> '.htmlspecialchars($comentario['fecha_comentario']).'<br>';
                $html .= nl2br(htmlspecialchars($comentario['contenido'])) . '</li>';
            }
        } else {
            $html .= '<li>No hay comentarios aún.</li>';
        }

        $html .= '</ul>';
        $html .= '<form action="../PHP/comentar.php" method="POST" class="comentar">';
        $html .= '<textarea id="comentario" name="comentario" placeholder="Escribí acá tu comentario..."></textarea>';
        $html .= '<input type="hidden" id="post_id" name="post_id" class="post_id" value="">';
        $html .= '<input type="submit" value="Comentar">';
        $html .= '</form>';
        $html .= '</div>';
        $html .= '</div>';
    }

    return $html;
}

// Mostrar los posts como HTML
echo generarPostHTML($posts);
?>
