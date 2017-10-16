<?php
if(!isset($_GET['mod'])) die("Ocurrio un problema");
if($_GET["mod"]=="") die("Ocurrio un problema");
if($_GET['mod']=="rd"){
	// ENVIADOS
	// consulta para recibido
	$q = $objDataBase->Ejecutar("SELECT m.*, u.nombres, u.nickname, mu.leido FROM mensajes m, usuarios u, mensajes_usuarios mu WHERE m.remitente_id = u.id AND m.id = mu.mensaje_id AND mu.usuario_id = ".G_USERID." AND m.id=$id");
	$row = $q->fetch_assoc();
	// actualizar de mensajes campos leido y fecha lectura
	if($row['leido']==0){
		//$objDataBase->Leido($row['id'], G_USERID);
		$objDataBase->Ejecutar("UPDATE mensajes_usuarios SET leido=1, fecha_leido=NOW() WHERE mensaje_id = ".$row['id']." AND usuario_id = ".G_USERID);
	}
}elseif($_GET['mod']=="sd"){
	// RECIBIDOS
	$q = $objDataBase->Ejecutar("SELECT id, asunto, contenido, remitente_id, fecha_envio FROM mensajes WHERE remitente_id = ".G_USERID." AND id = $id");
	$row = $q->fetch_assoc();
}
?>
<div id="toolbar">
   	<div id="toolbar-buttons">
		<span class="post-submit">
			<?php if($_GET['mod']=="sd"){ ?>
			<a href="<?= G_SERVER ?>/rb-admin/?pag=men&opc=send"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>
			<?php }elseif($_GET['mod']=="rd"){ ?>
			<a href="<?= G_SERVER ?>/rb-admin/?pag=men"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>
			<?php } ?>
		</span>
	</div>
</div>
<div>
	<div class="content-edit">
		<section class="seccion">
			<div class="seccion-body">
				<div class="header-message">
	        <h1><?= $row['asunto'] ?></h1>
	        <p>(<?= $row['fecha_envio'] ?>)</p>
	        <?php if($_GET['mod']=="sd"){ ?>
						<?php
						$User = rb_get_user_info(G_USERID);
						?>
						<p>De: <strong><?= $User['nombres'] ?> (<?= G_USERNAME ?>)</strong></p>
	          <hr />
	          <p>Para:
	          <?php
						$coma = "";
						$q = $objUsuario->destinatarios_del_mensaje($id);
						while($r = $q->fetch_assoc()){
							echo "<strong>".$coma.$r['nombres']." (".$r['nickname'].")</strong>";
							$coma=", ";
						}
	          ?>
	          </p>
					<?php }elseif($_GET['mod']=="rd"){ ?>
						<p>De: <strong><?= $row['nombres'] ?> (<?= $row['nickname'] ?>)</strong></p>
	          <hr />
						<?php
						$User = rb_get_user_info(G_USERID);
						?>
	          <p>Para: <strong><?= $User['nombres'] ?> (<?= G_USERNAME ?>)</strong></p>
	        <?php } ?>
				</div>
			<div class="body-message">
        <span id="mensaje" style="display:block;padding-top:10px;padding-bottom:10px;">
        <?= stripslashes($row['contenido']) ?>
        </span>
			</div>
			</div>
		</section>
	</div>
	<div id="sidebar">
	</div>
</div>
