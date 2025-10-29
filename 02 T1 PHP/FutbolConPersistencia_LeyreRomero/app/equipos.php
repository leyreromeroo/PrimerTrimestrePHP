<?php
require_once '../templates/header.php';

// incluye DAO y modelo
require_once '../persistence/DAO/EquipoDAO.php';
require_once '../models/Equipo.php';

// instancia del DAO
$dao = new EquipoDAO();

// insertar equipo si llega POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $estadio = trim($_POST['estadio'] ?? '');

    if ($nombre === '' || $estadio === '') {
        $error = "Todos los campos son obligatorios.";
    } else {
        $ok = $dao->insert($nombre, $estadio);
        if ($ok === false) {
            $error = "No se pudo insertar el equipo (error en BD).";
        } else {
            header("Location: equipos.php");
            exit;
        }
    }
}

// obtener todos los equipos (devuelve array de objetos Equipo)
$equipos = $dao->selectAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Equipos - LaLiga</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h1 class="text-success text-center mb-4">Equipos</h1>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Formulario de alta -->
    <div class="card shadow-sm mb-5">
      <div class="card-body">
        <h4 class="mb-3">Añadir nuevo equipo</h4>
        <form method="POST" class="row g-3">
          <div class="col-md-5">
            <input type="text" name="nombre" placeholder="Nombre" class="form-control" required>
          </div>
          <div class="col-md-5">
            <input type="text" name="estadio" placeholder="Estadio" class="form-control" required>
          </div>
          <div class="col-md-2">
            <button class="btn btn-success w-100">Añadir</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Tabla de equipos -->
    <table class="table table-striped table-bordered shadow-sm">
      <thead class="table-success text-center">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Estadio</th>
          <th>Partidos</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($equipos)): ?>
          <?php foreach ($equipos as $e): ?>
            <tr>
              <td><?= htmlspecialchars($e->getIdEquipo()) ?></td>
              <td><?= htmlspecialchars($e->getNombre()) ?></td>
              <td><?= htmlspecialchars($e->getEstadio()) ?></td>
              <td class="text-center">
                <a href="partidos_equipo.php?id=<?= htmlspecialchars($e->getIdEquipo()) ?>" class="btn btn-outline-primary btn-sm">Ver</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="4" class="text-center text-muted">No hay equipos registrados</td></tr>
        <?php endif; ?>
      </tbody>
    </table>

    <div class="text-center mt-4">
      <a href="../index.php" class="btn btn-secondary">Volver al inicio</a>
    </div>
  </div>
</body>
</html>
