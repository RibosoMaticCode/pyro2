<?php
$mode;
require_once '../global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
include_once ABSPATH.'rb-admin/tinymce.module.small.php';

if(isset($_GET["id"])){
	// if define realice the query
	$id=$_GET["id"];
	$cons_art = $objDataBase->Consultar("SELECT * FROM metro_puntos WHERE id=$id");
	$row=mysql_fetch_array($cons_art);
	$mode = "update";
}else{
	$mode = "new";
}
?>
<form id="link-form" name="link-form" method="post" action="<?= $rb_module_url ?>puntos.save.php">
        	<div id="toolbar">
            	<div id="toolbar-buttons">
                    <span class="post-submit">
					<input class="submit" name="guardar" type="submit" value="Guardar" />
                    <a href="<?= G_SERVER ?>/rb-admin/module.php?pag=predi_ptos" class="btn-primary">Cancelar</a>
                    </span>
                </div>
            </div>
			<div class="content-edit">
				<section class="seccion">
                	<div class="seccion-body">
                    <label title="Nombre de Punto de Predicacion" for="nom">Nombre del Punto:
                    <input class="ancho" name="nom" type="text" id="nom" value="<?php if(isset($row)) echo $row['nombre'] ?>" />
                    </label>

                    <label title="Descripcion" for="des">Descripcion:
                    <input class="ancho" name="des" type="text" id="des" value="<?php if(isset($row)) echo $row['descripcion'] ?>"/>
                    </label>

                    <label title="Descripcion de la ubicacion">Ubicacion:</label>
                    <textarea class="mceEditor" name="ubi" id="ubi" style="width:100%;"><?php if(isset($row)) echo stripslashes(htmlspecialchars($row['ubicacion'])); ?></textarea>

                    <!--<label title="Descripcion del almacen">Almacen:</label>
                    <textarea class="mceEditor" name="alm" id="alm" style="width:100%;"><?php //if(isset($row)) echo stripslashes(htmlspecialchars($row['almacen'])); ?></textarea>

                    <label title="Coordenadas" for="cor">Coordenadas:
                    <input class="ancho" name="cor" type="text" id="cor" value="<?php //if(isset($row)) echo $row['coordenadas'] ?>"/>
									</label>-->
                    </div>
               	</section>
			</div>
                <div id="sidebar">
                	<section class="seccion">
                	<div class="seccion-body">

                    <label title="URL imagen" for="src">Imagen Previa (Las imagenes esta ubicadas en la carpeta <code>/mp_img/puntos/</code>):

                    <label>
                    <script>
					$(document).ready(function() {
						$(".explorer-file").filexplorer({
							inputHideValue : "<?= isset($row) ? $row['src'] : "0" ?>"
						});
					});
					</script>
		            <input  name="src" type="text" class="explorer-file" readonly value="<?php if(isset($row)): $photos = rb_get_photo_from_id($row['src']); echo $photos['src']; endif ?>" />
		            </label>
                    </label>
                    	<label title="Selecciones Auxiliar responsable" for="auxiliar_id">Auxiliar:
						<select id="auxiliar_id" name="aux_id">
						<?php
						$select_option = "";
						$q = $objDataBase->Consultar("SELECT id, nombres, apellidos FROM usuarios WHERE tipo=4 ORDER BY nombres DESC");
						while ($r = mysql_fetch_array($q)):
							if(isset($row) && $row['auxiliar_id']==$r['id']) $select_option = "selected=\"selected\"";
							else $select_option = "";
							echo "<option ".$select_option." value=".$r['id'].">".$r['nombres']." ".$r['apellidos']."</option>";
						endwhile;
						?>
						</select>
						</label>

	                    <label title="Modalidad" for="modalidad">Modalidad:
	                    <input class="ancho" name="mod" type="text" id="modalidad" value="<?php if(isset($row)) echo $row['modalidad'] ?>" />
	                    </label>

	                    <!--<label title="Lugar de Almacen" for="almacen_nombre">Nombre del Almacen:
	                    <input class="ancho" name="almn" type="text" id="almacen_nombre" value="<?php if(isset($row)) echo $row['almacen_nombre'] ?>" />
										</label>-->

											<?php
											$r = $objDataBase->Consultar("SELECT * FROM metro_almacen ORDER BY nombre_almacen");
											?>
											<label>Almacen:
												<select name="alm">
													<?php while($almacen = mysql_fetch_array($r)): ?>
														<option value="<?= $almacen['id'] ?>"><?= $almacen['nombre_almacen'] ?></option>
													<?php endwhile ?>
												</select>
											</label>
					</div>
					</section>
                </div>

            <input name="section" value="puntos" type="hidden" />
            <input name="mode" value="<?php echo $mode ?>" type="hidden" />
            <input name="id" value="<?php if(isset($row)) echo $row['id'] ?>" type="hidden" />
		</form>
