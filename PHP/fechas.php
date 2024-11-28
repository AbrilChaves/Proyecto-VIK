<?php
// ver_fechas.php

// Conexión a la base de datos
$host = "localhost"; // Dirección de tu servidor
$dbname = "Vik_database"; // Nombre de tu base de datos
$username = "root"; // Usuario de tu base de datos
$password = ""; // Contraseña de tu base de datos

session_start(); // Iniciar sesión al inicio del archivo

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}

// Función para obtener los eventos
function obtenerEventos() {
    global $pdo;
    $query = "SELECT id_evento, lugar, fecha, hora FROM Eventos ORDER BY fecha ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Obtener los eventos
$eventos = obtenerEventos();

// Función para generar el HTML de los eventos
function generarEventosHTML($eventos) {
    $html = '<table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Lugar</th>';

    // Agregar columna de "Acciones" si el usuario es admin
    if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
        $html .= '<th><div class="centrar"><a href="./agregar_fecha.html"><button id="btn-evento">Agregar Evento</button></a></div></th>';
    }

    $html .= '</tr>
            </thead>
            <tbody>';

    foreach ($eventos as $evento) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars(date('d-m', strtotime($evento['fecha']))) . '</td>';
        $html .= '<td>' . htmlspecialchars(date('H:i', strtotime($evento['hora']))) . ' hs</td>';
        $html .= '<td>' . htmlspecialchars($evento['lugar']) . '</td>';

        // Si el usuario es admin, agregar botón de eliminar
        if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
            $html .= '<td>
                        <form action="../PHP/eliminar_fecha.php" method="POST" onsubmit="return confirm(\'¿Estás seguro de que quieres eliminar este evento?\')">
                            <input type="hidden" name="id_evento" value="' . htmlspecialchars($evento['id_evento']) . '">
                            <input type="submit" value="Eliminar">
                        </form>
                      </td>';
        }

        $html .= '</tr>';
    }

    $html .= '</tbody>
            </table>';

    return $html;
}

// Mostrar los eventos como HTML
echo generarEventosHTML($eventos);
?>
