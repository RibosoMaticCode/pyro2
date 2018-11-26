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
		//echo '<h2 class="title">Publicaciones</h2>';
		?>
		<div class="page-header">
			<h2>Publicaciones</h2>
		</div>
		<?php
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
		if(isset($_GET['profile'])){
			?>
			<div class="page-header">
				<h2>Mi perfil</h2>
			</div>
			<?php
		}else{
			?>
			<div class="page-header">
				<h2>Mi perfil</h2>
			</div>
			<?php
		}
			$sec="usu";
			if(isset($_GET['opc'])){
				$opc=$_GET['opc'];
			}else{
				$opc="";
			}
			switch($opc){
				case "nvo":
					if($userType != "admin"):
						printf(" Sección no disponible ");
						break;
					endif;
					include('core/users/user-edit.php');
					break;
				case "edt":
					include('core/users/user-edit.php');
					break;
				case "csv":
					if($userType != "admin"):
						printf(" Sección no disponible ");
						break;
					endif;
					include('core/users/user.csv.config.php');
					break;
				default:
					if($userType != "admin"):
						printf(" Sección no disponible ");
						break;
					endif;
					include('core/users/user-init.php');
			}
		break;
	case "menus":
		if($userType != "admin"):
			printf(" Sección no disponible ");
			break;
		endif;

		?>
			<div class="page-header">
				<h2>Menus</h2>
			</div>
			<?php
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
			printf(" Sección no disponible ");
			break;
		endif;
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
	  ?>
			<div class="page-header">
				<h2>Pseudo editor visual de páginas</h2>
			</div>
			<?php
		if($userType != "admin"):
			printf(" Sección no disponible ");
			break;
		endif;
        $sec="pages";
        if(isset($_GET['opc'])){
            $opc=$_GET['opc'];
        }else{
            $opc="";
        }
        switch($opc){
            case "nvo":
            case "edt":
                include('core/pages3/page-edit.php');
                break;
            default:
                include('core/pages3/page-init.php');
        }
    	break;
	case "pages2":
		if($userType != "admin"):
			printf(" Sección no disponible ");
			break;
		endif;
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
	?>
	<div class="page-header">
		<h2>Galerias</h2>
	</div>
	<?php
		$sec="gal";

		if(isset($_GET['opc'])){
			$opc=$_GET['opc'];
			switch($opc){
				case "nvo":
				case "edt":
					include('core/galleries/gallery-edit.php');
					break;
			}
		}elseif(isset($_GET['album_id'])){
			include('core/galleries/img-init.php');
		}else{
			include('core/galleries/gallery-init.php');
		}
		break;
	case "explorer":
	?>
	<div class="page-header">
		<h2>Archivos</h2>
	</div>
	<?php
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
		}
	break;
	// revisar de aca en adelante
	case "com":
		if($userType != "admin"):
			printf(" Sección no disponible ");
			break;
		endif;

		?>
			<div class="page-header">
				<h2>Comentarios</h2>
			</div>
			<?php
		$sec="com";
		if(isset($_GET['opc'])){
			$opc=$_GET['opc'];
		}else{
			$opc="";
		}
		switch($opc){
			case "edt":
				include('core/comments/comment-edit.php');
				break;
			default:
				include('core/comments/comment-init.php');
		}
		break;
	case "cat":
		if($userType != "admin"):
			printf(" Sección no disponible ");
			break;
		endif;

		?>
			<div class="page-header">
				<h2>Categorias</h2>
			</div>
			<?php
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
	?>
	<div class="page-header">
		<h2>Mensajes</h2>
	</div>
	<?php
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
			printf(" Sección no disponible ");
			break;
		endif;
		?>
			<div class="page-header">
				<h2>Opciones de configuracion</h2>
			</div>
			<?php
		include('option-edit.php');
		break;
	case "modules":
		if($userType != "admin"):
			printf(" Sección no disponible ");
			break;
		endif;
		include_once 'modules.php';
	break;
	case "nivel":
		if($userType != "admin"):
			printf(" Sección no disponible ");
			break;
		endif;
		include_once 'core/niveles/niveles.php';
	break;
	case "editfile":
		if($userType != "admin"):
			printf(" Sección no disponible ");
			break;
		endif;
		include_once ABSPATH.'rb-script/modules/rb-editfile/editfile.php';
	break;
	default:
		if( isset( $_GET['term'] ) && $_GET['term']!=" "){
			include_once 'search.php';
		}else{
			include('initial.php');
		}
}
?>
</div>
