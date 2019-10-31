<?php
include_once("../rb-admin/tinymce/tinymce.config.php");
$mode;
if(isset($_GET["id"])){
	$id=$_GET["id"];
	$q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."forms WHERE id=$id");
	$row= $q->fetch_assoc();
	$mode = "update";
}else{
	$mode = "new";
}
?>
<script>
$(document).ready(function() {
	$("#SaveForm").click(function (event) {
		event.preventDefault();
		tinyMCE.triggerSave();

		var fname = $('#form_name').val();
		var festr = $('#form_estructure').html();
		var fvalid = $('#form_validations').val();
		var fmode = $('#form_mode').val();
		var fmails = $('#form_mails').val();
		var fid = $('#form_id').val();
		var fintro = $('#form_intro').val();
		var frspta = $('#form_respuesta').val();

		$.ajax({
			url: "core/forms/forms.save.php",
			method: 'post',
			//data: $.param(data),
			data: 'name='+fname+'&estructure='+festr+'&validations='+fvalid+'&mode='+fmode+'&id='+fid+'&mails='+fmails+'&intro='+fintro+'&rspta='+frspta,
			beforeSend: function(){
				$('#img_loading, .bg-opacity').show();
			}
		})
		.done(function( data ) {
			$('#img_loading, .bg-opacity').hide();
			notify(data.message);
			setTimeout(function(){
				window.location.href = data.url+'/rb-admin/module.php?pag=forms&opc=edt&id='+data.last_id;
			}, 1000);
		});
	});
});
</script>
<div class="inside_contenedor_frm">
	<form id="frmForms" class="form">
		<div id="toolbar">
			<div class="inside_toolbar">
	      <div class="navigation">
	        <a href="<?= G_SERVER ?>rb-admin/module.php?pag=forms">Formularios</a> <i class="fas fa-angle-right"></i>
	        <?php if(isset($row)): ?>
	          <span><?= $row['name'] ?></span>
	        <?php else: ?>
	          <span>Nuevo formulario</span>
	        <?php endif ?>
	      </div>
	      <input class="btn-primary" name="guardar"  id="SaveForm" type="submit" value="Guardar" />
	      <a class="button" href="<?= G_SERVER ?>rb-admin/module.php?pag=forms">Cancelar</a>
	    </div>
		</div>
			<section class="seccion">
				<div class="seccion-body">
					<label>Asunto:
						<input name="name" id="form_name" type="text" value="<?php if(isset($row)) echo $row['name'] ?>" required />
					</label>
					<label>
						Contenido previo al formulario (opcional)
						<span class="info">Puede incluir HTML</span>
						<textarea id="form_intro" name="form_intro" class=" mceEditor"><?php if(isset($row)) echo $row['intro'] ?></textarea>
					</label>
					<label>
						Estructura de formulario
					</label>
					<div class="estructure">
						<div class="shadow"></div>
						<div class="estructure_html" id="form_estructure" style="border:2px solid red">
							<?php if(isset($row)) echo html_entity_decode(trim($row['estructure'])) ?>
						</div>
						<a class="editCodeForm" href="#">Editar</a>
					</div>
					<label>Validaciones:
						<span class="info">Usar estructura JSON para los campos a validar. Ejemplo:</span>
						<span class="info">{"NombreCampo1": "req|min=3|max=50", "NombreCampo2": "req", "NombreCampo3", "max=50" }</span>
						<textarea name="validations" id="form_validations"><?php if(isset($row)) echo $row['validations'] ?></textarea>
					</label>
					<label>Correos destino:
						<span class="info">Si no se establece, se toma el mail por defecto de la configuracion general</span>
						<input name="mails" id="form_mails" type="text" value="<?php if(isset($row)) echo $row['mails'] ?>" />
					</label>
					<label>
						Mensaje de respuesta luego del envio (opcional)
						<span class="info">Puede incluir HTML</span>
						<textarea id="form_respuesta" name="form_respuesta" class=" mceEditor"><?php if(isset($row)) echo $row['respuesta'] ?></textarea>
					</label>
				</div>
			</section>
		<input name="mode" id="form_mode" value="<?php echo $mode ?>" type="hidden" />
		<input name="id" id="form_id" value="<?php if(isset($row)) echo $row['id'] ?>" type="hidden" />
	</form>
</div>
<?php include_once 'form.editcode.php' ?>
