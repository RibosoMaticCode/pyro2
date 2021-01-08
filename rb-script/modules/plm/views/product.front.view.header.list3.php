<?php rb_header(['header-allpages.php'], false) ?>
<div class="wrap-content">
  <div class="inner-content clear">
    <div class="products-category-title">
      <?php if(isset($CountResult)): ?>
        <h1><?= $CountResult ?> resultados encontrados</h1>
      <?php endif ?>
      <?php if(isset($category_info)): ?>
        <h1><?= $category_info['nombre'] ?></h1>
      <?php endif ?>
    </div>
    <div class="category-pagination">
			<ul>
        <li<?php if($CurrentPage==1) echo " class='page-disabled'" ?>>
					<a href="<?= url_page($term, 1, $type) ?>">«</a>
				</li>
				<li<?php if($PrevPage==0) echo " class='page-disabled'" ?>>
					<a href="<?= url_page($term, $PrevPage, $type) ?>">‹</a>
				</li>
				<?php
				for ($i = 1; $i <= $TotalPage; $i++):
				?>
				<li>
					<a <?php if($CurrentPage==$i) echo " class='page-resalt'" ?>href="<?= url_page($term, $i, $type) ?>"><?= $i ?></a>
				</li>
				<?php
				endfor;
				?>
				<li<?php if($NextPage==0) echo " class='page-disabled'" ?>>
					<a href="<?= url_page($term, $NextPage, $type) ?>">›</a>
				</li>
				<li<?php if($LastPage==0) echo " class='page-disabled'" ?>>
					<a href="<?= url_page($term, $LastPage, $type) ?>">»</a>
				</li>
			</ul>
		</div>
    <?php include_once 'product.front.view.list2.php' ?>
    <div class="category-pagination" style="margin-bottom:60px">
			<ul>
        <li<?php if($CurrentPage==1) echo " class='page-disabled'" ?>>
					<a href="<?= url_page($term, 1, $type) ?>">«</a>
				</li>
				<li<?php if($PrevPage==0) echo " class='page-disabled'" ?>>
					<a href="<?= url_page($term, $PrevPage, $type) ?>">‹</a>
				</li>
				<?php
				for ($i = 1; $i <= $TotalPage; $i++):
				?>
				<li>
					<a <?php if($CurrentPage==$i) echo " class='page-resalt'" ?>href="<?= url_page($term, $i, $type) ?>"><?= $i ?></a>
				</li>
				<?php
				endfor;
				?>
				<li<?php if($NextPage==0) echo " class='page-disabled'" ?>>
					<a href="<?= url_page($term, $NextPage, $type) ?>">›</a>
				</li>
				<li<?php if($LastPage==0) echo " class='page-disabled'" ?>>
					<a href="<?= url_page($term, $LastPage, $type) ?>">»</a>
				</li>
			</ul>
		</div>
  </div>
</div>
<?php rb_footer(['footer-allpages.php'], false) ?>
