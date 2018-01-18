<?php
include 'islogged.php';
?>
<!DOCTYPE HTML>
<html class="bg-main" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta content="True" name="HandheldFriendly">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
<title><?= $rb_title ?></title>
<link rel="stylesheet" type="text/css" href="<?= G_SERVER ?>/rb-admin/css/style.css" />
<link rel="stylesheet" type="text/css" href="<?= G_SERVER ?>/rb-admin/css/styles2.css" />
<link rel="stylesheet" type="text/css" href="<?= G_SERVER ?>/rb-admin/css/cols.css" />
<link rel="stylesheet" type="text/css" href="<?= G_SERVER ?>/rb-admin/css/table.css" />
<link rel="stylesheet" type="text/css" href="<?= G_SERVER ?>/rb-admin/css/responsive.css" />
<link rel="stylesheet" type="text/css" href="<?= G_SERVER ?>/rb-admin/css/menu.css" />
<link rel="stylesheet" type="text/css" href="<?= G_SERVER ?>/rb-admin/css/fonts.css" />
<link rel="stylesheet" type="text/css" href="<?= G_SERVER ?>/rb-admin/css/font-awesome.css" />
<link rel="stylesheet" type="text/css" href="<?= G_SERVER ?>/rb-admin/resource/nestable/nestable.css" />
<!-- modulos css -->
<?= do_action('panel_header_css') ?>

<script src="<?= G_SERVER ?>/rb-admin/js/jquery-1.11.1.min.js"></script>
<script src="<?= G_SERVER ?>/rb-admin/js/func.js"></script>
<script src="<?= G_SERVER ?>/rb-admin/js/jquery.easing.1.3.js"></script>

<!-- modulos js -->
<?= do_action('panel_header_js') ?>

<!-- Add fancyBox -->
<link rel="stylesheet" href="<?= G_SERVER ?>/rb-admin/resource/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script src="<?= G_SERVER ?>/rb-admin/resource/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<script src="<?= G_SERVER ?>/rb-admin/resource/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

<!-- jquery ui -->
<link rel="stylesheet" href="<?= G_SERVER ?>/rb-admin/resource/ui/jquery-ui.css">

<!-- Funciones nuevas -->
<script src="<?= G_SERVER ?>/rb-admin/core/explo-uploader/file.explorer.js"></script>
<script>
	$(document).ready(function() {
		$(".fancybox").fancybox();

		// scroll then menu top fixed
		var num = 64; //number of pixels before modifying styles
		$(window).bind('scroll', function () {
			if ($(window).scrollTop() > num) {
				$('#toolbar').addClass('fixed');
			} else {
				$('#toolbar').removeClass('fixed');
			}
		});

		// Btn Menu - Open
		$('.btnMenuOpen').click( function (event){
			event.preventDefault();
			$('.items').show();
			//$('.items').show("slide", { direction: "left" }, 300);
			$(".bg-opacity").fadeIn();

			$('html, body').css({
			    'overflow': 'hidden',
			    'height': '100%'
			});
		});

		// Btn Menu - Close
		$('.btnMenuClose').click( function (event){
			event.preventDefault();
			$('.items').hide();
			//$('.items').hide("slide", { direction: "left" }, 200);
			$(".bg-opacity").fadeOut();

			$('html, body').css({
			    'overflow': 'auto',
			    'height': 'auto'
			});
		});

		// Add BtnClose to Help Box
		$('.help').append('<a id="help-close" class="help-close" href="#">X</a>');
		$('.help').on("click", "#help-close", function(event){
			var $NameHelpBox = $('.help').attr("data-name");
			//alert($NameHelpBox);
			$.ajax({
				type: 'GET',
				url: 'hide.help.php',
				data: {
					nameHelpBox: $NameHelpBox
				}
			})
			.done( function (data){
				console.log(data);
				$('.help').slideUp();
			});
		});
	});

	// Notificador principal
	var notify = function($text){
		$("#message").show();
		$("#message").html('<h3>'+$text+'</h3>');
		$("#message").animate({ "top": "+=50px", "opacity" : 1 }, "slow" );
		$("#message").delay(2000).animate({ "top": "-=50px", "opacity" : 0 }, "slow" );
	}
	/*var light_box = function(thisObj, msj){
		thisObj.addClass('input_red');
		thisObj.focus();
		thisObj.nextAll().remove();
		thisObj.after('<span style="color:red;font-size:.8em;">'+msj+'</span>');
	}*/
	var validateInputText = function(thisObj, msj){
		if( thisObj.val() == ""){
			thisObj.addClass('input_red');
			thisObj.focus();
			thisObj.nextAll().remove();
			thisObj.after('<span style="color:red;font-size:.8em;">'+msj+'</span>');
			//return false;
			event.preventDefault();
		}else{
			thisObj.removeClass('input_red');
			thisObj.nextAll().remove();
		}
	}
</script>
</head>
<body>
<?php
function msgOk($text){
	?>
	<script>
	notify('<?= $text ?>');
	</script>
	<?php
}
if(isset($_GET['m']) && $_GET['m']=="1")msgOk("Se envio un correo al usuario");
?>
<div id="message"></div>
<div class="bg-opacity"></div>
<div class="explorer"></div>
<header id="wrap-menu">
    <div class="logo">
    	<h1 class="title-web"><a href="index.php" title="Página Inicial"><?= $titulo ?></a></h1>
    	<a class="btnMenuOpen" href="#"><img src="img/icon_menu.png" height="24" width="24" alt="Menu"></a>
    </div>
    <div class="bar">
    	<form id="search-form" action="index.php" method="get">
    		<input type="text" name="term" placeholder="Escriba su busqueda" required />
    		<button class="search">B</button>
    	</form>
			<div class="menu2">
				<?php if(G_ESTILO!="0"): ?>
	    	<a title="Ver Sitio Web" class="btn-primary btn-goto-web" target="_blank" href="<?= G_SERVER ?>">
					<img src="img/website-icon.png" alt="Ver Sitio Web">
				</a>
				<?php endif ?>
				<?php if($userType == "admin"): ?>
	    	<a id="modules" title="Añadir funciones extras" href="modules.php">
	    		<img src="img/plugin-icon.png" alt="Modulos">
	    	</a>
				<?php endif ?>
	    	<?php if($userType == "admin"): ?>
	    	<a id="config" title="Opciones" href="index.php?pag=opc">
	    		<img src="img/options-icon.png" alt="Configuración general">
	    	</a>
	    	<?php endif ?>
	    	<a id="out" title="Cerrar sesion" href="<?= G_SERVER ?>/login.php?out">
	    		<img src="img/out-icon.png" alt="Cerrar">
	    	</a>
			</div>
    </div>
</header>
