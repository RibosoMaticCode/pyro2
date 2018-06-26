<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

$volver = "false";
if (isset($_POST['guardar_volver'])) {
  $volver = "true";
}

$mode=$_POST['mode'];
    // portada
    if(isset($_POST['featured'])) $port = "1";
    else $port = "0";
		// Categoria
		if(!isset($_REQUEST['categoria'])) {
			print "[!] Debe seleccionar una categoria ... !!!";
			die();
		}
		$array_categorias = $_REQUEST['categoria'];
		// Albums
		$albums = 1;
		if(!isset($_REQUEST['albums'])) {
			$albums = 0; // ningun album seleccionado
		}else{
			$array_albums = $_REQUEST['albums'];
		}
		// Titulo del articulo
		//$tit=stripslashes(htmlspecialchars($_POST['titulo'])); // grabar en base de datos limpiando el texto || mejor que ir colocando funcion cada vez q se llame al campo
		$tit=addslashes(htmlspecialchars($_POST['titulo'])); // addslashes->Escapa comillas de las expresiones
		if(empty($tit)) {print "[-] Debe proporcionar un titulo al post ... !!!"; die ();}
		// Enlace
		$tit_id=$_POST['titulo_enlace'];
		if(empty($tit_id)){
			//strip_tags — Retira las etiquetas HTML y PHP de un string
			$tit_id = rb_cambiar_nombre(strip_tags(utf8_encode($_POST['titulo'])));
		}
		// Palabras claves
		$cla=$_POST['claves'];
		// Contenido del artculo
		$cont= addslashes($_POST['contenido']);  // addslashes->Escapa comillas de las expresiones  //no aplicar  => stripslashes y htmlspecialchars, tiny_mce... se encarga de enviarlo en formato html
		if(empty($cont)) {print "[-] Debe proporcionar contenido al post ... !!!"; die ();}
		// Valores por defecto
		$aut=$_POST['userid']; // falta colocar ide del usuario
    // activity
    if(!empty($_POST['calendar']) || !$_POST['calendar']==""){
      $fecha = rb_a_yyyymmdd($_POST['calendar']);
      $actividad = 1;
    }else{
      $fecha = "0000-00-00";
			$actividad = 0;
    }
		// video
		$video = 0;
		$video_embed = "";
		$video_embed = trim($_POST['video_embed']);
    $galeria = 0;
		$src = "";
		$externo = 1;
		if(!isset($_REQUEST['externo'])) {
			$externo = 0; // ningun album seleccionado
		}else{
			$array_externo = $_REQUEST['externo'];
		}
		$atributo = 1;
		if(!isset($_REQUEST['atributo'])) {
			$atributo = 0;
		}else{
			$array_atributo = $_REQUEST['atributo'];
		}
		// tipo de accion
		if($mode=="new"){
			// Si grabar ok...
      $campos = array($tit, $tit_id, $aut, $cla, $cont,$port,$src,$actividad,$fecha,$video,$video_embed, $galeria);
      $q = "INSERT INTO articulos (fecha_creacion, titulo, titulo_enlace, autor_id, tags, contenido, portada, img_portada, actividad, fecha_actividad, video, video_embed, galeria_id) VALUES ( NOW() ,'".$campos[0]."','".$campos[1]."',".$campos[2].",'".$campos[3]."','".$campos[4]."',".$campos[5].",'".$campos[6]."',".$campos[7].",'".$campos[8]."',".$campos[9].",'".$campos[10]."',".$campos[11].")";
      $result =  $objDataBase->Insertar( $q );
			if($result){
				$ultimo_id = $result['insert_id'];
				// Activar articulo
				$objDataBase->EditarPorCampo('articulos', 'activo', 'A', $ultimo_id);
				//grabamos a nueva tabla articulos_categorias
				foreach($array_categorias as $categoria){
					$objDataBase->Ejecutar("INSERT INTO articulos_categorias (articulo_id, categoria_id) VALUES ($ultimo_id,$categoria)");
				}
				//grabamos a nueva tabla articulos_albums
				if($albums>0){
					foreach($array_albums as $album){
						$objDataBase->Ejecutar("INSERT INTO articulos_albums (articulo_id, album_id) VALUES ($ultimo_id,$album)");
					}
				}
				// externo
				if($externo>0){
					foreach($array_externo as $externo){
						$nombre_ext = $externo['tipo'];
						$objDataBase->Ejecutar("INSERT INTO objetos (nombre, contenido, tipo, articulo_id) VALUES ('".$nombre_ext."','".$externo['contenido']."','objeto',$ultimo_id)");
					}
				}
				// atributos
				if($atributo>0){
					foreach($array_atributo as $atributo){
						$nombre_atributo = $atributo['nombre'];
						$articulo_id_padre = $atributo['id'];
						$objDataBase->Ejecutar("INSERT INTO articulos_articulos (nombre_atributo, articulo_id_padre, articulo_id_hijo) VALUES ('".$nombre_atributo."',".$ultimo_id.",".$articulo_id_padre.")");
					}
				}
				// portada, logo, adjunto
				$portada = $_POST['portada'];
				$objDataBase->Ejecutar("INSERT INTO objetos (nombre, contenido, tipo, articulo_id) VALUES ('portada', '$portada','image',$ultimo_id)");
				$logo = $_POST['secundaria'];
				$objDataBase->Ejecutar("INSERT INTO objetos (nombre, contenido, tipo, articulo_id) VALUES ('logo', '$logo','image',$ultimo_id)");
				/*$adjunto = $_POST['adjunto'];
				$objDataBase->Ejecutar("INSERT INTO objetos (nombre, contenido, tipo, articulo_id) VALUES ('adjunto', '$adjunto','image',$ultimo_id)");*/
				//redireccionar a la pagina de edicion
				if($volver=="true"){
					$urlreload=G_SERVER.'/rb-admin/index.php?pag=art';
				}else{
					$urlreload=G_SERVER.'/rb-admin/index.php?pag=art&opc=edt&id='.$ultimo_id."&m=ok";
				}
				header('Location: '.$urlreload);
			}else{
			 	die("Ocurrio un error");
			}
		}elseif($mode=="update"){
			$id = $_POST['id'];
			$fecmod = $_POST['fechamod'];
      $campos = array($tit, $tit_id, $cla, $cont,$port,$src,$actividad,$fecha,$fecmod,$video,$video_embed,$galeria);
      $q = "UPDATE articulos SET titulo='".$campos[0]."', titulo_enlace='".$campos[1]."', tags='".$campos[2]."', contenido='".$campos[3]."', portada=".$campos[4].", img_portada='".$campos[5]."', actividad=".$campos[6].", fecha_actividad='".$campos[7]."', fecha_creacion='".$campos[8]."', video=".$campos[9].", video_embed = '".$campos[10]."', galeria_id = ".$campos[11]." WHERE id=".$id;
			$objDataBase->Ejecutar($q);
			// ejecutamos consulta
			$objDataBase->Ejecutar("DELETE FROM articulos_categorias WHERE articulo_id=$id");
			//grabando las categorias actuales
			foreach($array_categorias as $categoria){
				$objDataBase->Ejecutar("INSERT INTO articulos_categorias (articulo_id, categoria_id) VALUES ($id,$categoria)");
			}
			// eliminamos relacion de articulos con albums para crear nuevo
			$objDataBase->Ejecutar("DELETE FROM articulos_albums WHERE articulo_id=$id");
			//grabamos a nueva tabla articulos_albums
			if($albums>0){
				foreach($array_albums as $album){
					$objDataBase->Ejecutar("INSERT INTO articulos_albums (articulo_id, album_id) VALUES ($id,$album)");
				}
			}
			// grabamos nuevos objetos - campos
			if($externo>0){
				foreach($array_externo as $externo){
					$nombre_ext = $externo['tipo'];
					$r = $objDataBase->Ejecutar( "UPDATE objetos SET contenido = '".$externo['contenido']."' WHERE articulo_id = $id AND tipo = 'objeto' AND nombre = '$nombre_ext'" );

					if( $r->affected_rows == 0 ) 
						$objDataBase->Ejecutar("INSERT INTO objetos (nombre, contenido, tipo, articulo_id) VALUES ('".$nombre_ext."','".$externo['contenido']."','objeto',$id)");
				}
			}
			// eliminamos atributos anteriores
			$objDataBase->Ejecutar("DELETE FROM articulos_articulos WHERE articulo_id_padre=$id");
			// grabamos atributos
			if($atributo>0){
				foreach($array_atributo as $atributo){
					$nombre_atributo = $atributo['nombre'];
					$articulo_id_padre = $atributo['id'];
					$objDataBase->Ejecutar("INSERT INTO articulos_articulos (nombre_atributo, articulo_id_padre, articulo_id_hijo) VALUES ('".$nombre_atributo."',".$id.",".$articulo_id_padre.")");
				}
			}
			// portada, logo
			$portada = $_POST['portada'];
      $result = $objDataBase->Editar("UPDATE objetos SET contenido = '$portada' WHERE nombre='portada' AND tipo='image' AND articulo_id = $id");
			if( $result['affected_rows'] == 0 ) $objDataBase->Ejecutar("INSERT INTO objetos (nombre, contenido, tipo, articulo_id) VALUES ('portada', '$portada','image', $id)");

			$logo = $_POST['secundaria'];
			$result = $objDataBase->Editar("UPDATE objetos SET contenido = '$logo' WHERE nombre='logo' AND tipo='image' AND articulo_id = $id");
			if( $result['affected_rows'] == 0 ) $objDataBase->Ejecutar("INSERT INTO objetos (nombre, contenido, tipo, articulo_id) VALUES ('logo', '$logo','image', $id)");

			//redireccionar a la pagina de edicion
			if($volver=="true"){
				$urlreload=G_SERVER.'/rb-admin/index.php?pag=art';
			}else{
				$urlreload=G_SERVER.'/rb-admin/index.php?pag=art&opc=edt&id='.$id."&m=ok";
			}
			header('Location: '.$urlreload);
		}
?>
