<?php

$urlApp = '/Trabajos DW/PrimerTrimestrePHP/02 T1 PHP/FutbolConPersistencia_LeyreRomero/';
$indexPath = $urlApp . 'index.php';
$url_equipos = $urlApp . 'app/equipos.php';
$partidosPath = $urlApp . 'app/partidos.php';
require_once __DIR__ . '/../utils/SessionHelper.php';

// INICIAR SESIÓN CON TU SessionHelper
SessionHelper::startSessionIfNotStarted();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>LaLiga</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/dc47467364.js" crossorigin="anonymous"></script>
  <style>
    .navbar-custom {
      background: linear-gradient(90deg, #0d6efd 0%, #0a58ca 100%);
    }

    .navbar-brand,
    .nav-link {
      color: #fff !important;
      transition: 0.3s;
    }

    .nav-link:hover,
    .navbar-brand:hover {
      color: #ffd700 !important;
    }

    .navbar-toggler {
      border-color: rgba(255, 255, 255, 0.6);
    }

    .navbar-toggler-icon {
      filter: invert(1);
    }

    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .content-wrapper {
      flex-grow: 1;
    }
  </style>
</head>

<body class="bg-light text-center">

  <nav class="navbar navbar-expand-lg navbar-custom shadow-sm mb-5 ">
    <div class="container">
      <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= $indexPath ?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-trophy-fill me-2" viewBox="0 0 16 16">
          <path d="M2.5.75a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 .75.75v.75H2.5V.75zM13.25.75a.75.75 0 0 1 .75.75v.75h-1.5V.75a.75.75 0 0 1 .75-.75h1.5zM15.5 16h-15V14.5a1.5 1.5 0 0 1 1.5-1.5h12a1.5 1.5 0 0 1 1.5 1.5V16zm-5-14.75V1.5H5.5V1.25a.25.25 0 0 0-.5 0V1.5h-1V.75a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 .75.75v.75h-1V1.5a.25.25 0 0 0-.5 0zM8 12.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
        </svg>
        LaLiga
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link fw-semibold" href="<?= $indexPath ?>">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fw-semibold" href="<?= $url_equipos ?>">Equipos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fw-semibold" href="<?= $partidosPath ?>">Partidos</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>