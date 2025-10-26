<?php
// Iniciar sesión al comienzo del script (antes de cualquier salida)
session_start();

// Procesar las acciones antes de renderizar la página
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Si se pulsa el botón Iniciar
    if (isset($_POST['iniciar'])) {//El isset es para comprobar si existe el índice 'iniciar' en el array $_POST (si se ha pulsado el botón)
        $nombre = $_POST['nombre'];
        if ($nombre !== '') {
            $_SESSION['nombre'] = $nombre; // Guardar nombre en sesión
        } else {
            // Si envían vacío, nos aseguramos de no dejar nombre anterior
            unset($_SESSION['nombre']);
        }
    }

    // Si se pulsa el botón Cerrar
    if (isset($_POST['cerrar'])) {
        // Solo queremos borrar la variable 'nombre' (no destruir toda la sesión)
        unset($_SESSION['nombre']);
        // Si deseas destruir la sesión por completo usar:
        // session_unset();
        // session_destroy();
        // Nota: si destruyes la sesión, si usas `session_destroy()` y quieres seguir usando $_SESSION
        // durante esta misma petición tendrías que reiniciar session_start(), por eso aquí solo unset.
    }
}

// Estado actual de la sesión (ya procesado)
$sesionIniciada = isset($_SESSION['nombre']);

// Mensaje para mostrar en la página
if ($sesionIniciada) {
    $mensajeSesion = "✅ Sesión iniciada. Bienvenido, " . $_SESSION['nombre'];
} else {
    $mensajeSesion = "⚠️ No hay sesión iniciada.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Sesiones y Archivos en PHP</title>
</head>
<body>
    <h1>Gestión de Sesiones y Archivos en PHP</h1>

    <!-- FORMULARIO ÚNICO: inicio y cierre -->
    <form method="POST" action="">
        <!-- Si la sesión está iniciada, ocultamos el input del nombre -->
        <?php if (!$sesionIniciada): ?>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" autocomplete="off">
        <?php else: ?>
            <!-- opcional: mostrar nombre en un campo readonly -->
            <label>Usuario:</label>
            <input type="text" value="<?=$_SESSION['nombre']; ?>" readonly>
        <?php endif; ?>

        <!-- Botón iniciar solo visible si NO hay sesión iniciada -->
        <?php if (!$sesionIniciada): ?>
            <button type="submit" name="iniciar">Iniciar Sesión</button>
        <?php endif; ?>

        <!-- Botón cerrar solo visible si hay sesión iniciada -->
        <?php if ($sesionIniciada): ?>
            <button type="submit" name="cerrar">Cerrar Sesión</button>
        <?php endif; ?>
    </form>

    <p><?= $mensajeSesion; ?></p>
</body>
</html>
