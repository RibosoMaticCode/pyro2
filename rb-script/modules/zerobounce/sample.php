<?php
require_once("zerobounce.php");

$zba = new ZeroBounceAPI('0ab179998e2c4c298c239cb75a16fd44');

//print the credit balance
print_r($zba->get_credits());

//instantiate a validation object following a call to /validate and print individual elements
$validation = $zba->validate('dokoloco@hotmail.com', 'IP');
echo "address:".$validation['address']."<br />";
echo "status:".$validation['status'];