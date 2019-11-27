<?php
require_once('../class.function.php');
$account = new DTFunction(); 

if (isset($_POST['action'])) {
	
	$output = array();
	$stmt = $account->runQuery("SELECT 
`vsd`.`vsd_ID`,
`vsd`.`vsd_Img`,
`vsd`.`vsd_SchID`,
`vsd`.`vsd_FName`,
`vsd`.`vsd_MName`,
`vsd`.`vsd_LName`,
`vsd`.`vsd_Bday`,
`rs`.`sex_ID`,
`rm`.`marital_ID`,
`sf`.`suffix_ID`,
`vsd`.`vsd_Address`,
`vsd`.`vsd_Email`
FROM `record_visitor_details` `vsd`
LEFT JOIN `ref_marital` `rm` ON `rm`.`marital_ID` = `vsd`.`marital_ID`
LEFT JOIN `ref_sex` `rs` ON `rs`.`sex_ID` = `vsd`.`sex_ID`
LEFT JOIN `ref_suffixname` `sf` ON `sf`.`suffix_ID` = `vsd`.`suffix_ID`
WHERE vsd.vsd_ID =  '".$_POST["visitor_ID"]."' 
			LIMIT 1");
	$stmt->execute();
	$result = $stmt->fetchAll();
	foreach($result as $row)
	{

		if (!empty($row['vsd_Img'])) {
		 $s_img = 'data:image/jpeg;base64,'.base64_encode($row['vsd_Img']);
		}
		else{
		  $s_img = "../assets/img/users/default.jpg";
		}
		
		$output["vsd_ID"] = $row["vsd_ID"];
		$output["visitor_img"] = $s_img;
		$output["visitor_schID"] = $row["vsd_SchID"];
		$output["visitor_fname"] = $row["vsd_FName"];
		$output["visitor_mname"] = $row["vsd_MName"];
		$output["visitor_lname"] = $row["vsd_LName"];
		$output["visitor_bday"] = $row["vsd_Bday"];
		$output["visitor_suffix"] = $row["suffix_ID"];
		$output["visitor_sex"] = $row["sex_ID"];
		$output["visitor_marital"] = $row["marital_ID"];
		$output["visitor_email"] = $row["vsd_Email"];
		$output["visitor_address"] = $row["vsd_Address"];
		
	
	}
	
	echo json_encode($output);
	
}









 

?>