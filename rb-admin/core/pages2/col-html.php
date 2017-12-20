<?php
if(!isset($_GET['temp_id'])) $temp_id = 1;
else $temp_id = $_GET['temp_id'];
?>
<li class="col" data-id="<?= $temp_id ?>" data-type="html">
	<span class="col-head">
		<strong>HTML</strong>
		<a class="close-column" href="#" title="Eliminar">
			<i class="fa fa-trash fa-lg" aria-hidden="true"></i>
		</a>
	</span>
	<div class="col-box-edit">
		<div class="box-edit">
			<div class="box-edit-html" id="box-edit<?= $temp_id ?>">Click here to edit the second section of content!</div>
			<div class="box-edit-tool"><a href="#" class="showEditHtml">Editar</a></div>
			<input type="hidden" class="css_class" id="class_<?= $temp_id ?>" value="" />
		</div>
	</div>
</li>
