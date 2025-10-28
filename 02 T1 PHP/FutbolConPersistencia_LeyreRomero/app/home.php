<body>
  <header class="hero-section">
    <div class="container">
      <h1 class="display-3 fw-bold">Bienvenido al Gestor Deportivo</h1>

      <?php if ($pagina_principal === $url_partidos): ?>
        <p class="lead">Tu última actividad fue en **Partidos**. Haz clic a continuación para continuar o usa el menú.</p>
        <a class="btn btn-primary btn-lg mt-3" href="<?= $url_partidos; ?>" role="button">Ir a Partidos</a>
      <?php else: ?>
        <p class="lead">Tu página principal actual es **Equipos**. Usa el menú superior para navegar.</p>
        <a class="btn btn-primary btn-lg mt-3" href="<?= $url_equipos; ?>" role="button">Ir a Equipos</a>
      <?php endif; ?>

    </div>
  </header>

  <!-- Bootstrap core JavaScript
* TODO REVISE Este es el aspecto negativo de esta estructura ya que el código esta duplicado
================================================== -->
</body>
<footer class="footer">
  <div class="container">
    <span class="text-muted">Gestión Deportiva - 2º DAM.</span>
  </div>
</footer>
<script src=".\assets\js\bootstrap.js"></script>