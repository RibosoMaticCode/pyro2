<?php
//require_once(ABSPATH."rb-script/class/rb-usuarios.class.php");
if(isset($_GET['m']) && $_GET['m']=="ok") msgOk("Cambios guardados");

$key_web = rb_get_values_options('key_web'); // podria ser key de la sesion de usuario

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
  $('#user-form').submit(function(event) {
    event.preventDefault();
    // Validando AJAX antes de enviar datos
    validateInputText( $('#nom'), "Nombres obligatorio" );
    validateInputText( $('#mail'), "Correo electrónico obligatorio" );
    validateInputText( $('#nickname'), "Nombre de usuario obligatorio" );
    if( $('#user-form input[name="mode"]').val() =="update" ){
      // validacion
    }else{
      validateInputText( $('#password'), "Escriba una contraseña" );
      validateInputText( $('#password1'), "Repita la contraseña" );
    }
    // Validaciones en cliente
    if( $('#password').val() != $('#password1').val()){
      notify("Las contraseñas no coinciden");
      pointInputText( $('#password'), "Las contraseñas no coinciden" );
      pointInputText( $('#password1'), "Las contraseñas no coinciden" );
      return false;
    }
    $.ajax({
      async: false,
      method: "post",
      url: "<?= G_SERVER ?>/rb-admin/core/users/user-save.php",
      data: $( this ).serialize()
    })
    .done(function( data ) {
      switch (data.resultado) {
        case 0: // Correcto
          notify(data.contenido);
          setTimeout(function(){
            if(data.profile){
              window.location.href = '<?= G_SERVER ?>/rb-admin/?pag=usu&opc=edt&id='+data.insert_id+'&profile&m=ok';
            }else{
              window.location.href = '<?= G_SERVER ?>/rb-admin/?pag=usu&opc=edt&id='+data.insert_id+'&m=ok';
            }
	        }, 1500);
          break;
        // Validaciones en servidor
        case 1: // Campos vacios
          notify(data.contenido);
          break;
        case 2: // Nick taked
          notify(data.contenido);
          pointInputText( $('#nickname'), data.contenido );
          break;
        case 3: // Mail taked
          notify(data.contenido);
          pointInputText( $('#mail'), data.contenido );
          break;
        case 4: // Contraseñas no inciden
          notify(data.contenido);
          pointInputText( $('#password'), data.contenido );
          pointInputText( $('#password1'), data.contenido );
          break;
        case 5: // Contraseñas inseguras
          notify(data.contenido);
          pointInputText( $('#password'), data.contenido );
          pointInputText( $('#password1'), data.contenido );
          break;
      }
      /*if(data.resultado){
        //$.fancybox.close();
        notify(data.contenido);
      }else{
        notify(data.contenido);
      }*/
    });
  });
});
</script>
<div class="inside_contenedor_frm">
<form class="form" id="user-form" name="user-form" method="post" action="core/users/user-save.php">
  <?php
  if(isset($_GET['profile'])):
  ?>
  <input type="hidden" name="profile" />
  <?php
  endif;
  ?>
  <div id="toolbar">
    <div class="inside_toolbar">
      <span class="post-submit">
        <input class="submit" name="guardar" type="submit" value="Guardar" />
        <?php
        if(!isset($_GET['profile'])):
        ?>
        <a href="<?= G_SERVER ?>/rb-admin/?pag=usu"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Volver a listado" /></a>
        <a href="<?= G_SERVER ?>/rb-admin/?pag=usu&opc=nvo">Nuevo usuario</a>
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
              <label title="Nombres" for="nom">Nombres *:
                <input name="nom" type="text" id="nom" value="<?php if(isset($row)) echo $row['nombres'] ?>" />
              </label>
              <label title="Apellidos" for="ape">Apellidos:
                <input name="ape" type="text" id="ape" value="<?php if(isset($row)) echo $row['apellidos'] ?>" />
              </label>
              <label title="Correo electronico" for="mail">Correo electrónico *:
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
            <?php  if($mode == "new"): ?>
            <label title="Tipo de Usuario" for="tipo" >Tipo de usuario:
              <select name="tipo" id="tipo">
                <?php
                $q = $objDataBase->Ejecutar("SELECT * FROM usuarios_niveles ORDER BY nombre");
                while($r = $q->fetch_assoc()):
                ?>
                <option <?php if( rb_get_values_options('nivel_user_register') == $r['id'] ) echo " selected " ?> value="<?= $r['id'] ?>"><?= $r['nombre'] ?></option>
                <?php
                endwhile;
                ?>
              </select>
            </label>
            <?php endif; ?>
            <?php  if($mode == "update"): ?>
            <label title="Tipo de Usuario" for="tipo" >Tipo de usuario:
              <select name="tipo" id="tipo">
                <?php
                $q = $objDataBase->Ejecutar("SELECT * FROM usuarios_niveles ORDER BY nombre");
                while($r = $q->fetch_assoc()):
                ?>
                <option <?= isset($row) && $row['tipo']==$r['id'] ? "selected=\"selected\"" : "" ?> value="<?= $r['id'] ?>"><?= $r['nombre'] ?></option>
                <?php
                endwhile;
                ?>
              </select>
            </label>
            <?php endif; ?>
          <?php else: ?>
            <input type="hidden" name="tipo" value="<?= $row['tipo'] ?>" />
          <?php endif; ?>
          </div>
          <div class="subform">
            <?php if($mode == "new"): ?>
                <a class="nick_auto" href="#">Autogenerar</a>
                <script>
                  $(document).ready(function() {
                    $('.nick_auto').click(function(event) {
                      var email = $('#mail').val();
                      $.ajax({
                        method: "get",
                        url: "<?= G_SERVER ?>/rb-admin/core/users/autogenerate.php",
                        data: "email="+email
                      }).done(function( data ) {
                        if(data.result){
                          notify(data.message);
                          $('#nickname').val(data.nickname);
                          $('#pass_auto').append(data.password);
                          $('#password').val(data.password);
                          $('#password1').val(data.password);
                        }else{
                          notify(data.message);
                        }
                        //$('#img_loading, .bg-opacity').hide();
                      });
                    });
                  });
                </script>
            <?php endif; ?>
            <label title="Nombre usuario para identificarte con el sistema" for="nickname">Nombre de usuario:
              <input name="nickname" type="text" id="nickname" value="<?php if(isset($row)) echo $row['nickname'] ?>" <?php if(isset($row)){ ?>readonly="readonly" <?php } ?>  />
            </label>
            <?php if($mode == "update"): ?>
            <span class="info">
              Si no va a cambiar las contraseñas, deje los campos vacios.
            </span>
            <?php endif; ?>
            <span id="pass_auto" style="font-weight:bold"></span>
            <label title="Contrasena" for="password" >Contrase&ntilde;a:
              <input name="password" type="password" id="password" autocomplete="new-password" />
            </label>
            <label title="Repite Contrasena" for="password1" > Repetir Contrase&ntilde;a:
              <input name="password1" type="password" id="password1" autocomplete="new-password" />
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
      <?php
      if(isset($row)){
        if(G_USERID == $row['id']){
          ?>
          <a class="fancyboxForm fancybox.ajax" style="color:red;font-weight:bold" href="<?= G_SERVER ?>/rb-admin/core/users/user.del.auth.self.php?user_key=<?= $row['user_key'] ?>&user_id=<?= rb_encrypt_decrypt("encrypt", $row['id'], $row['user_key'], $key_web) ?>">Eliminar mi cuenta</a>
          <?php
        }
      }
      ?>
    </div>
  </div>
  <input name="section" value="usu" type="hidden" />
  <input name="mode" value="<?php echo $mode ?>" type="hidden" />
  <input name="id" value="<?php if(isset($row)) echo $row['id'] ?>" type="hidden" />
</form>
</div>
