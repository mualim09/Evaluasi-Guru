<?php
require_once('../class.function.php');
$account = new DTFunction(); 

if (isset($_POST['action'])) {
	
	$output = array();

	
	if($_POST['action'] == "form_view"){
		$stmt = $account->runQuery("SELECT * FROM `forms`
		WHERE form_ID =  '".$_POST["form_ID"]."' 
				LIMIT 1");
		$stmt->execute();
		$result = $stmt->fetchAll();
		foreach($result as $row)
		{
			
			$output["form_ID"] 	 = $row["form_ID"];
			$output["form_Name"] = $row["form_Name"];
			// $output["form_Desc"] = $row["form_Desc"];
			
		
		}
	}
	if($_POST['action'] == "form_update"){
		$stmt = $account->runQuery("SELECT * FROM `forms`
		WHERE form_ID =  '".$_POST["form_ID"]."' 
				LIMIT 1");
		$stmt->execute();
		$result = $stmt->fetchAll();
		foreach($result as $row)
		{
			
			$output["form_ID"] 	 = $row["form_ID"];
			$output["form_Name"] = $row["form_Name"];
			// $output["form_Desc"] = $row["form_Desc"];
			
		
		}

	}
	if($_POST['action'] == "formcontent_view"){
		$stmt = $account->runQuery("SELECT * FROM `forms_content`
		WHERE fc_ID =  '".$_POST["fc_ID"]."' 
				LIMIT 1");
		$stmt->execute();
		$result = $stmt->fetchAll();
		foreach($result as $row)
		{
			
			$output["fc_ID"] 	 = $row["fc_ID"];
			// $output["rform_Name"] = $row["fc_Desc"];
			
		
		}

	}

	
	
	echo json_encode($output);
	
}









 

?>