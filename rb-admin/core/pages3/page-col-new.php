<script>
// Arrastrar y soltar para columnas
$( ".cols" ).sortable({
    placeholder: "placeholder",
    handle: ".col-header",
    connectWith: ".cols"
});

// Arrastrar y soltar para widgets
$( ".widgets" ).sortable({
    placeholder: "placeholder",
    handle: ".widget-header",
    connectWith: ".widgets"
});
</script>
<?php
if(!isset($_GET['temp_id'])) $temp_id = 1;
else $temp_id = $_GET['temp_id'];
?>
<li id="col<?= $temp_id ?>" class="col" data-id="col<?= $temp_id ?>" data-type="col" data-class="" data-values="{}" data-save-id="">
  <div class="col-header">
    <strong>Columna</strong>
    <a href="#" class="showEditCol" title="Personalizar">
      <i class="fa fa-cog" aria-hidden="true"></i>
    </a>
    <a href="#" class="addNewWidget" title="Añadir componente">
      <i class="fa fa-cube fa-lg" aria-hidden="true"></i> Añadir componente
    </a>
    <!--<a class="toggle" href="#">
      <span class="arrow-up">&#9650;</span>
      <span class="arrow-down">&#9660;</span>
    </a>-->
    <a class="boxdelete" href="#" title="Eliminar">
      <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
    </a>
  </div>
  <div class="col-body">
    <ul class="widgets">
    </ul>
  </div>
</li>
