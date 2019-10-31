<?php
while ($row = $qlist->fetch_assoc()):
  $habitacion = get_rows('hotel_habitacion',$row['habitacion_id']);
  $cliente = get_rows('crm_customers',$row['cliente_id']);
  ?>
	<tr>
    <td><?= $row['codigo_unico'] ?></td>
    <td><?= rb_sqldate_to($row['fecha_registro']) ?><br /><?= rb_sqldate_to($row['fecha_registro'],'H:i') ?></td>
    <td><?= $habitacion['numero_habitacion'] ?></td>
    <td><?= $cliente['nombres'] ?> <?= $cliente['apellidos'] ?></td>
    <td>Llegada: <?= rb_sqldate_to($row['fecha_llegada']) ?><br />Salida: <?= rb_sqldate_to($row['fecha_salida']) ?></td>
    <td>
      <?php if($row['estado']==3): ?>
        <a href="<?= G_DIR_MODULES_URL.$module_dir ?>/document.php?reservacion_id=<?= $row['id']?>"><?= estado_habitacion($row['estado']) ?></a>
      <?php else: ?>
        <?= estado_habitacion($row['estado']) ?>
      <?php endif; ?>
    </td>
    <td><?= rb_sqldate_to($row['fecha_ocupado'], 'd-m-Y H:i') ?></td>
    <td><?= rb_sqldate_to($row['fecha_finalizacion'], 'd-m-Y H:i') ?></td>
    <td>S/. <?= $row['total_reservacion'] ?></td>
		<td class="row-actions">
      <a title="Editar" class="edit" data-item="<?= $row['id'] ?>" href="<?= G_SERVER ?>rb-admin/module.php?pag=hotel_reservaciones&res_id=<?= $row['id'] ?>&date=<?= $fecha ?>">
        <i class="fa fa-edit"></i>
      </a>
      <!--<a title="Eliminar" class="del" data-item="<?= $row['id'] ?>" href="#">
        <i class="fa fa-times"></i>
      </a>-->
    </td>
	</tr>
  <?php
endwhile;
?>
