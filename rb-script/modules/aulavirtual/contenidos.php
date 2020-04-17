<section class="seccion">
  <div class="seccion-header">
    <h2>Contenidos</h2>
    <ul class="buttons">
      <li><a class="button btn-primary" href="<?= G_SERVER ?>rb-admin/module.php?pag=aula_contenidos&id=0&tipo=1&padre_id=0">Nuevo curso</a></li>
    </ul>
  </div>
  <div class="seccion-body">
    <div id="content-list">
    	<ul class="aula_contenidos_list">
	      	<?php while( $curso = $r->fetch_assoc()): ?>
	      		<li>Curso: <?= $curso['titulo'] ?> 
	      			<div>
	      				<a href="<?= G_SERVER ?>rb-admin/module.php?pag=aula_contenidos&id=0&tipo=2&padre_id=<?= $curso['id'] ?>">Nueva sesión</a> 
	      				<a href="<?= G_SERVER ?>curso/<?= $curso['id'] ?>" target="_blank">Ver</a>
	      				<a href="<?= G_SERVER ?>rb-admin/module.php?pag=aula_contenidos&id=<?= $curso['id'] ?>&tipo=<?= $curso['tipo'] ?>&padre_id=<?= $curso['padre_id'] ?>">Editar</a> 
	      				<a class="del" data-id="<?= $curso['id'] ?>" href="#">Eliminar</a>
	      			</div>

	      			<?php
	      			// Sesiones
					$rs = $objDataBase->Ejecutar("SELECT * FROM aula_contenidos WHERE padre_id=".$curso['id'] );
					if($rs->num_rows > 0):
						print '<ul>';
		      			while( $sesion = $rs->fetch_assoc()): ?>
				      		<li>Sesion: <?= $sesion['titulo'] ?> 
				      			<div>
				      				<a href="<?= G_SERVER ?>rb-admin/module.php?pag=aula_contenidos&id=0&tipo=3&padre_id=<?= $sesion['id'] ?>">Nueva categoria</a>
				      				<a href="<?= G_SERVER ?>sesion/<?= $sesion['id'] ?>" target="_blank">Ver</a>
				      				<a href="<?= G_SERVER ?>rb-admin/module.php?pag=aula_contenidos&id=<?= $sesion['id'] ?>&tipo=<?= $sesion['tipo'] ?>&padre_id=<?= $sesion['padre_id'] ?>">Editar</a> 
				      				<a class="del" data-id="<?= $sesion['id'] ?>" href="#">Eliminar</a>
				      			</div>

				      			<?php
				      			// Categorias
								$rc = $objDataBase->Ejecutar("SELECT * FROM aula_contenidos WHERE padre_id=".$sesion['id'] );
								if($rc->num_rows > 0):
									print '<ul>';
					      			while( $categoria = $rc->fetch_assoc()): ?>
							      		<li>Categoria: <?= $categoria['titulo'] ?> 
							      			<div>
							      				<a href="<?= G_SERVER ?>categoria/<?= $categoria['id'] ?>" target="_blank">Ver</a>
							      				<a href="<?= G_SERVER ?>rb-admin/module.php?pag=aula_contenidos&id=<?= $categoria['id'] ?>&tipo=<?= $categoria['tipo'] ?>&padre_id=<?= $categoria['padre_id'] ?>">Editar</a> 
							      				<a class="del" data-id="<?= $categoria['id'] ?>" href="#">Eliminar</a>
							      			</div>
							      		</li>
							      	<?php 
							      	endwhile; 
							      	print '</ul>';  	
							    endif;
							    ?>
				      		</li>
				      	<?php 
				      	endwhile; 
				      	print '</ul>';  	
				    endif;
				    ?>
	      		</li>
	      	<?php endwhile ?>
	  	</ul>
    </div>
  </div>
</section>

<?php
$urlreload=G_SERVER.'rb-admin/module.php?pag=aula_contenidos';
?>
<script>
// Eliminar evento del dia
$('.del').on("click", function(event){
  event.preventDefault();
  var eliminar = confirm("[?] Esta seguro de eliminar este valor?");
  if ( eliminar ) {
    var id = $(this).attr('data-id');
    $.ajax({
      type: "GET",
      url: "<?= G_SERVER ?>rb-script/modules/aulavirtual/contenido.del.php?id="+id
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
