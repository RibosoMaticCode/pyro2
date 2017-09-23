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
	/* ---------------- FORMULARIO GALERIA ------------------------- */
	/* ------------------------------------------------------------- */
	case "gal":
		require_once(ABSPATH."rb-script/class/rb-galerias.class.php");
		if(isset($_GET['m']) && $_GET['m']=="ok") msgOk("Cambios guardados");

		$mode;
		if(isset($_GET["id"])){
			// if define realice the query
			$id=$_GET["id"];
			$cons_art = $objGaleria->Consultar("SELECT * FROM albums WHERE id=$id");
			$row=mysql_fetch_array($cons_art);
			$mode = "update";
		}else{
			$mode = "new";
		}
	?>
		<form id="galery-form" name="galery-form" method="post" action="save.php">
			<input type="hidden" name="user_id" value="<?= G_USERID ?>" />
        	<div id="toolbar">
            	<div id="toolbar-buttons">
                    <span class="post-submit">
					<input class="submit" name="guardar" type="submit" value="Guardar" />
					<a href="../rb-admin/?pag=gal"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>

                    </span>
                </div>
            </div>
            <div>
                <div class="content-edit">
                	<section class="seccion">
                		<div class="seccion-body">
	                      <label title="Especifica un nombre a tu galeria de fotos" for="nombre">Nombre de la Galeria:
	                        <input  name="nombre" type="text" value="<?php if(isset($row))echo $row['nombre'] ?>" required />
	                      </label>

	                      <label title="Describe brevemente acerca de esta galeria">Descripcion:
	                      	<span class="info">La descripción no es necesaria, salvo si su plantilla/diseño lo requiera.</span>
	                        <textarea name="descripcion" id="descripcion" cols="75" rows="15" style="width:100%; height:150px;"><?php if(isset($row))echo $row['descripcion'] ?></textarea>
	                      </label>

		                    <label title="Edita enlace amigable" for="titulo-enlace">Enlace por defecto:
		                        <input maxlength="200"  name="titulo_enlace" type="text" id="titulo-enlace" value="<?php if(isset($row)) echo $row['nombre_enlace'] ?>" />
		                    </label>

												<label>Grupo:
													<span class="info">Si deseas agrupar galerias, establece un texto identificador</span>
		                      <input maxlength="200"  name="grupo" type="text" value="<?php if(isset($row)) echo $row['galeria_grupo'] ?>" />
		                    </label>

												<label>Imagen de fondo:
													<script>
													$(document).ready(function() {
														$(".explorer-file").filexplorer({
															inputHideValue : "<?= isset($row) ? $row['photo_id'] : "0" ?>"
														});
													});
													</script>
