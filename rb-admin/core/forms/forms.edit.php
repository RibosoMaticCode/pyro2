<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';

if(G_ACCESOUSUARIO==0) die("No tiene permisos");

include_once ABSPATH.'rb-admin/tinymce/tinymce.config.php';
$mode;
if(isset($item)){
	$id= $item;
	$q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."forms WHERE id=$id");
	$row= $q->fetch_assoc();
	$mode = "update";
}else{
	$mode = "new";
}
?>
<script  src="<?= G_URLPANEL ?>core/forms/forms.js"></script>
<div class="inside_contenedor_frm">
	<form id="frmForms" class="form">
		<div id="toolbar">
			<div class="inside_toolbar">
	      <div class="navigation">
	        <a href="<?= G_SERVER ?>rb-admin/forms">Formularios</a> <i class="fas fa-angle-right"></i>
	        <?php if(isset($row)): ?>
	          <span><?= $row['name'] ?></span>
	        <?php else: ?>
	          <span>Nuevo formulario</span>
	        <?php endif ?>
	      </div>
	      <input class="btn-primary" name="guardar"  id="SaveForm" type="submit" value="Guardar" />
	      <a class="button" href="<?= G_SERVER ?>rb-admin/forms">Cancelar</a>
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
