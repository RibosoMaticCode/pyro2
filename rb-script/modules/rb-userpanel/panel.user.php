<script type="text/javascript">
	$(document).ready(function(){
		$('#userdata').submit(function() {
			$.ajax({
				data:  $('#userdata').serialize(), 
				type: "POST",
				dataType: "html",
				url: "<?= $rm_url?>rb-script/modules/rb-userpanel/saveuserdata.php"
			})
			.done(function( msg ) {
				if(msg == "Exito") {
					alert("Datos actualizados");
				}else{
			    	alert(msg);
			    }
			});			 
			return false;
		});
	});
</script>
	<div class="content-right content-right-add">
		<form id="userdata" class="frm" action="<?= $rm_url?>rb-script/modules/rb-userpanel/saveuserdata.php" method="post">
			
			<label class="col"><span>Nombres:</span>
				<input class="itext" type="text" id="nom" name="nom" value="<?= $UsuarioItem['nombres'] ?>"  />
			</label>
			<label class="col"><span>Apellidos:</span>
				<input class="itext" type="text" id="ape" name="ape" value="<?= $UsuarioItem['apellidos'] ?>"  />
			</label>
			<label class="col"><span>Direccion:</span>
				<input class="itext" type="text" id="dir" name="dir" value="<?= $UsuarioItem['direccion'] ?>"  />
			</label>
			<label class="col"><span>Ciudad:</span>
				<input class="itext" type="text" id="cir" name="cir" value="<?= $UsuarioItem['ciudad'] ?>"  />
			</label>
			<label class="col"><span>Telefono Movil:</span>
				<input class="itext" type="text" id="tem" name="tem" value="<?= $UsuarioItem['telefono-movil'] ?>"  />
			</label>
			<label class="col"><span>Telefono Fijo:</span>
				<input class="itext" type="text" id="tef" name="tef" value="<?= $UsuarioItem['telefono-fijo'] ?>"  />
			</label>
			<label class="col"><span>Correo Electronico:</span>
				<input class="itext" type="text" id="cor" name="cor" value="<?= $UsuarioItem['correo'] ?>"  />
			</label>
			<div style="clear:both"></div>
			<span class="info">Sino deseas cambiar la contraseña, deje los campos siguientes vacios.</span>
			
			<h3>Cambiar contrase&ntilde;a</h3>
			<?php
			if(isset($_GET['msg'])){
			    switch($_GET['msg']):
                    case 1:
                        imprimir('<h3>Se cambio con exito la contrase&ntilde;a</h3>');
                    break;
                    default:
                endswitch;
            }
			?>
			<label class="col"><span>Contrase&ntilde;a:</span>
				<input class="itext" type="password" id="p1" name="pass1" />
			</label>
			<label class="col"><span>Vuelva a escribir:</span>
				<input class="itext" type="password" id="p2" name="pass2" />
			</label>
			<div style="clear:both"></div>
			<input type="hidden" id="userid" name="userid" value="<?= $UsuarioItem['id'] ?>" />
			<div class="frm-foot">
				<input class="btn-comment" type="submit" name="newpass" value="Guardar Datos" />
			</div>			
		</form>
		<div style="clear:both"></div>
	</div>  
