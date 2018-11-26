<?php
// Agradecimiento: https://stackoverflow.com/questions/24753821/php-fopen-error-handling
//Open our CSV file using the fopen function.
$filename = "lista.csv";
if ( file_exists($filename) && ($fh = fopen($filename, "r"))!==false ) {

    //Setup a PHP array to hold our CSV rows.
    $csvData = array();

    //Loop through the rows in our CSV file and add them to
    //the PHP array that we created above.
    while (($row = fgetcsv($fh, 0, ";")) !== FALSE) {
        $csvData[] = $row;
    }

    //Finally, encode our array into a JSON string format so that we can print it out.
    print_r($csvData);
    fclose($fh);
}else{
    echo "No existe el archivo";
}