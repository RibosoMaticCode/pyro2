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
		$consulta = $objComentario->Ejecutar("SELECT c.*, a.titulo FROM comentarios c, articulos a WHERE a.id = c.articulo_id AND c.id=$id");
		$row= $consulta->fetch_assoc();
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
    /* ---------------- FORMULARIO GRUPO --------------------------- */
    /* ------------------------------------------------------------- */
    case "gru":
        require_once(ABSPATH."rb-script/class/rb-grupos.class.php");
        $mode;
        if(isset($_GET["id"])){
            // if define realice the query
            $id=$_GET["id"];
            $q = $objDataBase->Ejecutar("SELECT * FROM grupos WHERE id=$id");
            $row=$q->fetch_assoc();
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
						$q_user = $objDataBase->Ejecutar("SELECT tipo, id, nickname, nombres, apellidos FROM usuarios WHERE id<>".G_USERID);
						while($r_user = $q_user->fetch_assoc()){
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
