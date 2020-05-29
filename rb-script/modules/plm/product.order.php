<?php
$objDataBase = new DataBase;
$qlist = $objDataBase->Ejecutar("SELECT * FROM plm_products ORDER BY orden DESC");
?>
<script src="<?= G_SERVER ?>rb-admin/resource/ui/jquery-ui.js"></script>
<section class="seccion">
	<div class="seccion-header">
		<h2>Orden de Productos</h2>
		<ul class="buttons">
	      <li>
	      	<button id="plmSaveOrder" class="button btn-primary">Guardar orden</button>
	      </li>
	    </ul>
	</div>
  	<div class="seccion-body">
  		<ul class="plm_products_order">
  		<?php
  		while ($row = $qlist->fetch_assoc()){
  			if(G_ENL_AMIG) $product_url = G_SERVER."products/".$row['nombre_key']."/";
			else $product_url = G_SERVER."?products=".$row['id'];
  			?>
  			<li data-id="<?= $row['id'] ?>"><a href="<?= $product_url ?>"><?= $row['nombre'] ?></a></li>
  			<?php
  		}
  		?>
  		</ul>
  	</div>
</section>

<script>
$(document).ready(function(){
	// ORDER FOTOS
	$( ".plm_products_order" ).sortable();
    $( ".plm_products_order" ).disableSelection();

	$( '#plmSaveOrder').click ( function ( event ){
		var files = [];
        $($( ".plm_products_order li" ).get().reverse()).each(function( index ) {
        	files.push({
        		id: $( this ).attr('data-id'),
                order: index
            });
        });

        files = JSON.stringify( files );
        console.log( files );

		$.ajax({
        	method: "GET",
            url: "<?= G_DIR_MODULES_URL ?>plm/product.order.save.php",
            data: { jsonOrder : files }
        }).done(function( data ) {
        	if(!data.result){
        		notify("Error: ".data.message);
        	}else{
        		notify(data.message);
        	}
        	//notify("Se guardo el orden de la productos");
            console.log( data );
        });
    });
});
</script>