<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(__FILE__)) . '/');

require_once ABSPATH.'rb-script/funcs.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
if(is_https()){
	$protocol = "https://";
}else{
	$protocol = "http://";
}
$directory = str_replace('/rb-install/index.php', '', $_SERVER['SCRIPT_NAME']);
$rm_url = $protocol.$_SERVER['SERVER_NAME'].$directory;
$rm_urlinstall = $rm_url;

define('G_PREFIX', 'py_');//'select 1 from `table_name` LIMIT 1'
$q = $objDataBase->Ejecutar("SELECT 1 FROM ".G_PREFIX."configuration LIMIT 1");
if($q!==false){ // existe la base de datos
	// Fragmentamos la url
	$url_parts = explode("/",$_SERVER['SCRIPT_NAME']);
	// Obtenermos el ultimo elemento del array
	$last_part_url = $url_parts[count($url_parts)-1];
	// Obtener el directorio donde estara instalado el cms
	// Reemplazamos el ultimo elemento con un dato campo vacio para obtener este valor
	$directory = str_replace('/'.$last_part_url, '', $_SERVER['SCRIPT_NAME']);
	header('Location: '.$directory.'/login.php');
}
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Instalación de Pyro: Gestor de Contenidos Básico</title>
		<meta name="description" content="Instalación de Pyro: Gestor de Contenidos Básico">
		<meta name="author" content="RibosoMatic">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
		<link rel="shortcut icon" href="<?= $rm_url ?>/rb-script/images/blackpyro-logo.png">
		<link rel="apple-touch-icon" href="<?= $rm_url ?>/rb-script/images/blackpyro-logo.png">
		<link rel="stylesheet" href="<?= $rm_url ?>/rb-script/modules/rb-login/login.css">
		<link rel="stylesheet" href="<?= $rm_url ?>/rb-admin/css/style.css">
		<link rel="stylesheet" href="<?= $rm_url ?>/rb-admin/css/fonts.css">
		<script src="<?= $rm_url ?>/rb-admin/js/jquery-1.11.2.min.js"></script>
		<script src="<?= $rm_url ?>/rb-admin/js/func.js"></script>
	</head>
	<body>
		<div id="message"></div>
		<div class="bg"></div>
		<img class="imgLoading" src="<?= $rm_url ?>/rb-script/images/loading.gif" alt="Loading" style="display:none" />
		<div class="wrap-content">
			<div class="content">
				<form id="frmCreateSite" class="frmlogin frminstall" method="post">
					<div class="coverFormCreateSite">
						<h2>Bienvenido!</h2>
						<p class="frmmessage">Para empezar a usar el gestor de contenidos, deberás especificar algunos datos. El proceso no tomará mucho tiempo.</p>
						<div class="frmmessage alert warning">
							<p>Tenga en cuenta haber hecho esto antes.</p>
							<ul>
								<li>Crear tu base de datos MySQL en tu servicio de hospedaje.</li>
								<li>Especificar nombre de base de datos, usuario y clave necesarios en el archivo <code>config.php</code></li>
							</ul>
						</div>
						<label>
							<span>Título del sitio</span>
							<input type="text" name="sitio_titulo" />
						</label>
						<label>
							<span>URL del sitio</span>
							<input type="text" name="sitio_url" value="<?= $rm_urlinstall ?>" required readonly />
						</label>
						<label>
							<span>Correo electronico</span>
							<span class="info">Ingresa un correo válido</span>
							<input type="email" name="usuario_correo" />
						</label>
						<label>
							<span>Contraseña</span> <a id="btnGeneratePass" href="#">Generar</a><a id="btnShowHidePass" href="#">Mostrar/Ocultar</a>
							<span class="info">La contraseña debe tener al menos numero, minusculas, mayúscula y caracter no alfanumerico. Minimo 8 caracteres.</span>
							<input type="password" name="usuario_pass" />
						</label>
						<label>
							<span>Repetir Contraseña</span>
							<input type="password" name="usuario_pass1" />
						</label>
						<button>Crear el sitio</button>
					</div>
				</form>
				<div class="message">
				</div>
				<script>
				$(document).ready(function(){
					// Crear sitio web
					$('#frmCreateSite').submit(function(event){
				    event.preventDefault();
						$('.bg, .imgLoading').show();
						$.ajax({
							type: 'post',
							url: 'save.php',
							data: $( this ).serialize()
						})
						.done( function (data){
							$('.bg, .imgLoading').hide();
							if(data.result){
								$('.coverFormCreateSite').empty();
								$('.coverFormCreateSite').append(data.message);
								setTimeout(function(){
				          window.location.href = 'login.php';
				        }, 1500);
							}else{
								notify(data.message);
							}
						});
					});

					// Generar contraseña
					$('#btnGeneratePass').click(function(event){
						event.preventDefault();
						$('.bg, .imgLoading').show();
						var postData = {
							'function': 'random',
							'parameters': '8,abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
						}
						$.ajax({
							type: 'post',
							url: '../rb-script/list.data.func.php',
							data: {dataToSend: postData}
						})
						.done( function (data){
							$('.bg, .imgLoading').hide();
							$("input[name='usuario_pass']").get(0).type = 'text';
							$("input[name='usuario_pass1']").get(0).type = 'text';
							$("input[name='usuario_pass']").val(data);
							$("input[name='usuario_pass1']").val(data);
						});
					})

					// Mostrar/ocultar
					$('#btnShowHidePass').click(function(event){
						event.preventDefault();
						var input_type = $("input[name='usuario_pass']").attr('type');
						console.log(input_type);
						if(input_type == "text"){
							$("input[name='usuario_pass']").get(0).type = 'password';
							$("input[name='usuario_pass1']").get(0).type = 'password';
						}
						if(input_type == "password"){
							$("input[name='usuario_pass']").get(0).type = 'text';
							$("input[name='usuario_pass1']").get(0).type = 'text';
						}
					});
				});
				</script>
				<p style="font-size: .8em;margin-top: 20px; text-align: center"><a href="version.txt">Datos sobre la versión</a></p>
			</div>
		</div>
	</body>
</html>
