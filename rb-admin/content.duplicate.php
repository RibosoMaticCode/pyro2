<?php
//include 'islogged.php';
if(isset($_GET['sec'])){
	require_once("../rb-script/funciones.php");
	require_once("../rb-script/class/rb-database.class.php");
	switch($_GET['sec']){
		case 'art':
			$id=$_GET["id"];

			// CONSULTAMOS TODOS LOS DATOS DE ARTICULOS
			$q =  $objArticulo->Ejecutar("SELECT * FROM articulos WHERE id= $id");
			$r = mysql_fetch_array($q);

			$qr =  $objArticulo->Ejecutar("SELECT id FROM articulos WHERE titulo = '".$r['titulo']."'");
			$nums = mysql_num_rows($qr);
			$new_link =  rb_cambiar_nombre($r['titulo'])."-".$nums;

			if($objArticulo->Insertar(array( $r['titulo'] , $new_link , $r['autor_id'] ,  $r['tags'] ,  addslashes($r['contenido']) , $r['portada'] , $r['img_portada'] , $r['actividad'] , '0000-00-00' , $r['video'] , $r['video_embed'] ,  $r['galeria_id'] ))):
				$ultimo_id = mysql_insert_id();

				// CONSULTAMOS EN CATEGORIAS
				$q =  $objArticulo->Ejecutar("SELECT * FROM articulos_categorias WHERE articulo_id= $id");
				while($r = mysql_fetch_array($q)):
					$objArticulo->Ejecutar("INSERT INTO articulos_categorias (articulo_id, categoria_id) VALUES ($ultimo_id, ".$r['categoria_id'].")");
				endwhile;

				// CONSULTAMOS EN ALBUMS
				$q =  $objArticulo->Ejecutar("SELECT * FROM articulos_albums WHERE articulo_id= $id");
				while($r = mysql_fetch_array($q)):
					$objArticulo->Ejecutar("INSERT INTO articulos_albums (articulo_id, album_id) VALUES ($ultimo_id, ".$r['album_id'].")");
				endwhile;

				// CONSULTAMOS EN ARTICULOS ARTICULOS
				$q =  $objArticulo->Ejecutar("SELECT * FROM articulos_articulos WHERE articulo_id_padre= $id");
				while($r = mysql_fetch_array($q)):
					$objArticulo->Ejecutar("INSERT INTO articulos_articulos (articulo_id_padre, articulo_id_hijo) VALUES ($ultimo_id, ".$r['articulo_id_hijo'].")");
				endwhile;

				// CONSULTAMOS EN TABLA OBJETOS
				$q =  $objArticulo->Ejecutar("SELECT * FROM objetos WHERE articulo_id= $id");
				while($r = mysql_fetch_array($q)):
					$objArticulo->Ejecutar("INSERT INTO objetos (nombre, contenido, tipo, articulo_id) VALUES ('".$r['nombre']."', '".$r['contenido']."', '".$r['tipo']."', $ultimo_id)");
				endwhile;

				$urlreload='../rb-admin/index.php?pag=art';
				header('Location: '.$urlreload);
			else:
				echo "Error al duplicar dato.";
			endif;
		break;

		case 'pages':
			$id=$_GET["id"];

			// CONSULTAMOS TODOS LOS DATOS DE ARTICULOS
			$q =  $objDataBase->Ejecutar("SELECT * FROM paginas WHERE id= $id");
			$r = $q->fetch_assoc();

			$qr =  $objDataBase->Ejecutar("SELECT id FROM paginas WHERE titulo = '".$r['titulo']."'");
			$nums = $qr->num_rows;
			$new_link =  rb_cambiar_nombre($r['titulo'])."-".$nums;

			//INSERT INTO paginas (fecha_creacion, titulo, titulo_enlace, autor_id, tags, contenido, sidebar, popup, galeria_id, addon)

			$campos = array( $r['titulo'] , $new_link , $r['autor_id'] ,  $r['tags'] ,  $r['contenido'] , $r['sidebar'] , $r['popup'] , $r['galeria_id'] , $r['addon'] );

			if( $objDataBase->Ejecutar( "INSERT INTO paginas (fecha_creacion, titulo, titulo_enlace, autor_id, tags, contenido, sidebar, popup, galeria_id, addon) VALUES ( NOW() ,'".$campos[0]."','".$campos[1]."',".$campos[2].",'".$campos[3]."','".$campos[4]."',".$campos[5].",".$campos[6].",".$campos[7].",'".$campos[8]."')" ) ):
				//$ultimo_id = mysql_insert_id();
				$urlreload='../rb-admin/index.php?pag=pages';
				header('Location: '.$urlreload);
			endif;
		break;
	}
}
?>
