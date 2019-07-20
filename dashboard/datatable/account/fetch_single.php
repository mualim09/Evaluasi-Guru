<?php
require_once('../class.function.php');
$account = new DTFunction(); 

if (isset($_POST['action'])) {
	
	$output = array();
	$stmt = $account->runQuery("SELECT * FROM `user_account` WHERE user_ID  = '".$_POST["account_ID"]."' 
			LIMIT 1");
	$stmt->execute();
	$result = $stmt->fetchAll();
	foreach($result as $row)
	{

		if (!empty($row['user_img'])) {
				
			 $output["ac_Img"] = 'data:image/jpeg;base64,'.base64_encode($row['user_img']);
			}
			else{
			  $output["ac_Img"] = "../assets/img/uploads/blank.png";
			}
		
		$output["lvl_ID"] = $row["lvl_ID"];
		$output["user_Name"] = $row["user_Name"];
		$output["user_Email"] = $row["user_Email"];
		$output["user_Address"] = $row["user_Address"];
	
	}
	
	echo json_encode($output);
	
}









 

?>