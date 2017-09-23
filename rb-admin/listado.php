<?php
//include 'islogged.php';
if(!isset($sec)):
	$sec = $_GET['sec'];
	require('../global.php');
endif;

require_once(ABSPATH.'rb-script/funciones.php');
switch($sec){
	/* --------------------------------------------------------*/
	/* -------------- SECCION GALERIA -------------------------*/
	/* --------------------------------------------------------*/
	case "gal":
		require_once(ABSPATH."rb-script/class/rb-galerias.class.php");

		if(G_USERTYPE == "admin"):
			$q = $objGaleria->Ejecutar("SELECT a . * , (
	            SELECT COUNT( id )
	            FROM photo
	            WHERE album_id = a.id
	            ) AS nrophotos
	            FROM  `albums` a");
		else:
			$q = $objGaleria->Ejecutar("SELECT a . * , (
	            SELECT COUNT( id )
	            FROM photo
	            WHERE album_id = a.id
	            ) AS nrophotos
	            FROM  `albums` a WHERE usuario_id =".G_USERID);
		endif;
		while ($row = mysql_fetch_array($q)){

			echo "<tr>
					<td><input id=\"art-".$row['id']."\" type=\"checkbox\" value=\"".$row['id']."\" name=\"items\" /></td>
					<!--<td width='40px;'>
					<span>
						<a title=\"Agregar fotos al album\" href='../rb-admin/index.php?pag=img&amp;opc=nvo&amp;album_id=".$row['id']."'>
						<img style=\"border:0px;\" width=\"16px\" height=\"16px\" src=\"img/add.png\" alt=\"Agregar Fotos\" /></a>
					</span>
					</td>-->
					<td>
						<h3>".$row['nombre']."</h3>
						<div class='options'>
							<span><a href='../rb-admin/index.php?pag=img&amp;album_id=".$row['id']."'>Ver contenido</a></span>
							<span><a href='../rb-admin/index.php?pag=gal&amp;opc=edt&amp;id=".$row['id']."'>Editar</a></span>
							<span><a href='#' style=\"color:red\" onclick=\"Delete(".$row['id'].",'gal')\">Eliminar</a></span>
						</div>
					</td>
					<td>".$row['descripcion']."</td>
					<td>".$row['fecha']."</td>
					<td>".$row['nrophotos']."</td>
				<tr>";
		}
	break;
	/* --------------------------------------------------------*/
	/* -------------- SECCION IMAGENES ------------------------*/
	/* --------------------------------------------------------*/
	case "files":
		require_once(ABSPATH."global.php");
		require_once(ABSPATH."rb-script/class/rb-galerias.class.php");
		require_once(ABSPATH."rb-script/class/rb-fotos.class.php");
		$objFoto = new Fotos;

		if(G_USERTYPE == "admin"):
			$result = $objFoto->Ejecutar("SELECT * FROM photo ORDER BY id DESC");
		else:
			$result = $objFoto->Ejecutar("SELECT * FROM photo WHERE usuario_id = ".G_USERID." ORDER BY id DESC");
		endif;

		while ($row = mysql_fetch_array($result)):
		?>
			<li class="grid-1">
				<div class="cover-img">
				<?php
					if(rb_file_type($row['type']) == "image"):
						echo "<a class=\"fancybox\" rel=\"group\" href=\"../rb-media/gallery/".utf8_encode($row['src'])."\"> <img src=\"../rb-media/gallery/tn/".utf8_encode($row['tn_src'])."\" /></a>";
					else:
						if( rb_file_type( $row['type'] )=="pdf" ) echo "<img src=\"img/pdf.png\" alt=\"png\" />";
						if( rb_file_type( $row['type'] )=="word" ) echo "<img src=\"img/doc.png\" alt=\"png\" />";
						if( rb_file_type( $row['type'] )=="excel" ) echo "<img src=\"img/xls.png\" alt=\"png\" />";
					endif;
				?>
					<input class="checkbox" id="art-<?= $row['id'] ?>" type="checkbox" value="<?= $row['id'] ?>" name="items" />
					<span class="filename">
						<?= utf8_encode($row['src']) ?>
					</span>
					<span class="edit"><a href="../rb-admin/index.php?pag=file_edit&amp;opc=edt&amp;id=<?= $row['id'] ?>">
						<img src="img/edit-black-16.png" alt="icon" />
					</a></span>
					<span class="delete"><a href="#" style="color:red" onclick="Delete(<?= $row['id'] ?>,'files',0,0)">
						<img src="img/del-black-16.png" alt="icon" />
					</a></span>
				</div>
			</li>
		<?php
		endwhile;
	break;
	/* --------------------------------------------------------*/
	/* -------------- SECCION IMAGENES ------------------------*/
	/* --------------------------------------------------------*/
	case "img":
		require_once(ABSPATH."rb-script/class/rb-galerias.class.php");
        if ( defined('G_ALBUMID')) echo G_ALBUMID;

        if ( defined('G_ALBUMID')) $album_id = $AlbumID;
        else $album_id = $_GET['album_id'];

        $result_g = $objGaleria->Ejecutar("SELECT nombre FROM albums WHERE id=".$album_id);
        $row_g = mysql_fetch_array($result_g);

        //echo "<h2>Album : ".$row_g['nombre']."</h2>";

		require_once(ABSPATH."rb-script/class/rb-fotos.class.php");
		$objFoto = new Fotos;
		$result = $objFoto->Ejecutar("SELECT p.*, a.nombre FROM photo p, albums a WHERE p.album_id = a.id AND album_id=".$album_id." ORDER BY orden");
		while ($row = mysql_fetch_array($result)){
		?>
			<li class="grid-1" data-id="<?= $row['id'] ?>">
				<div class="cover-img">
			<?php
				if(rb_file_type($row['type']) == "image"){
					echo "<a class=\"fancybox\" rel=\"group\" href=\"../rb-media/gallery/".utf8_encode($row['src'])."\"> <img src=\"../rb-media/gallery/tn/".utf8_encode($row['tn_src'])."\" /></a>";
				}else {
					if( rb_file_type( $row['type'] )=="pdf" ) echo "<img src=\"img/pdf.png\" alt=\"png\" />";
					if( rb_file_type( $row['type'] )=="word" ) echo "<img src=\"img/doc.png\" alt=\"png\" />";
					if( rb_file_type( $row['type'] )=="excel" ) echo "<img src=\"img/xls.png\" alt=\"png\" />";
				}
				echo '<input class="checkbox" id="art-'.$row['id'].'" type="checkbox" value="'.$row['id'].'" name="items" />';
				?>
				<span class="filename"><?= utf8_encode($row['src']) ?></span>
				<?php
				echo '<span class="edit"><a href="../rb-admin/index.php?pag=img&amp;opc=edt&amp;id='.$row['id'].'&amp;album_id='.$row['album_id'].'">
					<img src="img/edit-black-16.png" alt="icon" />
				</a></span>';
				echo '<span class="delete"><a href="#" style="color:red" title="Eliminar" onclick="Delete('.$row['id'].',\'img\',0,'.$row['album_id'].')">
					<img src="img/del-black-16.png" alt="icon" />
				</a></span>';
			?>
				</div>
			</li>
		<?php
		}
	break;
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
