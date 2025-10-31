<?php
require_once '../templates/header.php';

// incluye DAO y modelo
require_once '../persistence/DAO/EquipoDAO.php';
require_once '../models/Equipo.php';

// instancia del DAO
$dao = new EquipoDAO();
$error = '';
$success = '';

// insertar equipo si llega POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = trim($_POST['nombre'] ?? '');
  $estadio = trim($_POST['estadio'] ?? '');

  if ($nombre === '' || $estadio === '') {
    $error = "Todos los campos son obligatorios.";
  } else {
    $ok = $dao->insert($nombre, $estadio);
    if ($ok === false) {
      // Este mensaje de error solo se mostrará si hay un problema de base de datos
      $error = "No se pudo insertar el equipo (error en BD).";
    } else {
      $success = "¡Equipo '{$nombre}' registrado con éxito!";
      // Redirección para evitar reenvío del formulario (Post/Redirect/Get pattern)
      header("Location: equipos.php");
      exit;
    }
  }
}

// obtener todos los equipos (devuelve array de objetos Equipo)
$equipos = $dao->selectAll();
?>

<!-- Contenido principal con mejoras visuales -->
<div class="container py-5">

  <!-- TÍTULO PRINCIPAL CON ICONO -->
  <h1 class="text-center text-primary mb-5 fw-bolder">
    <i class="fa-solid fa-people-group width=40 height=40"></i>
    Equipos
  </h1>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger fixed-top mx-auto mt-2" style="max-width: 400px; z-index: 1000;"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <?php if (!empty($success)): ?>
    <div class="alert alert-success fixed-top mx-auto mt-2" style="max-width: 400px; z-index: 1000;"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <div class="table-responsive rounded-3 shadow-lg mb-4">
    <table class="table table-striped table-hover align-middle mb-0 text-center">
      <!-- ENCABEZADO DE TABLA AZUL FUERTE -->
      <thead class="bg-primary fw-bold text-white">
        <tr>
          <th>Nombre</th>
          <th>Estadio</th>
          <th>Ver Partidos</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($equipos)): ?>
          <tr>
            <td colspan="3" class="text-center text-muted py-4">
              No hay equipos registrados. ¡Usa el botón de abajo para añadir uno!
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($equipos as $e): ?>
            <tr>
              <!-- Contenido Centrado -->
              <td class="fw-semibold text-dark"><?= htmlspecialchars($e->getNombre()) ?></td>
              <td class="text-muted"><?= htmlspecialchars($e->getEstadio()) ?></td>
              <td class="text-center">
                <a href="partidos_equipo.php?id=<?= htmlspecialchars($e->getIdEquipo()) ?>" class="btn btn-sm btn-outline-primary">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                  </svg>
                  Ver
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <button class="btn btn-outline-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addEquipoModal">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-circle-fill me-2" viewBox="0 0 16 16">
      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
    </svg>
    Añadir Equipo
  </button>
</div>

<!-- Modal para Añadir Equipo (Centrado y con estética consistente) -->
<div class="modal fade" id="addEquipoModal" tabindex="-1" aria-labelledby="addEquipoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content rounded-4 shadow-lg">
      <div class="modal-header bg-primary text-white rounded-top-4">
        <h5 class="modal-title fw-bold" id="addEquipoModalLabel">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-fill-add me-2" viewBox="0 0 16 16">
            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v-1a.5.5 0 0 1 1 0v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1zm-2-7a3 3 0 1 0 0 6 3 3 0 0 0 0-6m-2.715 6.842A.995.995 0 0 0 7 12.012V13h2v-1c0-.256-.058-.493-.157-.714C9.557 11.455 11.238 10 13 10c.026 0 .053.003.079.006-.411-.264-.86-.544-1.3-.772C11.173 9.421 8.84 9 6.678 9c-2.43 0-4.654.437-5.597 1.05.02.046.04.092.058.138A8.04 8.04 0 0 1 0 12c0 .381.109.745.289 1.077zM4.5 9a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
          </svg>
          Registrar Nuevo Equipo
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Formulario simple de dos campos -->
      <form method="POST">
        <div class="modal-body">
          <div class="mb-3">
            <label for="nombre" class="form-label fw-semibold">Nombre del Equipo</label>
            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: Real Madrid C.F." required>
          </div>
          <div class="mb-3">
            <label for="estadio" class="form-label fw-semibold">Estadio</label>
            <input type="text" name="estadio" id="estadio" class="form-control" placeholder="Ej: Santiago Bernabéu" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary shadow-sm px-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-save me-2" viewBox="0 0 16 16">
              <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
            </svg>
            Guardar Equipo
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once '../templates/footer.php'; ?>