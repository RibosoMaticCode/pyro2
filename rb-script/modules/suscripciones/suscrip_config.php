<section class="seccion">
  <div class="seccion-header">
    <h2>Instrucciones de uso</h2>
  </div>
  <div class="seccion-body">
    <p>Puedes invocar al formulario de suscripcion mediante este shortcode.</p>
    <pre>[suscripform]</pre>
    <br />
  </div>
</section>
<section class="seccion">
  <div class="seccion-header">
    <h2>Configuracion</h2>
  </div>
  <div class="seccion-body">
    <p>Puedes establecer que campos mostrar (en formato JSON). Por defecto son Nombres y Correo</p>
    <form class="form" id="suscriptores_config">
      <label>
        Configurar campos
        <?php
        global $objDataBase;
        $q = $objDataBase->Ejecutar("SELECT * FROM suscriptores_config WHERE opcion='campos'");
        echo $q->num_rows;
        if($q->num_rows > 0) :
          $row = $q->fetch_assoc();
          $campos = $row['valor'];
        else:
          $campos = '{"Nombres":"show", "Correo": "show", "Telefono": "hide"}'; // Por defecto
        endif;
        ?>
        <input type="text" name="campos" value='<?= $campos ?>' />
      </label>
      <button class="button btn-primary" type="submit">Guardar</button>
    </form>
  </div>
</section>
<?php
$urlreload=G_SERVER.'rb-admin/module.php?pag=rb_sus_susc_config';
?>
<script src="<?= G_DIR_MODULES_URL ?>suscripciones/funcs.js"></script>
