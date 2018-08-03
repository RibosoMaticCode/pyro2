<?php rb_header(['header-allpages.php'], false) ?>
<div class="wrap-content">
  <div class="inner-content clear block-content">
    <div class="cols-container">
      <ul class="staff-list">
        <?php
        while($staff = $qs->fetch_assoc()):
        ?>
        <li>
          <?php
          $foto = rb_get_photo_details_from_id($staff['photo_id']);
          $url_foto = $foto['file_url'];
          ?>
          <!--<a href="<?= G_SERVER ?>/rb-script/modules/staff/staff.front.controller.php?staff_id=<?= $staff['id'] ?>" class="staff-box" style="background-image:url('<?= $url_foto ?>')">-->
          <a href="<?= G_SERVER ?>/staff/<?= $staff['id'] ?>/" class="staff-box" style="background-image:url('<?= $url_foto ?>')">
            <div class="staff-shadow"></div>
            <div class="staff-title">
              <h3><?= $staff['name'] ?></h3>
              <h4><?= $staff['position'] ?></h4>
            </div>
          </a>
        </li>
        <?php
        endwhile;
        ?>
      </ul>
      <p style="text-align:right"><a href="<?= G_SERVER ?>" class="staff_back"><i class="fa fa-angle-double-left"></i> Regresa</a></p>
    </div>
  </div>
</div>
<?php rb_footer(['footer-allpages.php'], false) ?>
