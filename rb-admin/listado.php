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
		require_once(ABSPATH."rb-script/class/rb-comentarios.class.php");

		// si esta definida variabla art entonces se muestra los
		// comentarios de ese articulo

		$regMostrar = 100;

		if(isset($_GET['art'])){
			$articulo_id=$_GET['art'];
			$consulta = $objComentario->Ejecutar("SELECT c.*, a.titulo FROM comentarios c, articulos a WHERE a.id = c.articulo_id AND c.articulo_id = $articulo_id ORDER BY fecha DESC");
		}elseif(isset($_GET['page']) && ($_GET['page']>0)){
			$RegistrosAEmpezar=($_GET['page']-1)*$regMostrar;
			if(isset($_GET['term'])){
				//$consulta = $objComentario->search($_GET['term'], false, $RegistrosAEmpezar, $regMostrar);
			}else{
				$consulta = $objComentario->Ejecutar("SELECT c.*, a.titulo FROM comentarios c, articulos a WHERE a.id = c.articulo_id ORDER BY fecha DESC LIMIT $RegistrosAEmpezar, $regMostrar");
			}
		}else{
			$RegistrosAEmpezar = 0;
			if(isset($_GET['term'])){
				//$consulta = $objComentario->search($_GET['term']);
			}else{
				$consulta = $objComentario->Ejecutar("SELECT c.*, a.titulo FROM comentarios c, articulos a WHERE c.articulo_id = a.id ORDER BY fecha DESC LIMIT $RegistrosAEmpezar, $regMostrar");
			}
		}
		//<td>".nl2br(htmlspecialchars($row['contenido']))."</td>
		while ($row = mysql_fetch_array($consulta)){
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
	/* --------------------------------------------------------*/
	/* -------------- SECCION CATEGORIAS ----------------------*/
	/* --------------------------------------------------------*/
	case "cat":
		rb_listar_categorias(0);
	break;
    /* --------------------------------------------------------*/
    /* --------------SECCION GRUPOS ---------------------------*/
    /* --------------------------------------------------------*/
    case "gru":
        require_once(ABSPATH."rb-script/class/rb-grupos.class.php");

        $result = $objGrupo->Ejecutar("SELECT * FROM grupos ORDER BY nombre DESC LIMIT 10");
        while ($row = mysql_fetch_array($result)){
            echo "  <tr>
                        <td>".$row['nombre']."</td>";
            echo "<td width='40px;'>
                    <span>
                        <a title=\"Editar\" href='../rb-admin/index.php?pag=gru&amp;opc=edt&amp;id=".$row['id']."'>
                        <img style=\"border:0px;\" src=\"img/page_edit.png\" alt=\"Editar\" /></a>
                    </span>
                    </td>";
            echo "<td width='40px;'>
                    <span>
                        <a href=\"#\" style=\"color:red\" title=\"Eliminar\" onclick=\"Delete(".$row['id'].",'gru')\">
                        <img src=\"img/delete.png\" alt=\"Eliminar\" /></a>
                    </span>
                    </td>
                    <tr>\n";
        }
    break;
	/* --------------------------------------------------------*/
	/* -------------- SECCION MENSAJES ------------------------*/
	/* --------------------------------------------------------*/
	case "men":
		require_once(ABSPATH."rb-script/class/rb-mensajes.class.php");
		require_once(ABSPATH."rb-script/class/rb-usuarios.class.php");

		if(isset($_GET['opc'])){
			// ENVIADOS

			if($_GET['opc'] == "send"){
				$result = $objMensaje->Ejecutar("SELECT id, asunto, fecha_envio, inactivo FROM mensajes WHERE remitente_id = ".G_USERID." AND inactivo = 0 ORDER BY fecha_envio DESC LIMIT 10");
			}
		}else{
			// RECIBIDOS

			$result = $objMensaje->Ejecutar("SELECT u.nombres, m.id, m.remitente_id, m.asunto, mu.leido, m.fecha_envio, mu.usuario_id, mu.inactivo FROM mensajes m, mensajes_usuarios mu, usuarios u WHERE m.id = mu.mensaje_id AND u.id = m.remitente_id AND mu.usuario_id = ".G_USERID." AND mu.inactivo=0 ORDER BY fecha_envio DESC LIMIT 10");
		}

		while ($row = mysql_fetch_array($result)){
			$style = "";
			$mod = "";
			// si estamos en la opcion de enviados
			if(isset($_GET['opc']) && $_GET['opc'] == "send"){
				$style = "";
				$mod = "sd"; //send
			}else{
			// si estamos en la opcion de recibidos
				$style = "";
				if($row['leido']==0){
					$style = "style=\"font-weight:bold\"";
				}
				$mod = "rd"; //received
			}
			echo "	<tr $style> <td><a href=\"?pag=men&opc=view&mod=".$mod."&id=".$row['id']."\">".$row['asunto']."</a></td>";

			if(isset($_GET['opc']) && $_GET['opc'] == "send"){
				echo "<td>";
				$coma = "";
				$q = $objUsuario->destinatarios_del_mensaje($row['id']);
				while($r = mysql_fetch_array($q)){
					echo $coma.$r['nombres'];
					$coma=", ";
				}
				//fin categorias
				echo "</td>	";
			}else{
				echo "<td>".$row['nombres']."</td>";
			}
			echo "<td>".$row['fecha_envio']."</td>";
			echo "<td width='40px;'>
						<span>
							<a href=\"#\" style=\"color:red\" title=\"Eliminar\" onclick=\"Delete(".$row['id'].",'men',".G_USERID.",'".$mod."')\">
							<img src=\"img/del-black-16.png\" alt=\"Eliminar\" /></a><!--".$row['inactivo']."-->
						</span>
				</td>
				<tr>\n";
		}
	break;
}
?>
