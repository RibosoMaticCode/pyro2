<?php
/* Muestra nombre completo del cliente, segun su id */
function crm_customer_fullname($customer_id){
	global $objDataBase;
	$q = $objDataBase->Ejecutar("SELECT * FROM crm_customers WHERE id=$customer_id");
    $customer = $q->fetch_assoc();
    return $customer['nombres']." ".$customer['apellidos'];
}

/* Muestra cantidad de visitas, desde la fecha actual hasta N dias atras */
function count_last_days($customer_id, $days){
    global $objDataBase;
    $q = $objDataBase->Ejecutar("SELECT * FROM crm_visits WHERE customer_id=$customer_id AND DATEDIFF(CURDATE(), fecha_visita) <= $days");
    //$num_visits = $q->num_rows;
    return $q;
}
?>