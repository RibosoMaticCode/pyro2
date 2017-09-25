<script>
$(document).ready(function() {
  $( ".cols-html" ).sortable({
      placeholder: "placeholder",
      handle: ".col-head"
  });
});
</script>
<li class="item" id="" data-type="">
  <div class="box-header">
    <h4>Bloque</h4>
    <!--<a class="add-column" href="#">(+) Agregar Columna</a>-->
    <ul>
      <li>
        <a href="#">Añadir columna</a>
        <ul>
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
