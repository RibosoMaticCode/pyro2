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
	/* ---------------- FORMULARIO ARTICULO ------------------------ */
	/* ------------------------------------------------------------- */
	case "art":
		require_once(ABSPATH."rb-script/class/rb-articulos.class.php");
		require_once(ABSPATH."rb-script/class/rb-categorias.class.php");
		require_once(ABSPATH."rb-script/class/rb-galerias.class.php");

		$json_post_options = $objOpcion->obtener_valor(1,'post_options');
		$array_post_options = json_decode($json_post_options, true);

		if(isset($_GET['m']) && $_GET['m']=="ok") msgOk("Cambios guardados");
		$mode;
		if(isset($_GET["id"])){
			$id=$_GET["id"];
			$cons_art = $objArticulo->Consultar("SELECT *, DATE_FORMAT(fecha_creacion, '%Y-%m-%d') as fechamod, DATE_FORMAT(fecha_creacion, '%d-%m-%Y') as fechadmY FROM articulos WHERE id=$id");
			$row=mysql_fetch_array($cons_art);
			$mode = "update";
			$new_button = '<a href="../rb-admin/?pag=art&opc=nvo"><input title="Nuevo" class="button_new" name="nuevo" type="button" value="Nuevo" /></a>';
		}else{
			$mode = "new";
			$new_button = '';
		}
		include_once("tinymce.module.small.php");
	?>

		<script src="<?= G_SERVER ?>/rb-admin/resource/ui/jquery-ui.js"></script>
		<script>
			$.datepicker.regional['es'] = {
				 closeText: 'Cerrar',
				 prevText: '<Ant',
				 nextText: 'Sig>',
				 currentText: 'Hoy',
				 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
				 weekHeader: 'Sm',
				 dateFormat: 'dd/mm/yy',
				 firstDay: 1,
				 isRTL: false,
				 showMonthAfterYear: false,
				 yearSuffix: ''
			 };
			$.datepicker.setDefaults($.datepicker.regional['es']);

			$(document).ready(function() {
				$( '#edit-config' ).click(function( event ) {
					$.post( "post.options.php?s=posts" , function( data ) {
					 	$('.explorer').html(data);
					 	$(".bg-opacity").show();
				   		$(".explorer").fadeIn(500);
					});
				});
			});
		</script>

		<form name="formcat" action="category.minisave.php" method="post" id="formcat"></form>
		<form name="formgaleria" action="album.minisave.php" method="post" id="formgaleria"></form>

		<form enctype="multipart/form-data" id="article-form" name="article-form" method="post" action="save.php">
        	<div id="toolbar">
            	<div id="toolbar-buttons">
					<input class="submit" name="guardar" type="submit" value="Guardar" />
					<input class="submit" name="guardar_volver" type="submit" value="Guardar y Volver" />
                    <a href="../rb-admin/?pag=art"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>
                    <?= $new_button ?>
                    <a id="edit-config" class="edit-config" href="#">Configurar editor</a>
                </div>
            </div>
            <div>
                <div class="content-edit">
                	<!-- SECCION EDITOR -- POR DEFECTO VISIBLE -->
                	<section class="seccion">
                    <div class="seccion-body">
                        <input autocomplete="off" placeholder="Escribe el titulo aqui" class="titulo" name="titulo" type="text" id="titulo" value="<?php if(isset($row)) echo $row['titulo'] ?>" required />
                        <textarea class=" mceEditor" name="contenido" id="contenido" style="width:100%;"><?php if(isset($row)) echo stripslashes(htmlspecialchars($row['contenido'])); ?></textarea>
                        <?php //if($mode == "update"):?>
                        <script>
                        	$(document).ready(function() {
	                        	$('#btnshowDateTimeCover').click( function (event){
	                        		event.preventDefault();
	                        		$('#coverFechaPublicacion').slideDown();
	                        	});
	                        	$('#btnhideDateTimeCover').click( function (event){
	                        		event.preventDefault();
	                        		$('#coverFechaPublicacion').slideUp();
	                        	});
	                        });
                        </script>
                        	<a href="#" id="btnshowDateTimeCover">Establecer fecha de publicación</a>
                        	<div id="coverFechaPublicacion">
		                    <label title="Editar fecha publicacion">Fecha de Publicacion:
		                    	<span class="info">El gestor establece la fecha y hora de publicación en el momento que se guardan los datos, si desea establecerlos manualmente, siga este formato: YYYY-MM-DD HH:MM:SS Ejemplo: <?= date("Y-m-d H:i:s") ?></span>
		                    	<input maxlength="200"  name="fechamod" type="text" id="fechamod" value="<?php if(isset($row)) echo $row['fecha_creacion'] ?>" />
		                    </label>
		                    <a href="#" id="btnhideDateTimeCover">Cancelar</a>
		                    </div>
		                <?php //endif; ?>
                    </div>
                    </section>

                    <!-- SECCION ENLAZAR -->
					<?php if($array_post_options['enl']==1): ?>
					<section class="seccion">
						<div class="seccion-header">
                    	<h3>Enlazar con otras Publicaciones</h3>
                    	<a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
                    	</div>

                    	<div class="seccion-body">
                    	<?php if(isset($row)):?>
                    	<table class="tsmall" id="t_atributo" width="100%">
                    		<tr>
                    			<th>Nombre de Atributo</th>
                    			<th>Publicación</th>
                    			<th></th>
                    		</tr>
                    		<?php
                    		$qAll = $objArticulo->Consultar("SELECT titulo, id FROM articulos");

                    		$qo = $objArticulo->Consultar("SELECT * FROM articulos_articulos WHERE articulo_id_padre =". $row['id']);
							while($Atributo = mysql_fetch_array($qo)):
							?>
							<tr>
	                    		<td><input id="input_<?= $Atributo['id']?>" type="text" name="atributo[<?= $Atributo['id']?>][nombre]" value="<?= $Atributo['nombre_atributo'] ?>" /> </td>
	                    		<td>
	                    			<select class="select" data-id="<?= $Atributo['id']?>" id="select_<?= $Atributo['id']?>" required name="atributo[<?= $Atributo['id']?>][id]">
	                    			<?php
	                    			while($Posts = mysql_fetch_array($qAll)):
									?>
										<option title="<?= $Posts['titulo'] ?>" value="<?= $Posts['id'] ?>" <?php if($Posts['id']==$Atributo['articulo_id_hijo']) echo " selected " ?>><?= $Posts['id'] ?>-<?= $Posts['titulo'] ?></option>
									<?php
									endwhile;
									mysql_data_seek($qAll, 0)
	                    			?>
	                    			</select>
	                    		</td>
	                    		<td><a title="Borrar" class="deleteAtributo" href="#">
	                    			<img src="img/del-red-16.png" alt="delete" />
	                    		</a></td>
	                    	</tr>
                    		<?php
							endwhile;
                    		?>
                    	</table>
                    	<a class="add" id="newAtributo" href="#">Añadir atributo</a>
                    	<?php else: ?>
                    	<table class="tsmall" id="t_atributo" width="100%">
                    		<tr>
                    			<th>Nombre de Atributo</th>
                    			<th>Publicación</th>
                    			<th></th>
                    		</tr>
                    	</table>
                    	<a class="add" id="newAtributo" href="#">Añadir atributo</a>
                    	<?php endif; ?>
                    	</div>
                    </section>
                    <?php endif ?>

	                <!-- SECCIONES ADJUNTOS -->
	                <?php if($array_post_options['adj']==1): ?>
						<section class="seccion">
                		<div class="seccion-header">
                			<h3>Adjuntos</h3>
                			<a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
                		</div>
                		<div class="seccion-body">
	                    	<script>
								$(document).ready(function() {
									$(".explorer-file").filexplorer({
										inputHideValue : ""
									});
								});
							</script>
							<!--
							*************** A R C H I V O S  A D J U N T O S ***************
							-->
		                    <div id="featured-image">
		                    	<!-- A C T U A L I Z A R -->
		                    	<?php if(isset($row)):?>
		                    		<table id="t_imagen" width="100%" cellpadding="0" cellspacing="0">
										<tr>
			                    			<td width="40%"><strong>Imagen de Portada</strong><br />
			                    				<span class="info">Sirve como imagen de fondo, para slideshow, por lo general una imagen grande.</span></td>
			                    			<td>
			                    				<input name="portada" type="text" id="portada" class="explorer-file" readonly
			                    				value="<?= rb_image_exists( $objArticulo->SelectObject( "portada" , $row['id'] , 'image' ) ) ? $objArticulo->SelectObject( "portada" , $row['id'] , 'image' ) : '' ?>" />
			                    			</td>
			                    		</tr>
			                    		<tr>
			                    			<td><strong>Imagen Perfil</strong> <br />
			                    				<span class="info">Sirve como imagen que identifica a la publicación o artículo.</span>
			                    			</td>
			                    			<td>
			                    				<input name="secundaria" type="text" id="logo" class="explorer-file" readonly value="<?= rb_image_exists( $objArticulo->SelectObject( "logo" , $row['id'] , 'image' ) ) ? $objArticulo->SelectObject( "logo" , $row['id'] , 'image' ) : '' ?>" />
			                    			</td>
			                    		</tr>
			                    		<tr>
			                    			<td><strong>Archivo Adjunto</strong> <br />
			                    				<span class="info">Puede ser un archivo DOC, PDF, como información complementaria para descargar.</span></td>
			                    			<td>
			                    				<input name="adjunto" type="text" id="adjunto" class="explorer-file" readonly value="<?= rb_image_exists( $objArticulo->SelectObject( "adjunto" , $row['id'] , 'image' ) ) ? $objArticulo->SelectObject( "adjunto" , $row['id'] , 'image' ) : '' ?>" />
			                    			</td>
			                    		</tr>
									</table>
								<!-- N U E V O -->
								<?php else: ?>
			                    	<table id="t_imagen" width="100%">
			                    		<tr>
			                    			<td width="40%">Imagen de Portada<br />
			                    				<span class="info">Sirve como imagen de fondo, para slideshow, por lo general una imagen grande.</span></td>
			                    			<td>
			                    				<input name="portada" type="text" id="portada" class="explorer-file" readonly />
			                    			</td>
			                    		</tr>
			                    		<tr>
			                    			<td>Imagen Perfil <br />
			                    				<span class="info">Sirve como imagen que identifica a la publicación o artículo.</span>
			                    			</td>
			                    			<td>
			                    				<input name="secundaria" type="text" id="secundaria" class="explorer-file" readonly />
			                    			</td>
			                    		</tr>
			                    		<tr>
			                    			<td>Archivo Adjunto <br />
			                    				<span class="info">Puede ser un archivo DOC, PDF, como información complementaria para descargar.</span></td>
			                    			<td>
			                    				<input name="adjunto" type="text" id="adjunto" class="explorer-file" readonly />
			                    			</td>
			                    		</tr>
			                    	</table>
			                    <?php endif; ?>
		                    </div>
	                    </div>
					</section>
	                <?php endif ?>

	                <!-- SECCIONES OTRAS OPCIONES -->
	                <?php if($array_post_options['edi']==1): ?>
	                <section class="seccion">
	                	<div class="seccion-header">
                    		<h3>Opciones de Edición</h3>
                    		<a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
                    	</div>
                    	<div class="seccion-body">
	                        <label title="Edita enlace amigable" for="titulo-enlace">Enlace por defecto:</label>
	                        <input maxlength="200"  name="titulo_enlace" type="text" id="titulo-enlace" value="<?php if(isset($row)) echo $row['titulo_enlace'] ?>" />

	                        <label title="Edita etiquetas">Etiquetas (palabras claves relacionadas con la Publicacion. Ej. viajes, caribe, ofertas)</label>
	                        <input maxlength="200"  name="claves" type="text" id="claves" value="<?php if(isset($row)) echo $row['tags'] ?>" />
	                    </div>
                    </section>
                    <?php endif ?>
                </div>
                <div id="sidebar">
                	<!-- SECCION ACCESO POR NIVELES -- POR DEFECTO VISIBLE -->
                	<!--<section class="seccion">
                		<div class="seccion-header">
                			<h3>Acceso al post</h3>
                			<a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
                		</div>
                		<div class="seccion-body">
                			<label>
                				<input type="radio" name="acceso" value="public" <?php if(isset($row) && $row['acceso']=="public"){ echo " checked "; }else{ echo " checked "; } ?> /> Publico
                				<span class="info2">
                					La publicación puede ser vista por cualquier persona. No necesita registrarse.
                				</span>
                			</label>
                			<label>
                				<input type="radio" name="acceso" value="privat" <?php if(isset($row) && $row['acceso']=="privat"){ echo " checked "; } ?> /> Privado por niveles
                				<span class="info2">
                					La publicación puede verla los usuarios registrados. También puede filtrar por niveles de usuarios que pueden ver.
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
                	</section>-->
                	<!-- SECCION CATEGORIAS -- POR DEFECTO VISIBLE -->
                	<section class="seccion">
                		<div class="seccion-header">
                			<h3>Categoria</h3>
                			<a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
                		</div>
                		<div class="seccion-body">
                    		<div class="post-categories">
                    	<?php if($userType == "admin"): ?>
                    	<a href="#" class="popup" title="Nueva Categoría">+</a>
                    	<?php endif ?>
                        <div class="categoria_nueva" style="display:none">
                        	<input type="text" name="categoria_nombre" form="formcat" id="categoria_nombre" required value="" />
                        	<input type="submit" form="formcat" value="Guardar" /> <input type="button" form="formcat" value="Cancelar" id="cancel" />
                        </div>
                    	<script>
                    		$(document).ready(function() {
	                    		$( ".popup" ).click(function( event ) {
	                    			$( ".categoria_nueva" ).toggle();
	                    			$( "#categoria_nombre" ).focus();
	                    			event.preventDefault();
	                    		});

	                    		$( "#formcat" ).submit(function( event ) {
	                    			event.preventDefault();
								  	$.ajax({
									  	method: "POST",
									  	url: "category.add.post.php",
									  	data: $( "#formcat" ).serialize()
									}).done(function( msg ) {
									    $('#catlist').append( msg );
									    $( ".categoria_nueva" ).toggle();
									    $( "#categoria_nombre" ).val("");
									});
								});

								$( "#cancel" ).click(function( event ) {
									$( ".categoria_nueva" ).toggle();
									$( "#categoria_nombre" ).val("");
								});
	                    	});
                    	</script>

                        <div id="catlist">
						<?php
                            $cons_cat = $objCategoria->Consultar("SELECT * FROM categorias ORDER BY nombre ASC");

                            while($row_c=mysql_fetch_array($cons_cat)){
                                $categoria_id=$row_c['id'];

                                if(isset($row)){ // si esta definida variable con datos cargados para actualizar
									//buscar las coincidencias articulos-categorias
									$coincidencia=mysql_num_rows($objArticulo->Consultar("SELECT * FROM articulos_categorias WHERE articulo_id=$id AND categoria_id=$categoria_id"));
								}else{
									$coincidencia=0;
								}

                                echo "<label class=\"label_checkbox\">";
                                if($coincidencia>0){
                                    echo "<input type=\"checkbox\" value=\"$row_c[id]\" checked=\"checked\" name=\"categoria[]\" /> $row_c[nombre] \n";
                                }else{
                                    echo "<input type=\"checkbox\" value=\"$row_c[id]\" name=\"categoria[]\" /> $row_c[nombre] \n";
                                }
                                echo "</label>";
                            }
                        ?>
                        </div>
                    </div>
                    	</div>
                    </section>

                    <!-- SECCION CAMPOS ADICIONALES -->
                    <?php if($array_post_options['adi']==1): ?>
					<section class="seccion">
					<div class="seccion-header">
						<h3>Campos adicionales</h3>
						<a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
					</div>
					<div class="seccion-body">
					<div id="objects-extern" class="inseccion">
						<!-- actualizar -->
						<?php if(isset($row)):?>
							<table class="tsmall" id="t_externo" width="100%">
	                    		<tr>
	                    			<th>Tipo</th>
	                    			<th>Contenido</th>
	                    		</tr>
	                    		<?php
	                    		$i=0;
	                    		$objetos = $objOpcion->obtener_valor(1,'objetos');
								$array = explode(",",$objetos);
								$array_count = count($array);
	                    		while($i<$array_count):
	                    		?>
	                    		<tr>
	                    			<td>
	                    				<input name="externo[<?= trim($array[$i]) ?>][tipo]" type="hidden" value="<?= trim($array[$i]) ?>" />
	                    				<?php echo trim($array[$i]) ?>
	                    			</td>
	                    			<td>
	                    				<input name="externo[<?= trim($array[$i]) ?>][contenido]" type="text" value="<?= $objArticulo->SelectObject(trim($array[$i]),$row['id'],'objeto') ?>"/>
	                    			</td>
	                    		</tr>
	                    		<?php
	                    		$i++;
								endwhile;
	                    		?>
	                    	</table>
						<!-- nuevo -->
						<?php else: ?>
							<table class="tsmall" id="t_externo" width="100%">
	                    		<tr>
	                    			<th>Tipo</th>
	                    			<th>Contenido</th>
	                    		</tr>
	                    		<?php
	                    		$i=0;
	                    		$objetos = $objOpcion->obtener_valor(1,'objetos');
								$array = explode(",",$objetos);
								$array_count = count($array);
	                    		while($i<$array_count):
	                    		?>
	                    		<tr>
	                    			<td>
	                    				<input name="externo[<?= trim($array[$i]) ?>][tipo]" type="hidden" value="<?= trim($array[$i]) ?>" />
	                    				<?php echo trim($array[$i]) ?>
	                    			</td>
	                    			<td>
	                    				<input name="externo[<?= trim($array[$i]) ?>][contenido]" type="text" />
	                    			</td>
	                    		</tr>
	                    		<?php
	                    		$i++;
								endwhile;
	                    		?>
	                    	</table>
	                    <?php endif; ?>
					</div>
					</div>
					</section>
					<?php endif; ?>
                    <!-- SECCION GALERIAS / IMAGENES -->
                    <?php if($array_post_options['gal']==1): ?>
                    <section class="seccion">
                    	<div class="seccion-header">
                    		<h3>Galerías e imágenes</h3>
                    		<a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
                    	</div>
                    	<div class="seccion-body">
                    	<!--<div class="mitad">-->
							<div id="alblist">
							<?php
							if($userType == "user-panel"):
								$cons_cat = $objCategoria->Consultar("SELECT * FROM albums WHERE usuario_id = ".G_USERID." ORDER BY nombre ASC");
							else:
								$cons_cat = $objCategoria->Consultar("SELECT * FROM albums ORDER BY nombre ASC");
							endif;

		                        while($row_c=mysql_fetch_array($cons_cat)){
		                        	$album_id=$row_c['id'];

		                            if(isset($row)){ // si esta definida variable con datos cargados para actualizar
										//buscar las coincidencias articulos-categorias
										$coincidencia=mysql_num_rows($objArticulo->Consultar("SELECT * FROM articulos_albums WHERE articulo_id=$id AND album_id=$album_id"));
									}else{
										$coincidencia=0;
									}

		                            echo "<label class=\"label_checkbox\">";
		                            if($coincidencia>0){
		                            	echo "<input type=\"checkbox\" value=\"$row_c[id]\" checked=\"checked\" name=\"albums[]\" /> $row_c[nombre]  (<a data-id='".$row_c['id']."' class='galleries' href='#'>Ver</a>) \n";
		                            }else{
		                                echo "<input type=\"checkbox\" value=\"$row_c[id]\" name=\"albums[]\" /> $row_c[nombre]  (<a data-id='".$row_c['id']."' class='galleries' href='#'>Ver</a>) \n";
		                            }
		                            echo "</label>";
		                    	}
							?>
							</div>
							<a href="#" class="popup_galeria add" title="Nueva Galería">Nueva Galería</a>
							<!--<a class="add" href="index.php?pag=gal">Editor Avanzado</a>-->
	                        <div class="galeria_nueva" style="display:none">
	                        	<input type="text" name="galeria_nombre" form="formgaleria" id="galeria_nombre" required value="" />
	                        	<input type="submit" form="formgaleria" value="Guardar" /> <input type="button" form="formgaleria" value="Cancelar" id="cancel_galeria" />
	                        </div>
	                    	<script>
	                    		$(document).ready(function() {
		                    		$( ".popup_galeria" ).click(function( event ) {
		                    			event.preventDefault();
		                    			$( ".galeria_nueva" ).toggle();
		                    			$( "#galeria_nombre" ).focus();
		                    		});

		                    		$( "#formgaleria" ).submit(function( event ) {
		                    			event.preventDefault();
									  	$.ajax({
										  	method: "POST",
										  	url: "gallery.add.post.php",
										  	data: $( "#formgaleria" ).serialize()
										}).done(function( msg ) {
										    $('#alblist').append( msg );
										    $( ".galeria_nueva" ).toggle();
										    $( "#galeria_nombre" ).val("");
										});
									});

									$( "#cancel_galeria" ).click(function( event ) {
										$( ".galeria_nueva" ).toggle();
										$( "#categoria_nombre" ).val("");
									});
		                    	});
	                    	</script>

						<!--</div>-->

	                    </div>
	                    <div style="clear: both"></div>
	                </section>
	                <?php endif ?>


                    <!-- SECCION VIDEO -->
                    <?php if($array_post_options['vid']==1): ?>
					<section class="seccion">
						<div class="seccion-header">
                    		<h3>Video</h3>
                    		<a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
                    	</div>
						<div class="seccion-body">
							<span class="info">Puedes mostrar videos de Youtube unicamente (aparecerá luego del contenido)</span>
							<textarea name="video_embed" placeholder="http://www.youtube.com/embed/CODIGO"><?php if(isset($row)) echo $row['video_embed'] ?></textarea>
						</div>
					</section>
					<?php endif ?>

					<!-- SECCION CALENDARIO -->
					<?php if($array_post_options['cal']==1): ?>
					<section class="seccion">
						<div class="seccion-header">
							<h3>Calendario</h3>
							<a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
						</div>
						<div class="seccion-body">
						<span class="info">Bastará con seleccionar la fecha, y esta publicación aparecera en el calendario de actividades</span>
							<script>
							$(document).ready(function() {
								/* datapicker manager */
								/* ================== */
								$('.fecha_actividad').datepicker();

								$('.fecha_actividad').datepicker('option', {
									minDate: 0,
									dateFormat: 'dd-mm-yy'
								});

								<?php
								if(isset($row) && $row['actividad']=='1'):
								?>
								$('.fecha_actividad').datepicker('setDate', '<?= a_ddmmyyyy($row['fecha_actividad']) ?>');
								<?php
								endif;
								?>
							});
							</script>
						<input type="text" name="calendar" class="fecha_actividad" value="<?php if(isset($row) && $row['actividad']=='1') echo a_ddmmyyyy($row['fecha_actividad']) ?>" />
						</div>
					</section>
					<?php endif ?>

					<!-- SECCION OTRAS OPCIONES -->
					<?php if($array_post_options['otr']==1): ?>
                    <section class="seccion">
                    	<div class="seccion-header">
							<h3>Otras opciones</h3>
							<a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
						</div>
						<div class="seccion-body">
							<span class="info">Estas opciones afectan las publicaciones dependiendo de la plantilla usada.</span>
						<label class="label_checkbox" for="featured">
		                   	<?php $chektext = "Destacar <img src='img/star-16.png' alt='starred' />"?>
		                   	<?php if(isset($row)):
		                   		$check ="";
		                   		if($row['portada']==1) $check = " checked=\"checked\" ";
		                   	?>
		                   	<input type="checkbox" name="featured" id="featured" value="1" <?php echo $check ?> /> <?=$chektext?>
		                   	<?php else: ?>
		                   	<input type="checkbox" name="featured" id="featured" value="1" /> <?=$chektext?>
		                   	<?php endif; ?>
						</label>

						</div>
					</section>
					<?php endif ?>

					<!-- SECCION SUBIR IMAGENES -->
					<?php if($array_post_options['sub']==1): ?>
					<section class="seccion">
						<div class="seccion-header">
							<h3>Subir imagenes</h3>
							<a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
						</div>
						<div class="seccion-body">
						<?php
						include_once ABSPATH.'rb-script/modules/rb-uploadimg/mod.uploadimg.php';
						?>
						</div>
					</section>
					<?php endif ?>
                </div>
            </div>
			<input name="section" value="art" type="hidden" />
			<input name="mode" value="<?php echo $mode ?>" type="hidden" />
			<input name="id" value="<?php if(isset($row)) echo $row['id'] ?>" type="hidden" />
            <input name="userid" value="<?php echo G_USERID ?>" type="hidden" />
            <!-- url img -->
            <input name="srcimg" value="<?php if(isset($row)) echo $row['img_portada'] ?>" type="hidden" />
		</form>
	<?php
	break;
    /* ------------------------------------------------------------- */
    /* ---------------- FORMULARIO PAGINA -------------------------- */
    /* ------------------------------------------------------------- */
    case "pages":
		require_once(ABSPATH."rb-script/funciones.php");
        require_once(ABSPATH."rb-script/class/rb-paginas.class.php");
		require_once(ABSPATH."rb-script/class/rb-galerias.class.php");
        if(isset($_GET['m']) && $_GET['m']=="ok") msgOk("Cambios guardados");

        $mode;
        if(isset($_GET["id"])){
            // if define realice the query
            $id=$_GET["id"];
            $cons_art = $objPagina->Consultar("SELECT * FROM paginas WHERE id=$id");
            $row=mysql_fetch_array($cons_art);
            $mode = "update";
        }else{
            $mode = "new";
        }
		include_once("tinymce.module.small.php");
    ?>

        <form id="article-form" name="article-form" method="post" action="save.php">
            <div id="toolbar">
                <div id="toolbar-buttons">
                    <span class="post-submit">
                    <input class="submit" name="guardar" type="submit" value="Guardar" />
                    <input class="submit" name="guardar_volver" type="submit" value="Guardar y volver" />
                    <a href="../rb-admin/?pag=pages"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Volver" /></a>

                    </span>
                </div>
            </div>
            <div>
                <div class="content-edit">
                	<section class="seccion">
                    <div class="seccion-body">
                        <input class="titulo" placeholder="Escribe el titulo aqui"  name="titulo" type="text" id="titulo" value="<?php if(isset($row)) echo $row['titulo'] ?>" required />
                        <textarea class="mceEditor" name="contenido" id="contenido" style="width:100%;"><?php if(isset($row)) echo stripslashes(htmlspecialchars($row['contenido'])); ?></textarea>
                        <a href="#" class="desactivar">Desactivar editor</a>
                        <script>
                        	$( ".desactivar" ).on( "click", function(event) {
                        		$(this).addClass('activar');
                        		$(this).removeClass('desactivar');
                        		tinymce.remove();
                        	});
                        </script>
                    <?php if($mode=="update"):?>
                    	<?php
                    	$tipo = "pagn";
                    	if($row['popup']==1) $tipo = "popup";
                    	?>
                    	<label>URL: (Copia esta URL para asociarla con otra página)</label>
                        <input type="text" value="<?= rb_url_link('pag',$row['id']) ?>" readonly />
                    <?php endif ?>
                    </div>
                    </section>
                </div>
                <div id="sidebar">
                	<!--<a class="btn-primary" href="index.php?pag=design&page_id=<?php if(isset($row)) echo $row['id']; else echo "0" ?>">Editar Estructura</a>-->
                	<a class="fancybox fancybox.iframe" href="preview.php?page_id=<?php if(isset($row)) echo $row['id'] ?>">Vista previa</a>
                    <section class="seccion">
                    	<div class="seccion-header">
                    		<h3>Otras opciones</h3>
                    	</div>
	                	<div class="seccion-body">
							<label title="Tipo de Pagina" for="tipo" >Tipo:
	                        <select  name="tipo" id="tipo">
	                        	<option <?php if(isset($row) && $row['popup']==0) echo "selected=\"selected\"" ?> value="0">Pagina Entera</option>
	                            <option <?php if(isset($row) && $row['popup']==1) echo "selected=\"selected\"" ?> value="1">Bloque</option>
	                        </select>
	                        </label>

							<div id="galeria_embed_box">
		                    	<label title="Si deseas que se muestre una Galería de imágenes, selecciona una de la lista." for="galeria">
		                    	Asociar con galeria:
		                    	<span class="info">La galería de imágenes se mostrará al final del texto.</span>
		                    	<select name="galeria">
		                    		<option value="0">[ninguna]</option>
		                    		<?php
		                    		$q = $objGaleria->Consultar("SELECT * FROM albums");
									while($r_albums = mysql_fetch_array($q)):
									?>
		                    			<option <?php if(isset($row)){ $row['galeria_id']; if($row['galeria_id'] == $r_albums['id']){ echo " selected "; } }  ?> value="<?= $r_albums['id'] ?>"><?= $r_albums['nombre'] ?></option>
									<?php
									endwhile;
		                    		?>
		                    	</select>
		                    	</label>
		                    </div>

		                    <!--<label>Video
		                    	<span class="info">Puedes mostrar videos de Youtube unicamente (para que aparezca en contenido escribe <strong>[VIDEO]</strong>)</span>
		                    	<textarea placeholder="http://www.youtube.com/embed/CODIGO" name="video" rows="3"></textarea>
		                    </label>-->

		                    <label>Incluir Columna Lateral</label>
		                    <select name="sidebar">
		                    	<option <?php if(isset($row) && $row['sidebar']==0) echo "selected=\"selected\"" ?> value="0">No</option>
		                    	<option <?php if(isset($row) && $row['sidebar']==1) echo "selected=\"selected\"" ?> value="1">Si</option>
		                    </select>

		                    <label title="Nombre del Menu a Seleccionar" for="menu-select">Nombre del Menu a Seleccionar:
								<input name="addon" type="text" id="menu-select" value="<?php if(isset($row)) echo $row['addon'] ?>" />
							</label>
							<!-- MENU SELECTED
							<label title="Nombre del Menu a Seleccionar" for="menu-select">Nombre del Menu a Seleccionar:
								<input name="addon" type="text" id="menu-select" value="<?php if(isset($row)) echo $row['addon'] ?>" />
							</label> -->

	                   		<div class="post-link">
	                        	<a onclick="more('link-title')" style="cursor:pointer;text-decoration:underline;" title="Mas alternativas">Mas &raquo;</a>
	                    	</div>
		                    <div class="post-more" id="link-title" style="display:none;">
								<label title="Editar enlace amigable" for="titulo-enlace">Enlace por defecto:</label>
								<input maxlength="200"  name="titulo_enlace" type="text" id="titulo-enlace" value="<?php if(isset($row)) echo $row['titulo_enlace'] ?>" />
		                        <!--<label title="Editar palabras claves">Palabras para buscadores (separar por comas):</label>
		                        <input maxlength="200"  name="claves" type="text" id="claves" value="<?php if(isset($row)) echo $row['tags'] ?>" />-->
		                    </div>
	                    </div>
                    </section>

                    <section class="seccion">
                    	<div class="seccion-header">
							<h3>Subir imagenes</h3>
						</div>
						<div class="seccion-body">
						<?php
						include_once ABSPATH.'rb-script/modules/rb-uploadimg/mod.uploadimg.php';
						?>
						</div>
					</section>

                    <div class="help">
		            	<h4>Información</h4>
		            	<p>
		            		Hay valores predefinidos del sistema que se pueden usar en el contenido. Se deben usar tal y cual esta escrito, incluyendo los corchetes.
		            	</p>
		            	<p>
		            		<strong>[SERVER_URL]</strong>: Muestra la url del sitio web.
		            	</p>
		            	<p>
		            		<strong>[SERVER_THEME]</strong>: Muestra la url donde estan los archivos de la apariencia del sitio web.
		            	</p>
		            </div>
                </div>
            </div>
            <input name="section" value="pages" type="hidden" />
            <input name="mode" value="<?php echo $mode ?>" type="hidden" />
            <input name="id" value="<?php if(isset($row)) echo $row['id'] ?>" type="hidden" />
            <input name="userid" value="<?php echo G_USERID ?>" type="hidden" />

        </form>
    <?php
    break;
	/* ------------------------------------------------------------- */
	/* ---------------- FORMULARIO MENU ---------------------------- */
	/* ------------------------------------------------------------- */
	case "menus":
		require_once(ABSPATH."rb-script/class/rb-menus.class.php");

		$mode;
		if(isset($_GET["id"])){
			// if define realice the query
			$id=$_GET["id"];
			$cons = $objMenu->Consultar("SELECT * FROM menus WHERE id=$id");
			$row=mysql_fetch_array($cons);
			$mode = "update";
		}else{
			$mode = "new";
		}
	?>

		<form id="categorie-form" name="categorie-form" method="post" action="save.php">
        	<div id="toolbar">
            	<div id="toolbar-buttons">
                    <span class="post-submit">
                    <input class="submit" name="guardar" type="submit" value="Guardar" />

                    <a href="../rb-admin/?pag=menus"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>
                    </span>
                </div>
            </div>
            <div>
                <div class="content-edit">
                    <section class="seccion">
                    	<div class="seccion-body">
	                        <label title="Nombre del Menu" for="nombre">Nombre del Menu:
	                        <input required  name="nombre" type="text" value="<?php if(isset($row))echo $row['nombre'] ?>" />
	                        </label>
                        </div>
					</section>
                </div>
			</div>
            <input name="mode" value="<?php echo $mode; ?>" type="hidden" />
			<input name="section" value="menus" type="hidden" />
			<input name="id" value="<?php if(isset($row)) echo $row['id']; ?>" type="hidden" />
		</form>
	<?php
	break;
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
			$cancel ="Volver";
			$new_button = '<a href="../rb-admin/?pag=cat&opc=nvo"><input title="Nuevo" class="button_new" name="nuevo" type="button" value="Nuevo" /></a>';
		}else{
			$mode = "new";
			$cancel ="Volver";
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
	                        <label title="Nombre de la categoria" for="nombre">Nombre Categoria <span class="required">*</span>:
	                        <input required  name="nombre" type="text" value="<?php if(isset($row))echo $row['nombre'] ?>" />
	                        </label>


	                        <label title="Descripcion de la categoria">Descripcion:
	                        	<span class="info">La descripción no es necesaria, salvo si su plantilla/diseño lo requiera.</span>
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
                					La categoría puede ser vista por cualquier persona. No necesita registrarse.
                				</span>
                			</label>
                			<label>
                				<input type="radio" name="acceso" value="privat" <?php if(isset($row) && $row['acceso']=="privat"){ echo " checked "; } ?> /> Privado por niveles
                				<span class="info2">
                					La categoría puede verla los usuarios registrados. También puede filtrar por niveles de usuarios que pueden ver.
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
                	<?php ?>
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
	/* ---------------- FORMULARIO USUARIO ------------------------- */
	/* ------------------------------------------------------------- */
	case "usu":
		require_once(ABSPATH."rb-script/class/rb-usuarios.class.php");
		if(isset($_GET['m']) && $_GET['m']=="ok") msgOk("Cambios guardados");

		$mode;
		if(isset($_GET["id"])){
			// if define realice the query
			$id=$_GET["id"];
			$cons_art = $objUsuario->Consultar("SELECT * FROM usuarios WHERE id=$id");
			$row=mysql_fetch_array($cons_art);
			$mode = "update";
		}else{
			$mode = "new";
		}
	?>
		<form id="user-form" name="user-form" method="post" action="save.php">
        	<div id="toolbar">
            	<div id="toolbar-buttons">
                    <span class="post-submit">
					<input class="submit" name="guardar" type="submit" value="Guardar" />
					<a href="../rb-admin/?pag=usu"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>

                    </span>
                </div>
            </div>
			<div>
				<div class="content-edit">
					<section class="seccion">
						<div class="seccion-body">
	                    <div class="cols-container">
	                    	<h3 class="subtitle">Datos personales</h3>
	                    	<div class="cols-6-md col-padding">
		                        <label title="Nombres" for="nom">Nombres:
		                        <input name="nom" type="text" id="nom" value="<?php if(isset($row)) echo $row['nombres'] ?>" required />
		                        </label>

		                        <label title="Apellidos" for="ape">Apellidos:
		                        <input name="ape" type="text" id="ape" value="<?php if(isset($row)) echo $row['apellidos'] ?>" required />
		                        </label>

		                        <label title="Correo electronico" for="mail">Correo electronico:
		                        <input name="mail" type="text" id="mail" value="<?php if(isset($row)) echo $row['correo'] ?>" />
		                        </label>

		                        <label title="Direccion" for="dir">Direccion:
		                        <input name="dir" type="text" id="dir" value="<?php if(isset($row)) echo $row['direccion'] ?>" />
		                        </label>

		                        <label title="Congregacion" for="cong">Ciudad:
		                        <input name="ciu" type="text" value="<?php if(isset($row)) echo $row['ciudad'] ?>" />
		                        </label>

		                        <label title="Circuito" for="cir">País:
		                        <input name="pais" type="text" value="<?php if(isset($row)) echo $row['pais'] ?>" />
		                        </label>


	                        </div>
	                        <div class="cols-6-md col-padding">
	                        	<label title="Teléfono móvil" for="tel">Teléfono móvil:
		                        <input name="telmov" type="text" id="telmov" value="<?php if(isset($row)) echo $row['telefono-movil'] ?>" />
		                        </label>

		                        <label title="Teléfono fíjo" for="tel">Teléfono fíjo:
		                        <input name="telfij" type="text" id="telfij" value="<?php if(isset($row)) echo $row['telefono-fijo'] ?>" />
		                        </label>
		                        <label title="Sexo" for="sexo" >Sexo:
		                        <select  name="sexo" id="sexo">
		                            <option <?php if(isset($row) && $row['sexo']=='h') echo "selected=\"selected\"" ?> value="h">Hombre</option>
		                            <option <?php if(isset($row) && $row['sexo']=='m') echo "selected=\"selected\"" ?> value="m">Mujer</option>
		                        </select>
		                        </label>

		                        <label title="Sexo" for="sexo" >Image Perfil:
		                        	<script>
										$(document).ready(function() {
											$(".explorer-file").filexplorer({
												inputHideValue: "<?= isset($row) ?  $row['photo_id'] : "0" ?>" // establacer un valor por defecto al cammpo ocutlo
											});
										});
									</script>
									<input readonly type="text" name="photo" class="explorer-file" value="<?php if(isset($row)): $photos = rb_get_photo_from_id($row['photo_id']); echo $photos['src']; endif ?>" id="photo" />
		                        </label>
		                        <label>Biografía:
		                        	<textarea name="bio" placeholder="Cuentanos algo sobre ti"><?php if(isset($row)) echo $row['bio'] ?></textarea>
		                        </label>
	                        </div>
	                    </div>
	                    <div class="cols-container">
	                    	<h3 class="subtitle">Redes sociales</h2>
	                    	<div class="cols-6-md col-padding">
	                    		<label>Twitter:
	                        		<input name="tw" type="text" value="<?php if(isset($row)) echo $row['tw'] ?>" />
	                        	</label>

	                        	<label>Facebook:
	                        		<input name="fb" type="text" value="<?php if(isset($row)) echo $row['fb'] ?>" />
	                        	</label>

	                        	<label>Google +:
	                        		<input name="gplus" type="text" value="<?php if(isset($row)) echo $row['gplus'] ?>" />
	                        	</label>

	                        	<label>LinkedIn:
	                        		<input name="in" type="text" value="<?php if(isset($row)) echo $row['in'] ?>" />
	                        	</label>

	                        	<label>Pinterest:
	                        		<input name="pin" type="text" value="<?php if(isset($row)) echo $row['pin'] ?>" />
	                        	</label>

	                        	<label>Instagram:
	                        		<input name="insta" type="text" value="<?php if(isset($row)) echo $row['insta'] ?>" />
	                        	</label>

	                        	<label>Youtube:
	                        		<input name="youtube" type="text" value="<?php if(isset($row)) echo $row['youtube'] ?>" />
	                        	</label>
	                    	</div>
	                    </div>

	                    <div>

			            </div>

	                    </div>
                    </section>
				</div>
                <div id="sidebar">
                	<section class="seccion">
                		<div class="seccion-header">
                			<h3>Accceso al sistema</h3>
                		</div>
                		<div class="seccion-body">
		                	<div>
								<?php if($userType == "admin"): ?>
									<label title="Tipo de Usuario" for="tipo" >Tipo de usuario:
			                        	<select name="tipo" id="tipo">
			                        		<option value="0">[Ninguno]</option>
										<?php
										$q = $objUsuario->Consultar("SELECT * FROM usuarios_niveles");
										while($r = mysql_fetch_array($q)):
										?>
										<option <?= isset($row) && $row['tipo']==$r['id'] ? "selected=\"selected\"" : "" ?> value="<?= $r['id'] ?>"><?= $r['nombre'] ?></option>
										<?php
										endwhile;
										?>
										</select>
									</label>
		                        <?php else: ?>
									<input type="hidden" name="tipo" value="<?= $row['tipo'] ?>" />
								<?php endif; ?>
							</div>
		                    <div class="subform">
		                    	<label title="Nombre usuario para identificarte con el sistema" for="nickname">Nombre de usuario:
			                        <input name="nickname" type="text" id="nickname" value="<?php if(isset($row)) echo $row['nickname'] ?>" <?php if(isset($row)){ ?>readonly="readonly" <?php } ?>  />
			                    </label>
			                    <span class="info">
			                    	Si no va a cambiar las contraseñas, deje los campos vacios.
			                    </span>
			                    <label title="Contrasena" for="password" >Contrase&ntilde;a:
			                        <input name="password" type="password" id="password" />
			                    </label>
			                    <label title="Repite Contrasena" for="password1" > Repetir Contrase&ntilde;a:
			                        <input name="password1" type="password" id="password1" />
			                    </label>
			                </div>
	                    </div>
                    </section>
                    <section class="seccion">
                    	<div class="seccion-header">
                    		<h3>Grupos</h3>
                    	</div>
                    	<div class="seccion-body">
							<?php if($userType == "admin"): ?>
							<label>
			                   	<select name="grupo">
			                   		<option value="0">[Ninguno]</option>
								<?php
								$q = $objUsuario->Consultar("SELECT * FROM usuarios_grupos");
								while($r = mysql_fetch_array($q)):
								?>
									<option <?= isset($row) && $row['grupo_id']==$r['id'] ? "selected=\"selected\"" : "" ?> value="<?= $r['id'] ?>"><?= $r['nombre'] ?></option>
								<?php
								endwhile;
								?>
								</select>
							</label>
		                    <?php else: ?>
							<input type="hidden" name="tipo" value="<?= $row['tipo'] ?>" />
							<?php endif; ?>
						</div>
                    </section>
                </div>
			</div>
            <input name="section" value="usu" type="hidden" />
            <input name="mode" value="<?php echo $mode ?>" type="hidden" />
            <input name="id" value="<?php if(isset($row)) echo $row['id'] ?>" type="hidden" />
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
			include(ABSPATH.'rb-admin/modules/rb_message/mod.messages.show.php');
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
	/* ------------------------------------------------------------- */
	/* ---------------- FORMULARIO OPCIONES ------------------------ */
	/* ------------------------------------------------------------- */
	case "opc":
		include_once("tinymce.module.small.php");
		require_once(ABSPATH."rb-script/class/rb-opciones.class.php");
		require_once(ABSPATH."rb-script/class/rb-paginas.class.php");
		if(isset($_GET['m']) && $_GET['m']=="ok") msgOk("Cambios guardados");
		?>
		<form name="options-form" method="post" action="save.php">
      <div id="toolbar">
      	<div id="toolbar-buttons">
          <span class="post-submit">
            <input class="submit" name="guardar" type="submit" value="Guardar" />
          </span>
        </div>
      </div>
			<div class="content-centered">
				<section class="seccion">
					<div class="seccion-body">
						<!-- bloque 1 -->
						<div class="cols-container">
							<h3 class="subtitle">Datos del sitio web</h3>
							<div class="cols-6-md col-padding">
								<label title="Nombre del sitio" for="nombresitio">Nombre del Sitio Web:
									<input  name="nombresitio" type="text" value="<?php echo $objOpcion->obtener_valor(1,'nombresitio'); ?>" required />
								</label>
								<label title="Descripcion del sitio" for="descripcion">Descripcion Sitio Web:
									<input  name="descripcion" type="text" value="<?php echo $objOpcion->obtener_valor(1,'descripcion'); ?>" />
								</label>
								<label title="Direccion URL" for="direccionurl">Direccion URL (incluir http://):
									<input  name="direccionurl" type="text" value="<?php echo $objOpcion->obtener_valor(1,'direccion_url'); ?>" required />
								</label>
								<label>Directorio URL:
									<input name="directoriourl" type="text" value="<?php echo $objOpcion->obtener_valor(1,'directorio_url'); ?>" readonly />
								</label>
							</div>
							<div class="cols-6-md col-padding">
								<label title="Keywords" for="keywords">Meta Keywords (para Buscadores):
									<input  name="keywords" type="text" value="<?php echo $objOpcion->obtener_valor(1,'meta_keywords'); ?>" />
								</label>
								<label title="Description" for="description">Meta Description (para Buscadores):
									<input  name="description" type="text" value="<?php echo $objOpcion->obtener_valor(1,'meta_description'); ?>" />
								</label>
								<label title="Author" for="author">Meta Author (para Buscadores):
									<input  name="author" type="text" value="<?php echo $objOpcion->obtener_valor(1,'meta_author'); ?>" />
								</label>
							</div>
						</div>
						<!-- revisar -->
						<div class="cols-container">
							<h3 class="subtitle">Manejo de correos</h3>
							<div class="cols-6-md col-padding">
								<label title="Corre(os) que reciben los formularios de contacto" for="style">Correo receptor:
		            	<span class="info">El correo que recibe los formularios de contacto. Puede especificar varios, separelo por coma.</span>
		            	<input  name="mails" type="text" value="<?php echo $objOpcion->obtener_valor(1,'mail_destination'); ?>" />
		            </label>
		            <label>Nombre de quien emite correo:
		            	<span class="info">El nombre de quien envia alguna respuesta al usuario final, visitante, etc.</span>
		          		<input  name="namesender" type="text" value="<?php echo $objOpcion->obtener_valor(1,'name_sender'); ?>" />
		            </label>
		            <label title="Correo que envia información de registro" for="style">Correo emisor:
		            	<span class="info">El correo que envia alguna respuesta al usuario final, visitante, etc.</span>
		              <input  name="mailsender" type="text" value="<?php echo $objOpcion->obtener_valor(1,'mail_sender'); ?>" />
		            </label>
							</div>
							<div class="cols-6-md col-padding">
								<label>
									¿Usar librería externa para enviar correos?:
									<input type="text" name="lib_mail_native" value="<?= $objOpcion->obtener_valor(1,'lib_mail_native') ?>" />
								</label>
								<label>
									Api key de librería externa:
									<input type="text" name="sendgridapikey" value="<?= $objOpcion->obtener_valor(1,'sendgridapikey') ?>" />
								</label>
							</div>
						</div>
						<!-- Apariencia -->
						<div class="cols-container">
							<h3 class="subtitle">Apariencia</h3>
							<div class="cols-6-md col-padding">
								<label title="Campos personalizados" for="style">Campos personalizados:
			          	<span class="info">Estos campos aparecerán en la seccion Publicaciones, permiten añadir valores adicionales a los pre-establecidos.</span>
		            	<input  name="objetos" type="text" value="<?php echo $objOpcion->obtener_valor(1,'objetos'); ?>" />
		            </label>
			          <label title="Numero de Items por Página" for="style">Numero de Items por Página:
			            <input  name="post_by_category" type="text" value="<?php echo $objOpcion->obtener_valor(1,'post_by_category'); ?>" />
			          </label>
								<label>Logo:
									<script>
									$(document).ready(function() {
										$(".explorer-file").filexplorer({
											inputHideValue: "<?=  $objOpcion->obtener_valor(1,'logo') ?>" // establacer un valor por defecto al cammpo ocutlo
										});
									});
									</script>
			          	<input  name="logo" type="text" class="explorer-file" readonly value="<?php $photos = rb_get_photo_from_id( $objOpcion->obtener_valor(1,'logo') ); echo $photos['src']; ?>" />
			          </label>
								<label title="Menu Principal" for="menu">Menu Principal: <a class="btn-secundary" href="<?= G_SERVER ?>/rb-admin/?pag=menus">Nuevo menú</a>
									<span class="info">Dependiendo de la plantilla instalada, el menú que eliga figurara en la parte superior de la web.</span>
									<select name="menu">
										<option value="0">Ninguno</option>
										<?php
										$q = $objPagina->Consultar("SELECT * FROM menus ORDER BY nombre");
										while($r = mysql_fetch_array($q)):
											?><option <?php if( $objOpcion->obtener_valor(1,'mainmenu_id') == $r['id'] ) echo " selected " ?> value="<?= $r['id'] ?>"><?= $r['nombre'] ?></option><?php
										endwhile;
										?>
									</select>
								</label>
								<label title="Tema" for="tema">Plantilla del Sitio Web:
									<span class="info">Las plantillas temas se guardan en la carpeta raiz <code>rb-temas</code></span>
									<select  name="tema">
										<option value="0">Ninguno</option>
										<?php rb_list_themes('../rb-temas/',$objOpcion->obtener_valor(1,'tema')) ?>
									</select>
								</label>
								<label title="Pagina Index" for="index">¿Con qué página inicia el sitio web? <a class="btn-secundary" href="<?= G_SERVER ?>/rb-admin/?pag=pages">Nueva página</a></label>
								<span class="info">Puede elegir una en particular ó dejar por defecto según el tema instalado</span>
								<select  name="inicial">
									<option value="0">Por defecto</option>
									<?php
									$q = $objPagina->Consultar("SELECT * FROM paginas ORDER BY titulo");

									while($r = mysql_fetch_array($q)):
										?><option <?php if( $objOpcion->obtener_valor(1,'initial') == $r['id'] ) echo " selected " ?> value="<?= $r['id'] ?>"><?= $r['titulo'] ?></option><?php
									endwhile;
									?>
								</select>

								<label>Slide/Galería de Página Inicial <a class="btn-secundary" href="<?= G_SERVER ?>/rb-admin/?pag=album">Nuevo slide</a></label>
								<span class="info">Esto dependerá si su plantilla incluye y/o permite cambiar Slide/Galería.</span>
								<select name="slide">
									<option value="0">Ninguno</option>
									<?php
									$q = $objPagina->Consultar("SELECT * FROM albums ORDER BY nombre");
									while($r = mysql_fetch_array($q)):
										?><option <?php if( $objOpcion->obtener_valor(1,'slide_main') == $r['id'] ) echo " selected " ?> value="<?= $r['id'] ?>"><?= $r['nombre'] ?></option><?php
									endwhile;
									?>
								</select>
								<label>Tamaño de miniatura de imagen</label>
								<div class="cols-container">
									<div class="cols-6-md">
										<div class="cols-container">
											<div class="cols-6-md" style="padding:2px 5px">
												<span>Ancho</span>
												<input name="t_width" type="text" value="<?php echo $objOpcion->obtener_valor(1,'t_width'); ?>" />
											</div>
											<div class="cols-6-md" style="padding:2px 5px">
												<span>Alto</span>
												<input name="t_height" type="text" value="<?= $objOpcion->obtener_valor(1,'t_height') ?>" />
											</div>
										</div>
									</div>
									<div class="cols-6-md"></div>
								</div>

							</div>
							<div class="cols-6-md col-padding">
								<label>Enlace amigable para el sitio web:</label>
								<span class="info">Asegúrese que el archivo <code>.htaccess</code> figure en la raíz del sitio.</span>
								<label class="lbl-listoptions">
									<input name="amigable" type="radio" value="1" <?php if($objOpcion->obtener_valor(1,'enlaceamigable')=='1') echo "checked=\"checked\""?> />
									Enlace amigable. Ej. <code>/articulos/mi-post-sobre-web/</code>
								</label>
								<label class="lbl-listoptions">
									<input name="amigable" type="radio" value="0" <?php if($objOpcion->obtener_valor(1,'enlaceamigable')=='0') echo "checked=\"checked\""?> />
									Enlace estandar. Ej. <code>/?art=mi-post-sobre-web</code>
								</label>
								<span class="info">Solo si activo la opción URL amigables podrá ver reflejados los cambios</span>
								<label>Base para publicaciones:
									<input type="text" name="base_pub" value="<?= $objOpcion->obtener_valor(1,'base_publication') ?>" />
								</label>
								<label>Base para categorias:
									<input type="text" name="base_cat" value="<?= $objOpcion->obtener_valor(1,'base_category') ?>" />
								</label>
								<label>Base para usuarios:
									<input type="text" name="base_usu" value="<?= $objOpcion->obtener_valor(1,'base_user') ?>" />
								</label>
								<label>Base para busquedas:
									<input type="text" name="base_bus" value="<?= $objOpcion->obtener_valor(1,'base_search') ?>" />
								</label>
								<label>Base para paginado:
									<input type="text" name="base_pag" value="<?= $objOpcion->obtener_valor(1,'base_page') ?>" />
								</label>
								<label>Alcance del sitio web:</label>
								<!--<span class="info"></span>-->
								<label class="lbl-listoptions">
									<input name="alcance" type="radio" value="0" <?php if($objOpcion->obtener_valor(1,'alcance')=='0') echo "checked=\"checked\""?> />
									Publico - acceso directo al index y otras partes del sitio
								</label>
								<label class="lbl-listoptions">
									<input name="alcance" type="radio" value="1" <?php if($objOpcion->obtener_valor(1,'alcance')=='1') echo "checked=\"checked\""?> />
									Privado - para acceder al index tendra que loguearse previamente
								</label>
							</div>
						</div>
						<!-- gestion de usuarios -->
						<div class="cols-container">
							<h3 class="subtitle">Gestión de usuarios</h3>
							<div class="cols-6-md col-padding">
								<label>Nivel por defecto para usuarios nuevos: <a class="btn-secundary" href="<?= G_SERVER ?>/rb-admin/?pag=nivel">Nuevo nivel</a>
			            <span class="info">Cuando se registra por primera vez, que nivel tendrá el usuario.</span>
									<select name="nivel_user_register">
										<?php
										$q = $objPagina->Consultar("SELECT * FROM usuarios_niveles");
										while($r = mysql_fetch_array($q)):
										?>
										<option <?php if( $objOpcion->obtener_valor(1,'nivel_user_register') == $r['id'] ) echo " selected " ?> value="<?= $r['id'] ?>"><?= $r['nombre'] ?></option>
										<?php
										endwhile;
										?>
									</select>
								</label>
								<label>Activar usuario:</label>
								<span class="info">Cuando el usuario se registra, es necesario que se active, como medida de seguridad y para evitar el SPAM.</span>
								<label class="lbl-listoptions">
									<input name="user_active_admin" type="radio" value="2" <?php if($objOpcion->obtener_valor(1,'user_active_admin')=='2') echo "checked=\"checked\""?> />
									Solo el Administrador puede activar al usuario nuevo
								</label>
								<label class="lbl-listoptions">
									<input name="user_active_admin" type="radio" value="1" <?php if($objOpcion->obtener_valor(1,'user_active_admin')=='1') echo "checked=\"checked\""?> />
									El usuario puede activar su cuenta a través de un e-mail
								</label>
								<label class="lbl-listoptions">
									<input name="user_active_admin" type="radio" value="0" <?php if($objOpcion->obtener_valor(1,'user_active_admin')=='0') echo "checked=\"checked\""?> />
									El usuario nuevo no necesita activar su cuenta
								</label>
							</div>
							<div class="cols-6-md col-padding">
								<label>Permitir registrar nuevo usuario desde la página web</label>
								<span class="info">Puede incluir un link para registrarse en la página de inicio de sesión ó no.</span>
								<label class="lbl-listoptions">
									<input name="linkregister" type="radio" value="1" <?php if($objOpcion->obtener_valor(1,'linkregister')=='1') echo "checked=\"checked\""?> />
									Permitir e incluir link en la página de Inicio de Sesión
								</label>
								<label class="lbl-listoptions">
									<input name="linkregister" type="radio" value="0" <?php if($objOpcion->obtener_valor(1,'linkregister')=='0') echo "checked=\"checked\""?> />
									No permitir, solo crear Usuario Nuevo desde Panel Administrativo
								</label>
							</div>
						</div>
						<!-- redes sociales -->
						<div class="cols-container">
							<h3 class="subtitle">Redes sociales</h3>
							<div class="cols-6-md col-padding">
								<label>Facebook:
									<input  name="fb" type="text" value="<?php echo $objOpcion->obtener_valor(1,'fb') ?>" />
								</label>
								<label>Twitter:
									<input  name="tw" type="text" value="<?php echo $objOpcion->obtener_valor(1,'tw') ?>" />
								</label>
								<label>Google +:
									<input  name="gplus" type="text" value="<?php echo $objOpcion->obtener_valor(1,'gplus') ?>" />
								</label>
								<label>Pinterest:
									<input  name="pin" type="text" value="<?php echo $objOpcion->obtener_valor(1,'pin') ?>" />
								</label>
							</div>
							<div class="cols-6-md col-padding">
								<label>LinkedIn:
									<input  name="in" type="text" value="<?php echo $objOpcion->obtener_valor(1,'in') ?>" />
								</label>
								<label>Instagram:
									<input  name="insta" type="text" value="<?php echo $objOpcion->obtener_valor(1,'insta') ?>" />
								</label>
								<label>Youtube:
									<input  name="youtube" type="text" value="<?php echo $objOpcion->obtener_valor(1,'youtube') ?>" />
								</label>
								<label>Whatsapp:
									<input  name="whatsapp" type="text" value="<?php echo $objOpcion->obtener_valor(1,'whatsapp') ?>" />
								</label>
							</div>
						</div>
						<!-- redes sociales -->
						<div class="cols-container">
							<h3 class="subtitle">Panel Administrativo</h3>
							<div class="cols-6-md col-padding">
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
												//var pos = $(this).attr("data-pos");
												optionTexts.push({
													name : key,
													position : i
												});
												i++;
											});
											var myJsonString = JSON.stringify(optionTexts);
											console.log(myJsonString);

											$.ajax({
										  	method: "GET",
										  	url: "save.order.panelmenu.php",
												dataType: "json",
										  	data: {mydata : myJsonString}
											}).done(function( msg ) {
											    alert(msg);
											});

										});
									} );
								</script>
								<div class="cols-container">
									<div class="cols-6-md">
									<ul id="sortable" class="menu-list-edit">
										<?php
										$menu_panel = json_decode($objOpcion->obtener_valor(1,'menu_panel'), true);
										foreach ($menu_panel as $module => $value) {
											echo '<li data-key='.$value['key'].' data-pos='.$value['pos'].' class="ui-state-default">'.$value['nombre'].'</li>';
										}
										?>
									</ul>
									<button class="btnSaveOrderMenu" type="button">Guardar orden</button>
									</div>
								</div>
							</div>
							<div class="cols-6-md col-padding">
							</div>
						</div>
						<!-- maps -->
						<div class="cols-container">
							<h3 class="subtitle">Google Maps</h3>
							<div class="cols-6-md col-padding">
								<label>Coordenada X:
									<input name="map-x" type="text" value="<?= $objOpcion->obtener_valor(1,'map-x') ?>" />
								</label>
								<label>Coordenada Y:
									<input name="map-y" type="text" value="<?=$objOpcion->obtener_valor(1,'map-y') ?>" />
								</label>
								<label>Zoom:
									<input name="map-zoom" type="text" value="<?= $objOpcion->obtener_valor(1,'map-zoom') ?>" />
								</label>
								<label>Descripción:
									<textarea name="map-desc" rows="5"><?= $objOpcion->obtener_valor(1,'map-desc') ?></textarea>
								</label>
							</div>
							<div class="cols-6-md col-padding">
							</div>
						</div>
					</div>
					<?php
						// DESTRIPAR VALOR JSON DE modules_options
						$json_modules = $objOpcion->obtener_valor(1,'modules_options');
						$array_modules = json_decode($json_modules, true);
						//print_r($array_modules); // solo para verificar transformacion de json a array
						?>
						<!--<label>Modulos visibles</label>
						<span class="info">Los módulos serán funcionales siempre y cuando esten configurado en la plantilla. Mas información consular a Soporte.</span>
						<div class="cols-container">
							<div class="cols-3-md">
								<label>
									<input type="checkbox" name="modules[post]" value="1" <?php if($array_modules['post']==1) echo "checked" ?> /> Publicaciones
								</label>
								<label>
									<input type="checkbox" name="modules[cat]" value="1" <?php if($array_modules['cat']==1) echo "checked" ?> /> Categorias
								</label>
								<label>
									<input type="checkbox" name="modules[pag]" value="1" <?php if($array_modules['pag']==1) echo "checked" ?> /> Páginas
								</label>
							</div>
							<div class="cols-3-md">
								<label>
									<input type="checkbox" name="modules[com]" value="1" <?php if($array_modules['com']==1) echo "checked" ?> /> Comentarios
								</label>
								<label>
									<input type="checkbox" name="modules[file]" value="1" <?php if($array_modules['file']==1) echo "checked" ?> /> Archivos
								</label>
								<label>
									<input type="checkbox" name="modules[gal]" value="1" <?php if($array_modules['gal']==1) echo "checked" ?> /> Galeria
								</label>
							</div>
								<div class="cols-3-md">
								<label>
									<input type="checkbox" name="modules[usu]" value="1" <?php if($array_modules['usu']==1) echo "checked" ?> /> Usuarios
								</label>
								<label>
									<input type="checkbox" name="modules[mess]" value="1" <?php if($array_modules['mess']==1) echo "checked" ?> /> Mensajes
								</label>
								<label>
									<input type="checkbox" name="modules[men]" value="1" <?php if($array_modules['men']==1) echo "checked" ?> /> Editor de menus
								</label>
							</div>
							<div class="cols-3-md">
							</div>
						</div>
                  		<label>
			                   	Código de formulario de contacto <br />
			                   	<span class="info">
			                   		La ruta del archivo que procesa y envia el mail es <code><?= G_SERVER ?>/rb-script/mailer.v2.php</code>, copia y pega en la atributo <strong>action</strong> del codigo del formulario.
			                   	</span>
			                   	<textarea name="form_code" rows="10"><?= $objOpcion->obtener_valor(1,'form_code') ?></textarea>
			            	</label>-->
			            	<!-- redes -->
        </section>
			</div>
			<div id="sidebar"></div>
			<input name="section" value="opc" type="hidden" />
		</form>
	<?php
	break;
}
?>
