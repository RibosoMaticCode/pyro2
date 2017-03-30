<?php
include 'islogged.php';
$term = $_GET['term'];
require_once(ABSPATH."global.php");

// Requerir las clases de las tablas
require_once(ABSPATH."rb-script/class/rb-articulos.class.php");

// Realizar busqueda en todas las tablas
$objArticulos = new Articulos;
if(G_USERTYPE == "admin"):
	$qPosts = $objArticulos->Consultar("SELECT * FROM articulos WHERE titulo LIKE '%$term%' OR contenido LIKE '%$term%' LIMIT 10");
else:
	$qPosts = $objArticulos->Consultar("SELECT * FROM articulos WHERE autor_id = ".G_USERID."  AND titulo LIKE '%$term%' OR contenido LIKE '%$term%' LIMIT 10");
endif;
$numPosts = mysql_num_rows($qPosts);

$qPages = $objArticulos->Consultar("SELECT * FROM paginas WHERE titulo LIKE '%$term%' OR contenido LIKE '%$term%' LIMIT 10");
$numPages = mysql_num_rows($qPages);

if(G_USERTYPE == "admin"):
	$qFiles = $objArticulos->Consultar("SELECT * FROM photo WHERE src LIKE '%$term%' OR description LIKE '%$term%' LIMIT 10");
else:
	$qFiles = $objArticulos->Consultar("SELECT * FROM photo WHERE usuario_id = ".G_USERID." AND src LIKE '%$term%' OR description LIKE '%$term%' LIMIT 10");
endif;
$numFiles = mysql_num_rows($qFiles);

$qComments = $objArticulos->Consultar("SELECT * FROM comentarios WHERE nombre LIKE '%$term%' OR contenido LIKE '%$term%' OR mail LIKE '%$term%' LIMIT 10");
$numComments = mysql_num_rows($qComments);

