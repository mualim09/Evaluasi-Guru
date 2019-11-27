<?php
require_once('../class.function.php');
$acadstaff = new DTFunction(); 

if (isset($_POST['action'])) {
	
	$output = array();
	$stmt = $acadstaff->runQuery("SELECT 
	`acs`.`acs_ID`,
	`acs`.`yl_ID`,
`rtd`.`tcd_Img`,
`rtd`.`tcd_FName`,
`rtd`.`tcd_MName`,
`rtd`.`tcd_LName`,
`rsn`.`suffix`,
`rpos`.`pos_Name`,
`rsub`.`subject_ID`,
`rpos`.`pos_ID`,
`rsem`.`sem_ID`
FROM `academic_staff` `acs` 
LEFT JOIN `record_teacher_details` `rtd` ON `rtd`.`tcd_ID` = `acs`.`tcd_ID`
LEFT JOIN `ref_suffixname` `rsn` ON `rsn`.`suffix_ID` = `rtd`.`suffix_ID`
LEFT JOIN `ref_subject` `rsub` ON `rsub`.`subject_ID` = `acs`.`subject_ID`
LEFT JOIN `ref_year_level` `ryl` ON `ryl`.`yl_ID` = `acs`.`yl_ID`
LEFT JOIN `ref_position` `rpos` ON `rpos`.`pos_ID` = `acs`.`pos_ID`
LEFT JOIN `ref_semester` `rsem` ON `rsem`.`sem_ID` = `acs`.`sem_ID`
 WHERE acs_ID  = '".$_POST["staff_ID"]."' 
			LIMIT 1");
	$stmt->execute();
	$result = $stmt->fetchAll();
	foreach($result as $row)
	{
		
		if($row["suffix"] =="N/A")
		{
			$suffix = "";
		}
		else
		{
			$suffix = $row["suffix"];
		}
	
		
		$output["acs_ID"] = $row["acs_ID"];
		$output["staff_name"] =  $row["tcd_FName"].' '.$row["tcd_MName"].'. '.$row["tcd_LName"].' '.$suffix;
		$output["pos_ID"] = $row["pos_ID"];
		$output["subject_ID"] = $row["subject_ID"];
		$output["sem_ID"] = $row["sem_ID"];
		$output["yl_ID"] = $row["yl_ID"];
	
	}
	
	echo json_encode($output);
	
}









 

?>