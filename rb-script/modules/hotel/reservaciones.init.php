<?php
require_once 'funcs.php';

/* Parametros iniciales para CRUD basico */
$title_section = "Reservaciones";
$file_prefix = "reservaciones";
$table_name = "hotel_reservacion";
$module_dir = "hotel";
$key = "hotel_reservaciones";

$newedit_path = G_DIR_MODULES_URL.$module_dir."/".$file_prefix.".newedit.php";
$urlreload=G_SERVER.'/rb-admin/module.php?pag='.$key;

// Fecha a mostrar
$time_now = date(' H:i:s');
$hora_llegada = " ".get_option('hora_llegada');
$hora_salida = " ".get_option('hora_salida');
if(isset($_GET['date'])){
  $fecha = $_GET['date'];
}else{
  $fecha = date('Y-m-d'); // Por defecto
}
$objDataBase = new DataBase;

// Habitaciones ocupadas
$q = "SELECT h.*, r.* FROM hotel_reservacion r, hotel_habitacion h WHERE h.id = r.habitacion_id AND '$fecha$hora_llegada' >= r.fecha_llegada AND r.fecha_salida >= '$fecha$hora_salida'";
$qho = $objDataBase->Ejecutar( $q );

// Determinar Habitaciones disponibles:
$ids_habita_ocu = "";
$coma = "";
while( $habita = $qho->fetch_assoc() ){
  $ids_habita_ocu .= $coma.$habita['habitacion_id']; // Obtenemos el id de las ocupadas
  $coma = ",";
}

// Habitaciones disponibles : que se liberaran durante el dia
$hoy = date('Y-m-d'); // Fecha actual
if($fecha > $hoy){
  // Consulta si hay habitaciones que se desocupan a la hora del chekcout de este dia
  // Ej. Esto lista las habitaciones que se desocuparan hoy a las 14:30 horas, por lo tanto deben estar disponibles para elegir
  $q = "SELECT r.*, h.id, h.numero_habitacion FROM hotel_reservacion r, hotel_habitacion h WHERE r.habitacion_id = h.id AND date(fecha_salida) = '$fecha' AND time(fecha_salida) <= '$hora_llegada'";
  //echo $q;
  $qht = $objDataBase->Ejecutar( $q );
}

// Habitaciones disponibles: si o si
if(empty($ids_habita_ocu)){
  $q = "SELECT * FROM hotel_habitacion"; // Si no hay ninguna ocupada, muestra todas como libres
}else{
  $q = "SELECT * FROM hotel_habitacion WHERE id NOT IN ($ids_habita_ocu)"; // Si hay ocupadas, las obviamos de la consulta
}

