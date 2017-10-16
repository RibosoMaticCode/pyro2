<?php
//require_once(ABSPATH."rb-script/class/rb-usuarios.class.php");
if(isset($_GET['m']) && $_GET['m']=="ok") msgOk("Cambios guardados");

$mode;
if(isset($_GET["id"])){
  // if define realice the query
  $id=$_GET["id"];
  $cons_art = $objDataBase->Ejecutar("SELECT * FROM usuarios WHERE id=$id");
  $row=$cons_art->fetch_assoc();
  $mode = "update";
}else{
  $mode = "new";
}
?>
<script>
$(document).ready(function() {
  // Validando AJAX antes de enviar datos
  $('#user-form').submit(function() {
    // Dependiendo de tipo de usuario, mostrar mensaje error
    if( $('#user-form select[name="tipo"]').val() > 0 ){
      validateInputText( $('#mail'), "Correo electrónico obligatorio" );
      validateInputText( $('#nickname'), "Nombre de usuario obligatorio" );
      if( $('#user-form input[name="mode"]').val() =="update" ){
        // validacion
      }else{
        validateInputText( $('#password'), "Escriba una contraseña" );
        validateInputText( $('#password1'), "Repita la contraseña" );
      }
    }

    if( $('#password').val() != $('#password1').val()){
      notify("Las contraseñas no coinciden");
      return false;
    }
  });
});
</script>
<form id="user-form" name="user-form" method="post" action="core/users/user-save.php">
  <?php
  if(isset($_GET['profile'])):
  ?>
  <input type="hidden" name="profile" />
  <?php
  endif;
  ?>
  <div id="toolbar">
    <div id="toolbar-buttons">
      <span class="post-submit">
        <input class="submit" name="guardar" type="submit" value="Guardar" />
        <?php
        if(!isset($_GET['profile'])):
        ?>
        <a href="<?= G_SERVER ?>/rb-admin/?pag=usu"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>
        <?php
        endif;
        ?>
      </span>
    </div>
  </div>
  <div>
    <div class="content-edit">
      <section class="seccion">
        <div class="seccion-body">
                  <div class="cols-container">
                    <h3 class="subtitle">Datos personales</h3>
                    <div class="cols-6-md col-padding">
                        <label title="Nombres" for="nom">Nombres:
                        <input name="nom" type="text" id="nom" value="<?php if(isset($row)) echo $row['nombres'] ?>" required />
                        </label>

                        <label title="Apellidos" for="ape">Apellidos:
                        <input name="ape" type="text" id="ape" value="<?php if(isset($row)) echo $row['apellidos'] ?>" required />
                        </label>

                        <label title="Correo electronico" for="mail">Correo electronico:
                        <input name="mail" type="text" id="mail" value="<?php if(isset($row)) echo $row['correo'] ?>" />
                        </label>

                        <label title="Direccion" for="dir">Direccion:
                        <input name="dir" type="text" id="dir" value="<?php if(isset($row)) echo $row['direccion'] ?>" />
                        </label>

                        <label title="Congregacion" for="cong">Ciudad:
                        <input name="ciu" type="text" value="<?php if(isset($row)) echo $row['ciudad'] ?>" />
                        </label>

                        <label title="Circuito" for="cir">País:
                        <input name="pais" type="text" value="<?php if(isset($row)) echo $row['pais'] ?>" />
                        </label>


                      </div>
                      <div class="cols-6-md col-padding">
                        <label title="Teléfono móvil" for="tel">Teléfono móvil:
                        <input name="telmov" type="text" id="telmov" value="<?php if(isset($row)) echo $row['telefono-movil'] ?>" />
                        </label>

                        <label title="Teléfono fíjo" for="tel">Teléfono fíjo:
                        <input name="telfij" type="text" id="telfij" value="<?php if(isset($row)) echo $row['telefono-fijo'] ?>" />
                        </label>
                        <label title="Sexo" for="sexo" >Sexo:
                        <select  name="sexo" id="sexo">
                            <option <?php if(isset($row) && $row['sexo']=='h') echo "selected=\"selected\"" ?> value="h">Hombre</option>
                            <option <?php if(isset($row) && $row['sexo']=='m') echo "selected=\"selected\"" ?> value="m">Mujer</option>
                        </select>
                        </label>

                        <label title="Imagen de perfil" for="sexo" >Image Perfil:
                          <script>
                $(document).ready(function() {
                  $(".explorer-file").filexplorer({
                    inputHideValue: "<?= isset($row) ?  $row['photo_id'] : "0" ?>" // establacer un valor por defecto al cammpo ocutlo
                  });
                });
              </script>
              <input readonly type="text" name="photo" class="explorer-file" value="<?php if(isset($row)): $photos = rb_get_photo_from_id($row['photo_id']); echo $photos['src']; endif ?>" id="photo" />
                        </label>
                        <label>Biografía:
                          <textarea name="bio" placeholder="Cuentanos algo sobre ti"><?php if(isset($row)) echo $row['bio'] ?></textarea>
                        </label>
                      </div>
                  </div>
                  <div class="cols-container">
                    <h3 class="subtitle">Redes sociales</h2>
                    <div class="cols-6-md col-padding">
                      <label>Twitter:
                          <input name="tw" type="text" value="<?php if(isset($row)) echo $row['tw'] ?>" />
                        </label>

                        <label>Facebook:
                          <input name="fb" type="text" value="<?php if(isset($row)) echo $row['fb'] ?>" />
                        </label>

                        <label>Google +:
                          <input name="gplus" type="text" value="<?php if(isset($row)) echo $row['gplus'] ?>" />
                        </label>

                        <label>LinkedIn:
                          <input name="in" type="text" value="<?php if(isset($row)) echo $row['in'] ?>" />
                        </label>

                        <label>Pinterest:
                          <input name="pin" type="text" value="<?php if(isset($row)) echo $row['pin'] ?>" />
                        </label>

                        <label>Instagram:
                          <input name="insta" type="text" value="<?php if(isset($row)) echo $row['insta'] ?>" />
                        </label>

                        <label>Youtube:
                          <input name="youtube" type="text" value="<?php if(isset($row)) echo $row['youtube'] ?>" />
                        </label>
                    </div>
                  </div>

                  <div>

              </div>

                  </div>
                </section>
    </div>

    <div id="sidebar">
              <section class="seccion">
                <div class="seccion-header">
                  <h3>Accceso al sistema</h3>
                </div>
                <div class="seccion-body">
                  <div>
            <?php if($userType == "admin"): ?>
              <label title="Tipo de Usuario" for="tipo" >Tipo de usuario:
                            <select name="tipo" id="tipo">
                              <option value="0">[Ninguno]</option>
                <?php
                $q = $objDataBase->Ejecutar("SELECT * FROM usuarios_niveles");
                while($r = $q->fetch_assoc()):
                ?>
                <option <?= isset($row) && $row['tipo']==$r['id'] ? "selected=\"selected\"" : "" ?> value="<?= $r['id'] ?>"><?= $r['nombre'] ?></option>
                <?php
                endwhile;
                ?>
                </select>
              </label>
                        <?php else: ?>
              <input type="hidden" name="tipo" value="<?= $row['tipo'] ?>" />
            <?php endif; ?>
          </div>
                    <div class="subform">
                      <label title="Nombre usuario para identificarte con el sistema" for="nickname">Nombre de usuario:
                          <input name="nickname" type="text" id="nickname" value="<?php if(isset($row)) echo $row['nickname'] ?>" <?php if(isset($row)){ ?>readonly="readonly" <?php } ?>  />
                      </label>
                      <span class="info">
                        Si no va a cambiar las contraseñas, deje los campos vacios.
                      </span>
                      <label title="Contrasena" for="password" >Contrase&ntilde;a:
                          <input name="password" type="password" id="password" />
                      </label>
                      <label title="Repite Contrasena" for="password1" > Repetir Contrase&ntilde;a:
                          <input name="password1" type="password" id="password1" />
                      </label>
                  </div>
                  </div>
                </section>
                <section class="seccion">
                  <div class="seccion-header">
                    <h3>Grupos</h3>
                  </div>
                  <div class="seccion-body">
          <?php if($userType == "admin"): ?>
          <label>
                      <select name="grupo">
                        <option value="0">[Ninguno]</option>
            <?php
            $q = $objDataBase->Ejecutar("SELECT * FROM usuarios_grupos");
            while($r = $q->fetch_assoc() ):
            ?>
              <option <?= isset($row) && $row['grupo_id']==$r['id'] ? "selected=\"selected\"" : "" ?> value="<?= $r['id'] ?>"><?= $r['nombre'] ?></option>
            <?php
            endwhile;
            ?>
            </select>
          </label>
                    <?php else: ?>
          <input type="hidden" name="tipo" value="<?= $row['tipo'] ?>" />
          <?php endif; ?>
        </div>
                </section>
            </div>
  </div>
  <input name="section" value="usu" type="hidden" />
  <input name="mode" value="<?php echo $mode ?>" type="hidden" />
  <input name="id" value="<?php if(isset($row)) echo $row['id'] ?>" type="hidden" />
</form>
