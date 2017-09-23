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
		}
	break;
?>
