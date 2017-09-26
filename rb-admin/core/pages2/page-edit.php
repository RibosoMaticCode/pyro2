<?php
$mode;
if(isset($_GET["id"])){
	$id=$_GET["id"];
	$cons_art = $objDataBase->Ejecutar("SELECT * FROM paginas WHERE id=$id");
	$row=mysql_fetch_array($cons_art);
	$mode = "update";
}else{
	$mode = "new";
}
//include_once("tinymce.module.php");
?>
<script src="<?= G_SERVER ?>/rb-admin/resource/ui/jquery-ui.js"></script>
<script src="<?= G_SERVER ?>/rb-admin/core/pages2/func.js"></script>
<div id="toolbar">
	<div id="toolbar-buttons">
		<span class="post-submit">
			<input class="submit" name="guardar" type="submit" value="Guardar" id="btnGuardar" />
			<input class="submit" name="guardar_volver" type="submit" value="Guardar y volver" id="btnGuardarBack"/>
			<a href="../rb-admin/?pag=pages"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Volver" /></a>
		</span>
	</div>
</div>
<div class="container-page-edit">
	<section class="seccion">
		<div class="seccion-body">
			<div class="wrap-input">
				<input placeholder="Escribe el titulo de la página aquí" class="ancho" name="titulo" type="text" id="titulo" required value="<?php if(isset($row)) echo $row['titulo'] ?>" />
				<!--<input id="pagina_id" value="<?= $pagina_id ?>" type="hidden" />-->
			</div>
			<label>Estructura</label>
			<div class="estructure">
				<ul id="boxes">
					<?php include_once 'page-box-new.php' ?>
				</ul>
				<a id="boxNew" href="#">Añadir nuevo bloque</a>
			</div>
		</div>
	</section>
</div>

<div class="editor-html">
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.4.1/tinymce.min.js"></script>
	<div id="ta">
	  <p>Editor de html</p>
	</div>
	<button id="btn1">Get content with tinymce</button>
	<input type="hidden" id="control_id" value="" />
	<script>
	$(function() {
	    tinymce.init({
	        selector: "#ta",
	        contextmenu: false,
	        plugins: "textcolor link",
	        font_formats: "Sans Serif = arial, helvetica, sans-serif;Serif = times new roman, serif;Fixed Width = monospace;Wide = arial black, sans-serif;Narrow = arial narrow, sans-serif;Comic Sans MS = comic sans ms, sans-serif;Garamond = garamond, serif;Georgia = georgia, serif;Tahoma = tahoma, sans-serif;Trebuchet MS = trebuchet ms, sans-serif;Verdana = verdana, sans-serif",
	        toolbar: "fontselect | fontsizeselect | bold italic underline | forecolor | numlist bullist | alignleft aligncenter alignright alignjustify | outdent indent | link unlink | undo redo"
	    });

	    $('#btn1').click(function() {
	        console.log(tinymce.activeEditor.getContent());
					var control_id = $('#control_id').val();
					 $('#'+control_id).html(tinymce.activeEditor.getContent());
	    });
	});
	</script>
</div>