$qhd = $objDataBase->Ejecutar( $q );
?>
<section class="seccion">
  <div class="seccion-header">
    <h2><?= $title_section ?></h2>
    <ul class="buttons">
      <li>
        Seleccione fecha
        <input type="date" name="fecha" value="<?= $fecha ?>" id="fecha_pedido" />
        <script>
        $('input[name=fecha]').change(function() {
          console.log($(this).val());
          window.location.href = '<?= $urlreload ?>&date='+$(this).val();
        });
        </script>
      </li>
    </ul>
  </div>
  <div class="seccion-body">

    <!-- new section -->
    <h3>Habitaciones disponibles (A partir de las <?= get_option('hora_llegada') ?> horas)</h3>
    <ul class="list_habitaciones available">
      <?php
      if(isset($qht) && $qht->num_rows > 0):
  			while($habitacion = $qht->fetch_assoc()):
          // Verificamos si la habitacion que debia desocuparse hoy, la volvieron a reservar desde hoy.
          // Asi que comparamos si  hay registros con fecha de hoy, pero hora de registro mayor a la de llegada.
          // Ej. Si hay registros con hora mayor a 14:30, significa que esta habitacion ha sido tomada, y por tanto no se mostrara como disponible.
          $q = "SELECT r.*, h.id, h.numero_habitacion FROM hotel_reservacion r, hotel_habitacion h WHERE r.habitacion_id = h.id AND date(fecha_llegada) = '$fecha' AND time(fecha_llegada) >= '$hora_llegada'";
          $qhdt = $objDataBase->Ejecutar( $q );
          if($qhdt->num_rows == 0){
      			?>
      				<li value="<?= $habitacion['id'] ?>">
                <a class="fancyboxForm fancybox.ajax" href="<?= $newedit_path ?>?res_id=0&hab=<?= $habitacion['id'] ?>&date=<?= $fecha ?>">
                  <img src="<?= G_DIR_MODULES_URL.$module_dir."/room.png" ?>" alt="room" /> <?= $habitacion['numero_habitacion'] ?>
                  <br />
                  <span>Disponible desde: <?= get_option('hora_llegada') ?> horas</span>
                </a>
              </li>
      			<?php
          }
        endwhile;
      endif;
      if($qhd->num_rows > 0):
  			while($habitacion = $qhd->fetch_assoc()):
  			?>
  				<li value="<?= $habitacion['id'] ?>">
            <a class="fancyboxForm fancybox.ajax" href="<?= $newedit_path ?>?res_id=0&hab=<?= $habitacion['id'] ?>&date=<?= $fecha ?>">
              <img src="<?= G_DIR_MODULES_URL.$module_dir."/room.png" ?>" alt="room" /> <?= $habitacion['numero_habitacion'] ?>
            </a>
          </li>
  			<?php
        endwhile;
      else:
        ?>
        <div class="empty_box">Ninguno</div>
        <?php
      endif;
			?>
    </ul>
    <h3>Habitaciones reservadas</h3>
    <ul class="list_habitaciones occupied">
      <?php
      $qho->data_seek(0);
        if($qho->num_rows > 0):
  			while($reservacion = $qho->fetch_assoc()):
  			?>
  				<li value="<?= $reservacion['habitacion_id'] ?>">
            <a class="fancyboxForm fancybox.ajax" href="<?= $newedit_path ?>?res_id=<?= $reservacion['id'] ?>&date=<?= $fecha ?>">
              <img src="<?= G_DIR_MODULES_URL.$module_dir."/room.png" ?>" alt="room" /> <?= $reservacion['numero_habitacion'] ?>
              <br/>
            <span>Llegada : <?= rb_sqldate_to($reservacion['fecha_llegada'], 'd-m-Y H:i')?></span><br />
            <span>Salida : <?= rb_sqldate_to($reservacion['fecha_salida'], 'd-m-Y H:i')?></span><br />
            <span>Estado: <?= estado_habitacion($reservacion['estado']) ?></span>
            </a>
          </li>
  			<?php
  			endwhile;
      else:
        ?>
        <div class="empty_box">Ninguno</div>
        <?php
      endif;
  		?>
    </ul>
  </div>
</section>

<!-- listado -->
<?php
$columns_title_coltable = [
  'Fecha llegada' => 'fecha_llegada',
  'Fecha salida' => 'fecha_salida',
  /*'Habitacion' => 'habitacion_id',
  'Cliente' => 'cliente_id',
  'Personal' => 'personal_id',*/
  'Total habitacion' => 'total_habitacion',
  'Total adicionales' => 'total_adicionales',
  'Total reservacion' => 'total_reservacion'
];

$qlist = $objDataBase->Ejecutar("SELECT * FROM $table_name ORDER BY id DESC");
?>
<section class="seccion">
  <div class="seccion-header">
    <h3>Listado de reservaciones</h3>
  </div>
  <div class="seccion-body">
    <script>
      $(document).ready(function() {
        $('#table').DataTable({
          "language": {
            "url": "resource/datatables/Spanish.json"
          }
        });
      } );
    </script>
    <table id="table" class="tables table-striped">
      <thead>
        <tr>
          <th>Habitacion</th>
          <th>Cliente</th>
          <?php
          foreach ($columns_title_coltable as $key => $value) {
            ?>
            <th><?= $key ?></th>
            <?php
          }
          ?>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php include_once $file_prefix.'.list.php' ?>
      </tbody>
    </table>
  </div>
</section>
<script>
// Eliminar item
$('.del').on("click", function(event){
  event.preventDefault();
  var eliminar = confirm("¿Continuar con la eliminacion de este elemento?");
  if ( eliminar ) {
    var id = $(this).attr('data-item');
    $.ajax({
      type: "GET",
      url: "<?= G_DIR_MODULES_URL.$module_dir."/".$file_prefix ?>.del.php?id="+id
    })
    .done(function( data ) {
      if(data.resultado){
        notify(data.contenido);
        setTimeout(function(){
          window.location.href = '<?= $urlreload ?>';
        }, 1000);
      }else{
        notify(data.contenido);
      }
    });
  }
});
</script>
