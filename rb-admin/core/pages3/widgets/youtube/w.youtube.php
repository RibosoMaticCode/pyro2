<?php
if(isset($widget)){
	$widget_id = $widget['widget_id'];
}else{
	if(!isset($_GET['temp_id'])) $widget_id = 1;
	else $widget_id = $_GET['temp_id'];
}
// Si es un widget personalizado
$class_save = "";
if(isset($data_saved_id)){
	$class_save = "saved";
	$option_saved ='<span class="col-save-title">'.$name_save.'</span>';
}else{
	$data_saved_id = 0;
	$name_save = "";
	$option_saved = '<a href="#" class="showEditBlock"><i class="fa fa-save fa-lg" aria-hidden="true"></i> Guardar</a>';
}
?>
<li id="<?= $widget_id ?>" class="widget <?= $class_save?>" data-id="<?= $widget_id ?>" data-type="youtube1" data-class="<?php if(isset($widget)) echo $widget['widget_class'] ?>"
	data-values='<?php if(isset($widget))echo json_encode($widget['widget_values']); else echo "{}" ?>' data-saved-id="<?= $data_saved_id ?>">
	<div class="widget-header">
		<strong>Youtube</strong>
		<?= $option_saved ?>
		<a class="close-column" href="#" title="Eliminar">
			<i class="fa fa-trash fa-lg" aria-hidden="true"></i>
		</a>
	</div>
	<div class="widget-body">
		<div class="box-edit">
			<div class="box-edit-html" id="box-edit<?= $widget_id ?>">
				<p style="text-align:center;max-width:100%"><img src="core/pages2/img/slider.png" alt="post" /></p>
			</div>
			<div class="box-edit-tool"><a href="#" class="showEditYoutube1">Configurar</a></div>
		</div>
	</div>
</li>
