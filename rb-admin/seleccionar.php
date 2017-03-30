<?php
include 'islogged.php';
?>
<div id="contenedor">
<?php
//si esta definido la pagina
if(isset($_GET['pag'])){
	$pag=$_GET['pag'];
}else{
//si no esta definido mostrar index
	$pag="";
}
switch($pag){
	case "art":
		echo '<h2 class="title">Publicaciones</h2>';
		echo '<div class="page-bar">Inicio > Contenidos</div>';
		$sec="art";
		if(isset($_GET['opc'])){
			$opc=$_GET['opc'];
		}else{
			$opc="";
		}
		switch($opc){
			case "nvo":
				include('edit.php');
				break;
			case "edt":
				include('edit.php');
				break;
			default:
				include('secciones.php');
		}
		break;
    case "pages":
		if($userType != "admin"):
			printf(" No tiene permiso de Administrador ");
			break;
		endif;

		echo '<h2 class="title">Páginas</h2>';
		echo '<div class="page-bar">Inicio > Contenidos</div>';
        $sec="pages";
        if(isset($_GET['opc'])){
            $opc=$_GET['opc'];
        }else{
            $opc="";
        }
        switch($opc){
            case "nvo":
                include('edit.php');
                break;
            case "edt":
                include('edit.php');
                break;
            default:
                include('secciones.php');
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
			case "nvo":
				include('edit.php');
				break;
			case "edt":
				include('edit.php');
				break;
			default:
				include('secciones.php');
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
				include('edit.php');
				break;
			case "edt":
				include('edit.php');
				break;
			default:
				include('secciones.php');
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
				include('edit.php');
				break;
			case "edt":
				include('edit.php');
				break;
			default:
				include('secciones.php');
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
				include('edit.php');
				break;
			case "edt":
				include('edit.php');
				break;
			default:
				include('secciones.php');
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
				include('edit.php');
				break;
			default:
				include('secciones.php');
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
			/*case "nvo":
				include('edit.php');
				break;*/
			case "edt":
				include('edit.php');
				break;
			default:
				include('secciones.php');
		}
		break;
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
				include('edit.php');
				break;
			default:
				include('secciones.php');
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
				include('edit.php');
				break;
			case "edt":
				include('edit.php');
				break;
			default:
				include('secciones.php');
		}
		break;
	case "usu":
		echo '<h2 class="title">Usuarios</h2>';
		echo '<div class="page-bar">Inicio > Usuarios</div>';
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
				include('edit.php');
				break;
			case "edt":
				include('edit.php');
				break;
			default:
				if($userType != "admin"):
					printf(" No tiene permiso de Administrador ");
					break;
				endif;
				include('secciones.php');
		}
		break;
    case "design":
    	if($userType != "admin"):
			printf(" No tiene permiso de Administrador ");
			break;
		endif;

        $sec="design";
        if(isset($_GET['opc'])){
            $opc=$_GET['opc'];
        }else{
            $opc="";
        }
        switch($opc){
            case "nvo":
                //include('edit.php');
                break;
            case "edt":
                //include('edit.php');
                break;
            default:
                //include('secciones.php');
                include ABSPATH.'rb-script/modules/design/mod.design.edit.php';
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
				include('edit.php');
				break;
			case "view":
				include('edit.php');
				break;
			case "send":
				$style_btn_default = " ";
				$style_btn_1 = "style=\"font-weight:bold;\"";
				include('secciones.php');
				break;
			default:
				$style_btn_default = "style=\"font-weight:bold;\" ";
				$style_btn_1 = " ";
				include('secciones.php');
		}
		break;
	case "opc":
		if($userType != "admin"):
			printf(" No tiene permiso de Administrador ");
			break;
		endif;

		echo '<h2 class="title">Opciones de Configuración</h2>';
		echo '<div class="page-bar">Inicio</div>';
		$sec="opc";
		include('edit.php');
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

	/* modules adds */
	case "cit":
		/*$sec="cit";
		if(isset($_GET['opc'])){
			$opc=$_GET['opc'];
		}else{
			$opc="";
		}
		switch($opc){
			case "nvo":
				include('edit.php');
				break;
			case "edt":
				include('edit.php');
				break;
			default:
				include('secciones.php');
		}*/
		/*if($userType != 1):
			printf(" No tiene permiso de Administrador ");
			break;
		endif;
		include_once ABSPATH.'rb-script/modules/citas/mod.cita.php';
	break;*/
	/* modules adds */
	case "pla":
		if($userType != "admin"):
			printf(" No tiene permiso de Administrador ");
			break;
		endif;

		include_once ABSPATH.'rb-script/modules/plantilla/plantilla.php';
	break;
	/* modules adds */
	/*case "foot":
		if($userType != 1):
			printf(" No tiene permiso de Administrador ");
			break;
		endif;
		include_once ABSPATH.'rb-script/modules/footer/foot.php';
	break;
	case "form":
		if($userType != 1):
			printf(" No tiene permiso de Administrador ");
			break;
		endif;
		include_once ABSPATH.'rb-script/modules/forms/form.php';
	break;*/
	case "editfile":
		if($userType != "admin"):
			printf(" No tiene permiso de Administrador ");
			break;
		endif;
		include_once ABSPATH.'rb-script/modules/rb-editfile/editfile.php';
	break;
	/*case "reservas":
		if($userType != 1):
			printf(" No tiene permiso de Administrador ");
			break;
		endif;
		include_once ABSPATH.'rb-script/modules/reservas/reservas.php';
	break;*/
	/* COTIZACIONES */
	/*case "cot":
		if($userType != 1):
			printf(" No tiene permiso de Administrador ");
			break;
		endif;
		//include_once ABSPATH.'rb-script/modules/cotizador/cotizador.php';
	break;*/
	default:
		// Definir buscador
		if( isset( $_GET['term'] ) && $_GET['term']!=" "){
			include_once 'search.php';
		}else{
			include('inicial.php');
		}
}
?>
</div>
