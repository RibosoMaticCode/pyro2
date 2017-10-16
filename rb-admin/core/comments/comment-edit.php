<?php
$id=$_GET["id"];
require_once(ABSPATH."rb-script/class/rb-database.class.php");
$consulta = $objDataBase->Ejecutar("SELECT c.*, a.titulo FROM comentarios c, articulos a WHERE a.id = c.articulo_id AND c.id=$id");
$row= $consulta->fetch_assoc();
$mode = "update";
?>
<form id="comment-form" name="comment-form" method="post" action="core/comments/comment-save.php">
      <div id="toolbar">
          <div id="toolbar-buttons">
                <span class="post-submit">
      <input class="submit" name="guardar" type="submit" value="Guardar" />
      <a href="../rb-admin/?pag=com"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>
                </span>
            </div>
        </div>
  <div class="content-edit">
    <section class="seccion">
            <div class="seccion-body">
        <label title="Contenido del comentario">Comentario:
          <textarea name="comentario" id="comentario" cols="75" rows="20" style="width:100%; height:200px;"><?php echo htmlspecialchars($row['contenido']); ?></textarea>
        </label>
        <label title="Art&iacute;culo en el cual comento" for="articulo">T&iacute;tulo:
          <input  name="articulo" type="hidden" value="<?php echo $row['articulo_id']; ?>" />
          <input  name="articulo_titulo" type="text" readonly="true" value="<?php echo $row['titulo']; ?>" />
        </label>
              </div>
            </section>
  </div>
  <div id="sidebar">
    <section class="seccion">
      <div class="seccion-header">
        Datos del Autor
      </div>
      <div class="seccion-body">
        <label title="Autor, Propietario">Nombre autor:
        <input  name="autor" type="text" id="autor" value="<?php echo $row['nombre']; ?>"/>
        </label>

        <label title="Correo electronico del autor">E-mail:
        <input  name="mail" type="text" id="mail" value="<?php echo $row['mail']; ?>"/>
        </label>

        <label title="Website o blog del autor">Website o blog:
        <input  name="web" type="text" id="web" value="<?php echo $row['web']; ?>"/>
        </label>

        <label title="Fecha del publicacion">Fecha:
        <input readonly="true"  name="fecha" type="text" id="fecha" value="<?php echo $row['fecha']; ?>"/>
        </label>
              </div>
          </section>
  </div>
  <input name="section" value="com" type="hidden" />
        <input name="mode" value="<?php echo $mode ?>" type="hidden" />
  <input name="id" value="<?php echo $row['id']; ?>" type="hidden" />
</form>
