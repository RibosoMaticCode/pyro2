<script>
$(document).ready(function() {
  $( ".cols-html" ).sortable({
      placeholder: "placeholder",
      handle: ".col-head"
  });
});
</script>
<?php
if(!isset($_GET['temp_id'])) $temp_id = 1;
else $temp_id = $_GET['temp_id'];
?>
<li id="box<?= $temp_id ?>" class="box" data-id="box<?= $temp_id ?>" data-type="box" data-extclass="" data-extvalues="{}" data-inclass="" data-invalues="{}">
  <div class="box-header">
    <strong>Bloque</strong>
    <a href="#" class="showEditBox">
      <i class="fa fa-pencil" aria-hidden="true"></i> Personalizar
    </a>
    <a href="#" class="addNewCol">
      <i class="fa fa-columns fa-lg" aria-hidden="true"></i> Añadir columna
    </a>
    <a href="#" class="SaveBox">
      <i class="fa fa-save fa-lg" aria-hidden="true"></i> Guardar
    </a>
    <!--<a class="toggle" href="#">
      <span class="arrow-up">&#9650;</span>
      <span class="arrow-down">&#9660;</span>
    </a>-->
    <a class="boxdelete" href="#" title="Eliminar">
      <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
    </a>
  </div>
  <div class="box-body">
    <ul class="cols">
      <?php include_once 'page-col-new.php' ?>
    </ul>
  </div>
</li>
