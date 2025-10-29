<?php
require_once '../persistence/DAO/EquipoDAO.php';
require_once '../persistence/DAO/PartidoDAO.php';

$eDAO = new EquipoDAO();
$pDAO = new PartidoDAO();

$equipos = $eDAO->getAllEquipos();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pDAO->insertPartido($_POST['local'], $_POST['visitante'], $_POST['fecha'], $_POST['resultado']);
}

$partidos = $pDAO->getAllPartidos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Partidos - LaLiga</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h1 class="text-center text-primary mb-4">Partidos</h1>

    <div class="card shadow-sm mb-5">
      <div class="card-body">
        <h4 class="mb-3">Registrar partido</h4>
        <form method="POST" class="row g-3">
          <div class="col-md-3">
            <select name="local" class="form-select" required>
              <option value="">Equipo local</option>
              <?php foreach ($equipos as $eq): ?>
                <option value="<?= $eq->getIdEquipo() ?>"><?= $eq->getNombre() ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-3">
            <select name="visitante" class="form-select" required>
              <option value="">Equipo visitante</option>
              <?php foreach ($equipos as $eq): ?>
                <option value="<?= $eq->getIdEquipo() ?>"><?= $eq->getNombre() ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-3">
            <input type="date" name="fecha" class="form-control" required>
          </div>
          <div class="col-md-2">
            <input type="text" name="resultado" class="form-control" placeholder="2-1">
          </div>
          <div class="col-md-1">
            <button class="btn btn-primary w-100">OK</button>
          </div>
        </form>
      </div>
    </div>

    <table class="table table-striped table-bordered shadow-sm text-center">
      <thead class="table-primary">
        <tr>
          <th>Fecha</th>
          <th>Local</th>
          <th>Visitante</th>
          <th>Resultado</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($partidos as $p): ?>
          <tr>
            <td><?= $p['fecha'] ?></td>
            <td><?= $p['local_nombre'] ?></td>
            <td><?= $p['visitante_nombre'] ?></td>
            <td><?= $p['resultado'] ?: '-' ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="text-center mt-4">
      <a href="../index.php" class="btn btn-secondary">Volver al inicio</a>
    </div>
  </div>
</body>
</html>
