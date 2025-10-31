<?php
require_once '../templates/header.php';
require_once '../persistence/DAO/EquipoDAO.php';
require_once '../persistence/DAO/PartidoDAO.php';

$eDAO = new EquipoDAO();
$pDAO = new PartidoDAO();

// Control de error cuando los equipos sean iguales
$error_equipo_igual = false;

// Cargamos los equipos disponibles
$equipos = $eDAO->selectAll();

/**
 * Función auxiliar para calcular el resultado codificado ('1', '2' o 'X')
 */
function calcularResultado($marcador)
{
  if (empty($marcador) || strpos($marcador, '-') === false) return null;

  $partes = explode('-', trim($marcador));
  if (count($partes) !== 2 || !is_numeric($partes[0]) || !is_numeric($partes[1])) return null;

  $goles_local = (int) $partes[0];
  $goles_visitante = (int) $partes[1];

  if ($goles_local > $goles_visitante) return '1';
  elseif ($goles_local < $goles_visitante) return '2';
  else return 'X';
}

// Procesar formulario POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_local = $_POST['local'] ?? null;
  $id_visitante = $_POST['visitante'] ?? null;
  $jornada = $_POST['jornada'] ?? null;
  $marcador_input = $_POST['resultado'] ?? null;
  $estadio = $_POST['estadio'] ?? null;

  if ($id_local && $id_visitante && $jornada && $estadio) {
    // Validamos que los equipos no sean iguales
    if ($id_local == $id_visitante) {
      $error_equipo_igual = true;
    } else {
      $resultado_codificado = calcularResultado($marcador_input);
      $pDAO->insert($id_local, $id_visitante, $jornada, $resultado_codificado, $estadio);
      // Redirigimos para evitar reenvío del formulario
      header("Location: " . $_SERVER['PHP_SELF']);
      exit;
    }
  }
}

$partidos = $pDAO->selectAll();
?>

<div class="container py-5">
  <h1 class="text-center text-primary mb-5 fw-bolder">
    <i class="fa-solid fa-trophy"></i>
    Partidos
  </h1>

  <!-- TABLA DE PARTIDOS -->
  <div class="table-responsive rounded-3 shadow-lg mb-4">
    <table class="table table-striped table-hover align-middle mb-0 text-center bg-primary">
      <thead class="fw-bold text-white">
        <tr>
          <th>Equipo Local</th>
          <th>Equipo Visitante</th>
          <th>Jornada</th>
          <th>Resultado</th>
          <th>Estadio</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($partidos)): ?>
          <tr>
            <td colspan="5" class="text-center text-muted py-4">
              Aún no hay partidos registrados. ¡Usa el botón de abajo para añadir uno!
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($partidos as $p): ?>
            <tr>
              <td class="fw-semibold text-primary"><?= $p->getNombreEquipoLocal() ?></td>
              <td class="fw-semibold text-danger"><?= $p->getNombreEquipoVisitante() ?></td>
              <td><span class="badge bg-secondary rounded-pill"><?= $p->getJornada() ?></span></td>
              <td>
                <span class="fw-bolder fs-6 <?= $p->getResultado() ? 'text-dark' : 'text-muted' ?>">
                  <?= $p->getResultado() ?: 'Pendiente' ?>
                </span>
              </td>
              <td><?= htmlspecialchars($p->getEstadio()) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <button class="btn btn-outline-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addPartidoModal">
    <i class="fa-solid fa-circle-plus me-2"></i>
    Añadir Partido
  </button>
</div>

<!-- MODAL NUEVO PARTIDO -->
<div class="modal fade" id="addPartidoModal" tabindex="-1" aria-labelledby="addPartidoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4 shadow-lg">
      <div class="modal-header bg-primary text-white rounded-top-4">
        <h5 class="modal-title fw-bold" id="addPartidoModalLabel">
          <i class="fa-solid fa-calendar-plus me-2"></i>
          Registrar Nuevo Partido
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" id="formPartido">
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="local" class="form-label fw-semibold">Equipo Local</label>
              <select name="local" id="local" class="form-select border-primary" required>
                <option value="">Selecciona</option>
                <?php foreach ($equipos as $eq): ?>
                  <option value="<?= $eq->getIdEquipo() ?>"><?= htmlspecialchars($eq->getNombre()) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-6">
              <label for="visitante" class="form-label fw-semibold">Equipo Visitante</label>
              <select name="visitante" id="visitante" class="form-select border-danger" required>
                <option value="">Selecciona</option>
                <?php foreach ($equipos as $eq): ?>
                  <option value="<?= $eq->getIdEquipo() ?>"><?= htmlspecialchars($eq->getNombre()) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-4">
              <label for="jornada" class="form-label fw-semibold">Jornada</label>
              <input type="number" name="jornada" id="jornada" class="form-control" placeholder="#" min="1" required>
            </div>

            <div class="col-md-4">
              <label for="resultado" class="form-label fw-semibold">Resultado</label>
              <input type="text" name="resultado" id="resultado" class="form-control" placeholder="Ej: 2-1">
            </div>

            <div class="col-md-4">
              <label for="estadio" class="form-label fw-semibold">Estadio</label>
              <input type="text" name="estadio" id="estadio" class="form-control" placeholder="Nombre Estadio" required>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary shadow-sm px-4" id="btnGuardar">
            <i class="fa-solid fa-floppy-disk me-2"></i>
            Guardar Partido
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- SCRIPT DE VALIDACIÓN CLIENTE -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const localSelect = document.getElementById('local');
    const visitanteSelect = document.getElementById('visitante');
    const btnGuardar = document.getElementById('btnGuardar');
    const form = document.getElementById('formPartido');
    const hayErrorServidor = <?= $error_equipo_igual ? 'true' : 'false'; ?>;

    // Si hubo error desde el servidor, reabrir modal automáticamente
    if (hayErrorServidor) {
      const modal = new bootstrap.Modal(document.getElementById('addPartidoModal'));
      modal.show();
    }

    function actualizarOpciones() {
      const localVal = localSelect.value;
      const visitanteVal = visitanteSelect.value;

      // Rehabilitar todas las opciones
      document.querySelectorAll('#local option, #visitante option').forEach(opt => opt.disabled = false);

      // Deshabilitar el equipo seleccionado en el otro select
      if (localVal) {
        const opt = document.querySelector(`#visitante option[value="${localVal}"]`);
        if (opt) opt.disabled = true;
      }
      if (visitanteVal) {
        const opt = document.querySelector(`#local option[value="${visitanteVal}"]`);
        if (opt) opt.disabled = true;
      }

      // Bloquear guardado si ambos son iguales
      btnGuardar.disabled = (localVal && visitanteVal && localVal === visitanteVal);
    }

    // Eventos
    localSelect.addEventListener('change', actualizarOpciones);
    visitanteSelect.addEventListener('change', actualizarOpciones);

    // Reset al cerrar modal
    const modalElement = document.getElementById('addPartidoModal');
    modalElement.addEventListener('hidden.bs.modal', function() {
      form.reset();
      btnGuardar.disabled = false;
      document.querySelectorAll('#local option, #visitante option').forEach(opt => opt.disabled = false);
    });
  });
</script>

<?php require_once '../templates/footer.php'; ?>
