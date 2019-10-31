<?php
// Report3: Clientes sin visitas
?>
<section id="novisits" class="seccion">
  <div class="seccion-header">
    <h2>Clientes sin visitas</h2>
    <ul class="buttons">
      <li>
          <select id="period_month">
              <option value="30">30 dias</option>
              <option value="60">60 dias</option>
              <option value="90">90 dias</option>
          </select>
      </li>
      <script>
          $(document).ready(function() {
            $('#period_month').change(function(event){
              console.log($('#period_month').val());
              var days = $('#period_month').val();
              $.ajax({
                method: "get",
                url: "<?= G_SERVER ?>rb-script/modules/crm/report3.details.php?days="+days,
                beforeSend: function(){
                  $('#content-report3').html('<img src="<?= G_SERVER ?>rb-script/modules/crm/spinner.gif" alt="Wait" />')
                }
              })
              .done(function( data ) {
                $('#content-report3').html(data);
              });
            });
          });
      </script>
    </ul>
  </div>
  <div class="seccion-body">
    <div id="content-report3">
      <?php include_once 'report3.details.php' ?>
    </div>
  </div>
</section>
