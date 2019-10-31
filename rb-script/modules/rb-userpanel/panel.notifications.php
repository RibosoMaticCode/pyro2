<div class="panel notifications_panel">
<h3>Notificaciones</h3>
						<?php
						$qm = $objDataBase->Ejecutar("SELECT m.id, m.contenido, DATE_FORMAT(m.fecha_envio,'%d-%m-%Y') as fecha,
						TIME_FORMAT(m.fecha_envio,'%H:%i:%s') as hora,
						u.nombres, m.id, m.remitente_id, m.asunto, mu.leido, m.fecha_envio, mu.usuario_id, mu.inactivo
						FROM ".G_PREFIX."messages m, ".G_PREFIX."messages_users mu, ".G_PREFIX."users u WHERE m.id = mu.mensaje_id AND u.id = m.remitente_id AND mu.usuario_id = ".G_USERID." AND mu.inactivo=0 ORDER BY fecha_envio DESC LIMIT 20");
						?>
						<table class="tables">
							<thead>
								<tr>
									<th style="width:20%">Fecha</th>
									<th style="width:20%">Remitente</th>
									<th>Mensaje</th>
									<th style="width:10%">Estado</th>
								</tr>
							</thead>
							<tbody>
							<?php
							while ($row = $qm->fetch_assoc()){
								$style = "";
								$mod = "";

								// si estamos en la opcion de enviados
								if(isset($_GET['opc']) && $_GET['opc'] == "send"){
									$style = "";
									$mod = "sd"; //send
								}else{
								// si estamos en la opcion de recibidos
									$style = "";
									if($row['leido']==0){
										$style = " class='no-read' ";
									}
									$mod = "rd"; //received
								}
								echo "	<tr id='fila-".$row['id']."' $style> ";
								echo "<td><span>".$row['fecha']."<br />".$row['hora']."</span></td>";
								if(isset($_GET['opc']) && $_GET['opc'] == "send"){
									echo "<td>";
									$coma = "";
									$q = $objUsuario->destinatarios_del_mensaje($row['id']);
									while($r = mysql_fetch_array($q)){
										echo $coma.$r['nombres'];
										$coma=", ";
									}
									//fin categorias
									echo "</td>	";
								}else{
									echo "<td>".$row['nombres']."</td>";
								}
								echo "<td><a class='viewmessage' id='".$row['id']."' href=\"#\">".$row['asunto']."</a></td>";
								if($row['leido']==0)
									echo "<td id='msjread-".$row['id']."'>No leído</td>";
								else
									echo "<td id='msjread-".$row['id']."'>Leído</td>";
								echo "</tr>";
							}
							?>
							</tbody>
						</table>
							<script>
							$(document).ready(function() {
								$('a.viewmessage').click( function(event){
									var message_id = $(this).attr('id');
									var fila_id = "#fila-"+message_id;
									var msjread_id = "#msjread-"+message_id;

									$.ajax({
		  								url: "<?= rm_url ?>rb-script/modules/rb-userpanel/message.view.php?message_id="+message_id+"&user_id=<?= G_USERID ?>"
									})
		  						.done(function( data ) {
										if(data.resultado){
											$( ".bg" ).show();
											$( ".winfloat" ).html(data.contenido);
											$( ".winfloat" ).show();

											$(fila_id).removeClass('no-read');
											$(msjread_id).html("Leído");
		  							}else{
		  								$(".winfloat").html("Ocurrio un problema! Intentelo más tarde");
		  							}
		  						});

		  						$( ".bg" ).click(function(event) {
										$(".bg").fadeOut();
										$(".winfloat").hide();
									});
								});
							})
							</script>
</div>
