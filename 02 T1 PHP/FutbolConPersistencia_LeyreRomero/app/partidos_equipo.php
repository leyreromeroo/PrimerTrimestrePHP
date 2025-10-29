<?php
require_once 'templates/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Trabajos DW/PrimerTrimestrePHP/02 T1 PHP/FutbolConPersistencia_LeyreRomero/persistence/DAO/EquipoDAO.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Trabajos DW/PrimerTrimestrePHP/02 T1 PHP/FutbolConPersistencia_LeyreRomero/persistence/DAO/PartidoDAO.php';

$id = $_GET['id'] ?? null;
if (!$id) die("⚠️ Equipo no especificado");

$equipoDAO = new EquipoDAO();
$partidoDAO = new PartidoDAO();

$equipo = $equipoDAO->getEquipoById($id);
$partidos = $partidoDAO->getPartidosByEquipo($id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Partidos de <?= htmlspecialchars($equipo->getNombre()) ?></title>
</head>
<body>
    <h1>Partidos de <?= htmlspecialchars($equipo->getNombre()) ?></h1>

    <ul>
        <?php foreach ($partidos as $p): ?>
            <li>
                Jornada <?= htmlspecialchars($p->getjornada) ?> —
                Resultado: <?= htmlspecialchars($p->resultado) ?> —
                Estadio: <?= htmlspecialchars($p->estadio) ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="equipos.php">Volver a equipos</a>
</body>
</html>
