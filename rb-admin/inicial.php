<?php
include 'islogged.php';
// Requerir las clases de las tablas
require_once(ABSPATH."rb-script/class/rb-articulos.class.php");
require_once(ABSPATH."rb-script/class/rb-log.class.php");
$qLog = $objLog->Consultar("SELECT * FROM log ORDER BY id DESC LIMIT 10");

$objArticulos = new Articulos;
$qPosts = $objArticulos->Consultar("SELECT id FROM articulos");
$numPosts = mysql_num_rows($qPosts);

$qPages = $objArticulos->Consultar("SELECT id FROM paginas");
$numPages = mysql_num_rows($qPages);

$qFiles = $objArticulos->Consultar("SELECT id FROM photo");
$numFiles = mysql_num_rows($qFiles);

$qComments = $objArticulos->Consultar("SELECT id FROM comentarios");
$numComments = mysql_num_rows($qComments);

$qUsers = $objArticulos->Consultar("SELECT id FROM usuarios");
$numUsers = mysql_num_rows($qUsers);

$qCategories = $objArticulos->Consultar("SELECT id FROM categorias");
$numCategories = mysql_num_rows($qCategories);

// Tamaño de base datos
$sql = "SHOW TABLE STATUS";
$resultado = mysql_query($sql) or die(mysql_error());
$total = 0;
while ($tabla = mysql_fetch_assoc($resultado))
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
					<?php while ($log = mysql_fetch_array($qLog)): ?>
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
					include_once ABSPATH.'rb-script/modules/rb-uploadimg/mod.uploadimg.php';
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