$qUsers = $objArticulos->Consultar("SELECT * FROM usuarios WHERE nickname LIKE '%$term%' OR nombres LIKE '%$term%' OR apellidos LIKE '%$term%' OR correo LIKE '%$term%' LIMIT 10");
$numUsers = mysql_num_rows($qUsers);
?>
<h2 class="title">Resultados para: <?= $term ?></h2>
<div class="wrap-content-list">
	<!-- PUBLICACIONES -->
	<h3 class="subtitle">Publicaciones</h3>
	<section class="seccion">
		<table class="tables" border="0" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th>Titulo</th>
					<th>Contenido</th>
					<th>Fecha</th>
				</tr>
			</thead>
			<tbody>
				<?php if( $numPosts == 0): ?>
				<tr>
					<td colspan="3">
						No hay coincidencias
					</td>
				</tr>
				<?php else:?>
				<?php while( $post = mysql_fetch_array($qPosts) ): ?>
				<tr>
					<td><?= $post['titulo'] ?>
						<div class="options">
							<span><a href="../rb-admin/index.php?pag=art&amp;opc=edt&amp;id=<?= $post['id'] ?>">Editar</a></span>
							<span><a href="<?= rb_url_link('art',$post['id']) ?>">Ver</a></span>
						</div>
					</td>
					<td><?= rb_fragment_text($post['contenido'], 30) ?></td>
					<td><?= $post['fecha_creacion'] ?></td>
				</tr>
				<?php endwhile ?>
				<?php endif ?>
			</tbody>
		</table>
	</section>
	<!-- PAGINAS -->
	<?php if(G_USERTYPE == "admin"): ?>
	<h3 class="subtitle">Páginas</h3>
	<section class="seccion">
		<table class="tables" border="0" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th>Titulo</th>
					<th>Contenido</th>
					<th>Fecha</th>
				</tr>
			</thead>
			<tbody>
				<?php if( $numPages == 0): ?>
				<tr>
					<td colspan="3">
						No hay coincidencias
					</td>
				</tr>
				<?php else:?>
				<?php while( $page = mysql_fetch_array($qPages) ): ?>
				<tr>
					<td><?= $page['titulo'] ?>
						<div class="options">
							<span><a href="../rb-admin/index.php?pag=pages&amp;opc=edt&amp;id=<?= $page['id'] ?>">Editar</a></span>
							<span><a href="<?= rb_url_link('pag',$page['id']) ?>">Ver</a></span>
						</div>
					</td>
					<td><?= rb_fragment_text($page['contenido'], 30) ?></td>
					<td><?= $page['fecha_creacion'] ?></td>
				</tr>
				<?php endwhile ?>
				<?php endif ?>
			</tbody>
		</table>
	</section>
	<?php endif ?>
	<!-- ARCHIVOS -->
	<h3 class="subtitle">Archivos</h3>
	<section class="seccion">
		<table class="tables" border="0" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th>Previa</th>
					<th>Nombre Archivo</th>
					<th>Descripción</th>
				</tr>
			</thead>
			<tbody>
				<?php if( $numFiles == 0): ?>
				<tr>
					<td colspan="3">
						No hay coincidencias
					</td>
				</tr>
				<?php else:?>
				<?php while( $file = mysql_fetch_array($qFiles) ): ?>
				<tr>
					<td><img class="image-table" src="../rb-media/gallery/tn/<?= $file['src'] ?>" alt="previa" /></td>
					<td><?= $file['src'] ?>
						<div class="options">
							<span><a href="../rb-admin/index.php?pag=file_edit&amp;opc=edt&amp;id=<?= $file['id'] ?>">Editar</a></span>
						</div>
					</td>
					<td><?= $file['description'] ?></td>
				</tr>
				<?php endwhile ?>
				<?php endif ?>
			</tbody>
		</table>
	</section>
	<!-- COMENTARIOS -->
	<?php if(G_USERTYPE == "admin"): ?>
	<h3 class="subtitle">Comentarios</h3>
	<section class="seccion">
		<table class="tables" border="0" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th>Autor</th>
					<th>Contenido</th>
					<th>Fecha</th>
				</tr>
			</thead>
			<tbody>
				<?php if( $numComments == 0): ?>
				<tr>
					<td colspan="3">
						No hay coincidencias
					</td>
				</tr>
				<?php else:?>
				<?php while( $comment = mysql_fetch_array($qComments) ): ?>
				<tr>
					<td><?= $comment['nombre'] ?>
						<div class="options">
							<span><a href="../rb-admin/index.php?pag=com&amp;opc=edt&amp;id=<?= $comment['id'] ?>">Editar</a></span>
						</div>
					</td>
					<td><?= rb_fragment_text($comment['contenido'], 30) ?></td>
					<td><?= $comment['fecha'] ?></td>
				</tr>
				<?php endwhile ?>
				<?php endif ?>
			</tbody>
		</table>
	</section>
	<?php endif ?>

	<?php if(G_USERTYPE == "admin"): ?>
	<!-- USUARIOS // SOLO SI ES ADMIN SE MUESTRA -->
	<h3 class="subtitle">Usuarios</h3>
	<section class="seccion">
		<table class="tables" border="0" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th>Usuario</th>
					<th>Nombre Completo</th>
					<th>Correo</th>
				</tr>
			</thead>
			<tbody>
				<?php if( $numUsers == 0): ?>
				<tr>
					<td colspan="3">
						No hay coincidencias
					</td>
				</tr>
				<?php else:?>
				<?php while( $user = mysql_fetch_array($qUsers) ): ?>
				<tr>
					<td><?= $user['nickname'] ?>
						<div class="options">
							<span><a href="../rb-admin/index.php?pag=usu&amp;opc=edt&amp;id=<?= $user['id'] ?>">Editar</a></span>
						</div>
					</td>
					<td><?= $user['nombres']." ".$user['apellidos']  ?></td>
					<td><?= $user['correo'] ?></td>
				</tr>
				<?php endwhile ?>
				<?php endif ?>
			</tbody>
		</table>
	</section>
	<?php endif ?>
</div>
