<?php
include("../rb-script/funciones.php");
require("../rb-script/class/rb-opciones.class.php");
define('G_SERVER', $objOpcion->obtener_valor(1,'direccion_url'));

include 'islogged.php';

/*------------------ SCRIPT PHP PARA GUARDAR -----------------*/
$operacion=$_POST['section'];

switch($operacion){
	/*---------------------------------------------*/
	/*-------------- ARTICULOS --------------------*/
	/*---------------------------------------------*/
	case "imgnew":
		require_once("../rb-script/class/rb-fotos.class.php");
		if(!isset($_REQUEST['items'])) {
			print "[!] Debe seleccionar alguna imagen ... !!!";
			die();
		}
		$array_images = $_REQUEST['items'];

		foreach($array_images as $image){
			//update album_id
			$objFoto->Consultar("UPDATE photo SET album_id =".$_POST['album_id']." WHERE id=".$image);
		}
		$urlreload=G_SERVER.'/rb-admin/index.php?pag=img&album_id='.$_POST['album_id']."&m=ok";
		header('Location: '.$urlreload);
	break;
	case "art":
		require_once("../rb-script/class/rb-articulos.class.php");
		$volver = "false";
		if (isset($_POST['guardar_volver'])) {
			$volver = "true";
	    }

		// Tipo acceso
		/*$acceso=$_POST['acceso'];
		if($acceso=="privat"):
			// Niveles
			if(!isset($_REQUEST['niveles'])) {
				print "[!] Debe seleccionar al menos un nivel de acceso!!!";
			}
			$niveles = "";
			$coma= "";
			foreach($_REQUEST['niveles'] as $nivel){
				$niveles .= $coma.$nivel;
				$coma =",";
			}
		endif;*/

		// Modo
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
		//if(empty($cla)) {print "[-] Debe proporcionar palabras claves para los metatags ... !!!"; die ();}

		// Contenido del art�culo
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

		//revisa posible inject -codigo malicioso.- nivel basico
		/*if(esSpam($video_embed)>0){
			die("Revisar codigo de video, parece no ser el correcto");
		}*/

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
			if($objArticulo->Insertar(array($tit, $tit_id, $aut, $cla, $cont,$port,$src,$actividad,$fecha,$video,$video_embed, $galeria))){
				$ultimo_id=mysql_insert_id();

				// Activar articulo
				$objArticulo->EditarPorCampo('activo','A',$ultimo_id);

				// Actualizamos niveles de acceso en post
				/*$objArticulo->Consultar("UPDATE articulos SET acceso = '$acceso', niveles = '$niveles' WHERE id = $ultimo_id");*/

				//grabamos a nueva tabla articulos_categorias
				foreach($array_categorias as $categoria){
					$objArticulo->Consultar("INSERT INTO articulos_categorias (articulo_id, categoria_id) VALUES ($ultimo_id,$categoria)");
				}

				//grabamos a nueva tabla articulos_albums
				if($albums>0){
					foreach($array_albums as $album){
						$objArticulo->Consultar("INSERT INTO articulos_albums (articulo_id, album_id) VALUES ($ultimo_id,$album)");
					}
				}

				// externo
				if($externo>0){
					foreach($array_externo as $externo){
						$nombre_ext = $externo['tipo'];
						$objArticulo->Consultar("INSERT INTO objetos (nombre, contenido, tipo, articulo_id) VALUES ('".$nombre_ext."','".$externo['contenido']."','objeto',$ultimo_id)");
					}
				}
				// atributos
				if($atributo>0){
					foreach($array_atributo as $atributo){
						$nombre_atributo = $atributo['nombre'];
						$articulo_id_padre = $atributo['id'];
						$objArticulo->Consultar("INSERT INTO articulos_articulos (nombre_atributo, articulo_id_padre, articulo_id_hijo) VALUES ('".$nombre_atributo."',".$ultimo_id.",".$articulo_id_padre.")");
					}
				}

				// portada, logo, adjunto
				$portada = $_POST['portada'];
				$objArticulo->Consultar("INSERT INTO objetos (nombre, contenido, tipo, articulo_id) VALUES ('portada', '$portada','image',$ultimo_id)");

				$logo = $_POST['secundaria'];
				$objArticulo->Consultar("INSERT INTO objetos (nombre, contenido, tipo, articulo_id) VALUES ('logo', '$logo','image',$ultimo_id)");

				$adjunto = $_POST['adjunto'];
				$objArticulo->Consultar("INSERT INTO objetos (nombre, contenido, tipo, articulo_id) VALUES ('adjunto', '$adjunto','image',$ultimo_id)");

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
			//$fecmod = rb_a_ddmmyyyy($_POST['fechamod']);
			$fecmod = $_POST['fechamod'];

			$objArticulo->Editar(array($tit, $tit_id, $cla, $cont,$port,$src,$actividad,$fecha,$fecmod,$video,$video_embed,$galeria),$id);

			// Actualizamos niveles de acceso en post
			/*$objArticulo->Consultar("UPDATE articulos SET acceso = '$acceso', niveles = '$niveles' WHERE id = $id");*/

			// ejecutamos consulta
			$objArticulo->Consultar("DELETE FROM articulos_categorias WHERE articulo_id=$id");

			//grabando las categorias actuales
			foreach($array_categorias as $categoria){
				$objArticulo->Consultar("INSERT INTO articulos_categorias (articulo_id, categoria_id) VALUES ($id,$categoria)");
			}

			// eliminamos relacion de articulos con albums para crear nuevo
			$objArticulo->Consultar("DELETE FROM articulos_albums WHERE articulo_id=$id");

			//grabamos a nueva tabla articulos_albums
			if($albums>0){
				foreach($array_albums as $album){
					$objArticulo->Consultar("INSERT INTO articulos_albums (articulo_id, album_id) VALUES ($id,$album)");
				}
			}

			// grabamos nuevos objetos - campos
			if($externo>0){
				foreach($array_externo as $externo){
					$nombre_ext = $externo['tipo'];
					$objArticulo->Consultar( "UPDATE objetos SET contenido = '".$externo['contenido']."' WHERE articulo_id = $id AND tipo = 'objeto' AND nombre = '$nombre_ext'" );
					if( mysql_affected_rows() == 0 ) $objArticulo->Consultar("INSERT INTO objetos (nombre, contenido, tipo, articulo_id) VALUES ('".$nombre_ext."','".$externo['contenido']."','objeto',$id)");
				}
			}
			// eliminamos atributos anteriores
			$objArticulo->Consultar("DELETE FROM articulos_articulos WHERE articulo_id_padre=$id");

			// grabamos atributos
			if($atributo>0){
				foreach($array_atributo as $atributo){
					$nombre_atributo = $atributo['nombre'];
					$articulo_id_padre = $atributo['id'];
					$objArticulo->Consultar("INSERT INTO articulos_articulos (nombre_atributo, articulo_id_padre, articulo_id_hijo) VALUES ('".$nombre_atributo."',".$id.",".$articulo_id_padre.")");
				}
			}

			// portada, logo, adjunto
			$portada = $_POST['portada'];
			$objArticulo->Consultar("UPDATE objetos SET contenido = '$portada' WHERE nombre='portada' AND tipo='image' AND articulo_id = $id");
			if( mysql_affected_rows() == 0 ) $objArticulo->Consultar("INSERT INTO objetos (nombre, contenido, tipo, articulo_id) VALUES ('portada', '$portada','image', $id)");

			$logo = $_POST['secundaria'];
			$objArticulo->Consultar("UPDATE objetos SET contenido = '$logo' WHERE nombre='logo' AND tipo='image' AND articulo_id = $id");
			if( mysql_affected_rows() == 0 ) $objArticulo->Consultar("INSERT INTO objetos (nombre, contenido, tipo, articulo_id) VALUES ('logo', '$logo','image', $id)");

			$adjunto = $_POST['adjunto'];
			$objArticulo->Consultar("UPDATE objetos SET contenido = '$adjunto' WHERE nombre='adjunto' AND tipo='image' AND articulo_id = $id");
			if( mysql_affected_rows() == 0 ) $objArticulo->Consultar("INSERT INTO objetos (nombre, contenido, tipo, articulo_id) VALUES ('adjunto', '$adjunto','image', $id)");

			//redireccionar a la pagina de edicion
			if($volver=="true"){
				$urlreload=G_SERVER.'/rb-admin/index.php?pag=art';
			}else{
				$urlreload=G_SERVER.'/rb-admin/index.php?pag=art&opc=edt&id='.$id."&m=ok";
			}
			header('Location: '.$urlreload);
		}
	break;
    /*---------------------------------------------*/
    /*-------------- PAGINAS ----------------------*/
    /*---------------------------------------------*/
    case "pages":
        require_once("../rb-script/class/rb-paginas.class.php");
        // Modo
        $mode=$_POST['mode'];

        $volver = "false";
		if (isset($_POST['guardar_volver'])) {
			$volver = "true";
	    }

        // Barra lateral??
        $sidebar = $_POST['sidebar'];

        // Titulo del articulo
        $tit=$_POST['titulo'];
        if(empty($tit)) {print "[-] Debe proporcionar un titulo al post ... !!!"; die ();}

        // Enlace
        $tit_id=$_POST['titulo_enlace'];
        if(empty($tit_id)){
            $tit_id=rb_cambiar_nombre(utf8_encode($tit));
        }

        // Palabras claves
        $cla="none";//$_POST['claves'];
        //if(empty($cla)) {print "[-] Debe proporcionar palabras claves para los metatags ... !!!"; die ();}

        // Contenido del art�culo
        $cont= addslashes($_POST['contenido']);
        if(empty($cont)) {print "[-] Debe proporcionar contenido al post ... !!!"; die ();}

        // Valores por defecto
        $aut = $_POST['userid']; // falta colocar ide del usuario

        // galeria
		$galeria = $_POST['galeria'];

		$add = $_POST['addon'];

        // tipo de pagina
        $tipo = $_POST['tipo'];
        // tipo de accion
        if($mode=="new"){
            $objPagina->Insertar(array($tit, $tit_id, $aut, $cla, $cont, $sidebar,$tipo,$galeria,$add));
            $ultimo_id=mysql_insert_id();

            //redireccionar a la pagina de edicion
            if($volver=="true"){
				$urlreload=G_SERVER.'/rb-admin/index.php?pag=pages';
			}else{
				$urlreload=G_SERVER.'/rb-admin/index.php?pag=pages&opc=edt&id='.$ultimo_id."&m=ok";
			}
			header('Location: '.$urlreload);
        }elseif($mode=="update"){
            $id=$_POST['id'];

            $objPagina->Editar(array($tit, $tit_id, $aut, $cla, $cont, $sidebar,$tipo,$galeria,$add),$id);

            //redireccionar a la pagina de edicion
            if($volver=="true"){
				$urlreload=G_SERVER.'/rb-admin/index.php?pag=pages';
			}else{
				$urlreload=G_SERVER.'/rb-admin/index.php?pag=pages&opc=edt&id='.$id."&m=ok";
			}
			header('Location: '.$urlreload);
        }
    break;
	/*---------------------------------------------*/
	/*--------------   MENU  ----------------------*/
	/*---------------------------------------------*/

	case "menus":
		$volver = "false";
		if (isset($_POST['guardar_volver'])) {
			$volver = "true";
	    }
		require_once("../rb-script/class/rb-menus.class.php");

		// Modo
		$mode=$_POST['mode'];

		// definiendo valores
		$nom=$_POST['nombre'];

        // validates
        if($nom=="") die("Falta nombre del item");

		// tipo de accion
		if($mode=="new"){
			// sentencias sql
			$objMenu->Consultar("INSERT INTO menus (nombre) VALUES('$nom')");

			$ultimo_id=mysql_insert_id();
			$enlace=G_SERVER.'/rb-admin/index.php?pag=menus&opc=edt&id='.$ultimo_id;
			header('Location: '.$enlace);
		}elseif($mode=="update"){

			$id=$_POST['id'];
			$objMenu->Consultar("UPDATE menus SET nombre = '$nom' WHERE id = $id");

			$enlace=G_SERVER.'/rb-admin/index.php?pag=menus&opc=edt&id='.$id;
			header('Location: '.$enlace);
		}
	/*---------------------------------------------*/
	/*--------------   MENU  ----------------------*/
	/*---------------------------------------------*/

	case "menu":
		$volver = "false";
		if (isset($_POST['guardar_volver'])) {
			$volver = "true";
	    }
		require_once("../rb-script/class/rb-menus.class.php");

		// Modo
		$mode=$_POST['mode'];

		// definiendo valores
		$style = $_POST['estilo'];
		$nomOcul=rb_cambiar_nombre(utf8_encode($_POST['nombre']));
		$nomVis=$_POST['nombre'];
		//$des=$_POST['descripcion'];
		$catpadre = $_POST['catid'];
		$nivel = $_POST['nivel'];
		$mainmenu_id = $_POST['mainmenu_id'];

		$tipo = $_POST['tipo'];
		switch($tipo){
			case "art":
				$des = $_POST['articulo'];
				break;
			case "pag":
				$des = $_POST['pagina'];
				break;
			case "cat":
				$des = $_POST['categoria'];
				break;
			case "per":
				$des = $_POST['url'];
				break;
		}

        // validates
        if($nomVis=="") die("Falta nombre del item");
        if($des=="") die("Falta URL del item");

		// tipo de accion
		if($mode=="new"){
			// sentencias sql
			$objMenu->Insertar(array($nomOcul,$nomVis,$des,$catpadre,$nivel,$mainmenu_id, $tipo, $style));

			$ultimo_id=mysql_insert_id();

			//redireccionar a la pagina de edicion
            if($volver=="true"){
				$urlreload=G_SERVER.'/rb-admin/index.php?pag=menu&id='.$mainmenu_id;
			}else{
				$urlreload=G_SERVER.'/rb-admin/index.php?pag=menu&opc=edt&id='.$ultimo_id.'&mainmenu_id='.$mainmenu_id;
			}
			header('Location: '.$urlreload);

		}elseif($mode=="update"){

			$id=$_POST['id'];
			$objMenu->Editar(array($nomOcul,$nomVis,$des,$catpadre,$nivel,$tipo, $style),$id);

            if($volver=="true"){
				$urlreload=G_SERVER.'/rb-admin/index.php?pag=menu&id='.$mainmenu_id;
			}else{
				$urlreload=G_SERVER.'/rb-admin/index.php?pag=menu&opc=edt&id='.$id.'&mainmenu_id='.$mainmenu_id;
			}
			header('Location: '.$urlreload);
		}
	break;
	/*---------------------------------------------*/
	/*-------------- GALERIA ----------------------*/
	/*---------------------------------------------*/
	case "gal":
		require_once("../rb-script/class/rb-galerias.class.php");

		// Modo
		$mode=$_POST['mode'];

		// variables
		$nom = $_POST['nombre'];
		$des = $_POST['descripcion'];
		$nom_id=$_POST['titulo_enlace'];
		$user_id = $_POST['user_id'];
		$galeria_grupo = $_POST['grupo'];
		$imgfondo_id = $_POST['imgfondo_id'];

		if(empty($nom_id)){
			$nom_id = rb_cambiar_nombre($_POST['nombre']);
		}

		// tipo de accion
		if($mode=="new"){
			$objGaleria->Insertar(array($nom,$des,$nom_id, $galeria_grupo,$user_id,$imgfondo_id));
			$ultimo_id=mysql_insert_id();

			//redireccionar a la pagina de edicion
			$urlreload=G_SERVER.'/rb-admin/index.php?pag=gal&opc=edt&id='.$ultimo_id."&m=ok";
			header('Location: '.$urlreload);
		}elseif($mode=="update"){
			$id = $_POST['id'];

			$objGaleria->Editar(array($nom,$des,$nom_id,$galeria_grupo,$imgfondo_id),$id);

			//redireccionar a la pagina de edicion
			$urlreload=G_SERVER.'/rb-admin/index.php?pag=gal&opc=edt&id='.$id."&m=ok";
			header('Location: '.$urlreload);
		}
	break;
	/*---------------------------------------------*/
	/*-------------- IMAGENES ---------------------*/
	/*---------------------------------------------*/
	case "img":
		require_once("../rb-script/class/rb-fotos.class.php");
		$volver = "false";
		if (isset($_POST['guardar_volver'])) {
			$volver = "true";
	    }

		// Modo
		$mode=$_POST['mode'];
		$error;

		// variables
		$des = addslashes($_POST['title']);
		$des_add = addslashes($_POST['descripcion']);
		$album_id = $_POST['album_id'];
		$url = $_POST['url'];

        // validates the form input
        //if(strlen($_POST['descripcion']) < 4) die("Se necesita agregar una descripcion");

        // imagen
        $loadimage = false;
        if($mode == "new"){
            // si es nuevo y no hay imagen cargada - rebotar
            if($_FILES['fupload']['name'] == "") die("Debe seleccionar una imagen");
            $loadimage = true;

        }elseif($mode == "update"){
            // si es actualizar y no hay imagen, no carga imagen
            if($_FILES['fupload']['name'] == "") $loadimage = false;
            else $loadimage = true;
        }

        // si la orden es cargar imagen
        if($loadimage){
			if(isset($_FILES['fupload'])) {

                // file's directory
				$directorio = '../rb-media/gallery/';
				$directorio_thumbs = '../rb-media/gallery/tn/';

				$filename = addslashes($_FILES['fupload']['name']);
				$source = $_FILES['fupload']['tmp_name'];
				$target = $directorio . $filename;
				$src = $directorio . $filename;
				$tn_src = $directorio_thumbs  . $filename;

				// Validates the form input

				if($filename == '' || !preg_match('/[.](jpg)|(gif)|(png)|(jpeg)$/', $filename))
				$error['no_file'] = '<p class="alert">Por favor seleccionar una imagen! </p>';

				if(!$error) {  // esta linea genera un error (averiguar): Notice: Undefined variable: error in E:\xampp\htdocs\dev.clasmoche\rb-admin\save.php on line 145
					move_uploaded_file($source, $target);
					createThumbnail($filename, $directorio_thumbs, $directorio, 300);

					die("300");
				}  // end preg_match
			}
		}


		$tipo = $_POST['tipo'];
		switch($tipo){
			case "art":
				$desurl = $_POST['articulo'];
				break;
			case "pag":
				$desurl = $_POST['pagina'];
				break;
			case "cat":
				$desurl = $_POST['categoria'];
				break;
			case "per":
				$desurl = $_POST['url'];
				break;
		}

        // tipo de accion
        if($mode=="new"){
            $objFoto->Insertar(array($des,$filename,$filename,$album_id,$tipo));

			//redireccionar a la pagina de edicion
			$urlreload=G_SERVER.'/rb-admin/index.php?pag=img&album_id='.$album_id."&m=ok";
			header('Location: '.$urlreload);

			//redireccionar a la pagina de edicion
			/*if($volver=="true"){
				$urlreload=G_SERVER.'/rb-admin/index.php?pag=art';
			}else{
				$urlreload=G_SERVER.'/rb-admin/index.php?pag=art&opc=edt&id='.$id."&m=ok";
			}
			header('Location: '.$urlreload);*/

		}elseif($mode=="update"){

		    $id = $_POST['id'];

		    if($loadimage) {
                // si cargo imagen, actualizar imagen y descripcion
								$objFoto->EditarPorCampo("title",$des,$id);
                $objFoto->EditarPorCampo("description",$des_add,$id);
                $objFoto->EditarPorCampo("src",$filename,$id);
                $objFoto->EditarPorCampo("tn_src",$filename,$id);
								$objFoto->EditarPorCampo("url",$url,$id);
            }else{
                // si no cargo imagen, actualizar solo descripcion
								$objFoto->EditarPorCampo("title",$des,$id);
								$objFoto->EditarPorCampo("description",$des_add,$id);
								$objFoto->EditarPorCampo("url",$desurl,$id);
                $objFoto->EditarPorCampo("tipo",$tipo,$id);
            }

            //redireccionar a la pagina de edicion
            if($volver=="true"){
				$urlreload=G_SERVER.'/rb-admin/index.php?pag=img&album_id='.$album_id."&m=ok";
			}else{
				$urlreload=G_SERVER.'/rb-admin/index.php?pag=img&opc=edt&id='.$id.'&album_id='.$album_id."&m=ok";
			}
			header('Location: '.$urlreload);

            /*$urlreload=G_SERVER.'/rb-admin/index.php?pag=img&opc=edt&id='.$id.'&album_id='.$album_id."&m=ok";
            header('Location: '.$urlreload);*/
		}
	break;
	case "files":
		require_once("../rb-script/class/rb-fotos.class.php");

		// Modo
		$mode=$_POST['mode'];
		$error;

		// variables
		$des = $_POST['title'];
		$album_id = $_POST['album_id'];

        // validates the form input
        if(strlen($_POST['descripcion']) < 4) die("Se necesita agregar una descripcion");

        // imagen
        $loadimage = false;
        if($mode == "new"){
            // si es nuevo y no hay imagen cargada - rebotar
            if($_FILES['fupload']['name'] == "") die("Debe seleccionar una imagen");
            $loadimage = true;

        }elseif($mode == "update"){
            // si es actualizar y no hay imagen, no carga imagen
            if($_FILES['fupload']['name'] == "") $loadimage = false;
            else $loadimage = true;
        }

        // si la orden es cargar imagen
        if($loadimage){
			if(isset($_FILES['fupload'])) {

                // file's directory
				$directorio = '../rb-media/gallery/';
				$directorio_thumbs = '../rb-media/gallery/tn/';

				$filename = addslashes($_FILES['fupload']['name']);
				$source = $_FILES['fupload']['tmp_name'];
				$target = $directorio . $filename;
				$src = $directorio . $filename;
				$tn_src = $directorio_thumbs  . $filename;

				// Validates the form input

				if($filename == '' || !preg_match('/[.](jpg)|(gif)|(png)|(jpeg)$/', $filename))
				$error['no_file'] = '<p class="alert">Por favor seleccionar una imagen! </p>';

				if(!$error) {  // esta linea genera un error (averiguar): Notice: Undefined variable: error in E:\xampp\htdocs\dev.clasmoche\rb-admin\save.php on line 145
					move_uploaded_file($source, $target);
					createThumbnail($filename, $directorio_thumbs, $directorio, 300);

					die("300");
				}  // end preg_match
			}
		}

        // tipo de accion
        if($mode=="new"){
            $objFoto->Insertar(array($des,$filename,$filename,$album_id));

			//redireccionar a la pagina de edicion
			$urlreload=G_SERVER.'/rb-admin/index.php?pag=img&album_id='.$album_id."&m=ok";
			header('Location: '.$urlreload);

		}elseif($mode=="update"){

		    $id = $_POST['id'];

		    if($loadimage) {
                // si cargo imagen, actualizar imagen y descripcion
                $objFoto->EditarPorCampo("description",$des,$id);
                $objFoto->EditarPorCampo("src",$filename,$id);
                $objFoto->EditarPorCampo("tn_src",$filename,$id);
            }else{
                // si no cargo imagen, actualizar solo descripcion
                $objFoto->EditarPorCampo("description",$des,$id);

            }

            //redireccionar a la pagina de edicion
            $urlreload=G_SERVER.'/rb-admin/index.php?pag=file_edit&opc=edt&id='.$id.'&m=ok';
            header('Location: '.$urlreload);
		}
	break;
	/*---------------------------------------------*/
	/*-------------- COMENTARIO -------------------*/
	/*---------------------------------------------*/
	case "com":
		require_once("../rb-script/class/rb-comentarios.class.php");

		$id=$_POST['id'];
		$com=$_POST['comentario'];
		$web=$_POST['web'];
		$autor=$_POST['autor'];
		$mail=$_POST['mail'];

		if( $objComentario->Editar( array( $autor, $com, $mail, $web ),$id ) ){
			$enlace=G_SERVER."/rb-admin/index.php?pag=com&opc=edt&id=".$id;
			header('Location: '.$enlace);
		}else{
			echo "Hubo unos incovenientes";
		}
	break;
	/*---------------------------------------------*/
	/*-------------- CATEGORIA --------------------*/
	/*---------------------------------------------*/

	case "cat":
		require_once("../rb-script/class/rb-categorias.class.php");
		// Modo
		$mode=$_POST['mode'];

		// Tipo acceso
		$acceso=$_POST['acceso'];
		if($acceso=="privat"):
			// Niveles
			if(!isset($_REQUEST['niveles'])) {
				print "[!] Debe seleccionar al menos un nivel de acceso!!!";
			}
			$niveles = "";
			$coma= "";
			foreach($_REQUEST['niveles'] as $nivel){
				$niveles .= $coma.$nivel;
				$coma =",";
			}
		endif;

		// definiendo valores
		$nomOcul = rb_cambiar_nombre(utf8_encode($_POST['nombre']));

		if(empty($_POST['nombre_enlace'])){
			$nomOcul = rb_cambiar_nombre(utf8_encode($_POST['nombre']));
		}else{
			$nomOcul = rb_cambiar_nombre(utf8_encode( $_POST['nombre_enlace'] ));
		}

		$nomVis = $_POST['nombre'];
		$des = $_POST['descripcion'];
		$catpadre = $_POST['catid'];
		$nivel = $_POST['nivel'];
		$photo_id = $_POST['imagen-categoria_id'];

        // validates
        if($nomVis=="") die("Falta nombre de la categoria");
        //if($des=="") die("Falta descripcion de la categoria");

		// tipo de accion
		if($mode=="new"){
			$objCategoria->Insertar(array($nomOcul,$nomVis,$des,$catpadre,$nivel,$photo_id));
			$ultimo_id=mysql_insert_id();

			// Actualizamos niveles de acceso en post
			$objCategoria->Consultar("UPDATE categorias SET acceso = '$acceso', niveles = '$niveles' WHERE id = $ultimo_id");

			$enlace=G_SERVER.'/rb-admin/index.php?pag=cat&opc=edt&id='.$ultimo_id;
			header('Location: '.$enlace);
		}elseif($mode=="update"){
			$id=$_POST['id'];
			$objCategoria->Editar(array($nomOcul,$nomVis,$des,$catpadre,$nivel,$photo_id),$id);

			// Actualizamos niveles de acceso en post
			$objCategoria->Consultar("UPDATE categorias SET acceso = '$acceso', niveles = '$niveles' WHERE id = $id");

			$enlace=G_SERVER.'/rb-admin/index.php?pag=cat&opc=edt&id='.$id;
			header('Location: '.$enlace);
		}
	break;
	/*---------------------------------------------*/
	/*-------------- USUARIOS ---------------------*/
	/*---------------------------------------------*/
	case "usu":
		require_once("../rb-script/class/rb-usuarios.class.php");

		// Modo
		$mode=$_POST['mode'];

		// DEFINICION DE VARIABLES Y VALIDACIONES
		$nm = (empty($_POST['nom']) ? die('[!] Falta Nombres') : $_POST['nom']);
		$ap = (empty($_POST['ape']) ? die('[!] Falta Apellidos') : $_POST['ape']);
		$cn = $_POST['ciu'];
		$cr = $_POST['pais'];
		$di = $_POST['dir'];
		$tipo = $_POST['tipo'];

		if($tipo>0):
			$mail=(empty($_POST['mail']) ? die('[!] Falta E-mail') : $_POST['mail']);
			$nickname = (empty($_POST['nickname']) ? die('[!] Falta Nickname') : $_POST['nickname']);
		else:
			$mail= $_POST['mail'];
			$nickname = $_POST['nickname'];
		endif;

		$tf = $_POST['telfij'];
		$tm = $_POST['telmov'];

		$pwd=$_POST['password'];
		$pwd1=$_POST['password1'];

        $sex = $_POST['sexo'];
		$photo = $_POST['photo_id'];

		$bio = $_POST['bio'];
		$tw = $_POST['tw'];
		$fb = $_POST['fb'];
		$gplus = $_POST['gplus'];
		$in = $_POST['in'];
		$pin = $_POST['pin'];
		$insta = $_POST['insta'];
		$youtube = $_POST['youtube'];
		$grupo_id = $_POST['grupo'];

		// tipo de accion
		if($mode=="new"){
			// VALIDAR NOMBRE DE USUARIO
			if($tipo>0):
				if($objUsuario->existe('nickname',$nickname)!=0) die('Error: Nombre de usuario registrado');
			endif;

			// VALIDAR CORREO
			//if($objUsuario->existe('correo',$mail)!=0) die('Error: Correo electronico usado por otro usuario');

			// VALIDAR PASSWORDS
			if($tipo>0):
				$pwd=(empty($_POST['password']) ? die('[!] Ingrese una contrasena') : $_POST['password']);
				$pwd1=(empty($_POST['password1']) ? die('[!] Ingrese una contrasena') : $_POST['password1']);

				if($pwd!=$pwd1){
					die('Las contrasenas no coinciden');
				}
			endif;

			// INSERTAR USUARIO NUEVO
			if($objUsuario->Insertar(array($nickname, $pwd, $nm, $ap, $cn, $cr, $tm, $tf, $mail, $di, $tipo, $sex, $photo))){

				$ultimo_id=mysql_insert_id();

				$objUsuario->EditarPorCampo("bio", $bio, $ultimo_id);
				$objUsuario->EditarPorCampo("tw", $tw, $ultimo_id);
				$objUsuario->EditarPorCampo("fb", $fb, $ultimo_id);
				$objUsuario->EditarPorCampo("gplus", $gplus, $ultimo_id);
				$objUsuario->EditarPorCampo("in", $in, $ultimo_id);
				$objUsuario->EditarPorCampo("pin", $pin, $ultimo_id);
				$objUsuario->EditarPorCampo("insta", $insta, $ultimo_id);
				$objUsuario->EditarPorCampo("youtube", $youtube, $ultimo_id);

				$objUsuario->EditarPorCampo("grupo_id", $grupo_id, $ultimo_id);

				$enlace=G_SERVER.'/rb-admin/index.php?pag=usu&opc=edt&id='.$ultimo_id."&m=ok";
				header('Location: '.$enlace);
			}else{
				echo "[!] Problemas a guardar el nuevo usuario";
			}
		}elseif($mode=="update"){
			$id=$_POST['id'];
			$change_pwd = 0;

			// SI NO ESTAN VACIOS LOS CAMPOS DE CONTRASENA, ESTAS DEBEN SER IGUALES
			if( strlen(trim($pwd))>0 || strlen(trim($pwd1))>0 ){
				if($pwd!=$pwd1){
					die('Las contrasenas no coinciden');
				}else{
					// SE APRUEBA EL CAMBIO DE PASSWORD
					$change_pwd = 1;
				}
			}

			// EDITAR
			if($objUsuario->Editar(array($nm, $ap, $cn, $cr, $tm, $tf, $mail, $di, $tipo, $sex, $photo),$id)){

				if($change_pwd==1) $objUsuario->EditarPorCampo("password", md5(trim($pwd)),$id);

				/*$objUsuario->EditarPorCampo("bio", $bio, $id);
				$objUsuario->EditarPorCampo("tw", $tw, $id);
				$objUsuario->EditarPorCampo("fb", $fb, $id);
				$objUsuario->EditarPorCampo("gplus", $gplus, $id);*/
				$objUsuario->EditarPorCampo("in", $in, $id);
				/*$objUsuario->EditarPorCampo("pin", $pin, $id);
				$objUsuario->EditarPorCampo("insta", $insta, $id);
				$objUsuario->EditarPorCampo("youtube", $youtube, $id);*/
				$objUsuario->EditarPorCampo("grupo_id", $grupo_id, $id);

				$enlace=G_SERVER.'/rb-admin/index.php?pag=usu&opc=edt&id='.$id."&m=ok";
				header('Location: '.$enlace);
			}else{
				echo "[!] Problemas a actualizar datos del usuario";
			}
		}
	break;
    /*---------------------------------------------*/
    /*--------------  GRUPOS ----------------------*/
    /*---------------------------------------------*/
    case "gru":
        require_once("../rb-script/class/rb-grupos.class.php");
        // Modo
        $mode=$_POST['mode'];

        // DEFINICION DE VARIABLES
        $nombre=$_POST['nombre'];

        // validates
        if($nombre=="") die("Asigne un nombre al grupo");

        // tipo de accion
        if($mode=="new"){
            if($objGrupo->Insertar(array($nombre))){
                $ultimo_id=mysql_insert_id();
                $enlace=G_SERVER.'/rb-admin/index.php?pag=gru&opc=edt&id='.$ultimo_id;
                header('Location: '.$enlace);
            }else{
                echo "Problemas";
            }
        }elseif($mode=="update"){
            $id=$_POST['id'];

            if($objGrupo->Editar(array($nombre), $id)){
                $enlace=G_SERVER.'/rb-admin/index.php?pag=gru&opc=edt&id='.$id;
                header('Location: '.$enlace);
            }else{
                echo "Problemas";
            }
        }
    break;
	/*---------------------------------------------*/
	/*--------------  ENLACES ---------------------*/
	/*---------------------------------------------*/
	case "enl":
		require_once("../rb-script/class/rb-enlaces.class.php");
		// Modo
		$mode=$_POST['mode'];

		// DEFINICION DE VARIABLES
		$web_nombre=$_POST['web_nombre'];
		$link=$_POST['link'];
		$link_img=$_POST['link_img'];
		$descripcion=$_POST['descripcion'];
		$webmaster = $_POST['webmaster'];
		$webmaster_mail = $_POST['webmaster_mail'];
		$activo = $_POST['activo'];

		// tipo de accion
		if($mode=="new"){
			if($objEnlace->Insertar(array($web_nombre, $link, $link_img, $descripcion, $webmaster, $webmaster_mail, $activo))){
				$ultimo_id=mysql_insert_id();
				$enlace=G_SERVER.'/rb-admin/index.php?pag=enl&opc=edt&id='.$ultimo_id;
				header('Location: '.$enlace);
			}else{
				echo "Problemas";
			}
		}elseif($mode=="update"){
			$id=$_POST['id'];

			if($objEnlace->Editar(array($web_nombre, $link, $link_img, $descripcion, $webmaster, $webmaster_mail, $activo), $id)){
				$enlace=G_SERVER.'/rb-admin/index.php?pag=enl&opc=edt&id='.$id;
				header('Location: '.$enlace);
			}else{
				echo "Problemas";
			}
		}
	break;
	/*---------------------------------------------*/
	/*--------------  MENSAJES --------------------*/
	/*---------------------------------------------*/
	case "men":
		require_once("../rb-script/class/rb-mensajes.class.php");
		// Modo
		$mode=$_POST['mode'];

		// DEFINICION DE VARIABLES
		$remitente_id =$_POST['remitente_id'];
		$asunto =$_POST['asunto'];
		$contenido = addslashes($_POST['contenido']);

		// USUARIOS
		if(!isset($_REQUEST['users'])) {
			print "[!] Debe seleccionar el o los destinatarios";
			die();
		}
		$array_users_id = $_REQUEST['users'];

		// tipo de accion
		if($mode=="new"){
			if($objMensaje->Insertar(array($remitente_id, $asunto, $contenido))){
				$ultimo_id=mysql_insert_id();

				// GRABA DATOS EN LA TABLA DETALLES
				foreach($array_users_id as $user_id){
					$objMensaje->Consultar("INSERT INTO mensajes_usuarios (mensaje_id, usuario_id) VALUES ($ultimo_id,$user_id)");
				}

				// REDIRECCIONAR
				$enlace=G_SERVER.'/rb-admin/index.php?pag=men&opc=send';
				header('Location: '.$enlace);
			}else{
				echo "Problemas";
			}
		}/*elseif($mode=="update"){
			$id=$_POST['id'];

			if($objEnlace->Editar(array($web_nombre, $link, $link_img, $descripcion, $webmaster, $webmaster_mail, $activo), $id)){
				$enlace=G_SERVER.'/rb-admin/index.php?pag=enl&opc=edt&id='.$id;
				header('Location: '.$enlace);
			}else{
				echo "Problemas";
			}
		}*/
	break;
	/*---------------------------------------------------*/
	/*----------------  GRABA OPCIONES  -----------------*/
	/*---------------------------------------------------*/
	case "opc":
		require_once("../rb-script/class/rb-opciones.class.php");

		/*if(!isset($_REQUEST['modules'])) {
			print "[!] Debe seleccionar al menos un modulo ... !!!";
			die();
		}
		$array_modules = $_REQUEST['modules'];

		// Sino existe algun modulo lo agregamos y su valor por defecto = 1
		if (!array_key_exists('post', $array_modules)) $array_modules['post'] = 0;
		if (!array_key_exists('cat', $array_modules)) $array_modules['cat'] = 0;
		if (!array_key_exists('pag', $array_modules)) $array_modules['pag'] = 0;
		if (!array_key_exists('com', $array_modules)) $array_modules['com'] = 0;
		if (!array_key_exists('file', $array_modules)) $array_modules['file'] = 0;
		if (!array_key_exists('gal', $array_modules)) $array_modules['gal'] = 0;
		if (!array_key_exists('usu', $array_modules)) $array_modules['usu'] = 0;
		if (!array_key_exists('mess', $array_modules)) $array_modules['mess'] = 0;
		if (!array_key_exists('men', $array_modules)) $array_modules['men'] = 0;

		$array_modules_json = json_encode($array_modules);*/

		$opcion_id = 1; //opcion ID siempre es 1 -> codigo del blog
		$nombresitio = $_POST['nombresitio'];

		//quitar "/" final de direccion
		function quitar_barra($direccionurl){
			$barra = substr($direccionurl,-1);
			if($barra == "/"):
				$direccionurl = substr($direccionurl,0,-1);
				return quitar_barra($direccionurl);
			else:
				return $direccionurl;
			endif;
		}

		$direccionurl = quitar_barra($_POST['direccionurl']); // direccion_url sin slash al final

		$siteurl = "http://".$_SERVER['SERVER_NAME']; // url_del_sitio
		$directoriourl = str_replace($siteurl, "", $direccionurl); // quita http:// y url_del_sitio

		$descripcion = $_POST['descripcion'];
		$meta_keywords = $_POST['keywords'];
		$meta_description = $_POST['description'];
		$meta_author = $_POST['author'];
		$tema = $_POST['tema'];
		$enlaceamigable = $_POST['amigable'];
        //$style = $_POST['style'];
		$objetos = $_POST['objetos'];
		$mail_sender = $_POST['mailsender'];
		$name_sender = $_POST['namesender'];
		$mails = $_POST['mails'];
		$inicial = $_POST['inicial'];
		$post_by_category = $_POST['post_by_category'];
		$linkregister = $_POST['linkregister'];
		//$form_code = addslashes(htmlspecialchars ($_POST['form_code']));
		$mainmenu_id = $_POST['menu'];
		$t_width = $_POST['t_width'];
		$t_height = $_POST['t_height'];

		$objOpcion->modificar_valor(1,'nombresitio',$nombresitio);
		$objOpcion->modificar_valor(1,'direccion_url',$direccionurl);
		$objOpcion->modificar_valor(1,'directorio_url',$directoriourl);
		$objOpcion->modificar_valor(1,'descripcion',$descripcion);
		$objOpcion->modificar_valor(1,'meta_keywords',$meta_keywords);
		$objOpcion->modificar_valor(1,'meta_description',$meta_description);
		$objOpcion->modificar_valor(1,'meta_author',$meta_author);
		$objOpcion->modificar_valor(1,'tema',$tema);
		$objOpcion->modificar_valor(1,'enlaceamigable',$enlaceamigable);
        //$objOpcion->modificar_valor(1,'css_style',$style);
		$objOpcion->modificar_valor(1,'objetos',$objetos);
		$objOpcion->modificar_valor(1,'mail_destination',$mails);
		$objOpcion->modificar_valor(1,'name_sender',$name_sender);
		$objOpcion->modificar_valor(1,'mail_sender',$mail_sender);
		$objOpcion->modificar_valor(1,'initial',$inicial);
		$objOpcion->modificar_valor(1,'slide_main', $_POST['slide']);
		$objOpcion->modificar_valor(1,'post_by_category',$post_by_category);
		$objOpcion->modificar_valor(1,'linkregister',$linkregister);
		//$objOpcion->modificar_valor(1,'form_code',$form_code);
		$objOpcion->modificar_valor(1,'mainmenu_id',$mainmenu_id);
		$objOpcion->modificar_valor(1,'t_width',$t_width);
		$objOpcion->modificar_valor(1,'t_height',$t_height);
		//$objOpcion->modificar_valor(1,'modules_options',$array_modules_json);
		$objOpcion->modificar_valor(1,'logo', $_POST['logo_id']);
		$objOpcion->modificar_valor(1,'map-x', $_POST['map-x']);
		$objOpcion->modificar_valor(1,'map-y', $_POST['map-y']);
		$objOpcion->modificar_valor(1,'map-zoom', $_POST['map-zoom']);
		$objOpcion->modificar_valor(1,'map-desc', addslashes($_POST['map-desc']));
		// redes sociales
		$objOpcion->modificar_valor(1,'fb', $_POST['fb']);
		$objOpcion->modificar_valor(1,'tw', $_POST['tw']);
		$objOpcion->modificar_valor(1,'gplus', $_POST['gplus']);
		$objOpcion->modificar_valor(1,'in', $_POST['in']);
		$objOpcion->modificar_valor(1,'insta', $_POST['insta']);
		$objOpcion->modificar_valor(1,'youtube', $_POST['youtube']);
		$objOpcion->modificar_valor(1,'pin', $_POST['pin']);
		$objOpcion->modificar_valor(1,'whatsapp', $_POST['whatsapp']);
		// bases url
		$objOpcion->modificar_valor(1,'base_publication', $_POST['base_pub']);
		$objOpcion->modificar_valor(1,'base_category', $_POST['base_cat']);
		$objOpcion->modificar_valor(1,'base_search', $_POST['base_bus']);
		$objOpcion->modificar_valor(1,'base_user', $_POST['base_usu']);
		$objOpcion->modificar_valor(1,'base_page', $_POST['base_pag']);

		$objOpcion->modificar_valor(1,'user_active_admin', $_POST['user_active_admin']);
		$objOpcion->modificar_valor(1,'nivel_user_register', $_POST['nivel_user_register']);
		$objOpcion->modificar_valor(1,'alcance', $_POST['alcance']);

		$urlreload=G_SERVER."/rb-admin/index.php?pag=opc&m=ok";

		header('Location: '.$urlreload);
		die();
	break;
    /*---------------------------------------------*/
    /*--------------  PUNTOS ----------------------*/
    /*---------------------------------------------*/
    case "puntos":

    break;
}
?>
