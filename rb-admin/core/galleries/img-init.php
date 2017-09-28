<?php
//require_once(ABSPATH."rb-script/class/rb-galerias.class.php");

$album_id = $_GET["album_id"];
$result_g = $objDataBase->Ejecutar("SELECT nombre FROM albums WHERE id=".$album_id);
    $row_g = $result_g->fetch_assoc();
?>
<h2 class="title"><?= $row_g['nombre'] ?></h2>
<div class="page-bar">Inicio > Medios > Galerías</div>

<div id="sidebar-left">
        <ul class="buttons-edition">
  <li><a class="btn-primary" href="../rb-admin/?pag=gal">Volver</a></li>
        <li><a class="btn-primary" href="../rb-admin/?pag=imgnew&amp;opc=nvo&amp;album_id=<?= $album_id ?>"><img src="img/add-white-16.png" alt="Cargar" /> Agregar nuevo item</a></li>
  <li><a class="btn-primary" rel="img" href="#" id="edit"><img src="img/edit-white-16.png" alt="Editar" /> Editar</a></li>
  <li><a class="btn-primary" rel="img" data-albumid="<?= $album_id ?>" href="#" id="delete"><img src="img/del-white-16.png" alt="delete" /> Eliminar</a></li>
  <li><a class="btn-primary" href="#" id="imgSaveOrder">Guardar orden</a></li>
        </ul>
</div>
<div class="content">
      <div id="content-list">
            <div id="resultado"> <!-- ajax asyncron here -->
              <script src="<?= G_SERVER ?>/rb-admin/resource/ui/jquery-ui.js"></script>
              <script>
        $(function() {
          $( "#grid" ).sortable();
          $( "#grid" ).disableSelection();

          $( '#imgSaveOrder').click ( function ( event ){
            /*var jsonOrder = "{";
            var coma = "";*/
            var files = [];
            $( "#grid li" ).each(function( index ) {
              files.push({
                  id: $( this ).attr('data-id'),
                  order: index
              });
              /*files["id"] =
              files["order"] = index*/
              //var file_id = $( this ).attr('data-id');
              //jsonOrder += coma +" '"+file_id+"' : '"+index + "'";
              //coma = ",";
          });
          /*jsonOrder += "}";*/
          files = JSON.stringify( files );
          console.log( files );

          $.ajax({
            method: "GET",
            url: "gallery.img.save.order.php",
            data: { jsonOrder : files }
          }).done(function( msg ) {
              console.log( msg );
          });
          });
        });
        </script>
                <ul id="grid" class="wrap-grid">
                <?php include('img-list.php') ?>
                </ul>
                <!--</tbody>
            </table>-->
            </div>
        </div>
</div>
