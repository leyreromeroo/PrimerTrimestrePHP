<?php

/**
 * @title: Proyecto integrador Ev01 - Cabecera y barra de navegación.
 * @description: Incluye la cabecera HTML y el menú de navegación con opciones de Equipos y Partidos.
 *
 * @version    0.3
 * @author     Ander Frago & Miguel Goyena
 */

// 1. Siempre iniciar la sesión lo más pronto posible
// URLs de destino. Asegúrate que $urlApp esté bien definida para tu entorno local.
$urlApp = '/Trabajos DW/PrimerTrimestrePHP/02 T1 PHP/FutbolConPersistencia_LeyreRomero/'; // Añade '/' final para consistencia
$url_equipos = $urlApp . 'app/equipos.php';
$url_partidos_default = $urlApp . 'app/partidos.php';
$urlApp = '/Trabajos DW/PrimerTrimestrePHP/02 T1 PHP/ArteanV1/'; 

// Rutas a las páginas del proyecto
$indexPath = $urlApp . 'index.php';
$equiposPath = $urlApp . 'app/equipos.php';
$partidosPath = $urlApp . 'app/partidos.php';
$bootstrapPath = $urlApp . 'assets/css/bootstrap.css'; // Ruta a tu CSS

// Definir la página de inicio por defecto
$pagina_principal = $url_equipos;

// ----------------------------------------------------
// LÓGICA DE SESIÓN (La regla del ejercicio, sin login/signup por ahora)
// ----------------------------------------------------
session_start();

// Regla 2: Si el usuario ha consultado los partidos de un equipo concreto.
if (isset($_SESSION['equipo_id_consultado']) && $_SESSION['equipo_id_consultado'] > 0) {
    $id_equipo = $_SESSION['equipo_id_consultado'];
    // Redirigir a PartidosEquipo con el ID almacenado.
    $pagina_principal = $urlApp . 'app/partidos_equipo.php?id=' . $id_equipo;

} 
// Regla 1 (implícita): Si no hay ID de equipo consultado
else if (isset($_SESSION['ultima_pagina']) && $_SESSION['ultima_pagina'] === 'partidos') {
    // Si la última página GENERAL fue Partidos, redirigir allí.
    $pagina_principal = $url_partidos_default;
}
// En cualquier otro caso (sesión nueva, o última página 'equipos'), se mantiene $pagina_principal = $url_equipos.


// Redirigir al destino
header("Location: " . $pagina_principal);
exit;



?>
<!--Trabajos DW/PrimerTrimestrePHP/02 T1 PHP/ArteanV1/assets/css/bootstrap.css-->
<link rel="stylesheet" href="<?= $bootstrapPath ?>">

<head>
    <meta charset="utf-8">
    <title><?php echo "$user" ?></title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

</head>


<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-custom-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= $indexPath ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-trophy-fill me-2" viewBox="0 0 16 16">
                    <path d="M2.5.75a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 .75.75v.75H2.5V.75zM13.25.75a.75.75 0 0 1 .75.75v.75h-1.5V.75a.75.75 0 0 1 .75-.75h1.5zM15.5 16h-15V14.5a1.5 1.5 0 0 1 1.5-1.5h12a1.5 1.5 0 0 1 1.5 1.5V16zm-5-14.75V1.5H5.5V1.25a.25.25 0 0 0-.5 0V1.5h-1V.75a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 .75.75v.75h-1V1.5a.25.25 0 0 0-.5 0zM8 12.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                </svg>
                Gestión Deportiva
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mt-2 mt-md-0">

                    <li class="nav-item">
                        <a class="nav-link <?= $indexPath ?>">
                            Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $url_equipos ?>">
                            Equipos
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= $partidosPath ?>">
                            Partidos
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <?php

    ?>

    <!-- TODO Hay que incluir el Bootstrap en Assets -->
    <script src="/Trabajos DW/PrimerTrimestrePHP/02 T1 PHP/FutbolConPersistencia_LeyreRomero/assets/js/bootstrap.js"></script>