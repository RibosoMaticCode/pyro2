<?php
include 'islogged.php';
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(__FILE__)) . '/');

require_once(ABSPATH."rb-script/class/rb-menus.class.php");
require_once(ABSPATH."rb-script/class/rb-paginas.class.php");
require_once(ABSPATH."rb-script/class/rb-categorias.class.php");
?>
<script>
$(document).ready(function() {
	$( ".column" ).sortable({
		connectWith: ".column",
		handle: ".item-header",
		placeholder: "placeholder"
	});

	$( "#item-menu-name-<?= $_GET['last'] ?>" ).keyup(function(){
		//console.log( $( "#item-menu-name-<?= $_GET['last'] ?>" ).val() );

		$( "#item-<?= $_GET['last'] ?> .item-title" ).html( $( "#item-menu-name-<?= $_GET['last'] ?>" ).val() );
	});

});
</script>
<li id="item-<?= $_GET['last'] ?>">
	<div class="item-header"><span class="item-title">Nuevo Item</span>
		<a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
	</div>
	<div class="item-body" style="display: none">
							<label title="Nombre de la categoria" for="nombre">Nombre del Item:
	                        <input id="item-menu-name-<?= $_GET['last'] ?>" required autocomplete="off"  name="nombre" type="text" value="<?php if(isset($row))echo $row['nombre'] ?>" />
	                        </label>

							<h3 class="subtitle">Enlazar con:</h3>
							<div class="subform">
							<label>
								<input <?php if(isset($row) && $row['tipo']=="art") echo " checked " ?> type="radio" name="tipo" value="art" /> <span>Publicación</span><br/>
								<select name="articulo" >
		                    	<?php
		                    	$q = $objPagina->Consultar("SELECT * FROM articulos");
								while($r = mysql_fetch_array($q)):
		                    	?>
		                    		<option <?php if(isset($row) && $row['tipo']=="art" && $row['url'] == $r['id']) echo " selected " ?> value="<?= $r['id'] ?>"><?= $r['titulo'] ?></option>
		                    	<?php
								endwhile;
		                    	?>
		                    	</select>
							</label>
							<label>
								<input <?php if(isset($row) && $row['tipo']=="pag") echo " checked " ?> type="radio" name="tipo" value="pag" /> <span>Página</span><br/>
								<select name="pagina" >
		                    	<?php
		                    	$q = $objPagina->Consultar("SELECT * FROM paginas");
								while($r = mysql_fetch_array($q)):
		                    	?>
		                    		<option <?php if(isset($row) && $row['tipo']=="pag" && $row['url'] == $r['id']) echo " selected " ?> value="<?= $r['id'] ?>"><?= $r['titulo'] ?></option>
		                    	<?php
								endwhile;
		                    	?>
		                    	</select>
							</label>
							<label>
								<input <?php if(isset($row) && $row['tipo']=="cat") echo " checked " ?> type="radio" name="tipo" value="cat" /> <span>Categoría</span><br />
								<select name="categoria" >
		                    	<?php
		                    	$q = $objPagina->Consultar("SELECT * FROM categorias");
								while($r = mysql_fetch_array($q)):
		                    	?>
		                    		<option <?php if(isset($row) && $row['tipo']=="cat" && $row['url'] == $r['id']) echo " selected " ?> value="<?= $r['id'] ?>"><?= $r['nombre'] ?></option>
		                    	<?php
								endwhile;
		                    	?>
		                    	</select>
							</label>
							<label>
								<input <?php if(isset($row) && $row['tipo']=="per") echo " checked " ?> type="radio" name="tipo" value="per" /> <span>Personalizado (incluir <strong>http://</strong> para que sea válido)</span><br />
								<input <?php if(isset($row) && $row['tipo']=="per") echo " value='".$row['url']."'" ?> placeholder="http://" autocomplete="off"  name="url" type="text" />
							</label>
							</div>

	                        <label>Estilos CSS (id):
	                        <input  name="estilo" type="text" value="<?php if(isset($row))echo $row['style'] ?>" />
	                        </label>
	</div>
	<ul class='column item'></ul>
</li>
