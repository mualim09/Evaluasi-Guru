<?php
require_once('../class.function.php');
$account = new DTFunction(); 

if (isset($_POST['action'])) {
	
	$output = array();
	$stmt = $account->runQuery("SELECT 
`prd`.`prd_ID`,
`prd`.`prd_Img`,
`prd`.`prd_SchID`,
`prd`.`prd_FName`,
`prd`.`prd_MName`,
`prd`.`prd_LName`,
`prd`.`prd_Bday`,
`rs`.`sex_ID`,
`rm`.`marital_ID`,
`sf`.`suffix_ID`,
`prd`.`prd_Address`,
`prd`.`prd_Email`
FROM `record_principal_details` `prd`
LEFT JOIN `ref_marital` `rm` ON `rm`.`marital_ID` = `prd`.`marital_ID`
LEFT JOIN `ref_sex` `rs` ON `rs`.`sex_ID` = `prd`.`sex_ID`
LEFT JOIN `ref_suffixname` `sf` ON `sf`.`suffix_ID` = `prd`.`suffix_ID`
WHERE prd.prd_ID =  '".$_POST["principal_ID"]."' 
			LIMIT 1");
	$stmt->execute();
	$result = $stmt->fetchAll();
	foreach($result as $row)
	{

		if (!empty($row['prd_Img'])) {
		 $s_img = 'data:image/jpeg;base64,'.base64_encode($row['prd_Img']);
		}
		else{
		  $s_img = "../assets/img/users/default.jpg";
		}
		
		$output["principal_ID"] = $row["prd_ID"];
		$output["principal_img"] = $s_img;
		$output["principal_schID"] = $row["prd_SchID"];
		$output["principal_fname"] = $row["prd_FName"];
		$output["principal_mname"] = $row["prd_MName"];
		$output["principal_lname"] = $row["prd_LName"];
		$output["principal_bday"] = $row["prd_Bday"];
		$output["principal_suffix"] = $row["suffix_ID"];
		$output["principal_sex"] = $row["sex_ID"];
		$output["principal_marital"] = $row["marital_ID"];
		$output["principal_email"] = $row["prd_Email"];
		$output["principal_address"] = $row["prd_Address"];
		
	
	}
	
	echo json_encode($output);
	
}









 

?>