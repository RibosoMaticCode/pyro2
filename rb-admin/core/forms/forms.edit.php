<?php
$mode;
if(isset($_GET["id"])){
	$id=$_GET["id"];
	$q = $objDataBase->Ejecutar("SELECT * FROM forms WHERE id=$id");
	$row= $q->fetch_assoc();
	$mode = "update";
}else{
	$mode = "new";
}
?>
<script>
$(document).ready(function() {
	$("#frmForms").submit(function (event) {
		event.preventDefault();
		
		var festr = $('#form_estructure').html(); // estructura HTML
		var data = $("#frmForms").serializeArray();
		data.push({name: "estructure", value: festr});

		$.ajax({
			url: "core/forms/forms.save.php",
			method: 'post',
			data: $.param(data),
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
<div class="form">
	<form id="frmForms">
		<div id="toolbar">
			<div id="toolbar-buttons">
				<button class="submit" id="SaveForm" type="submit">Guardar</button>
				<a class="button" href="?pag=forms">Cancelar</a>
			</div>
		</div>
		<div class="content-edit">
			<section class="seccion">
				<div class="seccion-body">
					<label>Nombre:
						<input name="name" id="form_name" type="text" value="<?php if(isset($row)) echo $row['name'] ?>" required />
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
				</div>
			</section>
		</div>
		<input name="mode" id="form_mode" value="<?php echo $mode ?>" type="hidden" />
		<input name="id" id="form_id" value="<?php if(isset($row)) echo $row['id'] ?>" type="hidden" />
	</form>
</div>
<?php include_once 'form.editcode.php' ?>
