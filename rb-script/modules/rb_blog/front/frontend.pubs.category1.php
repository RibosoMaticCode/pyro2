<?php rb_header(['header-allpages.php'], false) ?>
<?php if($rm_url_page_img!=""): ?>
<div class="wrap-content wrap_category_header_img" style="background-image: url(<?= $rm_url_page_img ?>)">
  <div class="inner-content clear category_header_img">
  </div>
</div>
<?php endif ?>
<div class="wrap-content wrap_category_header_info">
  <div class="inner-content clear category_header_info">
  	<h1><?= $Categoria['nombre'] ?></h1>
  	<p><?= $Categoria['descripcion'] ?></p>
  </div>
</div>
<div class="wrap-content">
  <div class="inner-content clear block-content">
  	<div class="cover_categories">
      <?php 
      $categorias = blog_list_category($Categoria['id']); 
      if(count($categorias) > 0):
        ?>
        <ul>
          <?php
          foreach ($categorias as $categoria) {
            ?>
            <li><a href="<?= $categoria['url']?>"><?= $categoria['nombre']?></a></li>
            <?php
          }
          ?>
        </ul>
        <?php
      endif;
      ?>
  	</div>
    <div class="posts_list clear">
      	<?php
      	foreach ($Posts as $Post):
      	?>
      	<article>
	        <h2><a href="<?= $Post['url'] ?>"><?= $Post['titulo']  ?></a></h2>
	        <?= rb_fragment_text($Post['contenido'], 50) ?>
	        <ul class="post-categories">
              <?php
              $categorias = rb_show_category_from_post($Post['id']);
              foreach ($categorias as $categoria) {
                ?>
                <li><a href="<?= $categoria['url'] ?>"><?= $categoria['nombre'] ?></a></li>
                <?php
              }
              ?>
            </ul>
      	</article>
      	<?php
      	endforeach;
      	?>
    </div>
  </div>
</div>
<?php rb_footer(['footer-allpages.php'], false) ?>
