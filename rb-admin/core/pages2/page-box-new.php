<script>
$(document).ready(function() {
  $( ".cols-html" ).sortable({
      placeholder: "placeholder",
      handle: ".col-head"
  });
});
</script>
<?php
if(!isset($_GET['temp_id'])) $temp_id = 1;
else $temp_id = $_GET['temp_id'];
?>
<li class="item" data-id="box<?= $temp_id ?>" data-type="box">
  <div class="box-header">
    <strong>Bloque</strong>
    <ul class="box-options">
      <li>
        <a href="#">Añadir columna</a>
        <ul class="box-options-list">
          <li>
            <a class="addSlide" href="#">Slide</a>
          </li>
          <li>
            <a class="addHtml" href="#">HTML</a>
          </li>
        </ul>
      </li>
    <a class="toggle" href="#">
      <span class="arrow-up">&#9650;</span>
      <span class="arrow-down">&#9660;</span>
    </a>
    <a class="boxdelete" href="#">X</a>
  </div>
  <div class="box-body">
    <ul class="cols-html">
    </ul>
  </div>
</li>
