<?php
require_once('../class.function.php');
$account = new DTFunction();  		 // Create new connection by passing in your configuration array
session_start();

$query = '';
$output = array();
$query .= " 
SELECT 
`vsd`.`vsd_ID`,
`vsd`.`vsd_Img`,
`vsd`.`vsd_SchID`,
`vsd`.`vsd_FName`,
LEFT(`vsd`.`vsd_MName`,1) vsd_MName,
`vsd`.`vsd_LName`,
`vsd`.`user_ID`,
`rs`.`sex_Name`,
`rm`.`marital_Name`,
`sf`.`suffix`
";
$query .= "FROM `record_visitor_details` `vsd`
LEFT JOIN `ref_marital` `rm` ON `rm`.`marital_ID` = `vsd`.`marital_ID`
LEFT JOIN `ref_sex` `rs` ON `rs`.`sex_ID` = `vsd`.`sex_ID`
LEFT JOIN `ref_suffixname` `sf` ON `sf`.`suffix_ID` = `vsd`.`suffix_ID`

";

$query .= ' WHERE `vsd`.`user_ID` !=  "'.$_SESSION["user_ID"].'" AND ';

if(isset($_POST["search"]["value"]))
{
 $query .= '( vsd_ID LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR vsd_SchID LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR vsd_FName LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR vsd_MName LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR vsd_LName LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR suffix LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR sex_Name LIKE "%'.$_POST["search"]["value"].'%" )';
}


if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY vsd_ID DESC ';
}
if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $account->runQuery($query);
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

	if($row["vsd_MName"] ==" " || $row["vsd_MName"] == NULL || empty($row["vsd_MName"]) )
	{
		$mname = " ";
	}
	else
	{
		$mname = $row["vsd_MName"].'. ';
	}

	$cc_ID = strlen($row["vsd_SchID"]);
	$cc_ID = 7 - $cc_ID;
	$add_zeroinID ="";
	for($ds=1;$ds<=$cc_ID ;$ds++){
		$add_zeroinID .= "0";
	}
	$sub_array = array();
	
		
		$sub_array[] = $row["vsd_ID"];
		$sub_array[] =  $add_zeroinID.$row["vsd_SchID"];
		$sub_array[] =  ucwords(strtolower($row["vsd_LName"].', '.$row["vsd_FName"].' '.$mname.' '.$suffix));
		$sub_array[] =  ucwords(strtolower($row["sex_Name"]));
		$sub_array[] =  ucwords(strtolower($row["marital_Name"]));
	$data[] = $sub_array;
}

$q = "SELECT * FROM `record_visitor_details`";
$filtered_rec = $account->get_total_all_records($q);

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	$filtered_rec,
	"data"				=>	$data
);
echo json_encode($output);



?>



        
