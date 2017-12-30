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
<li id="box<?= $temp_id ?>" class="item" data-id="box<?= $temp_id ?>" data-type="box" data-inheight="" data-inwidth=""
  data-inbgimage="" data-inbgcolor="" data-inpaddingtop="" data-inpaddingright="" data-inpaddingbottom="" data-inpaddingleft="" data-inclass=""
  data-extbgimage="" data-extbgcolor="" data-extpaddingtop="" data-extpaddingright="" data-extpaddingbottom=""
  data-extpaddingleft="" data-extclass="" data-extparallax="">
  <div class="box-header">
    <strong>Bloque</strong>
    <a href="#" class="showEditBox">
      <i class="fa fa-pencil" aria-hidden="true"></i>
    </a>
    <ul class="box-options">
      <li>
        <a href="#">
          <i class="fa fa-columns fa-lg" aria-hidden="true"></i> Añadir columna
        </a>
        <ul class="box-options-list">
          <li>
            <a class="addSlide" href="#">Slide</a>
          </li>
          <li>
            <a class="addHtml" href="#">HTML</a>
          </li>
          <li>
            <a class="addPost1" href="#">Publicaciones (horizontal)</a>
          </li>
        </ul>
      </li>
    <a class="toggle" href="#">
      <span class="arrow-up">&#9650;</span>
      <span class="arrow-down">&#9660;</span>
    </a>
    <a class="boxdelete" href="#" title="Eliminar">
      <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
    </a>
  </div>
  <div class="box-body">
    <ul class="cols-html">
    </ul>
  </div>
</li>
