<?php
if(!isset($_GET['temp_id'])) $temp_id = 1;
else $temp_id = $_GET['temp_id'];
?>
<li id="col<?= $temp_id ?>" class="col" data-id="col<?= $temp_id ?>" data-type="col" data-class="" data-values="{}">
  <div class="col-header">
    <strong>Columna</strong>
    <a href="#" class="showEditCol">
      <i class="fa fa-pencil" aria-hidden="true"></i> Personalizar
    </a>
    <a href="#" class="addNewWidget">
      <i class="fa fa-cube fa-lg" aria-hidden="true"></i> Añadir widget
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
