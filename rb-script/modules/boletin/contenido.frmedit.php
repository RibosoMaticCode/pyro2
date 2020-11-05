<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH."global.php";
require_once ABSPATH."rb-script/class/rb-database.class.php";
include_once("../rb-admin/tinymce/tinymce.config.php");
?>
<section class="seccion">
	<form id="frmEdit" class="form">
	  	<div class="seccion-header">
	    	<h2>Edicion de contenido</h2>
	    	<ul class="buttons">
		      <li><button type="submit" class="button btn-primary">Guardar</button></li>
		      <li><a class="button" href="<?= G_SERVER ?>rb-admin/module.php?pag=boletin_contenidos">Cancelar</a></li>
		    </ul>
	   	</div>
	   	<div class="seccion-body">
			<input type="hidden" name="id" value="<?= $id ?>" required />
			<div class="cols-container">
				<div class="cols-9-md col-padding">
					<label>
						Titulo:
					    <input type="text" name="titulo" required value="<?php if(isset($contenido)) echo $contenido['titulo']; ?>" />
					</label>
					<label>
						Contenido:
					   	<textarea class="mceEditor" name="contenido"><?php if(isset($contenido)) echo $contenido['contenido']; ?></textarea>
					</label>
					<label>
				    <script>
				          $(document).ready(function() {
				            $(".imagen").filexplorer({
				              inputHideValue : "<?= isset($contenido) ? $contenido['imagen_id'] : "0" ?>"
				            });
				          });
				        </script>
				    	Imagen destacada:
				    	<input type="text" name="imagen" class="imagen" readonly value="<?php $Photo = rb_get_photo_details_from_id( isset($contenido) ? $contenido['imagen_id'] : 0 ); print $Photo['file_name']; ?>" />
  					</label>
					<label>
						Categoria:
						<select name="categoria_id">
							<?php while ($categoria = $qc->fetch_assoc()): ?>
								<option value="<?= $categoria['id'] ?>" <?php if(isset($contenido) && $contenido['categoria_id']==$categoria['id']) echo "selected" ?>><?= $categoria['titulo'] ?></option>
							<?php endwhile; ?>
						</select>
					</label>
					<label>
						Archivos PDF
						<span class="info">Escriba el link de descarga por linea</span>
						<textarea name="pdfs" rows="5"><?php if(isset($contenido)) echo $contenido['pdfs']; ?></textarea>
					</label>
					<label>
						Videos
						<span class="info">Escriba el codigo del video Youtube por linea</span>
						<textarea name="videos" rows="5"><?php if(isset($contenido)) echo $contenido['videos']; ?></textarea>
					</label>
					<label>
						Link de video en vivo
						<span class="info">Escriba el codigo del video Youtube</span>
						<input type="text" name="video_live" value="<?php if(isset($contenido)) echo $contenido['video_live']; ?>"/>
					</label>
				</div>
				<div class="cols-3-md col-padding">
					<h3>Subir Imagenes</h3>
					<span class="info">Para usarlas en el contenido</span>
					<?php include_once ABSPATH.'rb-admin/plugin-form-uploader.php' ?>
					<!--
					<label>
						<input name="acceso_permitir" type="checkbox" <?php if( isset($contenido) && $contenido['acceso_permitir']==1) echo "checked" ?> /> Contenido privado
						<span class="info">
							Para ver el contenido tendra que iniciar sesion con un usuario y contraseña
						</span>
					</label>
					<label>
					Permitir solo a estos usuarios:
					<?php
					//$qu = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."users");
					?>
					<input id="search_box" type="text" placeholder="Filtrar por..." />
					<div class="list_items">			
						<ul class="list">
							<?php
							/*while( $user = $qu->fetch_assoc() ){
								$users_ids = [];
								if( isset($contenido) ){
									$users_ids = explode(",", $contenido['allow_users_ids']);
								}
								?>
								<li>
									<label class="user_name">
										<input type="checkbox" name="users_ids[]" value="<?= $user['id'] ?>" <?php if(in_array ($user['id'], $users_ids)) print "checked"  ?> /> <?= $user['nombres'] ?> <?= $user['apellidos'] ?>
									</label>
								</li>
								<?php
							}*/
							?>
						</ul>
					</div>
				</label>-->
				</div>
			</div>
		</div>
	</form>
</section>
<script src="<?= G_DIR_MODULES_URL ?>boletin/contenido.js"></script>
