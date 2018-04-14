<!DOCTYPE html>
<html lang="es">
	<head>
    <meta charset="utf-8">
		<title><?= rm_title ?></title>
		<meta name="description" content="<?= rm_metadescription ?>">
		<meta name="author" content="<?= rm_metaauthor ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>

		<meta property="og:title" content="<?= rm_title ?>"/>
		<meta property="og:image" content="<?= rm_urltheme ?>img/default.png"/>
		<meta property="og:site_name" content="<?= rm_titlesite ?>"/>
		<meta property="og:description" content="<?= rm_metadescription ?>" />

		<link rel="stylesheet" href="<?= rm_urltheme ?>css/styles.css">
		<link rel="stylesheet" href="<?= rm_urltheme ?>css/cols.css">
		<link rel="stylesheet" href="<?= rm_urltheme ?>css/font-awesome.css">
		<link rel="stylesheet" href="<?= rm_url?>rb-script/modules/pages.view/styles-page.css">
		<link rel="stylesheet" href="<?= rm_urltheme ?>css/styles-add.css">
		<link rel="stylesheet" href="<?= rm_urltheme ?>css/responsive.css">
		<link rel="stylesheet" href="<?= rm_url?>rb-admin/css/frontend-bar.css">
		<link rel="shortcut icon" href="<?= rm_urltheme ?>favicon.ico">
		<link rel="apple-touch-icon" href="<?= rm_urltheme ?>apple-touch-icon.png">
		<!-- jquery -->
	  <script src="<?= rm_urltheme ?>js/jquery-1.11.2.min.js"></script>
		<script src="<?= rm_urltheme ?>js/jquery-migrate-1.2.1.js"></script>
		<!-- parallax -->
		<script src="<?= rm_urltheme ?>js/parallax.js"></script>
		<!-- fancy box -->
	  <link rel="stylesheet" href="<?= rm_urltheme ?>res/fancybox/source/jquery.fancybox.css" type="text/css" media="screen" />
	  <script src="<?= rm_urltheme ?>res/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
		<script src="<?= rm_urltheme ?>res/fancybox/source/jquery.fancybox.pack.js"></script>
		<script src="<?= rm_urltheme ?>res/fancybox/source/helpers/jquery.fancybox-media.js"></script>
		<!-- camera plugin -->
  	<link rel="stylesheet" href="<?= rm_urltheme ?>res/camera/css/camera.css">
		<script src="<?= rm_urltheme ?>res/camera/scripts/jquery.easing.1.3.js"></script>
		<script src="<?= rm_urltheme ?>res/camera/scripts/camera.min.js"></script>
		<script>
			$(document).ready(function() {
				$(".fancy").fancybox();

				if ($('.slide').length>0) {
					$('.slide').camera({
						height: 'auto',
						pagination: false,
						thumbnails: false,
						opacityOnGrid: false,
						time:4500,
						fx:  'scrollTop',
						loader: 'bar',
						imagePath: 'img/'
					});
				}
				// Menu
				$('.BtnOpen').click(function(event){
					event.preventDefault();
					$('.menu').show();
				});
				$('.BtnClose').click(function(event){
					event.preventDefault();
					$('.menu').hide();
				});
				// Formulario Contacto
				$('#fcontact').submit(function (){
					event.preventDefault();
					$.ajax({
						method: "post",
						url: "<?= rm_urltheme ?>mailer-contact.php",
						data: $( this ).serialize()
					})
					.done(function( data ) {
						if(data==1){
						    $('#fcontact').slideUp();
							$('.result').html('<h2 style="color:green">Mensaje enviado. Nos pondremos en contacto pronto.');
						}else{
						    $('.result').html('<h2 style="color:red">Algo salio mal. Intenta mas tarde');
						}
					});
				});
			});
		</script>
	</head>
	<body>
		<?php //rb_show_bar_admin() ?>
