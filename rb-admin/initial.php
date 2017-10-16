<h2 class="title">Panel Administrativo</h2>
<?php if (!in_array("home", $array_help_close)): ?>
<div class="help" data-name="home">
  <h1>Bienvenido!</h1>
  <p>Esta es la página inicial del gestor de contenidos. Puedes agregar accesos directos a esta seccion.</p>
</div>
<?php endif ?>
<?= do_action('panel_home') ?>
