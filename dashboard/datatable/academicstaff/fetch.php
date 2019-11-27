<?php
require_once('../class.function.php');
$acadstaff = new DTFunction();  		 


$query = '';
$output = array();
$query .= "SELECT *,
CONCAT(YEAR(`rsem`.`sem_start`),' - ',YEAR(`rsem`.`sem_end`)) `sem_year`,
LEFT(rtd.tcd_MName, 1) tcd_MNamex
";
$query .= " FROM `academic_staff` `acs` 
LEFT JOIN `record_teacher_details` `rtd` ON `rtd`.`tcd_ID` = `acs`.`tcd_ID`
LEFT JOIN `ref_suffixname` `rsn` ON `rsn`.`suffix_ID` = `rtd`.`suffix_ID`
LEFT JOIN `ref_subject` `rsub` ON `rsub`.`subject_ID` = `acs`.`subject_ID`
LEFT JOIN `ref_year_level` `ryl` ON `ryl`.`yl_ID` = `acs`.`yl_ID`
LEFT JOIN `ref_position` `rpos` ON `rpos`.`pos_ID` = `acs`.`pos_ID`
LEFT JOIN `ref_semester` `rsem` ON `rsem`.`sem_ID` = `acs`.`sem_ID`
";
if(isset($_POST["search"]["value"]))
{
 $query .= 'WHERE acs_ID LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR pos_Name LIKE "%'.$_POST["search"]["value"].'%" ';
}


if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY acs_ID DESC ';
}
if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $acadstaff->runQuery($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
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
	$sub_array = array();
	
		
		$sub_array[] = $row["acs_ID"];
		$sub_array[] =  ucwords(strtolower($row["tcd_LName"].', '.$row["tcd_FName"].' '.$row["tcd_MNamex"].'. '.$suffix));
		$sub_array[] =  $row["subject_Title"];
		$sub_array[] =  $row["pos_Name"];
		$sub_array[] =  ucwords(strtolower($row["yl_Name"]));
		$sub_array[] =  ucwords(strtolower($row["sem_year"]));
		$sub_array[] = '


		<div class="btn-group">
		  <button class="btn btn-info btn-sm view"  id="'.$row["acs_ID"].'"><i class="icon-eye" style="font-size: 20px;"></i></button>
		  <button class="btn btn-primary btn-sm edit"  id="'.$row["acs_ID"].'"><i class="icon-database-edit2" style="font-size: 20px;"></i></button>
		  <button class="btn btn-danger btn-sm delete"  id="'.$row["acs_ID"].'"><i class="icon-cross2" style="font-size: 20px;"></i></button>
		 
		</div>
		';
	$data[] = $sub_array;
}

$q = "SELECT * FROM `academic_staff`";
$filtered_rec = $acadstaff->get_total_all_records($q);

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	$filtered_rec,
	"data"				=>	$data
);
echo json_encode($output);



?>



        
