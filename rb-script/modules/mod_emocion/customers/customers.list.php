<?php
$rb_module_title = "Clientes";
$rb_module_title_section = "Clientes";

function rb_emocion_main(){
  require_once ABSPATH.'global.php';
  require_once ABSPATH.'rb-script/class/rb-database.class.php';

  global $rb_module_url_main;
  global $rb_module_url;
  if(isset($_GET['opc'])):
    $opc=$_GET['opc'];
    //include('puntos.edit.php');
  else:
    ?>
    <script>
    $(document).ready(function() {
      $(".winfloat").fancybox({
        helpers : {
          overlay : {closeClick: false}
        }
      });
    });
    </script>
    <ul class="buttons-edition">
      <li><a class="btn-primary winfloat fancybox.ajax" href="<?= $rb_module_url ?>customers/customers.form.php" id="edit"><img src="img/edit-white-16.png" alt="Editar"> Nuevo Cliente</a></li>
    </ul>
    <script>
    $(document).ready(function() {
      $('.sendcode').click(function( event ){
        event.preventDefault();
        var code = $(this).attr('data-code');
        var send = confirm("Enviara un correo con el codigo al correo del cliente. ¿Continuar?");
        if ( send ) {
          $.ajax({
            url: '<?= $rb_module_url ?>customers/customers.sendcode.php?uid='+code,
            cache: false,
            type: "GET",
            success: function(data){
              if(data=="1"){
                notify('El codigo fue enviado por correo al cliente');
              }else{
                console.log("Error: Recargue página");
              }
            }
          });
        }
      });

      $('.del-customer').click(function( event ){
        event.preventDefault();
        var id = $(this).attr('data-id');
        console.log(id);
        var eliminar = confirm("[?] Confirmar la eliminación permanente de este dato. ¿Continuar?");
        if ( eliminar ) {
          $.ajax({
            url: '<?= $rb_module_url ?>customers/customers.del.php?id='+id,
            cache: false,
            type: "GET",
            success: function(data){
              if(data.resultado=="ok"){
                notify('Eliminado');
                $('#f_'+id).children().addClass('deleteHighlight');
                $('#f_'+id).children().fadeOut(500);
              }else{
                console.log("Error: Recargue página");
              }
            }
          });
        }
      });
    });
    </script>
    <div class="wrap-content-list">
      <section class="seccion">
        <table class="tables">
          <thead>
            <tr>
              <th>Codigo Cliente<br /><span style="font-size:.7em">(Click para enviar el codigo al cliente)</span></th>
              <th>Empresa</th>
              <th>RUC</th>
              <th>Direccion</th>
              <th>Webs</th>
              <th>Contacto</th>
              <th>Correo</th>
              <th>Telefono</th>
              <th>Celular</th>
              <th>Fecha de Registro</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $r = $objDataBase->Ejecutar("SELECT * FROM emo_customers ORDER BY id DESC");
            while ($curr = mysql_fetch_array($r)):
            ?>
            	<tr id="f_<?= $curr['id']?>">
            		<td>
                  <a class="sendcode" data-code="<?= $curr['codigo']?>" title="Enviar por correo codigo" target="_blank" href="#">
                  <?= $curr['codigo']?>
                </a>
              </td>
            		<td><?= $curr['empresa']?>
                  <div class="options">
                    <a class="winfloat fancybox.ajax" href="<?= $rb_module_url ?>customers/customers.form.php?uid=<?= $curr['id']?>">Editar</a>
                  </div>
                </td>
            		<td><?= $curr['empresa_ruc']?></td>
                <td><?= $curr['empresa_direccion']?></td>
                <td>
                  <ul>
                  <?php
                  if(strlen($curr['empresa_webs'])>0){
            				$arr = json_decode($curr['empresa_webs']);
            				foreach ($arr as $key => $value) {
            					echo "<li>".$value."</li>";
            				}
            			}
                  ?>
                  </ul>
                </td>
                <td><?= $curr['contacto_nombres']?></td>
                <td><?= $curr['contacto_correo']?></td>
                <td><?= $curr['contacto_telefono']?></td>
                <td><?= $curr['contacto_celular']?></td>
                <td><?= $curr['fecha_registro']?></td>
            		<td><a title="Eliminar" class="del-customer" data-id="<?= $curr['id'] ?>" style="color:red" href="#"><img src="<?= $rb_module_url ?>/img/delete.png" alt="delete" /></a></td>
            	</tr>
            <?php
            endwhile;
            ?>
          </tbody>
        </table>
      </section>
    </div>
    <?php
  endif;
}

add_function('panel_header_css','rb_emocion_css');
add_function('module_content_main','rb_emocion_main');
?>
