<?php
include 'islogged.php';
$term = $_GET['term'];
require_once(ABSPATH."global.php");

// Requerir las clases de las tablas
require_once(ABSPATH."rb-script/class/rb-database.class.php");

// Realizar busqueda en todas las tablas
if(G_USERTYPE == "admin"):
	$qPosts = $objDataBase->Ejecutar("SELECT * FROM articulos WHERE titulo LIKE '%$term%' OR contenido LIKE '%$term%' LIMIT 10");
else:
	$qPosts = $objDataBase->Ejecutar("SELECT * FROM articulos WHERE autor_id = ".G_USERID."  AND titulo LIKE '%$term%' OR contenido LIKE '%$term%' LIMIT 10");
endif;
$numPosts = $qPosts->num_rows;

$qPages = $objDataBase->Ejecutar("SELECT * FROM paginas WHERE titulo LIKE '%$term%' OR contenido LIKE '%$term%' LIMIT 10");
$numPages = $qPages->num_rows;

if(G_USERTYPE == "admin"):
	$qFiles = $objDataBase->Ejecutar("SELECT * FROM photo WHERE src LIKE '%$term%' OR description LIKE '%$term%' LIMIT 10");
else:
	$qFiles = $objDataBase->Ejecutar("SELECT * FROM photo WHERE usuario_id = ".G_USERID." AND src LIKE '%$term%' OR description LIKE '%$term%' LIMIT 10");
endif;
$numFiles = $qFiles->num_rows;

$qComments = $objDataBase->Ejecutar("SELECT * FROM comentarios WHERE nombre LIKE '%$term%' OR contenido LIKE '%$term%' OR mail LIKE '%$term%' LIMIT 10");
$numComments = $qComments->num_rows;

$qUsers = $objDataBase->Ejecutar("SELECT * FROM usuarios WHERE nickname LIKE '%$term%' OR nombres LIKE '%$term%' OR apellidos LIKE '%$term%' OR correo LIKE '%$term%' LIMIT 10");
$numUsers = $qUsers->num_rows;
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
				<?php while( $post = $qPosts->fetch_assoc() ): ?>
				<tr>
					<td><?= $post['titulo'] ?>
						<div class="options">
							<span><a href="<?= G_SERVER ?>/rb-admin/index.php?pag=art&amp;opc=edt&amp;id=<?= $post['id'] ?>">Editar</a></span>
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
				<?php while( $page = $qPages->fetch_assoc() ): ?>
				<tr>
					<td><?= $page['titulo'] ?>
						<div class="options">
							<span><a href="<?= G_SERVER ?>/rb-admin/index.php?pag=pages&amp;opc=edt&amp;id=<?= $page['id'] ?>">Editar</a></span>
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
				<?php while( $file = $qFiles->fetch_assoc() ): ?>
				<tr>
					<td><img class="image-table" src="<?= G_SERVER ?>/rb-media/gallery/tn/<?= $file['src'] ?>" alt="previa" /></td>
					<td><?= $file['src'] ?>
						<div class="options">
							<span><a href="<?= G_SERVER ?>/rb-admin/index.php?pag=file_edit&amp;opc=edt&amp;id=<?= $file['id'] ?>">Editar</a></span>
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
				<?php while( $comment = $qComments->fetch_assoc() ): ?>
				<tr>
					<td><?= $comment['nombre'] ?>
						<div class="options">
							<span><a href="<?= G_SERVER ?>/rb-admin/index.php?pag=com&amp;opc=edt&amp;id=<?= $comment['id'] ?>">Editar</a></span>
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
				<?php while( $user = $qUsers->fetch_assoc() ): ?>
				<tr>
					<td><?= $user['nickname'] ?>
						<div class="options">
							<span><a href="<?= G_SERVER ?>/rb-admin/index.php?pag=usu&amp;opc=edt&amp;id=<?= $user['id'] ?>">Editar</a></span>
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
