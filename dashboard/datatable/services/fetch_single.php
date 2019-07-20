<?php
require_once('../class.function.php');
$account = new DTFunction(); 

if (isset($_POST['action'])) {
	
	$output = array();
	$stmt = $account->runQuery("SELECT * FROM `service` WHERE service_ID  = '".$_POST["service_ID"]."' 
			LIMIT 1");
	$stmt->execute();
	$result = $stmt->fetchAll();
	foreach($result as $row)
	{
		
		$output["service_Title"] = $row["service_Title"];
		$output["service_Description"] = $row["service_Description"];
		$output["service_Repository"] = $row["service_Repository"];
		$output["service_Amount"] = $row["service_Amount"];
		$output["service_Date"] = $row["service_Date"];
	
	}
	
	echo json_encode($output);
	
}









 

?>