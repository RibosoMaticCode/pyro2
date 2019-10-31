<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funcs.php';

$id=$_GET["id"];

// CONSULTAMOS TODOS LOS DATOS DE ARTICULOS
$q =  $objDataBase->Ejecutar("SELECT * FROM blog_posts WHERE id= $id");
$r = $q->fetch_assoc();

$qr =  $objDataBase->Ejecutar("SELECT id FROM blog_posts WHERE titulo = '".$r['titulo']."'");
$nums = $qr->num_rows;
$new_link =  rb_cambiar_nombre($r['titulo'])."-".$nums;
$campos = [
	'fecha_creacion' => date('Y-m-d G:i:s'),
	'titulo' => $r['titulo'],
	'titulo_enlace' => $new_link,
	'autor_id' => $r['autor_id'],
	'tags' => $r['tags'],
	'contenido' => addslashes($r['contenido']),
	'portada' => $r['portada'],
	'img_back' => $r['img_back'],
	'img_profile' => $r['img_profile']
];
$result = $objDataBase->Insert('blog_posts', $campos);

if( $result['result'] ):
	$ultimo_id = $result['insert_id'];
		// CONSULTAMOS EN CATEGORIAS
	$q =  $objDataBase->Ejecutar("SELECT * FROM blog_posts_categories WHERE articulo_id= $id");
	while($r = $q->fetch_assoc()):
		$objDataBase->Ejecutar("INSERT INTO blog_posts_categories (articulo_id, categoria_id) VALUES ($ultimo_id, ".$r['categoria_id'].")");
	endwhile;
		// CONSULTAMOS EN ARTICULOS ARTICULOS
	$q =  $objDataBase->Ejecutar("SELECT * FROM blog_posts_posts WHERE articulo_id_padre= $id");
	while($r = $q->fetch_assoc()):
		$objDataBase->Ejecutar("INSERT INTO blog_posts_posts (articulo_id_padre, articulo_id_hijo) VALUES ($ultimo_id, ".$r['articulo_id_hijo'].")");
	endwhile;
		// CONSULTAMOS EN TABLA OBJETOS
	$q =  $objDataBase->Ejecutar("SELECT * FROM blog_fields WHERE articulo_id= $id");
	while($r = $q->fetch_assoc()):
		$objDataBase->Ejecutar("INSERT INTO blog_fields (nombre, contenido, tipo, articulo_id) VALUES ('".$r['nombre']."', '".$r['contenido']."', '".$r['tipo']."', $ultimo_id)");
	endwhile;
		$urlreload=G_SERVER.'rb-admin/module.php?pag=rb_blog_pubs';
	header('Location: '.$urlreload);
else:
	echo "Error al intentar duplicar dato: ".$result['error'];
endif;
?>
