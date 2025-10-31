<?php
require_once '../templates/header.php';
require_once '../persistence/DAO/EquipoDAO.php';
require_once '../persistence/DAO/PartidoDAO.php';
// require_once '../models/Partido.php'; //Lo tienen ya los DAOs

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header("Location: equipos.php");
    exit();
}

// GUARDAR EL EQUIPO COMO "ÚLTIMO CONSULTADO"
$_SESSION['ultimo_equipo_id'] = (int)$id;

$equipoDAO = new EquipoDAO();
$partidoDAO = new PartidoDAO();

// Carga de datos
$equipo = $equipoDAO->selectById($id);
if (!$equipo) {
    die("Error: Equipo no encontrado.");
}

// Verifica que $partidos sea un array (en caso de error o resultado vacío)
$partidos = $partidoDAO->selectByEquipo($id);
if (!is_array($partidos)) $partidos = [];
?>

<div class="content-wrapper"> 
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">

                <div class="text-center mb-4">
                    <h1 class="display-5 fw-bold text-primary">
                        <i class="fa-regular fa-calendar-days width= 35 height= 35"></i>
                        Calendario de Partidos
                    </h1>
                    <p class="lead text-muted">Resultados y detalles para el equipo: <?= htmlspecialchars($equipo->getNombre()) ?></p>
                </div>

                <?php if (count($partidos) > 0): ?>
                    
                    <div class="list-group">
                        <?php foreach ($partidos as $p): ?>
                            <div class="list-group-item list-group-item-action py-3 mb-3 border-start border-5 border-info shadow-sm rounded-lg hover-shadow transition-shadow">
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <h5 class="mb-1 fw-bold text-dark">Jornada <?= htmlspecialchars($p->getJornada()) ?></h5>
                                    <span class="badge bg-primary rounded-pill fs-6"><?= htmlspecialchars($p->getResultado()) ?></span>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <p class="mb-1 text-muted">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill me-1" viewBox="0 0 16 16">
                                              <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                            </svg>
                                            Estadio: <span class="fw-semibold text-dark"><?= htmlspecialchars($p->getEstadio()) ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                <?php else: ?>
                    <!-- MENSAJE DE NO RESULTADOS -->
                    <div class="alert alert-warning text-center" role="alert">
                        <h4 class="alert-heading">¡Vaya!</h4>
                        <p>No se encontraron partidos registrados para el equipo: <?= htmlspecialchars($equipo->getNombre()) ?></p>
                    </div>
                <?php endif; ?>

                <div class="text-center mt-5">
                    <a href="equipos.php" class="btn btn-outline-secondary btn-lg shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                        </svg>
                        Volver a la lista de equipos
                    </a>
                </div>

            </div>
        </div>
    </div>
</div> 

<?php
require_once '../templates/footer.php';
?>
