<?php
while ($row = $qlist->fetch_assoc()):
  ?>
	<tr>
        <td><?= $row['fecha_registro'] ?></td>
		<td><?= $row['fecha_envio'] ?></td>
        <?php
        $User = rb_get_user_info($row['sender_id']);
        ?>
        <td><?= $User['nombrecompleto'] ?></td>
		<td><?= crm_customer_fullname($row['customer_id']) ?></td>
        <td>
        <?php
        if($row['enviado']==0){
            ?>
            <a class="send" data-item="<?= $row['id'] ?>" href="#">Enviar</a>
            <?php
        }else{
            ?>
            Enviado
            <?php
        }
        ?>
        </td>
		<td class="row-actions">
            <a title="Editar" class="edit fancyboxFormEditor fancybox.ajax" data-item="<?= $row['id'] ?>" href="<?= G_DIR_MODULES_URL ?>crm/newedit.notification.php?id=<?= $row['id'] ?>">
                <i class="fa fa-edit"></i>
            </a>
            <a title="Eliminar" class="del" data-item="<?= $row['id'] ?>" href="#">
                <i class="fa fa-times"></i>
            </a>
        </td>
	</tr>
  <?php
endwhile;
?>
