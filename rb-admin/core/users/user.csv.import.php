<?php
// Agradecimiento: http://thisinterestsme.com/convert-csv-file-json-using-php/
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funcs.php';
require_once ABSPATH.'rb-script/class/rb-users.class.php';

$filename = "lista.csv";
if ( file_exists($filename) && ($fh = fopen($filename, "r"))!==false ) {

    //Setup a PHP array to hold our CSV rows.
    $csvData = array();

    //Loop through the rows in our CSV file and add them to
    //the PHP array that we created above.
    while (($row = fgetcsv($fh, 0, ";")) !== FALSE) {
        $csvData[] = $row;
    }
    fclose($fh);
}else{
    die("No existe el archivo");
}

$message="";
?>
<table class="tables">
<tr>
<th>Nombres</th>
<th>Apellidos</th>
<th>Correo</th>
<th>Nombre de usuario</th>
<th>Contraseña</th>
<th>Observaciones</th>
<tr>
<?php
foreach ($csvData as $key) {
    // Estableciendo datos principales
    $nm = $key[0];
    $ap = $key[1];
    $mail = $key[2];
    $nickname = "";
    $pass = "";
    $message = "";

    // Verificando su correo existe en DB
    if($objUsuario->existe('correo',$key[2])!=0):
        $message = 'Correo electronico ya tomado. Pruebe con otro.';
    else:
        // Estableciendo otros datos
        $nickname = rb_generate_nickname($mail);
        $pass = random(8,"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890");
        $admin_active_user = 0;
        if(rb_get_values_options('user_active_admin')==0){
            $admin_active_user = 1;
        }
        $tipo = rb_get_values_options('nivel_user_register'); // nivel usuario por defecto segun sistema

        // Registramos en sistema
        $valores = [
            'nickname' => $nickname,
            'password' => md5($pass),
            'nombres' => $nm,
            'apellidos' => $ap,
            'correo' => $mail,
            'tipo' => $tipo,
            'fecharegistro' => date('Y-m-d G:i:s'),
            'ultimoacceso' => date('Y-m-d G:i:s'),
            'activo' => $admin_active_user,
            'user_key' => md5(microtime().rand())
        ];

        $r = $objDataBase->Insert(G_PREFIX."users", $valores);
        if($r['result']){
            $message.="Importacion exitosa";
        }
    endif;

    // Reportamos
    echo "<tr>";
    echo "<td>".$key[0]."</td>";
    echo "<td>".$key[1]."</td>";
    echo "<td>".$key[2]."</td>";
    echo "<td>".$nickname."</td>";
    echo "<td>".$pass."</td>";
    echo "<td>$message</td>";
    echo "</tr>";
}
?>
</table>
