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
			<div class="area_content">
				<!-- publicacion -->
				<div class="cols-container">
					<div class="cols-9-md">
						<div class="publicacion_content">
							<a href="<?= $CategoriaActual['url'] ?>">Volver a <?= $CategoriaActual['titulo'] ?></a>
							<h1>
								<?= $PublicacionActual['titulo'] ?>
								<?php if( $PublicacionActual['video_live']!="" ): ?>
									<a class="fancy fancybox.iframe" href="https://www.youtube.com/embed/<?= $PublicacionActual['video_live'] ?>">
										<img src="<?= G_DIR_MODULES_URL ?>boletin/img/iconlive.png" alt="icon" />
									</a>
								<?php endif ?>
							</h1>

							<?php if( $PublicacionActual['imagen_id'] > 0): ?>
								<img src="<?= $PublicacionActual['url_image'] ?>" alt="imagen publicacion" />
							<?php endif ?>

							<?php if( $PublicacionActual['pdfs']!=false ): ?>
							<div class="publicacion_pdfs">
								<h3>Descargue su material de trabajo</h3>
								<ul>
									<?php foreach ($PublicacionActual['pdfs_list'] as $pdf_file): ?>
										<li><?= url_get_name_file($pdf_file) ?>
											<a download href="<?= $pdf_file ?>"><img src="<?= G_DIR_MODULES_URL ?>boletin/img/download.png" alt="icon" /></a>
										</li>
									<?php endforeach ?>
								</ul>
							</div>
							<?php endif ?>

							<div class="content">
								<?= $PublicacionActual['contenido'] ?>
							</div>

							<?php if( $PublicacionActual['videos']!=false ): ?>
							<div class="publicacion_videos">
								<h3>Videos relacionados</h3>
								<ul class="clear">
									<?php foreach ($PublicacionActual['videos_list'] as $video_url): ?>
										<li>
											<a class="fancy fancybox.iframe" href="https://www.youtube.com/embed/<?= $video_url ?>">
												<img src="https://i.ytimg.com/vi/<?= $video_url ?>/sddefault.jpg" />
											</a>
										</li>
									<?php endforeach ?>
								</ul>
							</div>
							<?php endif ?>
						</div>
					</div>
					<div class="cols-3-md">
						<div class="publicacion_sidebar">
							<h2>Temas relacionados</h2>
							<ul class="publicacion_list">
							<?php foreach ($ContenidosArray as $Contenido ): ?>
								<li>
									<h2><a href="<?= $Contenido['url'] ?>"><?= $Contenido['titulo'] ?></a></h2>
									<div><?= rb_fragment_text($Contenido['contenido'], 20) ?></div>
								</li>
							<?php endforeach ?>
							</ul>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
<?php
endif;
?>
<?php rb_footer(['footer-allpages.php'], false) ?>
