<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH."global.php";
require_once ABSPATH."rb-script/class/rb-database.class.php";
$urlreload=G_SERVER.'rb-admin/module.php?pag=aula_contenidos';
$objDataBase = new DataBase;
$id = 0;
$mode = "Nuevo";
if(isset($_GET['id']) && $_GET['id'] > 0):
	$id = $_GET['id'];
	$r = $objDataBase->Ejecutar("SELECT * FROM aula_contenidos WHERE id=".$id);
	$row = $r->fetch_assoc();
	$mode = "Editando ";
endif;
include_once("../rb-admin/tinymce/tinymce.config.php");
switch ($_GET['tipo']) {
	case 1:
		$tipo = "Curso";
		break;
	case 2:
		$tipo = "Sesión";
		break;
	case 3:
		$tipo = "Categoría";
		break;
}
?>
<section class="seccion">
	<form id="frmEdit" class="form">
	  	<div class="seccion-header">
	    	<h2><?= $mode ?> <?= $tipo ?></h2>
	    	<ul class="buttons">
		      <li><button type="submit" class="button btn-primary">Guardar</button></li>
		      <li><a class="button" href="<?= G_SERVER ?>rb-admin/module.php?pag=aula_contenidos">Cancelar</a></li>
		    </ul>
	   	</div>
	   	<div class="seccion-body">
			<input type="hidden" name="id" value="<?= $id ?>" required />
			<input type="hidden" name="tipo" value="<?php if(isset($row)) echo $row['tipo']; else echo $_GET['tipo'] ?>" required />
			<input type="hidden" name="padre_id" value="<?php if(isset($row)) echo $row['padre_id']; else echo  $_GET['padre_id'] ?>" required />
			<div class="cols-container">
				<div class="cols-9-md col-padding">
					<label>
						Titulo:
					    <input type="text" name="titulo" required value="<?php if(isset($row)) echo $row['titulo']; ?>" />
					</label>
					<label>
						Contenido:
					   	<textarea class="mceEditor" name="contenido"><?php if(isset($row)) echo $row['contenido']; ?></textarea>
					</label>
					<label>
						<input name="acceso_permitir" type="checkbox" <?php if( isset($row) && $row['acceso_permitir']==1) echo "checked" ?> /> Contenido privado
						<span class="info">
							Para ver el contenido tendra que iniciar sesion con un usuario y contraseña
						</span>
					</label>
				</div>
				<div class="cols-3-md col-padding">
					<h3>Subir archivos</h3>
					<?php include_once ABSPATH.'rb-admin/plugin-form-uploader.php' ?>
				</div>
			</div>
		</div>
	</form>
</section>
<script>
	$(document).ready(function() {
    // Boton Cancelar
    $('.CancelFancyBox').on('click',function(event){
			$.fancybox.close();
		});

    // Boton Guardar
    $('#frmEdit').submit(function(event){
      	event.preventDefault();
  		tinyMCE.triggerSave(); //save first tinymce en textarea
  		$.ajax({
  			method: "post",
  			url: "<?= G_SERVER ?>rb-script/modules/aulavirtual/contenido.save.php",
  			data: $( this ).serialize()
  		})
  		.done(function( data ) {
  			if(data.result){
				notify(data.message);
				setTimeout(function(){
	          		window.location.href = '<?= G_SERVER ?>rb-admin/module.php?pag=aula_contenidos&id='+data.id+'&tipo='+data.tipo+'&padre_id='+data.padre_id;
		        }, 1000);
	  	  	}else{
	  			notify(data.message);
	  	  	}
  		});
    });
  });
</script>
