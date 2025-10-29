<?php
require_once '../templates/header.php';
require_once '../persistence/DAO/EquipoDAO.php';
require_once '../persistence/DAO/PartidoDAO.php';

$eDAO = new EquipoDAO();
$pDAO = new PartidoDAO();

// Obtener todos los equipos
$equipos = $eDAO->selectAll();

// Insertar nuevo partido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_local = $_POST['local'] ?? null;
    $id_visitante = $_POST['visitante'] ?? null;
    $jornada = $_POST['jornada'] ?? null;
    $resultado = $_POST['resultado'] ?? null;
    $estadio = $_POST['estadio'] ?? null;

    if ($id_local && $id_visitante && $jornada && $estadio) {
        $pDAO->insert($id_local, $id_visitante, $jornada, $resultado, $estadio);
    }
}

// Obtener todos los partidos
$partidos = $pDAO->selectAll();
?>

<body>

  <div class="container py-5">
    <h1 class="text-center text-primary mb-4">Gestión de Partidos</h1>

    <!-- Formulario para registrar nuevo partido -->
    <div class="card shadow-sm mb-5">
      <div class="card-body">
        <h4 class="mb-3">Registrar partido</h4>
        <form method="POST" class="row g-3">
          <div class="col-md-3">
            <select name="local" class="form-select" required>
              <option value="">Equipo local</option>
              <?php foreach ($equipos as $eq): ?>
                <option value="<?= $eq->getIdEquipo() ?>"><?= htmlspecialchars($eq->getNombre()) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-3">
            <select name="visitante" class="form-select" required>
              <option value="">Equipo visitante</option>
              <?php foreach ($equipos as $eq): ?>
                <option value="<?= $eq->getIdEquipo() ?>"><?= htmlspecialchars($eq->getNombre()) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-2">
            <input type="number" name="jornada" class="form-control" placeholder="Jornada" min="1" required>
          </div>
          <div class="col-md-2">
            <input type="text" name="resultado" class="form-control" placeholder="2-1">
          </div>
          <div class="col-md-2">
            <input type="text" name="estadio" class="form-control" placeholder="Estadio" required>
          </div>
          <div class="col-md-12 text-end">
            <button class="btn btn-primary px-4">Guardar</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Tabla de partidos -->
    <table class="table table-striped table-bordered shadow-sm text-center">
      <thead class="table-primary">
        <tr>
          <th>ID</th>
          <th>Local</th>
          <th>Visitante</th>
          <th>Jornada</th>
          <th>Resultado</th>
          <th>Estadio</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($partidos as $p): ?>
          <tr>
            <td><?= $p->getIdPartido() ?></td>
            <td><?= $p->getIdLocal() ?></td>
            <td><?= $p->getIdVisitante() ?></td>
            <td><?= $p->getJornada() ?></td>
            <td><?= $p->getResultado() ?: '-' ?></td>
            <td><?= htmlspecialchars($p->getEstadio()) ?></td>
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
