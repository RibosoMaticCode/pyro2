<?php rb_header(['header-allpages.php'], false) ?>
<div class="wrap-content"><?php rb_header(array('header-all.php')) ?>
  <div class="inner-content clear block-content">
    <div class="wrap-posts-list <?= class_col_1 ?>">
      <?php
      foreach ($Posts as $Post):
      ?>
      <article>
        <div class="info">
          <span class="date"><?= $Post['fec_dia']  ?> de <?= $Post['fec_mes_l']  ?>, <?= $Post['fec_anio']  ?></span>
        </div>
        <h2><a href="<?= $Post['url'] ?>"><?= $Post['titulo']  ?></a></h2>
        <img class="image-star" src="<?= $Post['url_img_por_max']  ?>" alt="img" />
        <?= rb_fragment_text($Post['contenido'], 50) ?>
      </article>
      <?php
      endforeach;
      ?>
      <div class="pagination">
				<ul>
					<li<?php if($CurrentPage==1) echo " class='page-disabled'" ?>>
						<a href="<?= rb_url_link('cat', $categoria_id) ?>">«</a>
					</li>
					<li<?php if($PrevPage==0) echo " class='page-disabled'" ?>>
						<a href="<?= rb_url_link('cat', $categoria_id, $PrevPage) ?>">‹</a>
					</li>
					<?php
					for ($i = 1; $i <= $TotalPage; $i++):
					?>
					<li>
						<a <?php if($CurrentPage==$i) echo " class='page-resalt' " ?>href="<?= rb_url_link('cat', $categoria_id, $i) ?>"><?= $i ?></a>
					</li>
					<?php
					endfor;
					?>
					<li<?php if($NextPage==0) echo " class='page-disabled'" ?>>
						<a href="<?= rb_url_link('cat', $categoria_id, $NextPage) ?>">›</a>
					</li>
					<li<?php if($LastPage==0) echo " class='page-disabled'" ?>>
						<a href="<?= rb_url_link('cat', $categoria_id, $LastPage) ?>">»</a>
					</li>
				</ul>
			</div>
    </div>
    <?php rb_sidebar() ?>
  </div>
</div>
<?php rb_footer(['footer-allpages.php'], false) ?>
