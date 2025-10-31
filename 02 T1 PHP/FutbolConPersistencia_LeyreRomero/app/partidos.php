<?php
require_once '../templates/header.php';
require_once '../persistence/DAO/EquipoDAO.php';
require_once '../persistence/DAO/PartidoDAO.php';

$eDAO = new EquipoDAO();
$pDAO = new PartidoDAO();
$error_equipo_igual = false;
$equipos = $eDAO->selectAll();

function calcularResultado($marcador)
{
  if (empty($marcador) || strpos($marcador, '-') === false) {
    return null;
  }
  $partes = explode('-', trim($marcador));
  if (count($partes) !== 2 || !is_numeric($partes[0]) || !is_numeric($partes[1])) {
    return null;
  }
  $goles_local = (int) $partes[0];
  $goles_visitante = (int) $partes[1];
  if ($goles_local > $goles_visitante) return '1';
  elseif ($goles_local < $goles_visitante) return '2';
  else return 'X';
}

// Procesar POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_local = $_POST['local'] ?? null;
  $id_visitante = $_POST['visitante'] ?? null;
  $jornada = $_POST['jornada'] ?? null;
  $marcador_input = $_POST['resultado'] ?? null;
  $estadio = $_POST['estadio'] ?? null;

  if ($id_local && $id_visitante && $jornada && $estadio) {
    if ($id_local == $id_visitante) {
      $error_equipo_igual = true;
    } else {
      $resultado_codificado = calcularResultado($marcador_input);
      $pDAO->insert($id_local, $id_visitante, $jornada, $resultado_codificado, $estadio);
      // Opcional: redirigir para evitar reenvío
      header("Location: " . $_SERVER['PHP_SELF']);
      exit;
    }
  }
}

$partidos = $pDAO->selectAll();
?>

<!-- Contenido principal con mejoras visuales -->
<div class="container py-5">
  <!-- TÍTULO PRINCIPAL CON ICONO -->
  <h1 class="text-center text-primary mb-5 fw-bolder">
    <i class="fa-solid fa-trophy width=40 height=40"></i>
    Partidos
  </h1>

  <div class="table-responsive rounded-3 shadow-lg mb-4">
    <table class="table table-striped table-hover align-middle mb-0 text-center bg-primary">
      <!-- ENCABEZADO DE TABLA AZUL (table-primary) -->
      <thead class="fw-bold text-white"> <!-- Añado text-white para mejor contraste -->
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
              <!-- Nombres de equipos centrados y resaltados con colores de equipos (primary/danger) -->
              <td class="fw-semibold text-primary"><?= $p->getNombreEquipoLocal() ?></td>
              <td class="fw-semibold text-danger"><?= $p->getNombreEquipoVisitante() ?></td>
              <td><span class="badge bg-secondary rounded-pill"><?= $p->getJornada() ?></span></td>
              <td>
                <!-- Resaltamos el resultado -->
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
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-circle-fill me-2" viewBox="0 0 16 16">
      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
    </svg>
    Añadir Partido
  </button>
</div>

<!-- Modal para Añadir Partido -->
<div class="modal fade" id="addPartidoModal" tabindex="-1" aria-labelledby="addPartidoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4 shadow-lg">
      <div class="modal-header bg-primary text-white rounded-top-4">
        <h5 class="modal-title fw-bold" id="addPartidoModalLabel">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-calendar-plus me-2" viewBox="0 0 16 16">
            <path d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7" />
            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
          </svg>
          Registrar Nuevo Partido
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" id="formPartido">
        <div class="modal-body">
          <div class="row g-3">
            <!-- Select Local -->
            <div class="col-md-6">
              <label for="local" class="form-label fw-semibold">Equipo Local</label>
              <select name="local" id="local" class="form-select border-primary" required>
                <option value="">Selecciona</option>
                <?php foreach ($equipos as $eq): ?>
                  <option value="<?= $eq->getIdEquipo() ?>"><?= htmlspecialchars($eq->getNombre()) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Select Visitante -->
            <div class="col-md-6">
              <label for="visitante" class="form-label fw-semibold">Equipo Visitante</label>
              <select name="visitante" id="visitante" class="form-select border-danger" required>
                <option value="">Selecciona</option>
                <?php foreach ($equipos as $eq): ?>
                  <option value="<?= $eq->getIdEquipo() ?>"><?= htmlspecialchars($eq->getNombre()) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Jornada -->
            <div class="col-md-4">
              <label for="jornada" class="form-label fw-semibold">Jornada</label>
              <input type="number" name="jornada" id="jornada" class="form-control" placeholder="#" min="1" required>
            </div>

            <!-- Resultado -->
            <div class="col-md-4">
              <label for="resultado" class="form-label fw-semibold">Resultado</label>
              <input type="text" name="resultado" id="resultado" class="form-control" placeholder="Ej: 2-1">
            </div>

            <!-- Estadio -->
            <div class="col-md-4">
              <label for="estadio" class="form-label fw-semibold">Estadio</label>
              <input type="text" name="estadio" id="estadio" class="form-control" placeholder="Nombre Estadio" required>
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary shadow-sm px-4" id="btnGuardar">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-save me-2" viewBox="0 0 16 16">
              <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
            </svg>
            Guardar Partido
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const localSelect = document.getElementById('local');
    const visitanteSelect = document.getElementById('visitante');
    const errorMsg = document.getElementById('error-equipo-igual');
    const btnGuardar = document.getElementById('btnGuardar');
    const form = document.getElementById('formPartido');
    const hayErrorServidor = <?= $error_equipo_igual ? 'true' : 'false'; ?>;

    // Mostrar modal y error si viene del servidor
    if (hayErrorServidor) {
      const modal = new bootstrap.Modal(document.getElementById('addPartidoModal'));
      modal.show();
    }

    function actualizarOpciones() {
      const localVal = localSelect.value;
      const visitanteVal = visitanteSelect.value;

      // Habilitar todas las opciones
      document.querySelectorAll('#local option, #visitante option').forEach(opt => {
        opt.disabled = false;
      });

      // Deshabilitar la opción del otro select
      if (localVal) {
        const opt = document.querySelector(`#visitante option[value="${localVal}"]`);
        if (opt) opt.disabled = true;
      }
      if (visitanteVal) {
        const opt = document.querySelector(`#local option[value="${visitanteVal}"]`);
        if (opt) opt.disabled = true;
      }

      // Validar equipos iguales
      if (localVal && visitanteVal && localVal === visitanteVal) {
        btnGuardar.disabled = true;
      } else {
        btnGuardar.disabled = false;
      }
    }

    // Eventos
    localSelect.addEventListener('change', actualizarOpciones);
    visitanteSelect.addEventListener('change', actualizarOpciones);

    // Al abrir el modal
    const modalElement = document.getElementById('addPartidoModal');
    modalElement.addEventListener('show.bs.modal', function() {
      setTimeout(actualizarOpciones, 50);
    });

    // Resetear al cerrar
    modalElement.addEventListener('hidden.bs.modal', function() {
      form.reset();
      btnGuardar.disabled = false;
      document.querySelectorAll('#local option, #visitante option').forEach(opt => {
        opt.disabled = false;
      });
    });
  });
</script>

<?php require_once '../templates/footer.php'; ?>