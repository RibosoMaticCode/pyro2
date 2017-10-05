<?php
//include 'islogged.php';
$id=$_GET['id'];
$sec=$_GET['sec'];

require("../rb-script/class/rb-database.class.php");

switch($sec){
	case "art":
		$objArticulo->Eliminar($id);
	break;
  case "pages":
    $objPagina->Eliminar($id);
  break;
  case "menus":
    $objMenu->EliminarNodos($id);
    $objMenu->Eliminar($id);
    break;
	case "menu":
    $objMenu->Eliminar_Item($id);
		//falta eliminar hijos del item, si los hubiera
    break;
	case "com":
		$objComentario->Eliminar($id);
	break;
	case "gal":
    $objGaleria->Eliminar($id);
	break;
	case "img": // resetea album_id de la imagen
		$q = $objFoto->Ejecutar("UPDATE photo SET album_id=0 WHERE id=".$id);
	break;
	case "files":
    $album_id = $_GET['_other'];

		// buscar datos de la foto
		$q = $objFoto->Ejecutar("select src from photo where id=$id");
    $r = mysql_fetch_array($q);
    $src_img = $r['src'];

    // eliminar foto fisica
    $dir = dirname( dirname(__FILE__) );

		// rb-media . default directory, if change, changed this line too
    $ruta_image = $dir.'/rb-media/gallery/'.$src_img;
    $ruta_tn = $dir.'/rb-media/gallery/tn/'.$src_img;
    unlink($ruta_image);
    unlink($ruta_tn);

    // eliminar de la base datos
    $objFoto->Eliminar($id);
		//include('listado.php');
	break;
	case "cat":
		//error falta eliminar demas nodos hijos
		$objCategoria->EliminarNodos($id);
		$objCategoria->Eliminar($id);
		include('listado.php');
	break;
	case "usu":
		require("../rb-script/class/rb-usuarios.class.php");
		if($id==1) die("[!] El usuario \"admin\" no se puede eliminar.");
		$objUsuario->Eliminar($id);
		//include('listado.php');
	break;
	case "men":
		// iniciar session
		session_name('_ribapp');
		session_start();

		// obtener id del usuario en sesion en navegador
		if(isset($_SESSION['usr_id'])) {
			$user_id = $_GET['uid'];

			// validar id del usuario del navegador con el que ingreso al sistema
			if($_SESSION['usr_id']==$user_id){

				// uso de variable auxiliar
				if(!isset($_GET['_other'])) die("[!] Ocurrio un error.");

				require("../rb-script/class/rb-mensajes.class.php");
				if($_GET['_other']=="rd"){
					if($objMensaje->DesactivarRecibidos($id,$user_id)) echo "Good";
					include('listado.php');
				}elseif($_GET['_other']=="sd"){
					if($objMensaje->DesactivarEnviados($id,$user_id)) echo "Good";
					include('listado.php');
				}
			}else{
				die("Usuario online no valido");
			}
		}else{
			die("[!] Necesita iniciar sesion con su cuenta de usuario");
		}
	break;
}
?>
