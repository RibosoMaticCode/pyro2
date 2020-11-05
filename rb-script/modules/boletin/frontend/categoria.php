<?php rb_header(['header-allpages.php'], false) ?>
<?php
if(G_ACCESOUSUARIO==0):
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
        $url = "https://";   
    else  
        $url = "http://";   

	// Append the host(domain name, ip) to the URL.   
	$url.= $_SERVER['HTTP_HOST'];   
	    
	// Append the requested resource location to the URL   
	$url.= $_SERVER['REQUEST_URI'];

	print '<p style="text-align:center;padding:30px 10px">Necesita <a href="'.G_SERVER.'/login.php?redirect='.$url.'">iniciar sesion</a> para ver este contenido</p>';
	$allow_view=false;
else:
	?>
	<div class="wrap-content header_area_img" style="background-image: url('<?= $Area['url_image'] ?>')">
		<div class="inner-content">
		</div>
	</div>
	<div class="wrap-content header_area_info">
		<div class="inner-content">
			<div class="area_header">
				<h1><?= $Area['titulo'] ?></h1>
				<p><?= $Area['descripcion'] ?></p>
			</div>
		</div>
	</div>
	<div class="wrap-content">
		<div class="inner-content">
			<div class="area_categorias">
				<!-- listado de categorias -->
				<ul>
				<?php foreach ($CategoriasArray as $Categoria ): ?>
					<li><a href="<?= $Categoria['url'] ?>"><img src="<?= $Categoria['url_icon'] ?>" alt="icon" /> <?= $Categoria['titulo'] ?></a></li>
				<?php endforeach ?>
				</ul>
			</div>
			<div class="area_content cols-container">
				<?php if( count($ContenidosArray) == 0): ?>
					<div class="content_empty">Aun no hay contenidos</div>
				<?php else: ?>
					<?php foreach ($ContenidosArray as $Contenido ): ?>
					<div class="col-6-md">
						<div class="publicacion_item">
							<h2><a href="<?= $Contenido['url'] ?>"><?= $Contenido['titulo'] ?></a></h2>
							<div><?= rb_fragment_text($Contenido['contenido'], 30) ?></div>
							<ul>
								<?php if( $Contenido['videos'] ): ?>
								<li><img src="<?= G_DIR_MODULES_URL ?>boletin/img/iconvideo.png" alt=""></li>
								<?php endif ?>
								<?php if( $Contenido['pdfs'] ): ?>
								<li><img src="<?= G_DIR_MODULES_URL ?>boletin/img/iconpdf.png" alt=""></li>
								<?php endif ?>
								<?php if( $Contenido['video_live'] ): ?>
								<li><img src="<?= G_DIR_MODULES_URL ?>boletin/img/iconlive.png" alt=""></li>
								<?php endif ?>
							</ul>
						</div>
					</div>
					<?php endforeach ?>
				<?php endif ?>
			</div>
		</div>
	</div>
<?php
endif;
?>
<?php rb_footer(['footer-allpages.php'], false) ?>
