<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH."global.php");
require_once(ABSPATH."rb-script/class/rb-database.class.php");

$mes = $_GET['m'];
$anio = $_GET['y'];
// Verificar si no hay datos en ese mes

// Verificar si todos los publicadores activos llenaron su informe

// GRUPOS
$q_grupos = $objDataBase->Consultar("SELECT * FROM usuarios_grupos ORDER BY nombre");
while($r_grupos = mysql_fetch_array($q_grupos)):
	// Ejecutando consulta:
	$q = "SELECT i.id, u.id as user_id, u.apellidos, u.nombres, u.grupo_id, i.pub, i.vid, i.hor, i.rev, i.est, i.obs, i.mes, i.anio, i.servi, i.respo
		FROM usuarios u LEFT JOIN informes i ON u.id = i.usuario_id
		WHERE u.grupo_id = ".$r_grupos['id']." AND (i.mes = $mes OR i.mes IS NULL) AND (i.anio = $anio OR i.anio IS NULL)
		ORDER BY u.apellidos";

	// PUBLICADORES, CON SU INFORME
	$q_publi = $objDataBase->Consultar($q);

	while($r_info = mysql_fetch_array($q_publi)):
		// INSERTA A LA TABLA FINAL
		$q = "INSERT INTO informes_final (usuario_id, nombres, apellidos, mes, anio, pub, vid, hor, rev, est, obs, grupo, servi, respo)
			VALUES (".$r_info['user_id'].", '".$r_info['nombres']."', '".$r_info['apellidos']."', ".$r_info['mes'].", ".$r_info['anio'].", ".$r_info['pub'].",
				".$r_info['vid'].", ".$r_info['hor'].", ".$r_info['rev'].", ".$r_info['est'].", '".$r_info['obs']."', '".$r_grupos['nombre']."', '".$r_info['servi']."', '".$r_info['respo']."')";
		$objDataBase->Consultar($q);
	endwhile;
endwhile;
sleep(2);
//echo "Reporte final creado";
$enlace=G_SERVER.'/rb-admin/module.php?pag=info';
header('Location: '.$enlace);
?>
