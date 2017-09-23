<?php
require_once(ABSPATH."rb-script/class/rb-database.class.php");
$mode;
if(isset($_GET["id"])){
	$id=$_GET["id"];
	$q = $objDataBase->Consultar("SELECT * FROM informes WHERE id=$id");	
	$row=mysql_fetch_array($q);
	$mode = "update";
}else{
	$mode = "new";
}
?>
<script>
$(document).ready(function() {
	// ENVIAR EL INFORME PARA GUARDAR
	$('#info-form').submit(function( event ) {
		$(".help").hide();
		event.preventDefault();		
		$.ajax({
		    type: "POST",
		    url: "<?= G_SERVER ?>/rb-script/modules/info/info.save.php",
		    data: $('#info-form').serialize(),
		    dataType: 'json',
		    success: function(data){
			    if(data['codigo']==0){
			    	notify(data['mensaje']);
			    }
			    if(data['codigo']==1){
			    	notify(data['mensaje']);
			    	$('#usuario_name').prop('readonly', true);
			    	$('#info_mode').val("update");
			    	$('#info_id').val(data['id']);
			    }
		    }
		});
	});
	// CLICK PARA ELIMINAR ITEM
	$('.del-info').click(function( event ){
		event.preventDefault();
		var id = $(this).attr('data-id');
		
		var eliminar = confirm("[?] Confirmar la eliminación permanente de este dato. ¿Continuar?");
		if ( eliminar ) {
			$.ajax({
				url: '<?= $rb_module_url ?>info.delete.php?id='+id,
				cache: false,
				type: "GET",
				success: function(data){
					if(data.resultado=="ok"){
						notify('Eliminado');
			    		$( "#result-block" ).show().delay(5000);
						$( "#result-block" ).html(data.contenido);
						/*setTimeout(function(){ 
							window.location.href = '<?= $urlreload ?>';
						}, 1000);*/
					}					
				}
			});
		}
	});
});	
</script>
<div class="help" style="display: none"></div>
<form id="info-form" method="post" action="<?= G_SERVER ?>/rb-script/modules/info/info.save.php">
	<div id="toolbar">
       	<div id="toolbar-buttons">
			<span class="post-submit">
				<button class="submit" name="guardar" type="submit" value="guardar">Guardar</button>
				<a class="submit" href="<?= G_SERVER ?>/rb-admin/module.php?pag=info&opc=nvo">Nuevo</a>
				<a class="submit" href="<?= G_SERVER ?>/rb-admin/module.php?pag=info">Cancelar/Volver</a>
			</span>
		</div>
	</div>
	<div class="cols-container">
		<div class="cols-6-md" style="padding: 0 5px">
			<section class="seccion">
				<div class="seccion-header">
					<h3>Ingrese datos del informe</h3>
				</div>
				<div class="seccion-body cols-container">
					<div class="cols-6-md">
						<div class="cols-container">
							<div class="cols-6-md">
								<?php
								if(isset($row)):
									$mes_actual = $row['mes'];
								else:
									$mes_actual = date('m', strtotime('-1 month'));// - 1;
								endif;
								?>
								<select name="mes">
									<?php
									$i=1;
									while($i<=12):
									?>
										<option <?php if($mes_actual == $i){ echo " selected "; } ?> value="<?= $i ?>"><?= rb_mes_nombre($i) ?></option>
									<?php
									$i++;
									endwhile;
									?>
								</select>
							</div>
							<div class="cols-6-md">
								<?php
								if(isset($row)):
									$anio_actual = $row['anio'];
								else:
									$anio_actual = date('Y', strtotime('-1 month')) ;;
								endif;
								?>
								<input type="text" name="anio" value="<?= $anio_actual ?>" />
							</div>
						</div>
						<label>Publicador:
						<?php
						$objUsuario = new Usuarios;
						$q = $objUsuario->Consultar("SELECT * FROM usuarios ORDER BY apellidos");
						?>
						<!-- PROTOTIPO -->
						<style>
							.ls_result{
								border:1px solid #CCC;
								overflow:auto;
								max-height: 100px;
								display:none;
							}
							.ls_items li{
								border-bottom:1px solid #CCC;
								margin:0!important;
							}
							.ls_items li:last-child{
								border-bottom: 0;
							}
							.ls_items li a{
								width:100%;
								padding:3px 4px;
								display:block;
							}
							.ls_items li a:hover{
								background-color:gray;
								color:#fff;
							}
						</style>
						<script>
							$(document).ready(function() {
								// BUSCAR PUBLICADOR ESCRIBIENDO SU NOMBRE
								$('#usuario_name').keyup(function(event){
									text_search = $(this).val();
									
									if(text_search.length == 0){
										$('#usuario_name_id').val("");
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
									
									var servi = $(this).attr( "data-servi" );
									console.log(servi);
									if(servi == "pa"){
										$('#servi_pa').prop('checked', true);
									}else if(servi == "pr"){
										$('#servi_pr').prop('checked', true);
									}else{
										$('#servi_pb').prop('checked', true);
									}
									
									$('#usuario_name_id').val( $(this).attr( "data-value" ) );
									$('#respo_pub').val( $(this).attr( "data-respo" ) );
								});
								
								// NO PREDICO, LLENAR DE CEROS
							});
						</script>
						<input type="hidden" name="usuario_name_id" id="usuario_name_id" value="<?php if(isset($row)) echo $row['usuario_id'] ?>" />
						<?php 
						if(isset($row)){
							$q = $objDataBase->Consultar("SELECT nombres, apellidos FROM usuarios WHERE id=".$row['usuario_id']);
							$ru=mysql_fetch_array($q);
							?>
							<input type="text" name="usuario_name" id="usuario_name" autocomplete="off" placeholder="Escribe nombre/apellido del publicador" value="<?= $ru['nombres'] ?> <?= $ru['apellidos'] ?>" readonly />
						<?php
						}else{
						?>
							<input type="text" name="usuario_name" id="usuario_name" autocomplete="off" placeholder="Escribe nombre/apellido del publicador" />
						<?php	
						}
						?>
						
						<div class="ls_result">
							<ul id="ls_items" class="ls_items">
							<?php
							$q = $objUsuario->Consultar("SELECT apellidos, nombres, id, puesto_servicio, puesto_responsabilidad 
							FROM usuarios u LEFT JOIN informes_publicador ip ON u.id = ip.user_id");
					
							//$q = $objUsuario->Consultar("SELECT apellidos, nombres, id FROM usuarios ORDER BY apellidos");
							while($r = mysql_fetch_array($q)):
							?>
							<li><a data-servi="<?= $r['puesto_servicio'] ?>" data-respo="<?= $r['puesto_responsabilidad'] ?>" data-value="<?= $r['id'] ?>" class="ls_item" href="#"><?= $r['nombres'] ?> <?= $r['apellidos'] ?></a></li>
							<?php
							endwhile;
							?>
							</ul>
						</div>
						<!-- // PROTOTIPO -->
						</label>
						<div class="cols-container">
							<div class="cols-6-md">
								<label>Publicaciones (impresas y electrónicas)</label>
							</div>
							<div class="cols-6-md">
								<input type="number" name="pub" value="<?php if(isset($row)) echo $row['pub'] ?>" />
							</div>
						</div>
						<div class="cols-container">
							<div class="cols-6-md">
								<label>Videos</label>
							</div>
							<div class="cols-6-md">
								<input type="number" name="vid" value="<?php if(isset($row)) echo $row['vid'] ?>" />
							</div>
						</div>
						<div class="cols-container">
							<div class="cols-6-md">
								<label>Horas</label>
							</div>
							<div class="cols-6-md">
								<input type="number" name="hor" value="<?php if(isset($row)) echo $row['hor'] ?>" />
							</div>
						</div>
						<div class="cols-container">
							<div class="cols-6-md">
								<label>Revisitas</label>
							</div>
							<div class="cols-6-md">
								<input type="number" name="rev" value="<?php if(isset($row)) echo $row['rev'] ?>" />
							</div>
						</div>
						<div class="cols-container">
							<div class="cols-6-md">
								<label>Estudios bíblicos</label>
							</div>
							<div class="cols-6-md">
								<input type="number" name="est" value="<?php if(isset($row)) echo $row['est'] ?>" />
							</div>
						</div>
						<div class="cols-container">
							<div class="cols-6-md">
								<label>Observaciones</label>
							</div>
							<div class="cols-6-md">
								<textarea name="obs"><?php if(isset($row)) echo $row['obs'] ?></textarea>
							</div>
						</div>
					</div>	
				
				<div class="cols-6-md" style="padding: 0 15px">
					<h3>Puesto de Servicio</h3>
					<label>
						<input type="radio" name="servi" value="pub" id="servi_pb" /> Publicador
					</label>
					<label>
						<input type="radio" name="servi" value="pa" id="servi_pa" /> Prec. Auxiliar
					</label>
					<label>
						<input type="radio" name="servi" value="pr" id="servi_pr" /> Prec. Regular
					</label>
					<br />
					<label>
						<input type="checkbox" name="inactivo" value="1" /> <span style="color:red">No predicó / No informó</span>
					</label>
				</div>
			</div>
			</section>
		</div>
		<div class="cols-6-md" style="padding: 0 5px">
			<section class="seccion">
				<div class="seccion-header">
					<h3>Recientes</h3>
				</div>
				<div>
					<table class="box-table-a">
						<thead>
							<tr>
							<th>Publicador</th>
							<th>Pub</th>
							<th>Vid</th>
							<th>Hor</th>
							<th>Rev</th>
							<th>E.B.</th>
							<th colspan="2">Acciones</th>
							</tr>	
						</thead>
						<tbody>
						<?php
						$ql = $objDataBase->Consultar("SELECT u.nombres, u.apellidos, i.* FROM informes i, usuarios u WHERE i.usuario_id = u.id ORDER BY id DESC LIMIT 10");
						while($rowl = mysql_fetch_array($ql)):
						?>
							<tr>
							<td><?= $rowl['nombres'] ?> <?= $rowl['apellidos'] ?></td>
							<td><?= $rowl['pub'] ?></td>
							<td><?= $rowl['vid'] ?></td>
							<td><?= $rowl['hor'] ?></td>
							<td><?= $rowl['rev'] ?></td>
							<td><?= $rowl['est'] ?></td>
							<td><a href="<?= G_SERVER ?>/rb-admin/module.php?pag=info&opc=edt&id=<?= $rowl['id'] ?>">Editar</a></td>
							<td><a href="#" data-id="<?= $rowl['id'] ?>" class="del-info del-color">Eliminar</a></td>	
							</tr>
						<?php
						endwhile;
						?>
						</tbody>
					</table>
				</div>
			</section>
		</div>
	</div>
	<input name="section" value="info" type="hidden" />
	<input name="mode" value="<?php echo $mode ?>" type="hidden" id="info_mode" />
	<input name="id" value="<?php if(isset($row)) echo $row['id'] ?>" type="hidden" id="info_id" />
	<!--<input name="servi" value="<?php if(isset($row)) echo $row['servi'] ?>" type="hidden" id="servi_pub" />-->
	<input name="respo" value="<?php if(isset($row)) echo $row['respo'] ?>" type="hidden" id="respo_pub" />
</form>