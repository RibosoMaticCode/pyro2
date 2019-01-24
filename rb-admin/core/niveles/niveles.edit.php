<?php
$mode;
if(isset($_GET["id"])){
	$id=$_GET["id"];
	$q = $objDataBase->Ejecutar("SELECT * FROM usuarios_niveles WHERE id=$id");
	$row= $q->fetch_assoc();
	$mode = "update";
}else{
	$mode = "new";
}
?>
<div class="inside_contenedor_frm">
<form class="form" id="nivel-form" method="post" action="../rb-admin/core/niveles/niveles.save.php">
	<div id="toolbar">
		<div class="inside_toolbar">
			<span class="post-submit">
				<input class="submit" name="guardar" type="submit" value="Guardar" />
				<a href="?pag=nivel"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>
			</span>
		</div>
	</div>
			<section class="seccion">
				<div class="seccion-body">
					<label>Nombre:
						<input name="nombre" type="text" value="<?php if(isset($row)) echo $row['nombre'] ?>" required />
					</label>
					<label>Nombre clave:
						<select name="nivel_enlace">
							<option <?php if(isset($row) && $row['nivel_enlace']=="admin") echo " selected " ?> value="admin">admin - acceso a todo el panel adminstrativo</option>
							<option <?php if(isset($row) && $row['nivel_enlace']=="user-panel") echo " selected " ?> value="user-panel">user-panel - acceso al panel administrativo, salvo que no puede configurar el sitio ni gestionar usuarios</option>
							<option <?php if(isset($row) && $row['nivel_enlace']=="user-front") echo " selected " ?> value="user-front">user-front - acceso solo al fron-end (plantilla)</option>
						</select>
					</label>
					<label>Sub clave:
						<span class="info">En caso de subniveles este nombre clave, puede ayudar.</span>
						<input name="subnivel_enlace" type="text" value="<?php if(isset($row)) echo $row['subnivel_enlace'] ?>" />
					</label>
					<label>Descripción:
						<textarea name="descripcion"><?php if(isset($row)) echo $row['descripcion'] ?></textarea>
					</label>
					<!--<label>Permisos:
						<textarea name="permisos"><?php if(isset($row)) echo $row['permisos'] ?></textarea>
					</label>-->
					<!-- niveles -->
					<?php if(isset($row)): ?>
					<div>
	          <h3 class="subtitle">Permisos para el menu</h3>
	          <div class="col-padding">
	            <script src="<?= G_SERVER ?>/rb-admin/resource/ui/jquery-ui.js"></script>
	            <script>
	              $( function() {
	                $( "#sortable" ).sortable({
	                  placeholder: "ui-state-highlight"
	                });
	                $( "#sortable" ).disableSelection();
	                //http://jsfiddle.net/beyondsanity/HgDZ9/

	                $(".btnSaveOrderMenu").click(function(event){
	                  var optionTexts = [];
	                  var i=1;
	                  $("#sortable li").each(function() {
	                    var key = $(this).attr("data-key");
	                    var show = 1;
	                    if ($('#chk_'+key).is(':checked')) {
	                      var show = 0;
	                    }
	                    //var pos = $(this).attr("data-pos");
	                    optionTexts.push({
	                      name : key,
	                      position : i,
	                      show: show
	                    });
	                    i++;
	                  });
	                  var myJsonString = JSON.stringify(optionTexts);
	                  console.log(myJsonString);

										var nivel_id = <?= $row['id'] ?>;

	                  $.ajax({
	                    method: "GET",
	                    url: "<?= G_SERVER ?>/rb-admin/core/niveles/save.order.panelmenu.php",
	                    dataType: "json",
	                    data: {mydata : myJsonString, nivel_id : nivel_id}
	                  }).done(function( data ) {
												if(data.resultado){
													$.fancybox.close();
								  				notify(data.contenido);
												}else{
													notify(data.contenido);
												}
	                  });
	                });
	              } );
	            </script>
							<div>
	              <ul id="sortable" class="menu-list-edit">
	                <?php
									// Obtener estrutura del menu del gestor
									// Verificamos si nivel de usuario tiene grabado una estructura del menu en sus permisos
									if(strlen($row['permisos'])>0){
										$menu_panel = json_decode( $row['permisos'], true);
									// Caso contrario, extraemos estructura del menu de la opciones del sistema
									}else{
										$menu_panel = json_decode(rb_get_values_options('menu_panel'), true);
									}

	                foreach ($menu_panel as $module => $value) {
	                  ?>
	                  <li data-key='<?= $value['key'] ?>' data-pos='<?= $value['pos'] ?>' class="ui-state-default">
	                    <img src="<?= G_SERVER ?>/rb-admin/img/drag-icon.png" alt="icon" />
	                    <span><?= $value['nombre'] ?></span>
	                    <label>
	                      <input type="checkbox" value="1" id="chk_<?= $value['key'] ?>" <?php if($value['show']==0) echo " checked "?> /> Ocultar
	                    </label>
	                  </li>
	                  <?php
	                }
	                ?>
	              </ul>
	              <button class="button btnSaveOrderMenu" type="button">Guardar orden</button>
							</div>
	          </div>
	        </div>
					<?php endif ?>
					<!-- niveles -->
				</div>
			</section>
		
	<input name="section" value="nivel" type="hidden" />
	<input name="mode" value="<?php echo $mode ?>" type="hidden" />
	<input name="id" value="<?php if(isset($row)) echo $row['id'] ?>" type="hidden" />
</form>
</div>