<!--													<input readonly name="imagen-categoria" type="text" class="explorer-file" value="<?php if(isset($row)): $photos = rb_get_photo_from_id($row['photo_id']); echo $photos['src']; endif ?>" />-->
							          	<input name="imgfondo" type="text" class="explorer-file" readonly value="<?php if(isset($row)): $photos = rb_get_photo_from_id($row['photo_id']); echo $photos['src']; endif ?>" />
							          </label>
	                    </div>
                    </section>
                </div>
                <div id="sidebar">
                	<?php if(isset($row)): ?>
                		<section class="seccion">
                			<div class="seccion-body">
                				<a class="btn-primary" href="index.php?pag=imgnew&opc=nvo&album_id=<?php echo $row['id'] ?>">Subir imágenes</a>
                			</div>
                		</section>
                	<?php endif ?>
                </div>
			</div>
            <input name="mode" value="<?php echo $mode ?>" type="hidden" />
			<input name="id" value="<?php if(isset($row))echo $row['id'] ?>" type="hidden" />
			<input name="section" value="gal" type="hidden" />
		</form>
	<?php
	break;
	/* ------------------------------------------------------------- */
	/* ---------------- FORMULARIO IMAGEN -------------------------- */
	/* ------------------------------------------------------------- */
	case "imgnew":
		require_once(ABSPATH."rb-script/class/rb-galerias.class.php");

		$album_id=$_GET["album_id"];
		$qg = $objGaleria->Consultar("SELECT nombre FROM albums WHERE id=$album_id");
		$rg=mysql_fetch_array($qg);

		?>
		<div id="sidebar-left">
			<div class="help">
            	<h4>Información</h4>
            	<p>Puedes agregar nuevos elementos a tu Galería:</p>
            	<ul>
            		<li>Subir directamente tu imagen</li>
            		<li>Seleccionar imágenes desde las que ya tienes subidas</li>
            		<!--<li>O también agregar un video, presentación, etc. Solo tendrás que copiar el código que te proporciona tu servicio de medios favorito.</li>-->
            	</ul>
            </div>
		</div>
		<div class="content">
			<h2 class="title"><?= $rg['nombre'] ?></h2>
			<div class="page-bar">Inicio &gt; Medios &gt; Galería</div>
			<!--<div class="wrap-home">-->
				<ul class="buttons-edition">
					<li><a class="btn-primary" href="<?= G_SERVER ?>/rb-admin/index.php?pag=img&album_id=<?= $album_id ?>">Volver</a></li>
				</ul>
				<section class="seccion">
					<div class="seccion-header">
						<h3>Subir archivos al albúm</h3>
					</div>
					<div class="seccion-body">
					<div id="mulitplefileuploader"></div>
					<div id="status"></div>
					<!-- Load multiples imagenes -->
					<link href="<?= G_SERVER ?>/rb-admin/resource/jquery.file.upload/uploadfile.css" rel="stylesheet">
					<script src="<?= G_SERVER ?>/rb-admin/resource/jquery.file.upload/jquery.uploadfile.js"></script>

					<script type="text/javascript">
					$(document).ready(function(){
						var settings = {
						    url: "upload.php",
						    dragDrop:true,
						    fileName: "myfile",
						    formData: {"albumid":"<?= $album_id ?>" , "user_id" : "<?= G_USERID ?>"},
						    urlimgedit: '<?= G_SERVER."/rb-admin/index.php?pag=img&opc=edt&album_id=".$album_id."&id=" ?>',
						    allowedTypes:"jpg,png,gif,doc,pdf,zip",
						    returnType:"html", //json
							onSuccess:function(files,data,xhr)
						    {
						       //$("#status").append("Subido con exito");
						    },
						    //showDelete:true,
						    deleteCallback: function(data,pd)
							{
						    for(var i=0;i<data.length;i++)
						    {
						        $.post("delete.php",{op:"delete",name:data[i]},
						        function(resp, textStatus, jqXHR)
						        {
						            $("#status").append("<div>Archivo borrado</div>");
						        });
						     }
						    pd.statusbar.hide(); //You choice to hide/not.

							}
						}

						var uploadObj = $("#mulitplefileuploader").uploadFile(settings);
					});
					</script>
					</div>
				</section>

				<?php
				if($userType == "user-panel"):
					$q = $objGaleria->Consultar("SELECT * FROM photo WHERE album_id=0 AND type IN ('image/gif','image/png','image/jpeg') AND usuario_id = ".G_USERID);
				else:
					$q = $objGaleria->Consultar("SELECT * FROM photo WHERE album_id=0 AND type IN ('image/gif','image/png','image/jpeg')");
				endif;
				if(mysql_num_rows($q)):
				?>
				<section class="seccion">
					<div class="seccion-header">
						<h3>Seleccionar imagenes de Biblioteca de medios</h3>
					</div>
					<div class="seccion-body">
						<div class="flibrary">
							<form action="save.php" method="POST" name="library">
								<input type="hidden" name="album_id" value="<?= $album_id ?>" />
								<input type="hidden" name="section" value="imgnew" />
								<ul class="wrap-grid">
								<?php

								while($r=mysql_fetch_array($q)):
								?>
								<li class="grid-1">
								<label>
									<div class="cover-img">
									<input class="checkbox" type="checkbox" name="items[]" value="<?= $r['id']?>" /> <br />
									<img class="thumb" src="<?= G_SERVER ?>/rb-media/gallery/tn/<?= $r['src'] ?>" /><br />
									</div>
								</label>
								</li>
								<?php
								endwhile;
								?>
								</ul>

								<p style="text-align: center;"><input type="submit" value="Guardar seleccion" /></p>
							</form>
						</div>
					</div>
				</section>
				<?php
				endif;
				?>
		</div>
		<?php
	break;
	/* ------------------------------------------------------------- */
	/* ---------------- FORMULARIO FILES  -------------------------- */
	/* ------------------------------------------------------------- */
	case "files":
		?>
		<div class="wrap-home">
			<section class="seccion">
				<div class="seccion-header">
					<h3>Subir archivos</h3>
				</div>
				<div class="seccion-body">
				<!--<h2>Subir archivos <sup class="required">*</sup> a la Biblioteca de Medios: [<a href="<?= G_SERVER ?>/rb-admin/index.php?pag=files">Volver</a>]</h2>-->
				<ul class="buttons-edition">
					<li><a href="<?= G_SERVER ?>/rb-admin/index.php?pag=files" class="btn-primary">Volver</a></li>
				</ul>

				<div id="mulitplefileuploader"></div>
				<span class="info">Archivos permitidos: jpg, png, gif, doc, docx, xls, xlsx, pdf. Tamaño máximo: 8 MB</span>
				<div id="status"></div>
				<!-- Load multiples imagenes -->
				<link href="<?= G_SERVER ?>/rb-admin/resource/jquery.file.upload/uploadfile.css" rel="stylesheet">
				<script src="<?= G_SERVER ?>/rb-admin/resource/jquery.file.upload/jquery.uploadfile.js"></script>

				<script type="text/javascript">
				$(document).ready(function(){
					var settings = {
					    url: "upload.php",
					    dragDrop:true,
					    fileName: "myfile",
					    formData: {"albumid":"0", "user_id" : "<?= G_USERID ?>"},
					    urlimgedit: '<?= G_SERVER."/rb-admin/index.php?pag=file_edit&opc=edt&id=" ?>',
					    allowedTypes:"jpg,png,gif,doc,docx,xls,xlsx,pdf",
					    returnType:"html", //json
						onSuccess:function(files,data,xhr)
					    {
					       //$("#status").append("Subido con exito");
					    },
					    //showDelete:true,
					    deleteCallback: function(data,pd)
						{
					    for(var i=0;i<data.length;i++)
					    {
					        $.post("delete.php",{op:"delete",name:data[i]},
					        function(resp, textStatus, jqXHR)
					        {
					            $("#status").append("<div>Archivo borrado</div>");
					        });
					     }
					    pd.statusbar.hide(); //You choice to hide/not.

						}
					}

					var uploadObj = $("#mulitplefileuploader").uploadFile(settings);
				});
				</script>
				</div>
			</section>
		</div>
		<?php
	break;
	/* ------------------------------------------------------------- */
	/* ---------------- FORMULARIO IMAGEN -------------------------- */
	/* ------------------------------------------------------------- */
	case "file_edit":
		require_once(ABSPATH."rb-script/class/rb-fotos.class.php");
		$objFoto = new Fotos;
		if(isset($_GET['m']) && $_GET['m']=="ok") msgOk("Cambios guardados");

		$mode;

		if(isset($_GET["id"])){
			$mode = "update";
			$id=$_GET["id"];
			$q = $objFoto->Consultar("SELECT * FROM photo WHERE id=$id");
			$row=mysql_fetch_array($q);
		}else{
			die("Usar otro metodo");
		}
	?>
		<form enctype="multipart/form-data" id="galery-form" name="galery-form" method="post" action="save.php">
        	<div id="toolbar">
            	<div id="toolbar-buttons">
                    <span class="post-submit">
					<input class="submit" name="guardar" type="submit" value="Guardar" />
					<a href="../rb-admin/?pag=files"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>
                    </span>
                </div>
            </div>
			<div class="content-edit">
				<section class="seccion">
					<div class="seccion-body">
						<div class="files-container">
	                    	<picture>
	                    		<img src="<?= G_SERVER ?>/rb-media/gallery/<?= $row['src'] ?>" alt="previo" />
	                    	</picture>
	                    	<h3 class="subtitle">Nombre del archivo: <?php if(isset($row))echo $row['src'] ?></h3>

	                    	<div>
		                        <label style="display: none" title="Selecciona la imagen" for="nombre">Selecciona tu archivo:
		                	        <input  name="fupload" type="file" />
		                        </label>

		                        <label title="Titulo de la foto">Titulo:
		                    	    <textarea name="title" id="title" style="width:100%;"><?php if(isset($row))echo $row['title'] ?></textarea>
		                        </label>
	                        </div>
	                    </div>
	               	</div>
				</section>
			</div>
            <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
            <input name="album_id" value="0" type="hidden" />
            <input name="mode" value="<?php echo $mode ?>" type="hidden" />
			<input name="id" value="<?php if(isset($row))echo $row['id'] ?>" type="hidden" />
			<input name="section" value="files" type="hidden" />
		</form>
	<?php
	break;
	/* ------------------------------------------------------------- */
	/* ---------------- FORMULARIO IMAGEN -------------------------- */
	/* ------------------------------------------------------------- */
	case "img":
		include_once("tinymce.module.small.php");
		require_once(ABSPATH."rb-script/class/rb-fotos.class.php");
		require_once(ABSPATH."rb-script/class/rb-paginas.class.php");
		require_once(ABSPATH."rb-script/class/rb-categorias.class.php");
		require_once(ABSPATH."rb-script/class/rb-articulos.class.php");
		if(isset($_GET['m']) && $_GET['m']=="ok") msgOk("Cambios guardados");

		$mode;
        $album_id=$_GET["album_id"];
		if(isset($_GET["id"])){
			// if define realice the query
			$id=$_GET["id"];
            $objFoto = new Fotos;
			$q = $objFoto->Consultar("SELECT * FROM photo WHERE id=$id");
			$row=mysql_fetch_array($q);
			$mode = "update";
		}else{
			$mode = "new";
		}
	?>
		<form enctype="multipart/form-data" id="galery-form" name="galery-form" method="post" action="save.php">
        	<div id="toolbar">
            	<div id="toolbar-buttons">
                    <span class="post-submit">
					<input class="submit" name="guardar" type="submit" value="Guardar" />
					<input class="submit" name="guardar_volver" type="submit" value="Guardar y Volver" />
					<a href="../rb-admin/?pag=img&album_id=<?php echo $album_id ?>"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>
                    </span>
                </div>
            </div>
            <div>
                <div class="content-edit">
                	<section class="seccion">
                		<div class="seccion-body">
                    	<div class="wrap-input">
                    		<picture>
                    			<img src="<?= G_SERVER ?>/rb-media/gallery/<?= $row['src'] ?>" alt="previo" />
                    		</picture>
                    		<h3 class="subtitle">Nombre del archivo: <?php if(isset($row))echo $row['src'] ?></h3>
                    		<div>
		                        <label style="display: none" title="Selecciona la imagen" for="nombre">Selecciona tu archivo:
		                        <input  name="fupload" type="file" />
		                        </label>
		                        <label title="Titulo de la foto">Titulo:
															<!-- class="mceEditor" -->
		                        <textarea name="title" id="title" style="width:100%;"><?php if(isset($row))echo $row['title'] ?></textarea>
		                        </label>
		                        <!--<label title="URL">URL:
		                        	<input type="text" name="url" id="url" value="<?php if(isset($row))echo $row['url'] ?>" />
		                        </label>-->
	                        </div>
                    	</div>
                    	<div class="wrap-input">
							<h3 class="subtitle">Enlazar imagen con:</h3>
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
							<label>
								<input <?php if(isset($row) && $row['tipo']=="obj") echo " checked " ?> type="radio" name="tipo" value="obj" />
								<span>Objetos externos como videos (Youtube, Vimeo), presentaciones (Slidesahre), etc </span>
								<span class="info">Si seleccionas está opción pega el código proporcionado por estos servicios en este recuadro</span>
								<textarea name="descripcion" id="descripcion" style="width:100%;"><?php if(isset($row))echo $row['description'] ?></textarea>
							</label>
							</div>
						</div>
						</div>
                    </section>
                <div id="sidebar">

                </div>
			</div>
            <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
            <input name="album_id" value="<?php echo $album_id ?>" type="hidden" />
            <input name="mode" value="<?php echo $mode ?>" type="hidden" />
			<input name="id" value="<?php if(isset($row))echo $row['id'] ?>" type="hidden" />
			<input name="section" value="img" type="hidden" />
		</form>
	<?php
	break;
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
