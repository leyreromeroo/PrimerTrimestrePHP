<?php
require_once 'templates/header.php';

// Si el usuario consultó un equipo → redirigir a sus partidos
if (isset($_SESSION['ultimo_equipo_id']) && !empty($_SESSION['ultimo_equipo_id'])) {
    $id = $_SESSION['ultimo_equipo_id'];
    header("Location: app/partidos_equipo.php?id=" . intval($id));
    exit;
}

// Si no hay sesión → ir a equipos
header("Location: app/equipos.php");
exit;
?>
?>


<div class="container align-items-center d-flex flex-column justify-content-center" style="height: 70vh;">
  <h1 class="text-primary mb-4">⚽ Bienvenido a LaLiga</h1>
  <p class="lead">Consulta los resultados de tu equipo o partidos.</p>
  <div class="d-flex justify-content-center gap-4 mt-4">
    <a href="app/equipos.php" class="btn btn-lg btn-success px-5">Equipos</a>
    <a href="app/partidos.php" class="btn btn-lg btn-primary px-5">Partidos</a>
  </div>
</div>
</body>

</html>