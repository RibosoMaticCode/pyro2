<script>
$(document).ready(function() {
  	$('#search_box').keyup(function(){
	    var valThis = $(this).val();
	    $('.list>li').each(function(){
	      var text = $(this).find('.user_name').text().trim().toLowerCase();
	      (text.indexOf(valThis) == 0) ? $(this).show() : $(this).hide();
	    });
	});
});
</script>
<div id="page-config" class="editor-window">
	<div class="editor-header">
		<strong>Más configuraciones</strong>
	</div>
	<div class="editor-body form">
		<div class="seccion-body cols-container">
			<div class="cols-6-md col-padding">
				<h4>Cabecera</h4>
				<label>
					<input type="radio" name="sheader" value="0" <?php if($shead==0) echo "checked" ?>> <span>Ninguna</span>
				</label>
				<label>
					<input type="radio" name="sheader" value="1" <?php if($shead==1) echo "checked" ?>> <span>Incluir de la plantilla</span>
				</label>
				<label>
					<input type="radio" name="sheader" value="2" <?php if($shead==2) echo "checked" ?>> <span>Personalizada</span>
					<?php
					if(isset($Page)){
						$id = $Page['id'];
						$q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."pages WHERE type=1 AND id<>".$id);
					}else{
						$q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."pages WHERE type=1");
					}
					?>
					<select name="sheader_custom_id">
						<option value="0">Ninguno</option>
						<?php while($header = $q->fetch_assoc()): ?>
						<option value="<?= $header['id'] ?>" <?php if($header['id']==$hcustid) echo "selected" ?>><?= $header['titulo'] ?></option>
						<?php endwhile ?>
					</select>
				</label>
			</div>
			<div class="cols-6-md col-padding">
				<h4>Pie de Pagina</h4>
				<label>
					<input type="radio" name="sfooter" value="0" <?php if($sfoot==0) echo "checked" ?>> <span>Ninguna</span>
				</label>
				<label>
					<input type="radio" name="sfooter" value="1" <?php if($sfoot==1) echo "checked" ?>> <span>Incluir de la plantilla</span>
				</label>
				<label>
					<input type="radio" name="sfooter" value="2" <?php if($sfoot==2) echo "checked" ?>> <span>Personalizada</span>
					<?php
					if(isset($Page)){
						$id = $Page['id'];
						$q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."pages WHERE type=2 AND id<>".$id);
					}else{
						$q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."pages WHERE type=2");
					}
					?>
					<select name="sfooter_custom_id">
						<option value="0">Ninguno</option>
						<?php while($footer = $q->fetch_assoc()): ?>
						<option value="<?= $footer['id'] ?>" <?php if($footer['id']==$fcustid) echo "selected" ?>><?= $footer['titulo'] ?></option>
						<?php endwhile ?>
					</select>
				</label>
			</div>
		</div>
		<div class="seccion-body cols-container">
			<div class="cols-6-md col-padding">
				<h4>Visualización de la página</h4>
				<label>
					<input id="access_required" type="checkbox" <?php if( isset($Page) && $Page['allow_access']==1) echo "checked" ?> /> Solicitar inicio de sesión
				</label>
				<label>
					Permitir solo a estos usuarios:
					<?php
					$qu = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."users");
					?>
					<input id="search_box" type="text" placeholder="Filtrar por..." />
					<div class="list_items">			
						<ul class="list">
							<?php
							while( $user = $qu->fetch_assoc() ){
								$users_ids = [];
								if( isset($Page) ){
									$users_ids = explode(",", $Page['allow_users_ids']);
								}
								?>
								<li>
									<label class="user_name">
										<input type="checkbox" name="users_ids[]" value="<?= $user['id'] ?>" <?php if(in_array ($user['id'], $users_ids)) print "checked"  ?> /> <?= $user['nombres'] ?> <?= $user['apellidos'] ?>
									</label>
								</li>
								<?php
							}
							?>
						</ul>
					</div>
				</label>
			</div>
			<div class="cols-6-md col-padding">
				<h4>Image para redes sociales</h4>
				<label>
					Establecer imagen (beta):
					<input name="image_id" type="text" placeholder="Escribir ID" value="<?php if( isset($Page) ) print $Page['image_id'] ?>" />
				</label>
			</div>
		</div>
	</div>
	<div class="editor-footer">
		<input type="hidden" id="eb_id" value="" />
		<button class="button" id="page-config-btn-cancel">Cerrar</button>
	</div>
</div>