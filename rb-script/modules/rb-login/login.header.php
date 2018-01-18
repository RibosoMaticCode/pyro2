<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title><?= $page_title ?> | <?= $rm_title ?></title>
		<meta name="description" content="<?= $rm_metadescription ?>">
		<meta name="author" content="BlackPyro <?= G_VERSION ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
		<link rel="stylesheet" href="<?= $rm_url ?>rb-admin/css/cols.css">
		<link rel="stylesheet" href="<?= $rm_url ?>rb-admin/css/login.css">
		<!-- favicon from template -->
		<link rel="shortcut icon" href="<?= $rm_urltheme ?>favicon.ico">
		<link rel="apple-touch-icon" href="<?= $rm_urltheme ?>apple-touch-icon.png">
		<script src="<?= $rm_url ?>rb-admin/js/jquery-1.11.1.min.js"></script>
		<!-- Add fancyBox -->
		<link rel="stylesheet" href="<?= G_SERVER ?>/rb-admin/resource/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
		<script src="<?= G_SERVER ?>/rb-admin/resource/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
		<script src="<?= G_SERVER ?>/rb-admin/resource/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
		<script>
			$(document).ready(function() {
				$(".fancybox").fancybox();
			});
		</script>
	</head>
	<?php
	if(G_BGLOGIN>0) $bg_styles = 'style="background:url(' . rb_photo_login(G_BGLOGIN) . ') no-repeat center center;background-size:cover;"';
	else $bg_styles = '';
	?>
	<body <?= $bg_styles ?>>
