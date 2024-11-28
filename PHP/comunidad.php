<?php
include('config.php');
session_start();

// Obtener todas las publicaciones
$stmt = $pdo->query("SELECT * FROM Posts ORDER BY fecha_publicacion DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comunidad</title>
</head>
<body>
    <h1>Comunidad</h1>

    <?php foreach ($posts as $post): ?>
        <div class="post">
            <h2><?= htmlspecialchars($post['titulo']); ?></h2>
            <p><?= nl2br(htmlspecialchars($post['contenido'])); ?></p>
            <img src="<?= htmlspecialchars($post['image_url']); ?>" alt="Imagen del post">

            <!-- Formulario de comentarios -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <form action="add_comment.php" method="POST">
                    <textarea name="contenido" placeholder="Escribe tu comentario" required></textarea><br>
                    <input type="hidden" name="id_post" value="<?= $post['id_post']; ?>">
                    <button type="submit">Comentar</button>
                </form>
            <?php else: ?>
                <p><a href="login.php">Inicia sesión</a> para comentar.</p>
            <?php endif; ?>

            <!-- Mostrar comentarios -->
            <div class="comments">
                <?php
                $stmt_comments = $pdo->prepare("SELECT * FROM Comentarios WHERE id_post = ? ORDER BY fecha_comentario DESC");
                $stmt_comments->execute([$post['id_post']]);
                $comments = $stmt_comments->fetchAll(PDO::FETCH_ASSOC);

                foreach ($comments as $comment): ?>
                    <p><strong>Usuario <?= $comment['id_usuario']; ?>:</strong> <?= nl2br(htmlspecialchars($comment['contenido'])); ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</body>
</html>
