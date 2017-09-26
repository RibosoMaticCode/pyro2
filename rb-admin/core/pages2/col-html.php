<?php
if(!isset($_GET['temp_id'])) $temp_id = 1;
else $temp_id = $_GET['temp_id'];
?>
<li class="col" data-id="<?= $temp_id ?>" data-type="html">
	<span class="col-head">
		<strong>HTML</strong><a class="close-column" href="#">X</a>
	</span>
	<div class="col-box-edit">
		<div class="box-edit">
			<label>
			  <div class="box-edit-html" id="box-edit<?= $temp_id ?>">Click here to edit the second section of content!</div>
			</label>
		</div>
		<a href="#" class="showEditHtml">Editar</a>
	</div>
</li>
