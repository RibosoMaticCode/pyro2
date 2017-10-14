<?php
include 'islogged.php';
?>
<div id="contenedor">
<?php
if(isset($_GET['pag'])){
	$pag=$_GET['pag'];
}else{
	$pag="";
}
switch($pag){
	case "art":
		echo '<h2 class="title">Publicaciones</h2>';
		$sec="art";
		if(isset($_GET['opc'])){
			$opc=$_GET['opc'];
		}else{
			$opc="";
		}
		switch($opc){
			case "nvo":
			case "edt":
				include('core/pubs/pub-edit.php');
				break;
			default:
				include('core/pubs/pub-init.php');
		}
	break;
	case "usu":
			echo '<h2 class="title">Usuarios</h2>';
			$sec="usu";
			if(isset($_GET['opc'])){
				$opc=$_GET['opc'];
			}else{
				$opc="";
			}
			switch($opc){
				case "nvo":
					if($userType != "admin"):
						printf(" No tiene permiso de Administrador ");
						break;
					endif;
					include('core/users/user-edit.php');
					break;
				case "edt":
					include('core/users/user-edit.php');
					break;
				default:
					if($userType != "admin"):
						printf(" No tiene permiso de Administrador ");
						break;
					endif;
					include('core/users/user-init.php');
			}
	break;
	case "menus":
		if($userType != "admin"):
			printf(" No tiene permiso de Administrador ");
			break;
		endif;

		echo '<h2 class="title">Menús</h2>';
		echo '<div class="page-bar">Inicio > Apariencia</div>';
		$sec="menus";
		if(isset($_GET['opc'])){
			$opc=$_GET['opc'];
		}else{
			$opc="";
		}
		switch($opc){
			case "nvo":
			case "edt":
				include('core/menu/menu-edit.php');
				break;
			default:
				include('core/menu/menu-init.php');
		}
		break;
		case "menu":
			if($userType != "admin"):
				printf(" No tiene permiso de Administrador ");
				break;
			endif;

			echo '<h2 class="title">Sub Menús</h2>';
			echo '<div class="page-bar">Inicio > Apariencia > Menú</div>';
			$sec="menu";
			if(isset($_GET['opc'])){
				$opc=$_GET['opc'];
			}else{
				$opc="";
			}
			switch($opc){
				default:
					include('core/menu/items-init.php');
			}
			break;
  case "pages":
		if($userType != "admin"):
			printf(" No tiene permiso de Administrador ");
			break;
		endif;
		echo '<h2 class="title">Editor Visual de Páginas (v.0.1)</h2>';
		echo '<div class="page-bar">Inicio > Contenidos</div>';
        $sec="pages";
        if(isset($_GET['opc'])){
            $opc=$_GET['opc'];
        }else{
            $opc="";
        }
        switch($opc){
            case "nvo":
            case "edt":
                include('core/pages2/page-edit.php');
                break;
            default:
                include('core/pages2/page-init.php');
        }
    break;
	case "gal":
		echo '<h2 class="title">Galerías</h2>';
		echo '<div class="page-bar">Inicio > Medios</div>';
		$sec="gal";
		if(isset($_GET['opc'])){
			$opc=$_GET['opc'];
		}else{
			$opc="";
		}
		switch($opc){
			case "nvo":
			case "edt":
				include('core/galleries/gallery-edit.php');
				break;
			default:
				include('core/galleries/gallery-init.php');
		}
		break;

	case "files":
		echo '<h2 class="title">Archivos</h2>';
		echo '<div class="page-bar">Inicio > Medios</div>';
		$sec="files";
		if(isset($_GET['opc'])){
			$opc=$_GET['opc'];
		}else{
			$opc="";
		}
		switch($opc){
			case "nvo":
				include('core/files/file-new.php');
				break;
			/*case "edt":
				include('edit.php');
				break;*/
			default:
				include('core/files/file-init.php');
		}
		break;
	case "imgnew":
		$sec="imgnew";
		if(isset($_GET['opc'])){
			$opc=$_GET['opc'];
		}else{
			$opc="";
		}
		switch($opc){
			case "nvo":
				include('core/galleries/img-new.php');
				break;
			/*default:
				include('secciones.php');*/
		}
	break;
	case "img":

		$sec="img";
		if(isset($_GET['opc'])){
			$opc=$_GET['opc'];
		}else{
			$opc="";
		}
		switch($opc){
			case "edt":
				include('core/galleries/img-edit.php'); //posible duplicado con imgnew
				break;
			default:
				include('core/galleries/img-init.php');
		}
		break;
	// revisar de aca en adelante
	case "file_edit":
		echo '<h2 class="title">Archivos</h2>';
		echo '<div class="page-bar">Inicio > Medios</div>';
		$sec="file_edit";
		if(isset($_GET['opc'])){
			$opc=$_GET['opc'];
		}else{
			$opc="";
		}
		switch($opc){
			case "edt":
				include('core/files/file-edit.php');
				break;
			/*default:
				include('secciones.php');*/
		}
		break;
	case "com":
		if($userType != "admin"):
			printf(" No tiene permiso de Administrador ");
			break;
		endif;

		echo '<h2 class="title">Comentarios</h2>';
		echo '<div class="page-bar">Inicio > Contenidos</div>';
		$sec="com";
		if(isset($_GET['opc'])){
			$opc=$_GET['opc'];
		}else{
			$opc="";
		}
		switch($opc){
			case "edt":
				include('edit.php');
				break;
			default:
				include('secciones.php');
		}
		break;
	case "cat":
		if($userType != "admin"):
			printf(" No tiene permiso de Administrador ");
			break;
		endif;

		echo '<h2 class="title">Categorias</h2>';
		echo '<div class="page-bar">Inicio > Contenidos</div>';
		$sec="cat";
		if(isset($_GET['opc'])){
			$opc=$_GET['opc'];
		}else{
			$opc="";
		}
		switch($opc){
			case "nvo":
			case "edt":
				include('core/categories/category-edit.php');
				break;
			default:
				include('core/categories/category-init.php');
		}
		break;

	case "men":
		echo '<h2 class="title">Mensajes</h2>';
		echo '<div class="page-bar">Inicio > Mensajes</div>';
		$sec="men";
		if(isset($_GET['opc'])){
			$opc=$_GET['opc'];
		}else{
			$opc="";
		}
		switch($opc){
			case "nvo":
				include('core/messages/message-edit.php');
				break;
			case "view":
				$id=$_GET["id"];
				include('core/messages/message-view.php');
				break;
			case "send":
				$style_btn_default = " ";
				$style_btn_1 = "style=\"font-weight:bold;\"";
				include('core/messages/message-init.php');
				break;
			default:
				$style_btn_default = "style=\"font-weight:bold;\" ";
				$style_btn_1 = " ";
				include('core/messages/message-init.php');
		}
		break;
	case "opc":
		if($userType != "admin"):
			printf(" No tiene permiso de Administrador ");
			break;
		endif;
		echo '<h2 class="title">Opciones de Configuración</h2>';
		echo '<div class="page-bar">Inicio</div>';
		include('option-edit.php');
		break;
	case "modules":
		if($userType != "admin"):
			printf(" No tiene permiso de Administrador ");
			break;
		endif;
		include_once 'modules.php';
	break;
	case "nivel":
		if($userType != "admin"):
			printf(" No tiene permiso de Administrador ");
			break;
		endif;
		include_once 'core/niveles/niveles.php';
	break;
	case "editfile":
		if($userType != "admin"):
			printf(" No tiene permiso de Administrador ");
			break;
		endif;
		include_once ABSPATH.'rb-script/modules/rb-editfile/editfile.php';
	break;
	default:
		if( isset( $_GET['term'] ) && $_GET['term']!=" "){
			include_once 'search.php';
		}else{
			include('inicial.php');
		}
}
?>
</div>
