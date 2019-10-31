<?php
if(!isset($_GET['mod'])) die("Ocurrio un problema");
if($_GET["mod"]=="") die("Ocurrio un problema");
if($_GET['mod']=="rd"){
	// ENVIADOS
	$qr = "SELECT m.*, mu.leido, mu.usuario_id, mu.inactivo, mu.retenido FROM ".G_PREFIX."messages m, ".G_PREFIX."messages_users mu
		WHERE m.id = mu.mensaje_id AND mu.usuario_id = ".G_USERID." AND m.id=$id";
	$q = $objDataBase->Ejecutar($qr);
	$row = $q->fetch_assoc();
	// actualizar de mensajes campos leido y fecha lectura
	if($row['leido']==0){
		//$objDataBase->Leido($row['id'], G_USERID);
		$objDataBase->Ejecutar("UPDATE ".G_PREFIX."messages_users SET leido=1, fecha_leido=NOW() WHERE mensaje_id = ".$row['id']." AND usuario_id = ".G_USERID);
	}
}elseif($_GET['mod']=="sd"){
	// RECIBIDOS
	$q = $objDataBase->Ejecutar("SELECT id, asunto, contenido, remitente_id, fecha_envio FROM ".G_PREFIX."messages WHERE remitente_id = ".G_USERID." AND id = $id");
	$row = $q->fetch_assoc();
}
?>
<div class="inside_contenedor_frm">
	<div id="toolbar">
		<div class="inside_toolbar">
			<div class="navigation">
				<a href="<?= G_SERVER ?>rb-admin/?pag=men">Mensajeria</a> <i class="fas fa-angle-right"></i>
        <span><?= $row['asunto'] ?></span>
			</div>
			<?php if($_GET['mod']=="sd"){ ?>
			<a class="button" href="<?= G_SERVER ?>rb-admin/?pag=men&opc=send">Cancelar</a>
			<?php }elseif($_GET['mod']=="rd"){ ?>
			<a class="button" href="<?= G_SERVER ?>rb-admin/?pag=men">Cancelar</a>
			<?php } ?>
		</div>
	</div>
		<section class="seccion">
			<div class="seccion-body">
				<div class="header-message">
	        <h1><?= $row['asunto'] ?></h1>
	        <p><?= rb_sqldate_to($row['fecha_envio'], 'd')?> de <?= rb_mes_nombre(rb_sqldate_to($row['fecha_envio'], 'm'))?>, <?= rb_sqldate_to($row['fecha_envio'], 'Y')?></p>
					<p><?= rb_sqldate_to($row['fecha_envio'], 'H')?>:<?= rb_sqldate_to($row['fecha_envio'], 'i')?> <?= rb_sqldate_to($row['fecha_envio'], 'a') ?></p>
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
						$qm = $objDataBase->Ejecutar("SELECT asunto, contenido FROM ".G_PREFIX."messages WHERE id = ".$message_json['message_id']);
						$rowm = $qm->fetch_assoc();

						$mensaje = "El siguiente mensaje esta esperando aprobacion: <br />
							De: ".$message_json['sender']."<br />
							Para: ".$message_json['receiver']." <br />
							Asunto: ".$rowm['asunto']." <br />
							<pre>".$rowm['contenido']."<br /></pre><br />
							<p>Para aprobar click en el vinculo:<a href='".G_SERVER."rb-admin/core/messages/message-approve.php?message_id=".$message_json['message_id']."&receiver_id=".$message_json['receiver_id']."&this_message_id=".$id."'>Aprobar el mensaje al usuario final</a></p>";

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
