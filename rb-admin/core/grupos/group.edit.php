<?php
require_once(ABSPATH."rb-script/class/rb-users.class.php");
global $objDataBase;
$mode;
if(isset($_GET["id"])){
	$id=$_GET["id"];
	$q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."users_groups WHERE id=".$id);
	$row= $q->fetch_assoc();
	$mode = "update";
}else{
	$mode = "new";
}
?>
<div class="inside_contenedor_frm">
<form id="nivel-form" class="form" method="post" action="<?= G_SERVER?>rb-admin/core/grupos/group.save.php">
	<div id="toolbar">
    <div class="inside_toolbar">
			<div class="navigation">
        <a href="<?= G_SERVER ?>rb-admin/module.php?pag=gru">Grupos</a> <i class="fas fa-angle-right"></i>
        <?php if(isset($row)): ?>
          <span><?= $row['nombre'] ?></span>
        <?php else: ?>
          <span>Nuevo grupo</span>
        <?php endif ?>
      </div>
				<input class="btn-primary" name="guardar" type="submit" value="Guardar" />
				<a class="button" href="?pag=gru">Cancelar</a>
		</div>
	</div>
			<section class="seccion">
				<div class="seccion-body">
					<label>Nombre Grupo:
						<input name="nombre" type="text" value="<?php if(isset($row)) echo $row['nombre'] ?>" required />
					</label>
				</div>
			</section>
	<input name="section" value="nivel" type="hidden" />
	<input name="mode" value="<?php echo $mode ?>" type="hidden" />
	<input name="id" value="<?php if(isset($row)) echo $row['id'] ?>" type="hidden" />
</form>
</div>
