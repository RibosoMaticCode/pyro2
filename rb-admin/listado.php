<?php
//include 'islogged.php';
if(!isset($sec)):
	$sec = $_GET['sec'];
	require('../global.php');
endif;

require_once(ABSPATH.'rb-script/funciones.php');
switch($sec){
	/* --------------------------------------------------------*/
	/* --------------SECCION ARTICULOS ------------------------*/
	/* --------------------------------------------------------*/
	case "art":
		require_once(ABSPATH."rb-script/class/rb-articulos.class.php");
		require_once(ABSPATH."rb-script/class/rb-categorias.class.php");

		$regMostrar = $_COOKIE['art_show_items'];

		if(isset($_GET['page']) && ($_GET['page']>0)):
			$RegistrosAEmpezar = ($_GET['page']-1) * $regMostrar;
		else:
			$RegistrosAEmpezar = 0;
		endif;

		if(G_USERTYPE == "admin"):
			$consulta = $objArticulo->Consultar("SELECT a.portada, a.id, a.fecha_creacion, a.titulo, a.titulo_enlace, a.lecturas, a.comentarios, a.activo, a.actcom, a.autor_id, u.nickname, u.nombres FROM articulos a, usuarios u WHERE a.autor_id = u.id ORDER BY a.fecha_creacion DESC LIMIT $RegistrosAEmpezar, $regMostrar");
		else:
			$consulta = $objArticulo->Consultar("SELECT a.portada, a.id, a.fecha_creacion, a.titulo, a.titulo_enlace, a.lecturas, a.comentarios, a.activo, a.actcom, a.autor_id, u.nickname, u.nombres FROM articulos a, usuarios u WHERE a.autor_id = u.id AND a.autor_id = ".G_USERID." ORDER BY a.fecha_creacion DESC LIMIT $RegistrosAEmpezar, $regMostrar");
		endif;

		$i=1;

		// bucle para llenar los datos segun pagina
		while ($row = mysql_fetch_array($consulta)):
		?>
			<tr>
				<td><input id="art-<?= $row['id'] ?>" type="checkbox" value="<?= $row['id'] ?>" name="items" /></td>
				<td>
					<h3><?= $row['titulo'] ?></h3>
					<div class="options">
						<span id="boxart_<?= $row['id'] ?>">
							<?php if($row['activo']=="D"): ?>
								<a href="#" title="Activar articulo" onclick="activarArticulo(<?= $row['id'] ?>)">Publicar</a> <!-- actualizar funcion js -->
							<?php else: ?>
								<a href="#" title="Desactivar articulo" onclick="activarArticulo(<?= $row['id'] ?>)">No publicar</a> <!-- actualizar funcion js -->
							<?php endif ?>
						</span>
						<span>
							<a title="Editar" href="../rb-admin/index.php?pag=art&amp;opc=edt&amp;id=<?= $row['id'] ?>">Editar</a>
						</span>
						<span>
							<a href="#" style="color:red" title="Eliminars" onclick="Delete(<?= $row['id'] ?>,'art')">Eliminar</a> <!-- actualizar funcion js -->
						</span>
						<span>
							<a href="content.duplicate.php?id=<?= $row['id'] ?>&sec=art">Duplicar</a>
						</span>
						<span>
							<a href="<?= rb_url_link('art',$row['id']) ?>" target="_blank">Vista Preliminar</a>
						</span>
					</div>
				</td>
				<td class="col_autor"><span style="text-align: center; display: block;"><?php if($row['portada']==1){ ?><img src="img/star-24.png" alt="star" /><?php } ?></span></td>
				<td class="col_autor"><?= $row['nombres'] ?></td>
				<td class="col_categoria">
					<?php
					$coma = "";
					$q = $objCategoria->categorias_del_articulo($row['id']); // Actualizar funcion
					while($r = mysql_fetch_array($q)):
						echo $coma.$r['nombre'];$coma=", ";
					endwhile;
					?>
				</td>
				<td class="col_vistas"><?= $row['lecturas'] ?></td>
				<td class="col_fecha"><?= rb_datesql_to_ddmmyyyy($row['fecha_creacion']) ?></td> <!-- actualizar funcion -->
			</tr>
		<?php
		$i++;
		endwhile;
	break;
    /* --------------------------------------------------------*/
    /* --------------SECCION PAGINAS --------------------------*/
    /* --------------------------------------------------------*/
    case "pages":
        require_once(ABSPATH."rb-script/class/rb-paginas.class.php");
        // determinando consulta con nro de paginas y registro a empezar
        $regMostrar = 30;

        // si pagina esta definido y es mayor que 0
        if(isset($_GET['page']) && ($_GET['page']>0)){
            $RegistrosAEmpezar=($_GET['page']-1)*$regMostrar;
        }else{
            $RegistrosAEmpezar = 0;
        }

		if(isset($_GET['term'])){
			// busqueda inicial sin paginado
            echo "<p>Buscando: <strong>".$_GET['term']."</strong></p>";
            $consulta = $objPagina->Search($_GET['term'], true, $RegistrosAEmpezar, $regMostrar);
        }else{
            // consulta por defecto
            $consulta = $objPagina->Consultar("SELECT * FROM paginas ORDER BY titulo LIMIT $RegistrosAEmpezar, $regMostrar");
        }

        $i=1;
        // bucle para llenar los datos segun pagina
        while ($row = mysql_fetch_array($consulta)){
            echo "
            <tr>
                <td><input id=\"art-".$row['id']."\" type=\"checkbox\" value=\"".$row['id']."\" name=\"items\" /></td>
                <td>
                	<h3>".$row['titulo']."</h3>";

				?>
				<div class="options">
					<span>
						<?php
						if($row['bloques']==1):
						?>
						<a title="Editar" href="../rb-admin/index.php?pag=design&amp;page_id=<?= $row['id'] ?>">Editar</a></span>
						<?php
						else:
						?>
						<a title="Editar" href="../rb-admin/index.php?pag=pages&amp;opc=edt&amp;id=<?= $row['id'] ?>">Editar</a></span>
						<?php
						endif;
						?>
					<span>
						<a href="#" style="color:red" title="Eliminar" onclick="Delete(<?= $row['id'] ?>,'pages')">Eliminar</a></span>
					<span>
						<a href="content.duplicate.php?id=<?= $row['id'] ?>&sec=pages">Duplicar</a></span>
					<span>
						<?php if($row['popup']==1):?>
							<a class="fancybox fancybox.iframe" href="preview.php?page_id=<?php if(isset($row)) echo $row['id'] ?>">Vista previa</a>
						<?php else: ?>
							<a href="<?= rb_url_link('pag',$row['id']) ?>" target="_blank">Vista previa</a>
						<?php endif; ?>
					</span>
				</div>
				</td>
				<td>
					<span><?php if($row['bloques']==1) echo "Estructural"; else echo "Estándar"; ?></span>
				</td>
				<?php
           		echo "<td>".cambiaf_a_normal($row['fecha_creacion'])."</td>";
            $i++;
        }
    break;
	/* --------------------------------------------------------*/
	/* -------------- SECCION MENU ----------------------------*/
	/* --------------------------------------------------------*/
	case "menu":
		// Ver en modulo
	break;
	/* --------------------------------------------------------*/
	/* -------------- SECCION MENUS  -------------------------*/
	/* --------------------------------------------------------*/
	case "menus":
		require_once(ABSPATH."rb-script/class/rb-menus.class.php");

		$result = $objMenu->Consultar("SELECT * FROM menus");
		while ($row = mysql_fetch_array($result)){

			echo "<tr>
					<td><input id=\"art-".$row['id']."\" type=\"checkbox\" value=\"".$row['id']."\" name=\"items\" /></td>
					<td>
						<h3>
						".$row['nombre']."
						</h3>
						<div class='options'>
							<span>
								<a title=\"Elementos\" href='../rb-admin/index.php?pag=menu&amp;id=".$row['id']."'>Añadir elementos</a>
							</span>
							<span>
								<a title=\"Editar\" href='../rb-admin/index.php?pag=menus&amp;opc=edt&amp;id=".$row['id']."'>Cambiar Nombre</a>
							</span>
							<span>
								<a style=\"color:red\" href=\"#\" title=\"Eliminar\" onclick=\"Delete(".$row['id'].",'menus')\">Eliminar</a>
							</span>
						</div>
					</td>";
		}
	break;
	/* --------------------------------------------------------*/
	/* -------------- SECCION GALERIA -------------------------*/
	/* --------------------------------------------------------*/
	case "gal":
		require_once(ABSPATH."rb-script/class/rb-galerias.class.php");

		if(G_USERTYPE == "admin"):
			$q = $objGaleria->Consultar("SELECT a . * , (
	            SELECT COUNT( id )
	            FROM photo
	            WHERE album_id = a.id
	            ) AS nrophotos
	            FROM  `albums` a");
		else:
			$q = $objGaleria->Consultar("SELECT a . * , (
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
			$result = $objFoto->Consultar("SELECT * FROM photo ORDER BY id DESC");
		else:
			$result = $objFoto->Consultar("SELECT * FROM photo WHERE usuario_id = ".G_USERID." ORDER BY id DESC");
		endif;

		while ($row = mysql_fetch_array($result)):
		?>
			<li class="grid-1">
				<div class="cover-img">
				<?php
					if(rb_file_type($row['type']) == "image"):
						echo "<a class=\"fancybox\" rel=\"group\" href=\"../rb-media/gallery/".$row['src']."\"> <img src=\"../rb-media/gallery/tn/".$row['tn_src']."\" /></a>";
					else:
						if( rb_file_type( $row['type'] )=="pdf" ) echo "<img src=\"img/pdf.png\" alt=\"png\" />";
						if( rb_file_type( $row['type'] )=="word" ) echo "<img src=\"img/doc.png\" alt=\"png\" />";
						if( rb_file_type( $row['type'] )=="excel" ) echo "<img src=\"img/xls.png\" alt=\"png\" />";
					endif;
				?>
					<input class="checkbox" id="art-<?= $row['id'] ?>" type="checkbox" value="<?= $row['id'] ?>" name="items" />
					<span class="filename">
						<?= $row['src'] ?>
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

        $result_g = $objGaleria->Consultar("SELECT nombre FROM albums WHERE id=".$album_id);
        $row_g = mysql_fetch_array($result_g);

        //echo "<h2>Album : ".$row_g['nombre']."</h2>";

		require_once(ABSPATH."rb-script/class/rb-fotos.class.php");
		$objFoto = new Fotos;
		$result = $objFoto->Consultar("SELECT p.*, a.nombre FROM photo p, albums a WHERE p.album_id = a.id AND album_id=".$album_id." ORDER BY orden");
		while ($row = mysql_fetch_array($result)){
		?>
			<li class="grid-1" data-id="<?= $row['id'] ?>">
				<div class="cover-img">
			<?php
				if(rb_file_type($row['type']) == "image"){
					echo "<a class=\"fancybox\" rel=\"group\" href=\"../rb-media/gallery/".$row['src']."\"> <img src=\"../rb-media/gallery/tn/".$row['tn_src']."\" /></a>";
				}else {
					if( rb_file_type( $row['type'] )=="pdf" ) echo "<img src=\"img/pdf.png\" alt=\"png\" />";
					if( rb_file_type( $row['type'] )=="word" ) echo "<img src=\"img/doc.png\" alt=\"png\" />";
					if( rb_file_type( $row['type'] )=="excel" ) echo "<img src=\"img/xls.png\" alt=\"png\" />";
				}
				echo '<input class="checkbox" id="art-'.$row['id'].'" type="checkbox" value="'.$row['id'].'" name="items" />';
				?>
				<span class="filename"><?= $row['src'] ?></span>
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
			$consulta = $objComentario->Consultar("SELECT c.*, a.titulo FROM comentarios c, articulos a WHERE a.id = c.articulo_id AND c.articulo_id = $articulo_id ORDER BY fecha DESC");
		}elseif(isset($_GET['page']) && ($_GET['page']>0)){
			$RegistrosAEmpezar=($_GET['page']-1)*$regMostrar;
			if(isset($_GET['term'])){
				//$consulta = $objComentario->search($_GET['term'], false, $RegistrosAEmpezar, $regMostrar);
			}else{
				$consulta = $objComentario->Consultar("SELECT c.*, a.titulo FROM comentarios c, articulos a WHERE a.id = c.articulo_id ORDER BY fecha DESC LIMIT $RegistrosAEmpezar, $regMostrar");
			}
		}else{
			$RegistrosAEmpezar = 0;
			if(isset($_GET['term'])){
				//$consulta = $objComentario->search($_GET['term']);
			}else{
				$consulta = $objComentario->Consultar("SELECT c.*, a.titulo FROM comentarios c, articulos a WHERE c.articulo_id = a.id ORDER BY fecha DESC LIMIT $RegistrosAEmpezar, $regMostrar");
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
		listar_categorias(0);
	break;
	/* --------------------------------------------------------*/
	/* --------------SECCION USUARIOS -------------------------*/
	/* --------------------------------------------------------*/
	case "usu":
		require_once(ABSPATH."rb-script/class/rb-usuarios.class.php");
		$regMostrar = $_COOKIE['user_show_items'];

		$colOrder = "nickname"; // column name table
		$Ord = "ASC"; // A-Z

		if(isset($_GET['page']) && ($_GET['page']>0)){
			$RegistrosAEmpezar=($_GET['page']-1)*$regMostrar;
		}else{
			$RegistrosAEmpezar=0;
		}

		function show_nivel($nivel_id){
			$objUsuario = new Usuarios;
			$q = $objUsuario->Consultar("SELECT nombre FROM usuarios_niveles WHERE id=$nivel_id");
			$r = mysql_fetch_array($q);
			if(mysql_num_rows($q)>0)
				return $r['nombre'];
			else
				return "Ninguno";
		}

		$result = $objUsuario->Consultar("SELECT * FROM usuarios ORDER BY $colOrder $Ord LIMIT $RegistrosAEmpezar, $regMostrar");
		while ($row = mysql_fetch_array($result)){
			echo '	<tr>
						<td><input id="user-'.$row['id'].'" type="checkbox" value="'.$row['id'].'" name="items" /></td>
						<td>'.$row['nickname'].'</td>
						<td>'.$row['nombres'].' '.$row['apellidos'].'
						<div class="options">
						<span><a title="Editar" href="../rb-admin/index.php?pag=usu&amp;opc=edt&amp;id='.$row['id'].'">Editar</a></span>
						<span><a style="color:red" href="#" title="Eliminar" onclick="Delete('.$row['id'].',\'usu\')">Eliminar</a></span></td>
						</div>
						</td>
						<td>'.$row['correo'].'</td>
						<td>'.show_nivel($row['tipo']).'</td>';
			echo		'<td>';
						if($row['activo']==0) echo '<a href="user.active.php?id='.$row['id'].'">¿Activar?</a>';
						else echo "Activo";
			echo 		'</td>';
		}
	break;
    /* --------------------------------------------------------*/
    /* --------------SECCION GRUPOS ---------------------------*/
    /* --------------------------------------------------------*/
    case "gru":
        require_once(ABSPATH."rb-script/class/rb-grupos.class.php");

        $result = $objGrupo->Consultar("SELECT * FROM grupos ORDER BY nombre DESC LIMIT 10");
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
	/* -------------- SECCION ENLACES -------------------------*/
	/* --------------------------------------------------------*/
	case "enl":
		require_once(ABSPATH."rb-script/class/rb-enlaces.class.php");
		$result = $objEnlace->Consultar("SELECT * FROM enlaces ORDER BY fecha_registro DESC LIMIT 10");

		while ($row = mysql_fetch_array($result)){
			echo "	<tr>
						<td><a href=".$row['link'].">".$row['web_nombre']."</a></td>
						<td>".$row['link']."</td>
						<td>".$row['activo']."</td>";
			echo "<td width='40px;'>
					<span>
						<a title=\"Editar\" href='../rb-admin/index.php?pag=enl&amp;opc=edt&amp;id=".$row['id']."'>
						<img style=\"border:0px;\" src=\"img/page_edit.png\" alt=\"Editar\" /></a>
					</span>
					</td>";
			echo "<td width='40px;'>
					<span>
						<a href=\"#\" style=\"color:red\" title=\"Eliminar\" onclick=\"Delete(".$row['id'].",'enl')\">
						<img src=\"img/delete.png\" alt=\"Eliminar\" /></a>
					<span>
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
				$result = $objMensaje->Consultar("SELECT id, asunto, fecha_envio, inactivo FROM mensajes WHERE remitente_id = ".G_USERID." AND inactivo = 0 ORDER BY fecha_envio DESC LIMIT 10");
			}
		}else{
			// RECIBIDOS

			$result = $objMensaje->Consultar("SELECT u.nombres, m.id, m.remitente_id, m.asunto, mu.leido, m.fecha_envio, mu.usuario_id, mu.inactivo FROM mensajes m, mensajes_usuarios mu, usuarios u WHERE m.id = mu.mensaje_id AND u.id = m.remitente_id AND mu.usuario_id = ".G_USERID." AND mu.inactivo=0 ORDER BY fecha_envio DESC LIMIT 10");
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
	/* --------------------------------------------------------*/
	/* -------------- SECCION PUNTOS  -------------------------*/
	/* --------------------------------------------------------*/
	case "puntos":
		require_once(ABSPATH."rb-script/class/rb-puntos.class.php");
		$result = $objPunto->Consultar("SELECT * FROM puntos ORDER BY nombre ASC LIMIT 10");

		while ($row = mysql_fetch_array($result)){
			echo "	<tr>
						<td>".$row['nombre']."</a></td>
						<td>".$row['descripcion']."</td>
						<td>".$row['src']."</td>";
			echo "<td>
					<span>
						<a title=\"Ver Turnos\" href='../rb-admin/index.php?pag=turno&amp;opc=edt&amp;pto_id=".$row['id']."'>
						<img style=\"border:0px;\" src=\"img/time.png\" alt=\"Horarios\" /> Crear y/o editar turnos</a>
					</span>
					</td>";
			echo "<td>
					<span>
						<a title=\"Ver Horarios\" href='../rb-admin/index.php?pag=horario&amp;opc=edt&amp;id=".$row['id']."'>
						<img style=\"border:0px;\" src=\"img/schedule.png\" alt=\"Horarios\" /> Ver y/o asignar horarios</a>
					</span>
					</td>";
			echo "<td width='40px;'>
					<span>
						<a title=\"Editar\" href='../rb-admin/index.php?pag=puntos&amp;opc=edt&amp;id=".$row['id']."'>
						<img style=\"border:0px;\" src=\"img/page_edit.png\" alt=\"Editar\" /></a>
					</span>
					</td>";
			echo "<td width='40px;'>
					<span>
						<a href=\"#\" style=\"color:red\" title=\"Eliminar\" onclick=\"Delete(".$row['id'].",'puntos')\">
						<img src=\"img/delete.png\" alt=\"Eliminar\" /></a>
					<span>
					</td>
					<tr>\n";
		}
	break;
}
?>
