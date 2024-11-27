<?php
session_start();

// Verifica si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    echo "Debes iniciar sesión para crear un post.";
    exit;
}

if ($_SESSION['rol'] !== 'admin') {
    echo "Solo los administradores pueden crear posts.";
    exit;
}

// Conexión a la base de datos
$host = "localhost";
$dbname = "Vik_database";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}

// Verificar si los datos fueron enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['imagen']) && isset($_POST['titulo']) && isset($_POST['nombre_imagen'])) {
    $titulo = $_POST['titulo'];
    $imagen_nombre = $_POST['nombre_imagen'];
    $id_usuario = $_SESSION['usuario_id'];
    $fecha_post = date('Y-m-d H:i:s');
    
    // Procesar la imagen
    $imagen = $_FILES['imagen'];
    
    // Validar imagen
    if ($imagen['error'] === UPLOAD_ERR_OK) {
        // Obtener la extensión de la imagen
        $ext = pathinfo($imagen['name'], PATHINFO_EXTENSION);
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Verificar si la extensión es válida
        if (in_array(strtolower($ext), $allowed_extensions)) {
            // Mover el archivo a la carpeta de imágenes
            $imagen_nombre .= '.' . $ext;
            $imagen_path = '../IMG/' . $imagen_nombre;
            
            if (move_uploaded_file($imagen['tmp_name'], $imagen_path)) {
                // Guardar el post en la base de datos
                try {
                    $query = "INSERT INTO Posts (id_usuario, titulo, contenido,  fecha_publicacion) 
                              VALUES (:id_usuario, :titulo, :contenido, :fecha_publicacion)";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':id_usuario', $id_usuario);
                    $stmt->bindParam(':titulo', $titulo);
                    $stmt->bindParam(':contenido', $imagen_path);
                    $stmt->bindParam(':fecha_publicacion', $fecha_post);
                    $stmt->execute();
                    echo "<script>alert('Post creado con éxito.'); window.location.href = '../HTML/comunidad.html';</script>";
                } catch (PDOException $e) {
                    echo "Error al guardar el post: " . $e->getMessage();
                }
            } else {
                echo "Error al mover el archivo de imagen.";
            }
        } else {
            echo "Formato de imagen no válido. Solo se permiten JPG, JPEG, PNG y GIF.";
        }
    } else {
        echo "Error al subir la imagen.";
    }
} else {
    echo "Faltan datos para crear el post.";
}
?>
