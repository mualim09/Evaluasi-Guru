<?php
require_once('../class.function.php');
$account = new DTFunction(); 

if (isset($_POST['action'])) {
	
	$output = array();
	$stmt = $account->runQuery("SELECT * FROM `ref_subject` WHERE subject_ID  = '".$_POST["subject_ID"]."' 
			LIMIT 1");
	$stmt->execute();
	$result = $stmt->fetchAll();
	foreach($result as $row)
	{

	
		
		$output["subject_ID"] = $row["subject_ID"];
		$output["subject_Title"] = $row["subject_Title"];
		$output["Abbreviation"] = $row["Abbreviation"];
		
	
	}
	
	echo json_encode($output);
	
}









 

?>