<?php
require_once('../class.function.php');
$account = new DTFunction(); 

if (isset($_POST['action'])) {
	
	$output = array();
	$stmt = $account->runQuery("SELECT 
`tcd`.`tcd_ID`,
`tcd`.`tcd_Img`,
`tcd`.`tcd_SchID`,
`tcd`.`tcd_FName`,
`tcd`.`tcd_MName`,
`tcd`.`tcd_LName`,
`tcd`.`tcd_Bday`,
`rs`.`sex_ID`,
`rm`.`marital_ID`,
`sf`.`suffix_ID`,
`tcd`.`tcd_Address`,
`tcd`.`tcd_Email`
FROM `record_teacher_details` `tcd`
LEFT JOIN `ref_marital` `rm` ON `rm`.`marital_ID` = `tcd`.`marital_ID`
LEFT JOIN `ref_sex` `rs` ON `rs`.`sex_ID` = `tcd`.`sex_ID`
LEFT JOIN `ref_suffixname` `sf` ON `sf`.`suffix_ID` = `tcd`.`suffix_ID`
WHERE tcd.tcd_ID =  '".$_POST["teacher_ID"]."' 
			LIMIT 1");
	$stmt->execute();
	$result = $stmt->fetchAll();
	foreach($result as $row)
	{

		if (!empty($row['tcd_Img'])) {
		 $s_img = 'data:image/jpeg;base64,'.base64_encode($row['tcd_Img']);
		}
		else{
		  $s_img = "../assets/img/users/default.jpg";
		}
		
		$output["tcd_ID"] = $row["tcd_ID"];
		$output["teacher_img"] = $s_img;
		$output["teacher_schID"] = $row["tcd_SchID"];
		$output["teacher_fname"] = $row["tcd_FName"];
		$output["teacher_mname"] = $row["tcd_MName"];
		$output["teacher_lname"] = $row["tcd_LName"];
		$output["teacher_bday"] = $row["tcd_Bday"];
		$output["teacher_suffix"] = $row["suffix_ID"];
		$output["teacher_sex"] = $row["sex_ID"];
		$output["teacher_marital"] = $row["marital_ID"];
		$output["teacher_email"] = $row["tcd_Email"];
		$output["teacher_address"] = $row["tcd_Address"];
		
	
	}
	
	echo json_encode($output);
	
}









 

?>