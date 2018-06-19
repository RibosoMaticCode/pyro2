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
<li id="<?= $widget_id ?>" class="widget <?= $class_save?>" data-id="<?= $widget_id ?>" data-type="htmlraw" data-class="<?php if(isset($widget)) echo $widget['widget_class'] ?>"
	data-values='<?php if(isset($widget))echo json_encode($widget['widget_values']); else echo "{}" ?>' data-saved-id="<?= $data_saved_id ?>">
	<div class="widget-header">
		<strong>HTML - Codigo</strong>
		<?= $option_saved ?>
		<a class="close-column" href="#" title="Eliminar">
			<i class="fa fa-trash fa-lg" aria-hidden="true"></i>
		</a>
	</div>
	<div class="widget-body">
		<div class="box-edit">
			<?php
			if(isset($widget)){
				$content = trim(html_entity_decode($widget['widget_content']));
			}else{
				$content = 'Clic aqui para editar el contenido!';
			}
			?>
			<div class="box-edit-html" id="box-edit<?= $widget_id ?>"><?= $content ?></div>
			<div class="box-edit-tool"><a href="#" class="showEditHtmlRaw">Editar</a></div>
			<input type="hidden" class="css_class" id="class_<?= $widget_id ?>" value="" />
		</div>
	</div>
</li>
