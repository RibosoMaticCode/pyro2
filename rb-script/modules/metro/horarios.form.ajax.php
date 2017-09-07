<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funciones.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/class/rb-usuarios.class.php';

$rb_module_url = G_SERVER."/rb-script/modules/metro/";

$urlreload=G_SERVER.'/rb-admin/module.php?pag=predi_hor&id='.$_GET['pto_id'];

$q = $objDataBase->Consultar("SELECT * FROM metro_puntos WHERE id=".$_GET['pto_id']);
$punto = mysql_fetch_array($q);
?>
<div class="wrap-content-list">
<section class="seccion">
	<div class="seccion-body">

	<script>
	$(document).ready(function() {
		$('#frmHorarios').submit(function (){
			event.preventDefault();
			$.ajax({
				method: "post",
				url: "<?= $rb_module_url ?>horarios.save.php",
				data: $( this ).serialize()
			})
			.done(function( data ) {
				if(data.resultado=="ok"){
		    		$('#frmHorarios').hide();
		    		$( "#result" ).show().delay(5000);
					$( "#result" ).html(data.contenido);
					setTimeout(function(){
						window.location.href = '<?= $urlreload ?>';
					}, 500);
		  		}else{
		  			$( "#result" ).show();
		  			$( "#result" ).html(data.contenido);
		  			$( "#result" ).delay(4000).fadeOut(1000);
		  		}
			});
		});
	})
	</script>
	<div id="result" style="text-align: center;"></div>
	<form id="frmHorarios" method="POST" action="<?= $rb_module_url ?>horarios.save.php">
		<h2>Punto de Predicación: <?= $punto['nombre']  ?></h2>
		<p>Seleccione al publicador que estará en ese horario</p>
		<input type="hidden" name="ajax" />
		<input type="hidden" value="<?php echo trim($_GET['pto_id']) ?>" name="punto_id" />
		<input type="hidden" value="<?php echo trim($_GET['day']) ?>" name="dia" />
		<input type="hidden" value="<?php echo trim($_GET['horini']) ?>" name="horaini" />
		<input type="hidden" value="<?php echo trim($_GET['horfin']) ?>" name="horafin" />
		<label for="">
			D&iacute;a:
			<?php echo rb_numadia($_GET['day']) ?>
		</label>
		<label>
			Hora Inicio:
			<?php echo convertirdorhora($_GET['horini']) ?>
		</label>
		<label>
			Hora Fin:
			<?php echo convertirdorhora($_GET['horfin']) ?>
		</label>
		<label>
			Publicador:
			<!--<select name="usuario_id">
				<?php
				/*$q = $objDataBase->Consultar("SELECT id, nombres, apellidos FROM usuarios WHERE tipo=1 OR tipo=3 OR tipo=4 ORDER BY nombres ASC");
				while ($r = mysql_fetch_array($q)):
					echo "<option value=".$r['id'].">".$r['nombres']." ".$r['apellidos']."</option>";
				endwhile;*/
				?>
			</select>-->
			<script>
				$(document).ready(function() {
					// BUSCAR PUBLICADOR ESCRIBIENDO SU NOMBRE
					$('#usuario_name').keyup(function(event){
						text_search = $(this).val();

						if(text_search.length == 0){
							$('#usuario_id').val("");
							$('.ls_result').hide();
						}else{
							$('.ls_result').show();
						}

						console.log($('#usuario_name').val());
						$("#ls_items > li").each(function() {
										//if ($(this).text().search(text_search) > -1) { sensible a Mayus-Minusc
										//if ($(this).text().toLowerCase().indexOf(text_search) > -1) { // No sensible a Mayus-Minusc
										if ($(this).text().search(new RegExp(text_search, "i")) > -1) { // No sensible a Mayus-Minusc
												$(this).show();
										}
										else {
												$(this).hide();
										}
								});
					});
					// CLICK EN ITEM - NOMBRE DEL PUBLICADOR
					$('.ls_item').click(function(event){
						var text_item = $(this).closest('li').text();
						$('#usuario_name').val(text_item);
						$('.ls_result').hide();

						/*var servi = $(this).attr( "data-servi" );
						console.log(servi);
						if(servi == "pa"){
							$('#servi_pa').prop('checked', true);
						}else if(servi == "pr"){
							$('#servi_pr').prop('checked', true);
						}else{
							$('#servi_pb').prop('checked', true);
						}*/

						$('#usuario_id').val( $(this).attr( "data-value" ) );
						//$('#respo_pub').val( $(this).attr( "data-respo" ) );
					});

					// NO PREDICO, LLENAR DE CEROS
				});
			</script>
			<input type="hidden" name="usuario_id" id="usuario_id" />
			<?php
			/*if(isset($row)){
				$q = $objDataBase->Consultar("SELECT nombres, apellidos FROM usuarios WHERE id=".$row['usuario_id']);
				$ru=mysql_fetch_array($q);
				?>
				<input type="text" name="usuario_name" id="usuario_name" autocomplete="off" placeholder="Escribe nombre/apellido del publicador" value="<?= $ru['nombres'] ?> <?= $ru['apellidos'] ?>" readonly />
			<?php
		}else{*/
			?>
				<input type="text" name="usuario_name" id="usuario_name" autocomplete="off" placeholder="Escribe nombre/apellido del publicador" />
			<?php
			//}
			?>
			<div class="ls_result">
				<ul id="ls_items" class="ls_items">
				<?php
				$q = $objUsuario->Consultar("SELECT apellidos, nombres, id FROM usuarios");

				//$q = $objUsuario->Consultar("SELECT apellidos, nombres, id FROM usuarios ORDER BY apellidos");
				while($r = mysql_fetch_array($q)):
				?>
				<li><a data-value="<?= $r['id'] ?>" class="ls_item" href="#"><?= $r['nombres'] ?> <?= $r['apellidos'] ?></a></li>
				<?php
				endwhile;
				?>
				</ul>
			</div>
			<!-- // PROTOTIPO -->
		</label>
		<label>
			<input class="btn-primary" type="submit" value="Guardar Horario" />
		</label>
	</form>
	</div>
</section>
</div>
