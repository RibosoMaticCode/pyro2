<?php
require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$r = $objDataBase->Ejecutar("SELECT * FROM emo_sendfile ORDER BY id DESC");

while ($curr = mysql_fetch_array($r)):
?>
	<tr id="f_<?= $curr['id']?>">
		<td><a target="_blank" href="<?= G_SERVER ?>/customers/files.php?uid=<?= $curr['vinculo_usuario']?>"><?= $curr['vinculo_usuario']?></a></td>
		<td><?= $curr['emisor']?></td>
		<td><?= $curr['destinatarios']?></td>
    <td>
			<ol>
			<?php
			if(strlen($curr['archivos'])>0){
				$arr = json_decode($curr['archivos']);
				foreach ($arr as $key => $value) {
					$q_file = $objDataBase->Ejecutar("SELECT * FROM photo WHERE id =".$value);
					$file = mysql_fetch_array($q_file);
					echo "<li>".utf8_encode($file['src'])."</li>";
				}
			}elseif(strlen($curr['vinculos'])>0){
				$arr = json_decode($curr['vinculos']);
				foreach ($arr as $key => $value) {
					echo "<li>".$value."</li>";
				}
			}else{
				echo "Ninguno :(";
			}
			?>
			</ol>
		</td>
    <td><?= $curr['fecha_envio']?></td>
		<td><a title="Eliminar" class="del-sendfile" data-id="<?= $curr['id'] ?>" style="color:red" href="#">Eliminar</a></td>
	</tr>
<?php
endwhile;
?>
