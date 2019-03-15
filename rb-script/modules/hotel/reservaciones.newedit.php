<?php
/*if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';*/
require_once 'funcs.php';

$objDataBase = new DataBase;

/* parametros inciales */
$file_prefix = "reservaciones";
$table_name = "hotel_reservacion";
$key = "hotel_reservaciones";
$module_dir = "hotel";
$save_path = G_DIR_MODULES_URL.$module_dir."/".$file_prefix.".save.php";
$urlreload=G_SERVER.'/rb-admin/module.php?pag='.$key;

/* customers */
$qc = $objDataBase->Ejecutar("SELECT * FROM crm_customers");

/* start */
if( isset($_GET['res_id']) && $_GET['res_id'] > 0 ){
  $id=$_GET['res_id'];
  $q = $objDataBase->Ejecutar("SELECT * FROM $table_name WHERE id=$id");
  $row = $q->fetch_assoc();
	$hab_id = $row['habitacion_id'];
}else{
  $id = 0;
	$hab_id = $_GET['hab'];
}
?>
<div class="inside_contenedor_frm">
	<div id="toolbar">
    <div class="inside_toolbar">
    	<a class="button" href="http://dev.pyro2/rb-admin/module.php?pag=hotel_reservaciones">Volver</a>
			<div class="cols-4-md cols-content-left">
				<?php if ($id==0): ?>
					<button type="submit" form="frmNewEdit">Realizar reservacion</button>
				<?php else: ?>
					<button type="submit" form="frmNewEdit">Actualizar datos</button>
				<?php endif ?>
			</div>
    </div>
  </div>
	<div class="cols-container">
		<div class="cols-8-md col-padding-right">
			<section class="seccion">
				<div class="seccion-header">
					<h3>Reservacion <?php if(isset($row)) echo $row['codigo_unico']; else echo "Nueva"; ?></h3>
				</div>
				<div class="seccion-body">
					<form id="frmNewEdit" class="form" style="max-width:900px">
						<?php
							/* habitaciones */
							$qh = $objDataBase->Ejecutar("SELECT * FROM hotel_habitacion WHERE id=$hab_id");
							$habitacion = $qh->fetch_assoc();
						?>
						<div class="cols-container">
							<div class="cols-6-md col-padding-right">
								<input type="hidden" class="data_reservacion" data-reservacion-id="<?= $id ?>" name="id" value="<?= $id ?>" required />
								<!-- campos inicio -->
								<label>
									Habitacion seleccionada
									<input type="text" readonly value="<?= $habitacion['numero_habitacion'] ?> - S/. <?= $habitacion['precio'] ?>" />
									<input type="hidden" name="habitacion_id" value="<?= $hab_id ?>" required />
									<input type="hidden" id="habitacion_precio" value="<?= $habitacion['precio'] ?>" />
								</label>
								<label>
									Huesped - <a href="#" class="show_explorer" data-type="alone">Añadir</a>
                  <?php
                  if(isset($row)){
                    $cliente = get_rows('crm_customers', $row['cliente_id'], 'id');
                  }
                  ?>
                  <input type="hidden" name="cliente_id" value="<?php if(isset($row)) echo $row['cliente_id']; else echo "0" ?>" />
                  <input type="text" readonly name="cliente_name" value="<?php if(isset($row)) echo $cliente['nombres']." ".$cliente['apellidos'] ?>" />
								</label>
                <label>
                  <input type="hidden" name="ocupantes_ids" value="<?php if(isset($row)) echo $row['ocupantes_ids']; else echo "" ?>" />
                  Ocupantes - <a href="#" class="show_explorer" data-type="various">Añadir</a>
                  <select size="4" id="list_ocupantes" name="ocupantes" readonly>
                    <?php
                    if(isset($row) && strlen($row['ocupantes_ids'])>0){
                      $ocupantes_ids = explode(",", $row['ocupantes_ids']);
                      foreach ($ocupantes_ids as $ocupante) {
                        $cliente = get_rows('crm_customers', $ocupante, 'id');
                        echo '<option value="'.$ocupante.'">'.$cliente['nombres'].' '.$cliente['apellidos'].'</option>';
                      }
                    }
                    ?>
                  </select>
                  <span class="info">Para eliminar seleccione y presione Suprimir</span>
                </label>
								<div class="cols-container">
									<div class="cols-6-md">
										<label>
											<?php
											$today = $_GET['date'] ? $_GET['date'] : date('Y-m-d');
											?>
									  	Fecha Desde
									    <input type="date" data-value="<?php if(isset($row)) echo rb_sqldate_to($row['fecha_llegada'], 'Y-m-d'); else echo $today ?>" name="fecha_llegada" required value="<?php if(isset($row)) echo rb_sqldate_to($row['fecha_llegada'], 'Y-m-d'); else echo $today ?>" <?php if($id>0) echo "readonly" ?> />
									  </label>
										<label><strong>Check in: <?= get_option('hora_llegada')?></strong></label>
									</div>
									<div class="cols-6-md">
										<label>
									    Fecha Hasta
											<?php
											$tomorrow = date('Y-m-d', strtotime($today . ' +1 day'));
											?>
									    <input type="date" data-value="<?php if(isset($row)) echo rb_sqldate_to($row['fecha_salida'], 'Y-m-d'); else echo $tomorrow; ?>" name="fecha_salida" required value="<?php if(isset($row)) echo rb_sqldate_to($row['fecha_salida'], 'Y-m-d'); else echo $tomorrow; ?>" />
									  </label>
										<label><strong>Check out: <?= get_option('hora_salida')?></strong></label>
									</div>
								</div>
								<label>
									Estado de la habitacion
									<select name="estado">
										<option value="1" <?php if(isset($row) && $row['estado']==1) echo "selected" ?>>Solo reservar</option>
										<option value="2" <?php if(isset($row) && $row['estado']==2) echo "selected" ?>>Ocupar ya</option>
									</select>
								</label>
                <label>
                  Palabra secreta del cliente
                  <span class="info">Cualquier cambios requerira este código. Max. 10 caracteres</span>
                  <input type="password" name="codigo_secreto_cliente" maxlength="10" />
                </label>
							</div>
							<div class="cols-6-md col-padding-left">
								<!-- productos adicionales -->
								<input type="hidden" id="plato_id_temp" />
								<input type="hidden" id="plato_prec_temp" />
								<input type="hidden" name="productos_json" id="productos_json" />
								<div class="cols-container container_plato_filter">
									<div class="cols-8-md">
										<label class="cover_plato_filter">
									    Producto / Servicio extra
									    <input id="plato_nombre" type="text" name="plato_nombre" placeholder="Escriba nombre del plato" autocomplete="off" />
											<span class="error_msg" id="err_plato"></span>
											<div class="cover_platos_list">
												<ul class="platos_list">
													<?php
													$qp = $objDataBase->Ejecutar("SELECT * FROM hotel_producto ORDER BY nombre");
													while($plato = $qp->fetch_assoc()){
														$photo = rb_get_photo_details_from_id($plato['foto_id']);
														?>
														<li>
															<a class="plato" data-id="<?= $plato['id'] ?>" data-precio="<?= $plato['precio'] ?>" href="#">
																<img style="max-width:50px" src="<?= $photo['thumb_url'] ?>" alt="imagen" /><?= $plato['nombre'] ?> : S/ <?= $plato['precio'] ?>
															</a>
														</li>
														<?php
													}
													?>
												</ul>
											</div>
										</label>
									</div>
									<div class="cols-2-md">
										<label>
									    Cantidad
									    <input id="plato_cantidad" type="number" name="plato_cantidad" autocomplete="off" />
											<span class="error_msg" id="err_cant"></span>
									  </label>
									</div>
									<div class="cols-2-md">
										<button class="btnAdd" type="button"><i class="fas fa-plus"></i></button>
									</div>
								</div>
								<div class="pedido_detalles">
									<?php
									//if(isset($pedido)){
										$qpd = $objDataBase->Ejecutar("SELECT * FROM hotel_extras WHERE reservacion_id=".$id);
										while ($pedido_detalle = $qpd->fetch_assoc()) {
											$qpl = $objDataBase->Ejecutar("SELECT * FROM hotel_producto WHERE id=".$pedido_detalle['producto_id']);
											$plato = $qpl->fetch_assoc();
											?>
											<div class="cols-container plato-item" data-id="<?= $pedido_detalle['producto_id'] ?>" data-prec="<?= $pedido_detalle['precio'] ?>" data-cant="<?= $pedido_detalle['cantidad'] ?>">
												<div class="cols-7-md"><?= $plato['nombre'] ?></div>
												<div class="cols-2-md"><?= $pedido_detalle['cantidad'] ?></div>
												<div class="cols-2-md"><?= $pedido_detalle['precio'] ?></div>
												<div class="cols-1-md"><a class="delete" title="Quitar" href="#">x</a></div>
											</div>
											<?php
										}
									//}
									?>
								</div>
							</div>
						</div>
						<!-- campos final -->

								<?php if ($id>0 && $row['estado']==1): ?>
									<a class="finishReservation" data-estado="1" href="#">Cancelar reservacion</a>
								<?php endif ?>
								<?php if ($id>0 && $row['estado']==2): ?>
									<a class="finishReservation" data-estado="2" href="#">Finalizar reservacion</a>
								<?php endif ?>


					</form>
				</div>
			</section>
		</div>
		<div class="cols-4-md col-padding-left">
			<section class="seccion">
				<div class="seccion-header">
					<h3>Totales</h3>
				</div>
				<div class="seccion-body">
					<div class="detalles_reservacion">
						<div class="cols-container">
							<div class="cols-6-md">
								Total habitacion
							</div>
							<div class="cols-6-md cols-content-right">
                <div class="habitacion_precio_cover">
  								<?= G_COIN ?> <span id="total_habitacion_visible"><?php if(isset($row)) echo $row['total_habitacion']; else echo $habitacion['precio'] ?></span>
  								<input form="frmNewEdit" id="total_habitacion" type="hidden" name="total_habitacion" value="<?php if(isset($row)) echo $row['total_habitacion']; else echo $habitacion['precio'] ?>" />
                  <br /><a class="btnShowEditPrice" href="#">Editar</a>
                </div>
                <div class="habitacion_edit_cover">
                  <input type="number" name="precio_nuevo"/><br />
                  <a class="btnAcceptEditPrice" href="#">Aceptar</a> <a class="btnCancelEditPrice" href="#">Cancelar</a>
                </div>
							</div>
						</div>
						<div class="cols-container">
							<div class="cols-6-md">
								Total extras
							</div>
							<div class="cols-6-md cols-content-right">
								<?= G_COIN ?> <span id="total_extras_visible"><?php if(isset($row)) echo $row['total_adicionales']; else echo "0" ?></span>
								<input form="frmNewEdit" id="total_extras" type="hidden" name="total_extras" value="<?php if(isset($row)) echo $row['total_adicionales']; else echo "0" ?>" />
							</div>
						</div>
						<div class="cols-container">
							<div class="cols-6-md">
								Total Final
							</div>
							<div class="cols-6-md cols-content-right">
								<?= G_COIN ?> <span id="total_final_visible"><?php if(isset($row)) echo $row['total_reservacion']; else echo $habitacion['precio'] ?></span>
								<input form="frmNewEdit" id="total_final" type="hidden" name="total_final" value="<?php if(isset($row)) echo $row['total_reservacion']; else echo $habitacion['precio'] ?>" />
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		function today(day){//https://stackoverflow.com/questions/1531093/how-do-i-get-the-current-date-in-javascript
			var today = new Date();
			var dd = today.getDate() + day;
			var mm = today.getMonth() + 1; //January is 0!
			var yyyy = today.getFullYear();

			if (dd < 10) {
			  dd = '0' + dd;
			}

			if (mm < 10) {
			  mm = '0' + mm;
			}

			today = yyyy + '-' + mm + '-' + dd;
			return today;
		}
		// Validaciones fechas
		// LLEGADA
		$('input[name=fecha_llegada]').change(function() {
			var before_date = $('input[name=fecha_llegada]').attr('data-value');
			console.log($('input[name=fecha_llegada]').attr('data-value'));

			var fec1 = $('input[name=fecha_llegada]').val();
			var fec2 = $('input[name=fecha_salida]').val();

			var date_1 = new Date(fec1);
			var date_2 = new Date(fec2);
			var date_hoy = new Date(today(0));

			if(date_1 >= date_2){ //
				alert("La fecha salida no puede ser menor o igual a la fecha de llegada");
				$('input[name=fecha_llegada]').val( before_date );
				return;
			}

			if(date_1 < date_hoy){
				alert("La fecha llegada no puede ser anterior a la fecha de hoy");
				$('input[name=fecha_llegada]').val( today(0) );
			}

			$('input[name=fecha_llegada]').attr('data-value', $('input[name=fecha_llegada]').val());
			$('input[name=fecha_salida]').change();
		});
		// SALIDA
		$('input[name=fecha_salida]').change(function() {
			var after_date = $('input[name=fecha_salida]').attr('data-value');
			console.log($('input[name=fecha_salida]').attr('data-value'));

			var fec1 = $('input[name=fecha_llegada]').val();
			var fec2 = $('input[name=fecha_salida]').val();
			var date_1 = new Date(fec1);
			var date_2 = new Date(fec2);

			if(date_1 >= date_2){
				alert("La fecha salida no puede ser menor o igual a la fecha de llegada");
				$('input[name=fecha_salida]').val( after_date );
				$('input[name=fecha_salida]').change();
				return;
			}

			var day_as_milliseconds = 86400000; // milisegundos en el dia
			var diff_in_millisenconds = date_2 - date_1;
			var diff_in_days = diff_in_millisenconds / day_as_milliseconds;

			var total_dias_habitacion = $('#habitacion_precio').val() * diff_in_days;
			$('#total_habitacion_visible').html(total_dias_habitacion);
			$('#total_habitacion').val(total_dias_habitacion);

			$('input[name=fecha_salida]').attr('data-value', $('input[name=fecha_salida]').val());

			calcular_total();
			//console.log(diff_in_days);
		});

		// Boton Cancelar
    $('.finishReservation').on('click',function(event){
      var code_customer = $('input[name=codigo_secreto_cliente]').val();
			var estado = $(this).attr('data-estado');
			var finalizar = confirm("¿Continuar con la finalizacion de la reservacion?");
		  if ( finalizar ) {
				var id = $('.data_reservacion').attr('data-reservacion-id');
				console.log(id);
		    $.ajax({
		      type: "GET",
		      url: "<?= G_DIR_MODULES_URL.$module_dir ?>/reservaciones.finish.php?id="+id+"&estado="+estado+"&code_customer="+code_customer
		    })
		    .done(function( data ) {
		      if(data.resultado){
		        notify(data.contenido);
						$.fancybox.close();
		        setTimeout(function(){
		          window.location.href = '<?= $urlreload ?>';
		        }, 1000);
		      }else{
		        notify(data.contenido);
		      }
		    });
			}
		});

    // Boton Cancelar
    $('.CancelFancyBox').on('click',function(event){
			$.fancybox.close();
		});

		// GENERAR RESERVACION
		// =======================================
		$('#frmNewEdit').submit(function(event){
			event.preventDefault();
			var platos = {};
			$(".plato-item").each(function(index, element){
					plato_id = $(element).attr("data-id");
					plato_prec = $(element).attr("data-prec");
					plato_cant = $(element).attr("data-cant");

					//JavaScript does not support arrays with named indexes.
					//plato = new Array( plato_id,  plato_cant, plato_prec);
					plato = {};
					plato['producto_id'] = plato_id;
					plato['cant'] = plato_cant;
					plato['prec'] = plato_prec;

					//platos.push(plato);
					platos[plato_id] = plato;
			});
			var platosJson = JSON.stringify(platos);
			console.log(platos);
			console.log(platosJson);
			$('#productos_json').val(platosJson);

			$.ajax({
				method: "post",
				url: "<?= $save_path ?>",
				data: $( this ).serialize()
			})
			.done(function( data ) {
				if(data.resultado){
					$.fancybox.close();
					notify(data.contenido);
					setTimeout(function(){
						window.location.href = '<?= $urlreload ?>&date=<?= $today ?>';
					}, 1000);
				}else{
					notify(data.contenido);
				}
			});
		});

		// BUSCAR PLATO ESCRIBIENDO SU NOMBRE
		// =======================================
		$('#plato_nombre').keyup(function(event){
			text_search = $(this).val();
			if(text_search.length == 0){
				$('#plato_id_temp').val("");
				$('.cover_platos_list').hide();
			}else{
				$('.cover_platos_list').show();
			}
			$(".platos_list > li").each(function() {
				if ($(this).text().search(new RegExp(text_search, "i")) > -1) { // No sensible a Mayus-Minusc
					$(this).show();
				}else{
					$(this).hide();
				}
			});
		});

		// CLICK EN EL PLATO
		// =======================================
		$('.plato').click(function(event){
			var text_item = $(this).closest('li').text().trim();
			//console.log(text_item);
			$('#plato_nombre').val(text_item);
			$('#plato_cantidad').focus();
			$('.cover_platos_list').hide();
			$('#plato_id_temp').val( $(this).attr( "data-id" ) );
			$('#plato_prec_temp').val( $(this).attr( "data-precio" ) );
		});

		// AÑADIR PUBLICACION
		// =======================================
		//var total_extras = 0;
		$('.btnAdd').click(function (event){
			event.preventDefault();

			// validaciones
			var plato_id = $('#plato_id_temp').val();
			var plato_prec = $('#plato_prec_temp').val();
			var plato_name = $('#plato_nombre').val();
			var plato_cant = $('#plato_cantidad').val();

			/*
			// Calcular total extras
			total_extras += plato_prec * plato_cant;
			console.log("extras"+total_extras);
			$('#total_extras').val(total_extras);
			$('#total_extras_visible').html(total_extras);

			// Calcular total reservacion
			total_habitacion = $('#total_habitacion').val();
			total_final = parseFloat(total_habitacion) + parseFloat(total_extras);
			$('#total_final').val(total_final);
			$('#total_final_visible').html(total_final);
			*/


			if(plato_id == "" || plato_name == ""){
				$('#plato_nombre').addClass('error');
				$('#err_plato').text("El plato no se reconoce");
				return false;
			}else{
				$('#plato_nombre').removeClass('error');
				$('#err_plato').text("");
			}
			if(plato_cant == "" || plato_cant == 0 || plato_cant < 0){
				$('#plato_cantidad').addClass('error');
				$('#err_cant').text("Ingresa cantidad correctamente");
				return false;
			}else{
				$('#plato_cantidad').removeClass('error');
				$('#err_cant').text("");
			}

			// Buscar repetido
			if( $(".plato-item").length > 0){
				// Buscar repetido
				var repetido = false;
				$(".pedido_detalles .plato-item").each(function(){
    	    // Si existe reemplazar
					if( $(this).attr("data-id") == plato_id ){
						console.log("repetido");
						$(this).replaceWith(
							'<div class="cols-container plato-item" data-id="'+plato_id+'" data-prec="'+plato_prec+'" data-cant="'+plato_cant+'"><div class="cols-7-md">'+plato_name+'</div><div class="cols-2-md">'+plato_cant+'</div><div class="cols-2-md">'+plato_prec+'</div><div class="cols-1-md"><a class="delete" title="Quitar" href="#">x</a></div></div>'
						);
						repetido = true;
					}
    		});
				if(repetido==false) add(plato_id, plato_name, plato_cant, plato_prec);
			}else{
				add(plato_id, plato_name, plato_cant, plato_prec);
				$('.btnSend').show();
			}

			calcular_totales();
			// limpiar datos y poner cursor
			$('#plato_nombre').val("");
			$('#plato_cantidad').val("");
			$('#plato_id_temp').val("");
			$('#plato_nombre').focus();
		});

		// ELIMINAR PLATO DE LISTA TEMPORAL
		// =======================================
		$('.pedido_detalles').on('click', '.delete', function(event){
			$(this).closest('.plato-item').remove();
			if( $(".plato-item").length == 0){
				$('.btnSend').hide(); // ocultar boton submit sino hay elementos a guardar
			}
			calcular_totales();
		});

		// FUNCION AÑADIR PLATO AL PEDIDO
		// =====================================
		function add(plato_id, plato_name, plato_cant, plato_prec){
			$('.pedido_detalles').append(
				'<div class="cols-container plato-item" data-id="'+plato_id+'" data-prec="'+plato_prec+'" data-cant="'+plato_cant+'"><div class="cols-7-md">'+plato_name+'</div><div class="cols-2-md">'+plato_cant+'</div><div class="cols-2-md">'+plato_prec+'</div><div class="cols-1-md"><a class="delete" title="Quitar" href="#">x</a></div></div>'
			);
		}

		function calcular_totales(){ // Calcular adicionales
			//return "hola";
			var total_extras=0;
			var platos = {};

			$(".plato-item").each(function(index, element){
					//plato_id = $(element).attr("data-id");
					plato_prec = $(element).attr("data-prec");
					plato_cant = $(element).attr("data-cant");

					//JavaScript does not support arrays with named indexes.
					//plato = new Array( plato_id,  plato_cant, plato_prec);
					subtotal = plato_prec * plato_cant;
					console.log(subtotal);
					total_extras += subtotal;
			});

			// Calcular total extras
			console.log("extras"+total_extras);
			$('#total_extras').val(total_extras);
			$('#total_extras_visible').html(total_extras);

			// Calcular total reservacion
			calcular_total();
			/*total_habitacion = $('#total_habitacion').val();
			total_final = parseFloat(total_habitacion) + parseFloat(total_extras);
			$('#total_final').val(total_final);
			$('#total_final_visible').html(total_final);*/
		}

		function calcular_total(){
			console.log("calculando...");
			// Calcular total reservacion
			total_habitacion = $('#total_habitacion').val();
			total_extras = $('#total_extras').val();

			total_final = parseFloat(total_habitacion) + parseFloat(total_extras);
			$('#total_final').val(total_final);
			$('#total_final_visible').html(total_final);
		}

    // Mostrar explorer
    var type="various";
    $('.show_explorer').click(function(event){
      type = $(this).attr('data-type');
      $('.explorer').attr('data-type',type);
      controles(type);
      console.log(type);
      $('.explorer, .bg-opacity').show();
    });

    //function ocultar/mostrar checbox o link seleccionar, de acuerdo al requerimiento
    window.controles = function(type){ // funcion se accede desde cualquier block de codigo
      if(type=="alone"){
        // ocultar varios
        $('.btn_select_customers').hide();
        $('.crm_check_alone').show();
        $('.crm_cover_check').hide();
      }else{
        // ocultar solos
        $('.btn_select_customers').show();
        $('.crm_check_alone').hide();
        $('.crm_cover_check').show();
      }
    }

    // Editar
    $('.btnShowEditPrice').click(function(event){
      $('.habitacion_precio_cover').hide();
      $('.habitacion_edit_cover').show();
    });

    // Aceptar
    $('.btnAcceptEditPrice').click(function(event){
      var new_price = $('input[name=precio_nuevo]').val();
      $('input[name=total_habitacion]').val(new_price);
      $('#total_habitacion_visible').html(new_price);
      calcular_total();
      $('.btnCancelEditPrice').click();
    });

    // Cancelar
    $('.btnCancelEditPrice').click(function(event){
      $('.habitacion_precio_cover').show();
      $('.habitacion_edit_cover').hide();
    });

    // Delete item clientes
    $('#list_ocupantes').keyup(function(e){
      if(e.keyCode == 46) {
        var customer_id = $( "#list_ocupantes option:selected" ).val();
        $( "#list_ocupantes option:selected" ).remove();
        var ocupantes_id = $('input[name=ocupantes_ids]').val();
        var array_ocupantes_id = ocupantes_id.split(",");

        var index = array_ocupantes_id.indexOf(customer_id);
        if (index > -1) {
          array_ocupantes_id.splice(index, 1);
        }
        $('input[name=ocupantes_ids]').val(array_ocupantes_id.toString());
      }
    });
  });
</script>
<?php
include_once 'customer.neweditlist.php';
?>
