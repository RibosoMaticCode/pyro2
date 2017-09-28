<?php
include 'islogged.php';
function msgOk_(){
?>
	<script>
		$(document).ready(function() {
			$("#message").append('<p>Cambios Guardados</p>');
			$("#message").fadeIn( "slow");
			$("#message").delay(2000).fadeOut( 'slow' );
		});
	</script>
<?php
}
switch($sec){
	/* ------------------------------------------------------------- */
	/* ---------------- FORMULARIO COMENTARIO  --------------------- */
	/* ------------------------------------------------------------- */
	case "com":

		$id=$_GET["id"];
		require_once(ABSPATH."rb-script/class/rb-comentarios.class.php");
		$consulta = $objComentario->Consultar("SELECT c.*, a.titulo FROM comentarios c, articulos a WHERE a.id = c.articulo_id AND c.id=$id");
		$row=mysql_fetch_array($consulta);
		$mode = "update";
		?>
		<form id="comment-form" name="comment-form" method="post" action="save.php">
        	<div id="toolbar">
            	<div id="toolbar-buttons">
                    <span class="post-submit">
					<input class="submit" name="guardar" type="submit" value="Guardar" />
					<a href="../rb-admin/?pag=com"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>
                    </span>
                </div>
            </div>
			<div class="content-edit">
				<section class="seccion">
	            	<div class="seccion-body">
						<label title="Contenido del comentario">Comentario:
							<textarea name="comentario" id="comentario" cols="75" rows="20" style="width:100%; height:200px;"><?php echo htmlspecialchars($row['contenido']); ?></textarea>
						</label>
						<label title="Art&iacute;culo en el cual comento" for="articulo">T&iacute;tulo:
							<input  name="articulo" type="hidden" value="<?php echo $row['articulo_id']; ?>" />
							<input  name="articulo_titulo" type="text" readonly="true" value="<?php echo $row['titulo']; ?>" />
						</label>
	                </div>
                </section>
			</div>
			<div id="sidebar">
				<section class="seccion">
					<div class="seccion-header">
						Datos del Autor
					</div>
					<div class="seccion-body">
						<label title="Autor, Propietario">Nombre autor:
						<input  name="autor" type="text" id="autor" value="<?php echo $row['nombre']; ?>"/>
						</label>

						<label title="Correo electronico del autor">E-mail:
						<input  name="mail" type="text" id="mail" value="<?php echo $row['mail']; ?>"/>
						</label>

						<label title="Website o blog del autor">Website o blog:
						<input  name="web" type="text" id="web" value="<?php echo $row['web']; ?>"/>
						</label>

						<label title="Fecha del publicacion">Fecha:
						<input readonly="true"  name="fecha" type="text" id="fecha" value="<?php echo $row['fecha']; ?>"/>
						</label>
	                </div>
	            </section>
			</div>
			<input name="section" value="com" type="hidden" />
            <input name="mode" value="<?php echo $mode ?>" type="hidden" />
			<input name="id" value="<?php echo $row['id']; ?>" type="hidden" />
		</form>
	<?php
	break;

	/* ------------------------------------------------------------- */
	/* ---------------- FORMULARIO CATEGORIA ----------------------- */
	/* ------------------------------------------------------------- */
	case "cat":
		require_once(ABSPATH."rb-script/class/rb-categorias.class.php");

		$mode;
		if(isset($_GET["id"])){
			// if define realice the query
			$id=$_GET["id"];
			$cons_art = $objCategoria->Consultar("SELECT * FROM categorias WHERE id=$id");
			$row=mysql_fetch_array($cons_art);
			$mode = "update";
			$cancel ="Cancelar";
			$new_button = '<a href="../rb-admin/?pag=cat&opc=nvo"><input title="Nuevo" class="button_new" name="nuevo" type="button" value="Nuevo" /></a>';
		}else{
			$mode = "new";
			$cancel ="Cancelar";
			$new_button = "";
		}
	?>
		<script>
			$(document).ready(function() {
				$(".explorer-file").filexplorer({
					inputHideValue : "<?= isset($row) ? $row['photo_id'] : "0" ?>"
				});
			});
		</script>
		<form id="categorie-form" name="categorie-form" method="post" action="save.php">
      <div id="toolbar">
        <div id="toolbar-buttons">
          <span class="post-submit">
            <input class="submit" name="guardar" type="submit" value="Guardar" />
            <a href="../rb-admin/?pag=cat"><input title="Volver al listado" class="button" name="cancelar" type="button" value="<?= $cancel ?>" /></a>
            <?= $new_button ?>
          </span>
        </div>
      </div>
			<div>
        <div class="content-edit">
          <section class="seccion">
						<div class="seccion-body">
							<?php
							$title_category = "Categoría";
							if($mode=="new"):
								if(isset($_GET['catid']) && isset($_GET['niv'])):?>
								<label>Ruta / Ubicacion:
										<input readonly type="text" value="<?= rb_path_categories($_GET['catid']) ?>" />
										<?php $title_category = "Subcategoria" ?>
								</label>
								<?php
								endif;
							elseif($mode=="update"):
								if($row['nivel'] > 0 && $row['categoria_id'] > 0): ?>
									<label>Ruta / Ubicacion:
											<input readonly type="text" value="<?= rb_path_categories($row['categoria_id']) ?>" />
											<?php $title_category = "Subcategoria" ?>
									</label>
								<?php
								endif;
							endif ?>
							<label>Nombre <?= $title_category ?> <span class="required">*</span>:
								<input required  name="nombre" type="text" value="<?php if(isset($row))echo $row['nombre'] ?>" />
							</label>
							<label title="Descripcion de la categoria">Descripcion: <span class="info">La descripción no es necesaria, salvo si su plantilla/diseño lo requiera.</span>
								<textarea name="descripcion" id="descripcion" rows="4" style="width:100%; height:150px;"><?php if(isset($row))echo $row['descripcion'] ?></textarea>
							</label>
							<label title="Tag url" for="nombre">Enlace por defecto:
								<input  name="nombre_enlace" type="text" value="<?php if(isset($row))echo $row['nombre_enlace'] ?>" />
							</label>
						</div>
					</section>
				</div>
				<div id="sidebar">
          <!-- SECCION ACCESO POR NIVELES -- POR DEFECTO VISIBLE -->
          <section class="seccion">
            <div class="seccion-header">
              <h3>Acceso al categoria</h3>
              <a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
            </div>
            <div class="seccion-body">
              <label>
                <input type="radio" name="acceso" value="public" <?php if(isset($row) && $row['acceso']=="public"){ echo " checked "; }else{ echo " checked "; } ?> /> Publico
                <span class="info2">
                	La categoría (y su contenido) puede ser vista por cualquier persona. No necesita registrarse.
                </span>
            	</label>
              <label>
                <input type="radio" name="acceso" value="privat" <?php if(isset($row) && $row['acceso']=="privat"){ echo " checked "; } ?> /> Privado por niveles
                <span class="info2">
                	La categoría (y su contenido) puede verla los usuarios registrados. También puede filtrar por niveles de usuarios que pueden ver.
                </span>
              </label>
              <div class="seccion-list-margin-left">
                <?php
								$q = $objUsuario->Consultar("SELECT * FROM usuarios_niveles WHERE id<>1");
								while($r = mysql_fetch_array($q)):
								?>
								<label>
									<?php if($mode=="new"): ?>
									<input checked type="checkbox" name="niveles[]" value="<?= $r['id'] ?>" /> <?= $r['nombre'] ?>
									<?php
									else:
										$array_niveles = explode(',',$row['niveles']);
									?>
									<input type="checkbox" name="niveles[]" value="<?= $r['id'] ?>" <?php if(in_array($r['id'], $array_niveles)) echo " checked " ?> /> <?= $r['nombre'] ?>
									<?php endif; ?>
								</label>
								<?php
								endwhile;
								?>
							</div>
            </div>
          </section>
          <section class="seccion">
						<div class="seccion-body">
							<label>Seleccionar imagen:
								<span class="info">De preferencia una imagen de las misma dimensión horizontal y vertical</span>
								<input readonly name="imagen-categoria" type="text" class="explorer-file" value="<?php if(isset($row)): $photos = rb_get_photo_from_id($row['photo_id']); echo $photos['src']; endif ?>" />
							</label>
						</div>
          </section>
        </div>
			</div>
      <input name="mode" value="<?php echo $mode; ?>" type="hidden" />
			<input name="section" value="cat" type="hidden" />
			<input name="id" value="<?php if(isset($row)) echo $row['id']; ?>" type="hidden" />
			<input name="nivel" value="<?php if(isset($row)) {echo $row['nivel'];}elseif(isset($_GET['niv'])){ echo $_GET['niv']; }else{ echo "0";} ?>" type="hidden" />
			<input name="catid" value="<?php if(isset($row)) {echo $row['categoria_id'];}elseif(isset($_GET['catid'])){ echo $_GET['catid']; }else{ echo "0";} ?>" type="hidden" />
		</form>
	<?php
	break;
    /* ------------------------------------------------------------- */
    /* ---------------- FORMULARIO GRUPO --------------------------- */
    /* ------------------------------------------------------------- */
    case "gru":
        require_once(ABSPATH."rb-script/class/rb-grupos.class.php");
        $mode;
        if(isset($_GET["id"])){
            // if define realice the query
            $id=$_GET["id"];
            $q = $objGrupo->Consultar("SELECT * FROM grupos WHERE id=$id");
            $row=mysql_fetch_array($q);
            $mode = "update";
        }else{
            $mode = "new";
        }
    ?>
        <form id="form" name="form" method="post" action="save.php">
            <div id="toolbar">
                <div id="toolbar-buttons">
                    <span class="post-submit">
                    <input class="submit" name="guardar" type="submit" value="Guardar" />
                    <a href="../rb-admin/?pag=gru"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>

                    </span>
                </div>
            </div>
            <div>
                <div class="content-edit">
                    <div class="wrap-input">
                    <label title="Nombre del Grupo" for="web_nombre">Nombre del Grupo:
                    <input  name="nombre" type="text" id="nombre" value="<?php if(isset($row)) echo $row['nombre'] ?>" />
                    </label>
                    </div>
                </div>
                <div id="sidebar">
                </div>
            </div>
            <input name="section" value="gru" type="hidden" />
            <input name="mode" value="<?php echo $mode ?>" type="hidden" />
            <input name="id" value="<?php if(isset($row)) echo $row['id'] ?>" type="hidden" />
        </form>
    <?php
    break;
	/* ------------------------------------------------------------- */
	/* ---------------- FORMULARIO ENLACE -------------------------- */
	/* ------------------------------------------------------------- */
	case "enl":
		require_once(ABSPATH."rb-script/class/rb-enlaces.class.php");
		$mode;
		if(isset($_GET["id"])){
			// if define realice the query
			$id=$_GET["id"];
			$cons_art = $objEnlace->Consultar("SELECT * FROM enlaces WHERE id=$id");
			$row=mysql_fetch_array($cons_art);
			$mode = "update";
		}else{
			$mode = "new";
		}
	?>
		<form id="link-form" name="link-form" method="post" action="save.php">
        	<div id="toolbar">
            	<div id="toolbar-buttons">
                    <span class="post-submit">
					<input class="submit" name="guardar" type="submit" value="Guardar" />
					<a href="../rb-admin/?pag=enl"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>

                    </span>
                </div>
            </div>
            <div>
                <div class="content-edit">
                	<div class="wrap-input">
                    <label title="Nombre web" for="web_nombre">Nombre del Sitio Web:
                    <input  name="web_nombre" type="text" id="web_nombre" value="<?php if(isset($row)) echo $row['web_nombre'] ?>" />
                    </label>
                    </div>
                    <div class="wrap-input">
                    <label title="Enlace web" for="link">Enlace del Sitio Web (<em>incluir http://</em>):
                    <input  name="link" type="text" id="link" value="<?php if(isset($row)) echo $row['link'] ?>"/>
                    </label>
                    </div>
                    <div class="wrap-input">
					<label title="Enlace de imagen" for="link_img">Enlace de Imagen de Logo (<em>16x16 o 32x32</em>):
                    <input  name="link_img" type="text" id="link_img" value="<?php if(isset($row)) echo $row['link_img'] ?>" />
                    </label>
                    </div>
                    <div class="wrap-input">
                    <label title="Descripcion" for="descripcion">Descripci&oacute;n:
                    <textarea  name="descripcion" id="descripcion"><?php if(isset($row)) echo $row['descripcion'] ?></textarea>
                    </label>
                    </div>
                </div>
                <div id="sidebar">
                	<div>
                    <label title="Webmaster" for="webmaster">Webmaster Nombres:
                    <input  name="webmaster" type="text" id="webmaster" value="<?php if(isset($row)) echo $row['webmaster'] ?>" />
                    </label>
                    </div>
                    <div>
                    <label title="Webmaster E-mail" for="webmaster_mail">Webmaster E-mail:
                    <input  name="webmaster_mail" type="text" id="webmaster_mail" value="<?php if(isset($row)) echo $row['webmaster_mail'] ?>" />
                    </label>
                    </div>
                    <div>
                    <label title="Activar enlace" for="activo">Activar para mostrar:
                    <select  name="activo" id="activo">
                        <option value="0" <?php if(isset($row) && $row['activo']==0) echo "selected=\"selected\"" ?>>Desactivado</option>
                        <option value="1" <?php if(isset($row) && $row['activo']==1) echo "selected=\"selected\"" ?>>Activado</option>
                    </select>
                    </label>
                    </div>
                </div>
            </div>
            <input name="section" value="enl" type="hidden" />
            <input name="mode" value="<?php echo $mode ?>" type="hidden" />
            <input name="id" value="<?php if(isset($row)) echo $row['id'] ?>" type="hidden" />
		</form>
	<?php
	break;
	/* ------------------------------------------------------------- */
	/* ---------------- FORMULARIO MENSAJES ------------------------ */
	/* ------------------------------------------------------------- */
	case "men":
		require_once(ABSPATH."rb-script/class/rb-mensajes.class.php");
		require_once(ABSPATH."rb-script/class/rb-usuarios.class.php");
		$mode;
		if(isset($_GET["id"])){
			if($_GET["id"]=="") die (" Ocurrio un problema ");

			// if define realice the query
			$id=$_GET["id"];

			// CALL TO MODULE FOR SHOW MESSAGE
			include(ABSPATH.'rb-script/modules/rb-message/mod.messages.show.php');
		}else{
			/*$mode = "new";
		}*/
		include_once("tinymce.module.small.php");
	?>
		<form id="edit-form" name="edit-form" method="post" action="save.php">
        	<div id="toolbar">
            	<div id="toolbar-buttons">
                    <span class="post-submit">
					<input class="submit" name="guardar" type="submit" value="Enviar" />
					<a href="../rb-admin/?pag=men"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>
                    </span>
                </div>
            </div>
            <div class="content-edit">
            	<section class="seccion">
            		<div class="seccion-body">
                	<div class="wrap-input">
                    	<label title="Asunto del mensaje" for="web_nombre">Asunto:
                    	<input  name="asunto" type="text" id="asunto" required />
                    	</label>
                    </div>
                    <div class="wrap-input">
                        <label title="Escribe tu mensaje" for="mensaje">Mensaje:
                        <textarea class=" mceEditor" name="contenido" id="contenido"></textarea>
                        </label>
                    </div>
                   </div>
				</section>
			</div>
			<div id="sidebar">
				<section class="seccion">
					<div class="seccion-body">
                	<div class="edit-list">
                    	<label title="Webmaster" for="webmaster">Destinatarios:</label>
                    	<div id="catlist">
                    		<!--<label>
                				<input type="text" placeholder="Buscar..." />
                			</label>-->
                        <?php
						$q_user = $objUsuario->Consultar("SELECT tipo, id, nickname, nombres, apellidos FROM usuarios WHERE id<>".G_USERID);
						while($r_user = mysql_fetch_array($q_user)){
                        ?>
                            <label class="label_checkbox">
							<input type="checkbox" value="<?php echo $r_user['id'] ?>" name="users[]" /> <?php echo $r_user['nombres']." ".$r_user['apellidos'] ?> [<?= rb_get_user_type($r_user['tipo']) ?>]
                            </label>
                        <?php
						}
						?>
                        </div>
                    </div>
                   	</div>
                </section>
            </div>
            <input name="section" value="men" type="hidden" />
            <input name="mode" value="new" type="hidden" />
            <!--<input name="id" value="<?php if(isset($row)) echo $row['id'] ?>" type="hidden" />-->
            <input name="remitente_id" value="<?php echo G_USERID ?>" type="hidden" />
		</form>
	<?php
		}
	break;
}
?>
