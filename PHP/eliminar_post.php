<?php
session_start();

// Verifica si el usuario está logueado y es admin o el creador del post
if (!isset($_SESSION['usuario_id'])) {
    echo "Debes iniciar sesión para eliminar un post.";
    exit;
}

// Verifica que se haya enviado el ID del post
if (isset($_POST['id_post'])) {
    $id_post = $_POST['id_post'];
    $id_usuario = $_SESSION['usuario_id'];

    // Conexión a la base de datos
    $host = "localhost";
    $dbname = "Vik_database";
    $username = "root";
    $password = "";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verificar si el post existe y si el usuario tiene permiso para eliminarlo
        $query = "SELECT id_usuario FROM Posts WHERE id_post = :id_post";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_post', $id_post);
        $stmt->execute();

        $post = $stmt->fetch();

        if (!$post) {
            echo "Post no encontrado.";
            exit;
        }

        // Verifica si el usuario es el propietario del post o si es admin
        if ($post['id_usuario'] == $id_usuario || $_SESSION['rol'] == 'admin') {
            // Inicia una transacción para garantizar consistencia
            $pdo->beginTransaction();

            // Eliminar comentarios relacionados al post
            $query = "DELETE FROM Comentarios WHERE id_post = :id_post";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id_post', $id_post);
            $stmt->execute();

            // Eliminar el post
            $query = "DELETE FROM Posts WHERE id_post = :id_post";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id_post', $id_post);
            $stmt->execute();

            // Confirma la transacción
            $pdo->commit();

            echo "<script>alert('Post y comentarios eliminados con éxito.'); window.location.href = '../HTML/comunidad.html';</script>";
        } else {
            echo "No tienes permisos para eliminar este post.";
        }

    } catch (PDOException $e) {
        // En caso de error, revierte la transacción
        $pdo->rollBack();
        echo "Error al eliminar el post: " . $e->getMessage();
    }
} else {
    echo "No se especificó el post a eliminar.";
}
?>
