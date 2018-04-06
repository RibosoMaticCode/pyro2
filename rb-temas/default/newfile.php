<?php
$config = array(
    "database" => "test",
    "user"     => "testUser"
);

function writeConfig( $filename, $config ) {
    $fh = fopen($filename, "w");
    if (!is_resource($fh)) {
        return false;
    }
    foreach ($config as $key => $value) {
        fwrite($fh, sprintf("%s = %s\n", $key, $value));
    }
    fclose($fh);

    return true;
}

var_dump(writeConfig("mailer.php", $config));
?>
