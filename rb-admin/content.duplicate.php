<?php
//include 'islogged.php';
if(isset($_GET['sec'])){
	require_once("../rb-script/funciones.php");
	require_once("../rb-script/class/rb-database.class.php");
	switch($_GET['sec']){
		case 'art':
			$id=$_GET["id"];

			// CONSULTAMOS TODOS LOS DATOS DE ARTICULOS
			$q =  $objDataBase->Ejecutar("SELECT * FROM articulos WHERE id= $id");
			$r = $q->fetch_assoc();

			$qr =  $objDataBase->Ejecutar("SELECT id FROM articulos WHERE titulo = '".$r['titulo']."'");
			$nums = $qr->num_rows;
			$new_link =  rb_cambiar_nombre($r['titulo'])."-".$nums;
			$campos = [
				'fecha_creacion' => date('Y-m-d G:i:s'),
				'titulo' => $r['titulo'],
				'titulo_enlace' => $new_link,
				'autor_id' => $r['autor_id'],
				'tags' => $r['tags'],
				'contenido' => addslashes($r['contenido']),
				'video' => $r['video'],
				'video_embed' => $r['video_embed'],
				'portada' => $r['portada'],
				'actividad' => $r['actividad'],
				'fecha_actividad' => '0000-00-00',
				'img_back' => $r['img_back'],
				'img_profile' => $r['img_profile']
			];
			//$result = $objDataBase->Insertar("INSERT INTO articulos (fecha_creacion, titulo, titulo_enlace, autor_id, tags, contenido, portada,, actividad, fecha_actividad, video, video_embed, galeria_id) VALUES ( NOW() ,'".$campos[0]."','".$campos[1]."',".$campos[2].",'".$campos[3]."','".$campos[4]."',".$campos[5].",'".$campos[6]."',".$campos[7].",'".$campos[8]."',".$campos[9].",'".$campos[10]."',".$campos[11].")");
			$result = $objDataBase->Insert('articulos', $campos);

			if( $result['result'] ):
				$ultimo_id = $result['insert_id'];

				// CONSULTAMOS EN CATEGORIAS
				$q =  $objDataBase->Ejecutar("SELECT * FROM articulos_categorias WHERE articulo_id= $id");
				while($r = $q->fetch_assoc()):
					$objDataBase->Ejecutar("INSERT INTO articulos_categorias (articulo_id, categoria_id) VALUES ($ultimo_id, ".$r['categoria_id'].")");
				endwhile;

				// CONSULTAMOS EN ALBUMS
				$q =  $objDataBase->Ejecutar("SELECT * FROM articulos_albums WHERE articulo_id= $id");
				while($r = $q->fetch_assoc()):
					$objDataBase->Ejecutar("INSERT INTO articulos_albums (articulo_id, album_id) VALUES ($ultimo_id, ".$r['album_id'].")");
				endwhile;

				// CONSULTAMOS EN ARTICULOS ARTICULOS
				$q =  $objDataBase->Ejecutar("SELECT * FROM articulos_articulos WHERE articulo_id_padre= $id");
				while($r = $q->fetch_assoc()):
					$objDataBase->Ejecutar("INSERT INTO articulos_articulos (articulo_id_padre, articulo_id_hijo) VALUES ($ultimo_id, ".$r['articulo_id_hijo'].")");
				endwhile;

				// CONSULTAMOS EN TABLA OBJETOS
				$q =  $objDataBase->Ejecutar("SELECT * FROM objetos WHERE articulo_id= $id");
				while($r = $q->fetch_assoc()):
					$objDataBase->Ejecutar("INSERT INTO objetos (nombre, contenido, tipo, articulo_id) VALUES ('".$r['nombre']."', '".$r['contenido']."', '".$r['tipo']."', $ultimo_id)");
				endwhile;

				$urlreload='../rb-admin/index.php?pag=art';
				header('Location: '.$urlreload);
			else:
				echo "Error al intentar duplicar dato.";
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

			$campos = [
				'fecha_creacion' => date('Y-m-d G:i:s'),
				'titulo'=> $r['titulo'],
				'titulo_enlace'=> $new_link,
				'autor_id'=> $r['autor_id'],
				'tags'=> $r['tags'],
				'contenido'=> $r['contenido'],
				'type'=> $r['type'],
				'description'=> $r['description'],
				'show_header' => $r['show_header'],
				'header_custom_id' => $r['header_custom_id'],
				'show_footer' => $r['show_footer'],
				'footer_custom_id' => $r['footer_custom_id']
			];

			$row = $objDataBase->Insert( 'paginas', $campos );
			if($row['result']):
				//echo $row['insert_id'];
				$urlreload='../rb-admin/index.php?pag=pages';
				header('Location: '.$urlreload);
			else:
				echo $row['error'];
				//echo "Error al intentar duplicar.";
			endif;
		break;
	}
}
?>
