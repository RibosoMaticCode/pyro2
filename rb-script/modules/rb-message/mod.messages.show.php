<?php
if(!isset($_GET['mod'])) die("Ocurrio un problema");
if($_GET["mod"]=="") die("Ocurrio un problema");

if($_GET['mod']=="rd"){
	// ENVIADOS 
			
	// consulta para recibido
	$q = $objMensaje->Consultar("SELECT m.*, u.nombres, u.nickname, mu.leido FROM mensajes m, usuarios u, mensajes_usuarios mu WHERE m.remitente_id = u.id AND m.id = mu.mensaje_id AND mu.usuario_id = ".G_USERID." AND m.id=$id");	
	$row = mysql_fetch_array($q);
			
	// actualizar de mensajes campos leido y fecha lectura
	if($row['leido']==0){
		$objMensaje->Leido($row['id'], G_USERID);
	}
	
}elseif($_GET['mod']=="sd"){
	// RECIBIDOS
	$q = $objMensaje->Consultar("SELECT id, asunto, contenido, remitente_id, fecha_envio FROM mensajes WHERE remitente_id = ".G_USERID." AND id = $id");
	$row = mysql_fetch_array($q);
}
?>
<div id="toolbar">
   	<div id="toolbar-buttons">
		<span class="post-submit">
			<?php if($_GET['mod']=="sd"){ ?>
			<a href="../rb-admin/?pag=men&opc=send"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>
			<!--<input title="Volver" class="button" name="cancelar" type="button" value="Enviados" onclick="rb_cancel('men&opc=send')" />-->
			<?php }elseif($_GET['mod']=="rd"){ ?>
			<a href="../rb-admin/?pag=men"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>
			<!--<input title="Volver" class="button" name="cancelar" type="button" value="Recibidos" onclick="rb_cancel('men')" />-->
			<?php } ?>
		</span>
	</div>
</div>
<div>
	<div class="content-edit">
		<section class="seccion">
			<div class="seccion-body">
			<div class="header-message">
                <h1><?php echo $row['asunto'] ?></h1>
                <p>(<?php echo $row['fecha_envio'] ?>)</p>
                
                <?php if($_GET['mod']=="sd"){ ?>
                
                <p>De: <strong><?php echo G_USERNAME ?></strong></p>
                <hr />
                <p>Para: 
                <?php
				$coma = "";
				$q = $objUsuario->destinatarios_del_mensaje($id);
				while($r = mysql_fetch_array($q)){
					echo "<strong>".$coma.$r['nombres']." (".$r['nickname'].")</strong>";
					$coma=", ";
				}
                ?>
                </p>
                
                <?php }elseif($_GET['mod']=="rd"){ ?>
                
                <p>De: <strong><?php echo $row['nombres'] ?> (<?php echo $row['nickname'] ?>)</strong></p>
                <hr />
                <p>Para: <strong><?php echo G_USERNAME ?></strong></p>
                <?php } ?> 
			</div>
            
			<div class="body-message">
                <span id="mensaje" style="display:block;padding-top:10px;padding-bottom:10px;">
                <?php echo stripslashes($row['contenido']) ?>
                </span> 
			</div>
			</div>
		</section>            
	</div>
	<div id="sidebar">
	</div>
</div>
