<?php
if(!isset($_GET['temp_id'])) $temp_id = 1;
else $temp_id = $_GET['temp_id'];
?>
<li id="<?= $temp_id ?>" class="col" data-id="<?= $temp_id ?>" data-type="post1" data-class="" data-values='{"cat":0,"count":3,"ord":"DESC", "tit":"","typ":0}'>
	<span class="col-head">
		<strong>Publicaciones</strong>
		<a class="close-column" href="#" title="Eliminar">
			<i class="fa fa-trash fa-lg" aria-hidden="true"></i>
		</a>
	</span>
	<div class="col-box-edit">
		<div class="box-edit">
			<div class="box-edit-html" id="box-edit<?= $temp_id ?>">
				<p style="text-align:center;max-width:100%"><img src="core/pages2/img/post1.png" alt="post" /></p>
			</div>
			<div class="box-edit-tool"><a href="#" class="showEditPost1">Editar</a></div>
		</div>
	</div>
</li>
