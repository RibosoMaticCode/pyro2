<?php
$rm_url = "http://".$_SERVER['SERVER_NAME'];
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Instalación de Pyro: Gestor de Contenidos Básico</title>
		<meta name="description" content="Instalación de Pyro: Gestor de Contenidos Básico">
		<meta name="author" content="Yiustus Liñán">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
		<link rel="shortcut icon" href="favicon.ico">
		<link rel="apple-touch-icon" href="apple-touch-icon.png">

		<link rel="stylesheet" href="<?= $rm_url ?>/rb-admin/css/cols.css">
		<link rel="stylesheet" href="<?= $rm_url ?>/rb-admin/css/login.css">
	</head>

	<body>
		<div class="wrap-content">
			<div class="content">
				<form class="frmlogin frminstall" method="post" action="save.php">
					<h2>Bienvenido!</h2>
					<p class="frmmessage">Para empezar a usar el gestor de contenidos, deberás especificar algunos datos. El proceso no tomará mucho tiempo.</p>
					<div class="frmmessage alert warning">
						<p>Tenga en cuenta haber hecho estos 2 procesos</p>
						<ul>
							<li>Cargar la estructura de base de datos (puede descargar una copia <a href="/_sql/pyro.sql">desde aqui</a>)</li>
							<li>Especificar nombre de base de datos, usuario y clave necesarios en el archivo <code>config.php</code></li>
						</ul>
					</div>
					<label>
						<span>Título del sitio</span>
						<input type="text" name="sitio_titulo" required />
					</label>
					<label>
						<span>URL del sitio</span>
						<input type="text" name="sitio_url" value="<?= $rm_url ?>" required readonly />
					</label>
					<label>
						<span>Correo electronico</span>
						<input type="email" name="usuario_correo" required />
					</label>
					<label>
						<span>Contraseña</span>
						<input type="password" name="usuario_pass" required />
					</label>
					<label>
						<span>Repetir Contraseña</span>
						<input type="password" name="usuario_pass1" required />
					</label>
					<button>Crear el sitio</button>
				</form>
				<p style="font-size: .8em;margin-top: 20px; text-align: center"><a href="version.txt">Datos sobre la versión</a></p>
			</div>
		</div>
	</body>
</html>
