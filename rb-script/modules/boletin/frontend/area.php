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
				<ul>
				<?php foreach ($CategoriasArray as $Categoria ): ?>
					<li><a href="<?= $Categoria['url'] ?>"><img src="<?= $Categoria['url_icon'] ?>" alt="icon" /> <?= $Categoria['titulo'] ?></a></li>
				<?php endforeach ?>
				</ul>
			</div>
		</div>
	</div>
	<?php
endif;
?>
<?php rb_footer(['footer-allpages.php'], false) ?>
