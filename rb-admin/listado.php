<?php
//include 'islogged.php';
if(!isset($sec)):
	$sec = $_GET['sec'];
	require('../global.php');
endif;

require_once(ABSPATH.'rb-script/funciones.php');
switch($sec){
	/* --------------------------------------------------------*/
	/* ------------- SECCION COMENTARIOS ----------------------*/
	/* --------------------------------------------------------*/
	case "com":
		require_once(ABSPATH."rb-script/class/rb-database.class.php");

		// si esta definida variabla art entonces se muestra los
		// comentarios de ese articulo

		$regMostrar = 100;

		if(isset($_GET['art'])){
			$articulo_id=$_GET['art'];
			$consulta = $objDataBase->Ejecutar("SELECT c.*, a.titulo FROM comentarios c, articulos a WHERE a.id = c.articulo_id AND c.articulo_id = $articulo_id ORDER BY fecha DESC");
		}elseif(isset($_GET['page']) && ($_GET['page']>0)){
			$RegistrosAEmpezar=($_GET['page']-1)*$regMostrar;
			if(isset($_GET['term'])){
				//$consulta = $objDataBase->search($_GET['term'], false, $RegistrosAEmpezar, $regMostrar);
			}else{
				$consulta = $objDataBase->Ejecutar("SELECT c.*, a.titulo FROM comentarios c, articulos a WHERE a.id = c.articulo_id ORDER BY fecha DESC LIMIT $RegistrosAEmpezar, $regMostrar");
			}
		}else{
			$RegistrosAEmpezar = 0;
			if(isset($_GET['term'])){
				//$consulta = $objDataBase->search($_GET['term']);
			}else{
				$consulta = $objDataBase->Ejecutar("SELECT c.*, a.titulo FROM comentarios c, articulos a WHERE c.articulo_id = a.id ORDER BY fecha DESC LIMIT $RegistrosAEmpezar, $regMostrar");
			}
		}
		//<td>".nl2br(htmlspecialchars($row['contenido']))."</td>
		while ($row = $consulta->fetch_assoc()){
			echo "	<tr>
					<td><input id=\"art-".$row['id']."\" type=\"checkbox\" value=\"".$row['id']."\" name=\"items\" /></td>
					<td><h3>".$row['nombre']."</h3>
						<span>".$row['mail']."</span>
					</td>
					<td>
						<span style='font-size:.85em'>".$row['fecha']."</span>
						<div style='margin-top:10px;margin-bottom:10px'>".$row['contenido']."</div>
						<div class='options'>
						<span><a title=\"Editar\" href='../rb-admin/index.php?pag=com&amp;opc=edt&amp;id=".$row['id']."'>Editar</a></span>
						<span><a style=\"color:red\" href=\"#\" title=\"Eliminar\" onclick=\"Delete(".$row['id'].",'com')\">Eliminar</a></span></td>
						</div>
					</td>
					<td><a href=\"index.php?pag=com&art=".$row['articulo_id']."\">".$row['titulo']."</a></td>\n
				</tr>";
		}
	break;
}
?>
