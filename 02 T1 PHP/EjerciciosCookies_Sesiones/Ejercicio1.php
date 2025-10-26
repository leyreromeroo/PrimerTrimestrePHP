<?php
session_start(); // Iniciar sesión al principio del script

function comprobarInicioSesion() {
   // Si se envía el formulario
    if (isset($_POST['nombre'])) {
        $nombre = $_POST['nombre']; 

        if ($nombre !== "") {
            // Guardamos el nombre si no está vacío
            $_SESSION['nombre'] = $nombre;
        } else {
            // Si está vacío, eliminamos la sesión anterior (si existía)
            unset($_SESSION['nombre']);
        }
    }
      // Si se ha pulsado el botón de cerrar sesión
    if (isset($_POST['cerrar'])) {
        cerrarSesion();
    }
    // Mostrar mensaje según el estado de la sesión
    if (isset($_SESSION['nombre'])) {
        echo "Sesión iniciada. Bienvenido, " . $_SESSION['nombre'] . "!";
    } else {
        echo "No hay sesión iniciada.";
    }
}

function cerrarSesion() {
    session_unset(); // Eliminar todas las variables de sesión
    session_destroy(); // Destruir la sesión
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Sesiones y Archivos en PHP</title>
</head>
<body>
    <h1>Gestión de Sesiones y Archivos en PHP</h1>
    <form method="POST" action="#">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre">

        <button type="submit" name="iniciar">Enviar</button>
        <!-- Botón visible solo si la sesión está iniciada -->
        <button type="submit" name="cerrar" <?= isset($_SESSION['nombre']) ? '' : 'hidden'; ?>>Cerrar Sesión</button>
    </form>

    <p><?=comprobarInicioSesion();?></p>

</body>
</html>