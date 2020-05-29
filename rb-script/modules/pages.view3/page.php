<?php rb_header(array('header-allpages.php')) ?>
<?php
	$allow_view = true; // Permitir ver por defecto: true
	if( $Page['allow_access']==1){
		// Si no inicio sesion
		print '<div class="wrap-content"><div class="inner-content">';
	    if(G_ACCESOUSUARIO==0){
			if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
		        $url = "https://";   
		    else  
		        $url = "http://";   
		    // Append the host(domain name, ip) to the URL.   
		    $url.= $_SERVER['HTTP_HOST'];   
		    
		    // Append the requested resource location to the URL   
		    $url.= $_SERVER['REQUEST_URI'];

		    if($Page['blocking_message']==""){
			    print '<p style="text-align:center;padding:30px 10px">Necesita <a href="'.G_SERVER.'/login.php?redirect='.$url.'">iniciar sesion</a> para ver este contenido</p>';
			}else{
				print rb_shortcode(rb_BBCodeToGlobalVariable(html_entity_decode($Page['blocking_message'])));
			}
			$allow_view=false;
		}

	    // Si inicio sesion
	    if(G_ACCESOUSUARIO==1){
			// Usuarios permitidos
		    $users_ids = explode(",", $Page['allow_users_ids']);
		    if(!in_array (G_USERID, $users_ids)) {
		    	print '<p style="text-align:center;padding:30px 10px">No tiene permiso para ver este contenido. Si es considera es un error, contacte con el administrador.</p>';
		    	$allow_view=false;
			}else{
				$allow_view=true;
			}
		}

		print '</div></div>';
	}

	if($allow_view){
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
