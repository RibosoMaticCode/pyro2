<?php
$regMostrar = $_COOKIE['user_show_items'];

$colOrder = "id"; // column name table
$Ord = "DESC"; // A-Z

$key_web = rb_get_values_options('key_web'); // podria ser key de la sesion de usuario

$result = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."users ORDER BY $colOrder $Ord");
while ( $row = $result->fetch_assoc() ):
  $nivel = rb_shownivelname($row['tipo']);
  ?>
  <tr>
    <td>
      <input id="user-<?= $row['id'] ?>" type="checkbox" value="<?= $row['id'] ?>" name="items" data-userkey="<?= $row['user_key'] ?>" data-userid="<?= rb_encrypt_decrypt("encrypt", $row['id'], $row['user_key'], $key_web) ?>" />
    </td>
    <td><?= $row['nickname'] ?></td>
    <td>
      <?= $row['nombres'] ?> <?= $row['apellidos'] ?>

    </td>
    <td><?= $row['correo'] ?></td>
    <td><?= $nivel ?></td>
    <td><?= rb_sqldate_to($row['fecharegistro'], 'd')?> de <?= rb_mes_nombre(rb_sqldate_to($row['fecharegistro'], 'm'))?>, <?= rb_sqldate_to($row['fecharegistro'], 'Y')?></td>
    <td><?= rb_sqldate_to($row['ultimoacceso'], 'd')?> de <?= rb_mes_nombre(rb_sqldate_to($row['ultimoacceso'], 'm'))?>, <?= rb_sqldate_to($row['ultimoacceso'], 'Y')?></td>
    <td>
      <?php
      if($row['activo']==0) echo '<a href="'.G_SERVER.'rb-admin/core/users/user-active.php?id='.$row['id'].'">¿Activar?</a>';
      else echo "Activo";
      ?>
    </td>
    <td class="row-actions">
      <a title="Editar" class="edit" href="<?= G_SERVER ?>rb-admin/index.php?pag=usu&opc=edt&id=<?= $row['id'] ?>"><i class="fa fa-edit"></i></a>
      <a style="color:red" class="del fancyboxForm fancybox.ajax" href="<?= G_SERVER ?>rb-admin/core/users/user.del.auth.php?user_key=<?= $row['user_key'] ?>&user_id=<?= rb_encrypt_decrypt("encrypt", $row['id'], $row['user_key'], $key_web) ?>"
        title="Eliminar la cuenta"><i class="fa fa-times"></i></a>
    </td>
  </tr>
<?php
endwhile;
?>
