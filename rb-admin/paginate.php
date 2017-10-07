<?php
//include 'islogged.php';
require_once("../global.php");
if(!isset($sec)){
	$sec = $_GET['sec'];
}
switch($sec){
	case "com":
		require_once("../rb-script/class/rb-database.class.php");

		if(isset($_GET['term'])){
			//$numrows = $objDataBase->search($_GET['term'],true);
			//$func_to_use = "Search";
		}else{
			$q = $objDataBase->Ejecutar("select id from comentarios");
			$numrows = $q->num_rows;
			$func_to_use = "Consult";
		}
		$type = "com";
		$nums_show = $_COOKIE['com_show_items'];
		$nums_show_list=true;
	break;
	case "menus":
		die();
	break;
	case "menu":
		die();
	break;
}

$total=$numrows;
// parte 1: definimos regitros iniciales
if(isset($_GET['page']) && ($_GET['page']>0)){
	$reg_ini=($_GET['page']-1)*$nums_show;
	$reg_fin=$reg_ini+$nums_show;
	$pag_act=$_GET['page'];
//caso contrario los iniciamos
}else{
	$reg_ini=0;
	$reg_fin=$reg_ini+$nums_show;
	$pag_act=1;
}

//parte 2: determinar numero de paginas
$pag_ini = 1;
$pag_ant=$pag_act-1;
$pag_sig=$pag_act+1;
$pag_ult=$total/$nums_show;
$residuo=$total%$nums_show;
if($residuo>0) $pag_ult=floor($pag_ult)+1;

//parte 3: navegacion
?>
<div class="navs">
	<table>
		<tr>
			<td>
				<div class="pagination">
					<ul>
					<?php
					if($pag_act>1){	?>
					    <?php if($func_to_use == "Search"){ // Revisar Busqueda ?>
					    <li><a href="?term=<?php echo urlencode($_GET['term']) ?>&amp;pag=<?= $type ?>&page=<?= $pag_ant?>">Anterior</a></li>
					    <?php } ?>

					    <?php if($func_to_use == "Consult"){ ?>
						<li><a href="<?= $link_section ?>">«</a></li> <!-- siempre sera 1 -->
						<li><a href="<?= $link_section ?><?php if($pag_ant>1): ?>&page=<?= $pag_ant?> <?php endif ?>">‹</a></li>
						<?php } ?>
					<?php
					}else{?>
						<li class="page-disabled"><a class="pbutton previous">«</a></li>
						<li class="page-disabled"><a class="pbutton previous">‹</a></li>
					<?php
					}
					?>
					<li>
						<span class="page-info">
						Pagina <?= $pag_act ?> <?php if ($pag_ult > 0) ?> de <?= $pag_ult ?>
						</span>
					</li>
					<?php
					if($pag_act<$pag_ult) {?>
						<?php if($func_to_use == "Search"){ // Revisar Busqueda ?>
							<li><a href="?term=<?= urlencode($_GET['term']) ?>&amp;pag=<?= $type ?>&page=<?= $pag_sig?>">Siguiente</a></li>
						<?php } ?>

						<?php if($func_to_use == "Consult"){ ?>
							<li><a href="<?= $link_section ?>&page=<?= $pag_sig?>">›</a></li>
							<li><a href="<?= $link_section ?>&page=<?= $pag_ult?>">»</a></li>
						<?php } ?>

						<?php
					}else{?>
						<li class="page-disabled"><a class="pbutton next">›</a></li>
						<li class="page-disabled"><a class="pbutton next">»</a></li>
					<?php
					}
					?>
					</ul>
				</div>
			</td>
			<?php if($nums_show_list): ?>
			<td><strong>Mostrar:</strong>
				<select onchange="change_items_show()" id="nums_items_show" name="<?= $type?>">
					<option <?php if($nums_show==25) echo "selected"?> value="25">25</option>
					<option <?php if($nums_show==50) echo "selected"?> value="50">50</option>
					<option <?php if($nums_show==100) echo "selected"?> value="100">100</option>
				</select>
			</td>
			<?php endif; ?>
			<td><?php echo "<strong>Total: </strong>".$numrows." registros " ?></td>
		</tr>
	</table>
</div>
