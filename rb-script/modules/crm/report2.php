<?php
// Report2: Top visitas por cliente
?>
<section id="topvisit" class="seccion">
  <div class="seccion-header">
    <h2>Top visitas por cliente</h2>
    <ul class="buttons">
      <li>
          <select id="period">
              <option value="7">semana</option>
              <option value="30">mes</option>
          </select>
      </li>
      <script>
          $(document).ready(function() {
            $('#period').change(function(event){
              console.log($('#period').val());
              var days = $('#period').val();
              $.ajax({
                method: "get",
                url: "<?= G_SERVER ?>/rb-script/modules/crm/report2.details.php?days="+days,
                beforeSend: function(){
                  $('#content-report2').html('<img src="<?= G_SERVER ?>/rb-script/modules/crm/spinner.gif" alt="Wait" />')
                }
              })
              .done(function( data ) {
                $('#content-report2').html(data);
              });
            });
          });
      </script>
    </ul>
  </div>
  <div class="seccion-body">
    <div id="content-report2">
      <?php include_once 'report2.details.php' ?>
    </div>
  </div>
</section>