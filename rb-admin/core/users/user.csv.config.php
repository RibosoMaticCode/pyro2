<div class="wrap-content-list">
    <section class="seccion">
        <div class="seccion-header">
            <h3>CSV a lista de usuarios (Version 1.0)</h3>
        </div>
        <div class="seccion-body">
            <p>Si tienes una hoja de calculo con lista de usuarios, puedes pasarlo a formato CSV</p>
            <p>Las columnas que acepta nuestro sistema son Nombres, Apellidos y Correo (no incluir estos como cabecera)</p>
            <p>Un ejemplo de formato CSV</p>
            <pre>Radmila;Milenkovia;sergiocarranzaherrera@gmail.com
Monica;Figueroa;monickafe@live.com
Fatima;Huertas;grace_fhh@hotmail.com</pre>
            <p>Subir a este directorio <code>rb-admin/core/user</code>. El archivo debe tener el nombre <code>lista.csv</code></p>
            <p>Si cumples con lo anterior. Pulsa el siguiente vínculo para previsualizarlos. <a id="btnLoadFile" href="#">Previsualizar</a></p>
            <pre id="PreviewCSV" style="max-height:500px; overflow:auto">
            </pre>
            <p>Si logra visualizar sus datos, están listo para importarlos al sistema. En caso un correo ya exista, se saltará al siguiente usuario.</p>
            <p>Al final del proceso se mostrará un resumen de los usuarios con su nombre de usuario y contraseñas generados automaticamente</p>
            <p>Es importante guardar esa lista para notificar los usuarios como acceder al sistema con dichos datos</p>
            <p><a id="btnImport" href="#">Importar al sistema</a></p>
            <div id="ResumenFinal">
            </div>
        </div>
    </section>
</div>
<script>
$(document).ready(function() {
    // PREVISUALIZAR
    $('#btnLoadFile').click(function(event){
        $.ajax({
  			url: 'core/users/user.csv.preview.php',
  			cache: false,
  			type: "GET",
  			success: function(data){
                  $('#PreviewCSV').html(data);
            }
        });
    });

    // IMPORTACION
    $('#btnImport').click(function(event){
        $.ajax({
  			url: 'core/users/user.csv.import.php',
  			cache: false,
  			type: "GET",
  			success: function(data){
                  $('#ResumenFinal').html(data);
            }
        });
    });
});
</script>