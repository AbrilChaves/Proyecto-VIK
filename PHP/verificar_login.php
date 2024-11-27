<?php
session_start();

// Verificar si el usuario está logueado
$is_logged_in = isset($_SESSION['usuario_id']);
$nombre = $is_logged_in ? $_SESSION['nombre'] : null;
$rol = $is_logged_in ? $_SESSION['rol'] : null;

// Devolver la respuesta en formato JSON
echo json_encode([
    'is_logged_in' => $is_logged_in,
    'usuario_nombre' => $nombre,
    'usuario_rol' => $rol
]);

// Finaliza el script
exit;
?>
