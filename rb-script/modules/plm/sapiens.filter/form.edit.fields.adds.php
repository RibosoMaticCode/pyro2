<?php
require_once 'fields.adds.options.php';

if(isset($row)){
  $qr = $objDataBase->Ejecutar("SELECT * FROM sapiens_fields_adds WHERE product_id=".$row['id']);
  if($qr->num_rows == 0){
    $sapiens['universidad'] = "";
    $sapiens['tipo_libro'] = "";
    $sapiens['area'] = "";
  }else{
    $sapiens = $qr->fetch_assoc();
  }
}
?>
<section class="seccion">
  <div class="seccion-header">
    <h3>Campos adicionales</h3>
  </div>
  <div class="seccion-body">
    <label>
      Universidad:
      <select name="sapiens_universidad">
        <?php foreach ($univer as $key) { ?>
          <option value="<?= $key ?>" <?php if(isset($row) && $sapiens['universidad']==$key) print "selected" ?>><?= $key ?></option>
        <?php } ?>
      </select>
    </label>
    <label>
      Tipo libro:
      <select name="sapiens_tipo_libro">
        <?php foreach ($tipo_lib as $key) { ?>
          <option value="<?= $key ?>" <?php if(isset($row) && $sapiens['tipo_libro']==$key) print "selected" ?>><?= $key ?></option>
        <?php } ?>
      </select>
    </label>
    <label>
      Area:
      <select name="sapiens_area">
        <?php foreach ($area as $key) { ?>
          <option value="<?= $key ?>" <?php if(isset($row) && $sapiens['area']==$key) print "selected" ?>><?= $key ?></option>
        <?php } ?>
      </select>
    </label>
  </div>
</section>