<?php
$result = $objDataBase->Ejecutar("SELECT * FROM articulos"); // Consulta SQl
$total = $result->num_rows; // numero total de registros
$link_section = G_SERVER."/rb-admin/index.php?pag=art"; // Link de retorno
$type = "art"; // valor para listado de combo, de cuantos mostrar por lista
$nums_show = $_COOKIE['user_show_items']; // registro a mostrar almacenado en cookie
$nums_show_list=true; // mostrar combo con lista
$pag_act = isset($_GET['page']) ? $_GET['page'] : 1;
?>
<div class="navs">
	<table>
		<tr>
			<td>
				<div class="pagination">
          <?php rb_paged_list($pag_act, $total, $link_section, $nums_show) ?>
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
			<td><?php echo "<strong>Total: </strong>".$total." registros " ?></td>
		</tr>
	</table>
</div>
