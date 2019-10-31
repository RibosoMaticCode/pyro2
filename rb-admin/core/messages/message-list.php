<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH."rb-script/class/rb-database.class.php");

if(isset($_GET['opc'])){
  // ENVIADOS
  if($_GET['opc'] == "send"){
    $result = $objDataBase->Ejecutar("SELECT id, asunto, fecha_envio, inactivo FROM ".G_PREFIX."messages WHERE remitente_id = ".G_USERID." AND inactivo = 0 ORDER BY fecha_envio DESC LIMIT 10");
  }
}else{
  // RECIBIDOS
	$q = "SELECT m.id, m.remitente_id, m.asunto, mu.leido, m.fecha_envio, mu.usuario_id, mu.inactivo, mu.retenido FROM ".G_PREFIX."messages m, ".G_PREFIX."messages_users mu
		WHERE m.id = mu.mensaje_id AND mu.usuario_id = ".G_USERID." AND mu.inactivo=0 AND mu.retenido=0 ORDER BY fecha_envio DESC";
	$result = $objDataBase->Ejecutar( $q );

	//echo G_USERTYPE;
}
while ($row = $result->fetch_assoc()){
  $style = "";
  $mod = "";
  // si estamos en la opcion de enviados
  if(isset($_GET['opc']) && $_GET['opc'] == "send"){
    $style = "";
    $mod = "sd"; //send
  }else{
  // si estamos en la opcion de recibidos
    $style = "";
    if($row['leido']==0){
      $style = 'style="font-weight:bold"';
    }
    $mod = "rd"; //received
  }?>
  <tr <?= $style ?>>
		<td>
      <input id="message-<?= $row['id'] ?>" type="checkbox" value="<?= $row['id'] ?>" name="items" data-mode="<?= $mod ?>" data-uid="<?= G_USERID ?>" />
    </td>
		<td>
			<a href="?pag=men&opc=view&mod=<?= $mod ?>&id=<?= $row['id'] ?>"><?= $row['asunto'] ?></a>
		</td>
		<?php
	  if(isset($_GET['opc']) && $_GET['opc'] == "send"){
			?>
	    <td>
			<?php
	    $coma = "";
	    $q = $objUsuario->destinatarios_del_mensaje($row['id']);
	    while($r = $q->fetch_assoc()){
	      echo $coma.$r['nombres'];
	      $coma=", ";
	    }
	    ?>
			</td>
			<?php
	  }else{
			?>
	    <td>
				<?php
				if($row['remitente_id']==0){
					echo "Gestor de Contenido ";
				}else{
					$Usuario = rb_get_user_info($row['remitente_id']);
					if($Usuario) echo $Usuario['nombrecompleto'];
					else echo 'Este usuario ya no existe';
				}
				?>
			</td>
			<?php
	  }
		?>
	  <td><?= rb_sqldate_to($row['fecha_envio'], 'd')?> de <?= rb_mes_nombre(rb_sqldate_to($row['fecha_envio'], 'm'))?>, <?= rb_sqldate_to($row['fecha_envio'], 'Y')?></td>
	  <td class="row-actions">
			<a href="#" title="Eliminar" class="del del-item" data-id="<?= $row['id'] ?>" data-mode="<?= $mod ?>" data-uid="<?= G_USERID ?>">
				<i class="fa fa-times"></i>
			</a>
	  </td>
	</tr>
<?php
}
?>
