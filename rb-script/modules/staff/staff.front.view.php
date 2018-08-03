<?php rb_header(['header-allpages.php'], false) ?>
<div class="wrap-content">
  <div class="inner-content clear block-content">
    <h2 style="margin-bottom:20px">STAFF</h2>
    <div class="cols-container staff_top">
      <div class="cols-6-md">
        <h1><?= $staff['name']  ?></h1>
        <h3><?= $staff['position'] ?></h3>
      </div>
      <div class="cols-6-md">
        <ul class="staff_details">
          <li>
            <i class="fa fa-envelope"></i> <?= $staff['email']  ?>
          </li>
          <li>
            <i class="fa fa-phone"></i> <?= $staff['telefono']  ?>
          </li>
        </ul>
      </div>
    </div>
    <div class="cols-container">
      <?php
      $foto = rb_get_photo_details_from_id($staff['photo_id']);
      $url_foto = $foto['file_url'];
      ?>
      <div class="cols-6-md">
        <div class="staff_photo" style="background-image:url(<?= $url_foto ?>)">
        </div>
      </div>
      <div class="cols-6-md">
        <div class="staff_info">
          <?= $staff['description'] ?>
        </div>
      </div>
    </div>
    <a href="<?= G_SERVER ?>/staff/listado/" class="staff_back"><i class="fa fa-angle-double-left"></i> Regresa</a>
  </div>
</div>
<?php rb_footer(['footer-allpages.php'], false) ?>
