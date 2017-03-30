<?php
require_once(ABSPATH."rb-script/class/rb-usuarios.class.php");
$mode;
if(isset($_GET["id"])){
	$id=$_GET["id"];
	$q = $objUsuario->Consultar("SELECT * FROM usuarios_niveles WHERE id=$id");
	$row=mysql_fetch_array($q);
	$mode = "update";
}else{
	$mode = "new";
}
?>
<form id="nivel-form" method="post" action="../rb-admin/core/niveles/niveles.save.php">
	<div id="toolbar">
       	<div id="toolbar-buttons">
			<span class="post-submit">
				<input class="submit" name="guardar" type="submit" value="Guardar" />
				<a href="?pag=nivel"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>
			</span>
		</div>
	</div>
	<div>
		<div class="content-edit">
			<section class="seccion">
				<div class="seccion-body">
					<label>Nombre:
						<input name="nombre" type="text" value="<?php if(isset($row)) echo $row['nombre'] ?>" required />
					</label>
					<label>Nombre clave:
						<!--<input name="enlace" type="text" value="" required />-->
						<select name="enlace">
							<option <?php if(isset($row) && $row['nivel_enlace']=="admin") echo " selected " ?> value="admin">admin - acceso a todo el panel adminstrativo</option>
							<option <?php if(isset($row) && $row['nivel_enlace']=="user-panel") echo " selected " ?> value="user-panel">user-panel - acceso al panel administrativo, salvo que no puede configurar el sitio ni gestionar usuarios</option>
							<option <?php if(isset($row) && $row['nivel_enlace']=="user-front") echo " selected " ?> value="user-front">user-front - acceso solo al fron-end (plantilla)</option>
						</select>
					</label>
					<label>Detalles:
						<textarea name="permisos"><?php if(isset($row)) echo $row['permisos'] ?></textarea>
					</label>
				</div>
			</section>
		</div>
		<div id="sidebar"></div>
	</div>
	<input name="section" value="nivel" type="hidden" />
	<input name="mode" value="<?php echo $mode ?>" type="hidden" />
	<input name="id" value="<?php if(isset($row)) echo $row['id'] ?>" type="hidden" />
</form>
