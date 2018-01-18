<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

if(isset($_GET['custom_id'])){
	$id = $_GET['custom_id'];
}else{
	$id = $block_id;
}
$qb = $objDataBase->Ejecutar("SELECT * FROM bloques WHERE id=$id");
$row= $qb->fetch_assoc();
$col = json_decode($row['contenido'], true);
?>
<li id="<?= $col['col_id'] ?>" class="col saved" data-id="<?= $col['col_id'] ?>" data-type="<?= $col['col_type'] ?>" data-values='<?= json_encode ($col['col_values']) ?>' data-class="<?= $col['col_css'] ?>" data-saved-id="<?= $row['id'] ?>">
<?php
switch ($col['col_type']) {
  case 'html':
  ?>
  <span class="col-head">
    <strong>HTML - Editor: <span class="col-save-title"><?= $row['nombre'] ?></span></strong>
    <a class="close-column" href="#">
      <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
    </a>
  </span>
  <div class="col-box-edit">
    <div class="box-edit box-edit-html" id="box-edit<?= $col['col_id'] ?>"><?= html_entity_decode($col['col_content']) ?></div>
    <div class="box-edit-tool"><a href="#" class="showEditHtml">Editar</a></div>
  	<input type="hidden" class="css_class" id="class_<?= $col['col_id'] ?>" value="<?= $col['col_css'] ?>" />
  </div>
  <?php
    break;
  case 'htmlraw':
  ?>
  <span class="col-head">
    <strong>HTML - Código: <span class="col-save-title"><?= $row['nombre'] ?></span></strong>
    <a class="close-column" href="#">
      <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
    </a>
  </span>
  <div class="col-box-edit">
    <div class="box-edit box-edit-html" id="box-edit<?= $col['col_id'] ?>"><?= html_entity_decode($col['col_content']) ?></div>
    <div class="box-edit-tool"><a href="#" class="showEditHtmlRaw">Editar</a></div>
    <input type="hidden" class="css_class" id="class_<?= $col['col_id'] ?>" value="<?= $col['col_css'] ?>" />
  </div>
  <?php
    break;
  case 'slide':
  ?>
  <span class="col-head">
    <strong>Slide: <span class="col-save-title"><?= $row['nombre'] ?></span></strong>
    <a class="close-column" href="#" title="Eliminar">
      <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
    </a>
  </span>
  <div class="col-box-edit">
    <div class="box-edit">
      <div class="box-edit-html" id="box-edit<?= $col['col_id'] ?>">
        <p style="text-align:center;max-width:100%"><img src="core/pages2/img/slider.png" alt="post" /></p>
      </div>
      <div class="box-edit-tool"><a href="#" class="showEditSlide">Editar</a></div>
    </div>
  </div>
  <?php
    break;
  case 'post1':
  ?>
  <span class="col-head">
    <strong>Publicaciones: <span class="col-save-title"><?= $row['nombre'] ?></span></strong>
    <a class="close-column" href="#" title="Eliminar">
      <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
    </a>
  </span>
  <div class="col-box-edit">
    <div class="box-edit">
      <div class="box-edit-html" id="box-edit<?= $col['col_id'] ?>">
        <p style="text-align:center;max-width:100%"><img src="core/pages2/img/post1.png" alt="post" /></p>
      </div>
      <div class="box-edit-tool"><a href="#" class="showEditPost1">Editar</a></div>
    </div>
  </div>
  <?php
    break;
}
?>
