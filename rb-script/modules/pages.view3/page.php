<?php rb_header(array('header-allpages.php')) ?>
<?php
	if($Page['allow_access']==1 && G_ACCESOUSUARIO==0){
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
	        $url = "https://";   
	    else  
	        $url = "http://";   
	    // Append the host(domain name, ip) to the URL.   
	    $url.= $_SERVER['HTTP_HOST'];   
	    
	    // Append the requested resource location to the URL   
	    $url.= $_SERVER['REQUEST_URI'];    
	      
		print '<p style="text-align:center;padding:30px 10px">Necesita <a href="'.G_SERVER.'/login.php?redirect='.$url.'">iniciar sesion</a> para ver este contenido</p>';
	}else{
		?>
		<div class="wrap-content">
		<?php
		$array_content = json_decode($Page['contenido'], true);
		foreach ($array_content['boxes'] as $box) {
		  rb_show_block($box);
		}
		?>
		</div>
		<?php
	}
?>
<?php rb_footer(array('footer-allpages.php')) ?>
