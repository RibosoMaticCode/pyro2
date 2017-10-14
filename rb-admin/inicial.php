<?php
include 'islogged.php';
// Requerir las clases de las tablas
//require_once(ABSPATH."rb-script/class/rb-articulos.class.php");
require_once(ABSPATH."rb-script/class/rb-database.class.php");
$qLog = $objDataBase->Ejecutar("SELECT * FROM log ORDER BY id DESC LIMIT 10");

//$objArticulos = new Articulos;
$qPosts = $objDataBase->Ejecutar("SELECT id FROM articulos");
$numPosts = $qPosts->num_rows;

$qPages = $objDataBase->Ejecutar("SELECT id FROM paginas");
$numPages = $qPages->num_rows;

$qFiles = $objDataBase->Ejecutar("SELECT id FROM photo");
$numFiles = $qFiles->num_rows;

$qComments = $objDataBase->Ejecutar("SELECT id FROM comentarios");
$numComments = $qComments->num_rows;

$qUsers = $objDataBase->Ejecutar("SELECT id FROM usuarios");
$numUsers = $qUsers->num_rows;

$qCategories = $objDataBase->Ejecutar("SELECT id FROM categorias");
$numCategories = $qCategories->num_rows;

// Tamaño de base datos
$sql = "SHOW TABLE STATUS";
$resultado = $objDataBase->Ejecutar($sql);// or die(mysql_error());
$total = 0;
while ($tabla = $resultado->fetch_assoc())
	$total += ($tabla['Data_length']+$tabla['Index_length']);

$size_db = round($total/1024,2)." KB";
?>
<div class="wrap-home">
<h2>Bienvenido</h2>
<?php
if(isset($_SESSION['type'])){
	// acceso no administrador
	if($_SESSION['type']!="admin"):
	?>
	<p>Esta seccion permite la edición de su contenido el el sitio web.</p>

	<div class="cols-container">
		<div class="cols-4-lg colInicial">
			<section class="seccion">
				<div class="seccion-header">
					<h3>Accesos directos</h3>
				</div>
				<div class="seccion-body">
					<p>
						<a class="btn-primary" href="?pag=art&opc=nvo">Nueva publicación</a>
					</p>
					<p>
						<a class="btn-primary" href="?pag=gal&opc=nvo">Nueva galería</a>
					</p>
					<p>
						<a class="btn-primary" href="?pag=men&opc=nvo">Nueva mensaje</a>
					</p>
				</div>
			</section>
		</div>
		<div class="cols-4-lg colInicial">
			<section class="seccion">
				<div class="seccion-header">
					<h3>Subir archivos</h3>
				</div>
				<div class="seccion-body">
					<?php
					include_once '../rb-script/modules/rb-uploadimg/mod.uploadimg.php';
					?>
				</div>
			</section>
		</div>
		<div class="cols-4-lg"></div>
	</div>
	<?php
	endif;
	// acceso administrador
	if($_SESSION['type']=="admin"):
	?>
	<p>Esta seccion permite la administracion del contenido del sitio web.</p>
	<p>Solo los usuarios con acceso de Administrador puede ver este contenido.</p>
	<div class="cols-container">
		<div class="cols-4-lg colInicial">
			<section class="seccion">
				<div class="seccion-header">
					<h3>Registro de procesos</h3>
				</div>
				<div class="seccion-body">
					<table width="100%;">
					<?php while ($log = $qLog->fetch_assoc()): ?>
						<tr>
							<td><?= $log['usuario'] ?></td>
							<td><?= $log['fecha'] ?></td>
							<td><?= $log['observacion'] ?></td>
						</tr>
					<?php endwhile ?>
					</table>
				</div>
			</section>
		</div>
		<div class="cols-4-lg colInicial">
			<section class="seccion">
				<div class="seccion-header">
					<h3>Estadisticas</h3>
				</div>
				<div class="seccion-body">
					<p>Publicaciones (<?= $numPosts ?>)</p>
					<p>Páginas (<?= $numPages ?>)</p>
					<p>Archivos (<?= $numFiles ?>)</p>
					<p>Comentarios (<?= $numComments ?>)</p>
					<p>Usuarios (<?= $numUsers ?>)</p>
					<p>Categorias (<?= $numCategories ?>)</p>
					<p>Tamaño de base de datos: <strong><?= $size_db ?></strong></p>
				</div>
			</section>
		</div>
		<div class="cols-4-lg colInicial">
			<section class="seccion">
				<div class="seccion-header">
					<h3>Accesos Directos</h3>
				</div>
				<div class="seccion-body">
					<p>
						<a class="btn-primary" href="?pag=art&opc=nvo">Nueva publicación</a>
					</p>
					<p>
						<a class="btn-primary" href="?pag=pages&opc=nvo">Nueva página</a>
					</p>
					<p>
						<a class="btn-primary" href="?pag=usu&opc=nvo">Nuevo usuario</a>
					</p>
					<h4>Subir archivo</h4>
					<?php
					include_once ABSPATH.'rb-admin/plugin-form-uploader.php';
					?>
				</div>
			</section>
		</div>
	</div>

	<?php
	endif;
}
?>
</div>
