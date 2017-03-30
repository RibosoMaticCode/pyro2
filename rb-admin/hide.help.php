<?php
//include 'islogged.php';
$name = $_GET['nameHelpBox'];

if(isset($_COOKIE['help_close'])):
	$arrayHelpValues = unserialize($_COOKIE['help_close']);
	if(!in_array($name, $arrayHelpValues)):
		array_push($arrayHelpValues, $name);
		setcookie ("help_close", serialize($arrayHelpValues), time() + 3600 * 360); // 1 año
	endif;
	echo "Cookie existente";
else:
	$arrayHelpValues = array();
	array_push($arrayHelpValues, $name);
	setcookie ("help_close", serialize($arrayHelpValues), time() + 3600 * 360); // 1 año
	echo "Cookie nueva";
endif;
?>
