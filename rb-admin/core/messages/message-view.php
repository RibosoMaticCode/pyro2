<?php
if(!isset($_GET['mod'])) die("Ocurrio un problema");
if($_GET["mod"]=="") die("Ocurrio un problema");
if($_GET['mod']=="rd"){
	// ENVIADOS
	// consulta para recibido
	//$q = $objDataBase->Ejecutar("SELECT m.*, u.nombres, u.nickname, mu.leido FROM mensajes m, usuarios u, mensajes_usuarios mu
	//WHERE m.remitente_id = u.id AND m.id = mu.mensaje_id AND mu.usuario_id = ".G_USERID." AND m.id=$id");
	$qr = "SELECT m.*, mu.leido, mu.usuario_id, mu.inactivo, mu.retenido FROM mensajes m, mensajes_usuarios mu
		WHERE m.id = mu.mensaje_id AND mu.usuario_id = ".G_USERID." AND m.id=$id";
	$q = $objDataBase->Ejecutar($qr);
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
						<?php
						if($row['remitente_id']==0){
							$nombres = "Gestor de Contenido";
						}else{
							$Usuario = rb_get_user_info($row['remitente_id']);
							$nombres = $Usuario['nombrecompleto']."(".$Usuario['nickname'].")";
						}
						?>
						<p>De: <strong><?= $nombres ?></strong></p>
	          <hr />
						<?php
						$User = rb_get_user_info(G_USERID);
						?>
	          <p>Para: <strong><?= $User['nombres'] ?> (<?= G_USERNAME ?>)</strong></p>
	        <?php } ?>
				</div>
			<div class="body-message">
        <span id="mensaje" style="display:block;padding-top:10px;padding-bottom:10px;">
					<?php
					if($row['remitente_id']==0){
						$message_json = json_decode($row['contenido'], true);

						// Consultar contenido del mensaje original
						$qm = $objDataBase->Ejecutar("SELECT asunto, contenido FROM mensajes WHERE id = ".$message_json['message_id']);
						$rowm = $qm->fetch_assoc();

						$mensaje = "El siguiente mensaje esta esperando aprobacion: <br />
							De: ".$message_json['sender']."<br />
							Para: ".$message_json['receiver']." <br />
							Asunto: ".$rowm['asunto']." <br />
							<pre>".$rowm['contenido']."<br /></pre><br />
							<p>Para aprobar click en el vinculo:<a href='".G_SERVER."/rb-admin/core/messages/message-approve.php?message_id=".$message_json['message_id']."&receiver_id=".$message_json['receiver_id']."&this_message_id=".$id."'>Aprobar el mensaje al usuario final</a></p>";

						echo $mensaje;
					}else{
						echo stripslashes($row['contenido']);
					}
					?>
        </span>
			</div>
			</div>
		</section>
	</div>
	<div id="sidebar">
	</div>
</div>
