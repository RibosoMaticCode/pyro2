<?php
require_once "../global.php";
require_once "../rb-script/funcs.php";
require_once "../rb-script/class/rb-database.class.php";

if(isset($_GET['sec'])){
	switch($_GET['sec']){
		case 'pages':
			$id=$_GET["id"];
			// CONSULTAMOS TODOS LOS DATOS DE ARTICULOS
			$q =  $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."pages WHERE id= $id");
			$r = $q->fetch_assoc();
			$qr =  $objDataBase->Ejecutar("SELECT id FROM ".G_PREFIX."pages WHERE titulo = '".$r['titulo']."'");
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

			$row = $objDataBase->Insert( G_PREFIX."pages", $campos );
			if($row['result']):
				$urlreload=G_SERVER.'rb-admin/index.php?pag=pages';
				header('Location: '.$urlreload);
			else:
				echo $row['error'];
			endif;
		break;
	}
}
?>
