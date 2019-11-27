<?php
require_once('../class.function.php');
$account = new DTFunction();  		 // Create new connection by passing in your configuration array


$query = '';
$output = array();
$query .= " 
SELECT 
`tcd`.`tcd_ID`,
`tcd`.`tcd_Img`,
`tcd`.`tcd_SchID`,
`tcd`.`tcd_FName`,
LEFT(`tcd`.`tcd_MName`,1) tcd_MName,
`tcd`.`tcd_LName`,
`tcd`.`user_ID`,
`rs`.`sex_Name`,
`rm`.`marital_Name`,
`sf`.`suffix`
";
$query .= "FROM `record_teacher_details` `tcd`
LEFT JOIN `ref_marital` `rm` ON `rm`.`marital_ID` = `tcd`.`marital_ID`
LEFT JOIN `ref_sex` `rs` ON `rs`.`sex_ID` = `tcd`.`sex_ID`
LEFT JOIN `ref_suffixname` `sf` ON `sf`.`suffix_ID` = `tcd`.`suffix_ID`";
if(isset($_POST["search"]["value"]))
{
 $query .= 'WHERE tcd_ID LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR tcd_SchID LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR tcd_FName LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR tcd_MName LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR tcd_LName LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR suffix LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR sex_Name LIKE "%'.$_POST["search"]["value"].'%" ';
}


if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY tcd_ID DESC ';
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

	if($row["tcd_MName"] ==" " || $row["tcd_MName"] == NULL || empty($row["tcd_MName"]) )
	{
		$mname = " ";
	}
	else
	{
		$mname = $row["tcd_MName"].'. ';
	}
	if(empty($row["user_ID"]))
	{
		$reg = "<span class='badge badge-danger'>Unregistered</span>";
		$acreg = "UN";
		$btnrg = '<button type="button" class="btn btn-warning btn-sm gen_account" data-toggle="tooltip" data-html="true" title="Generate Account" id="'.$row["tcd_ID"].'">
		  <i class="icon-key" style="font-size: 20px;"></i>
		</button>
		';
		// <button class="btn btn-success btn-sm gen_account"  id="'.$row["rsd_ID"].'">Generate Account <i class="icon-gear" style="font-size: 20px;"></i></button>
	}
	else
	{
		$reg = "<span class='badge badge-success'>Registered</span>";
		$acreg = "RG";
		$btnrg = '';
	}

	$cc_ID = strlen($row["tcd_SchID"]);
	$cc_ID = 7 - $cc_ID;
	$add_zeroinID ="";
	for($ds=1;$ds<=$cc_ID ;$ds++){
		$add_zeroinID .= "0";
	}

	$sub_array = array();
	
		
		$sub_array[] = $row["tcd_ID"];
		$sub_array[] =  $add_zeroinID.$row["tcd_SchID"];
		$sub_array[] =  ucwords(strtolower($row["tcd_LName"].', '.$row["tcd_FName"].' '.$mname.' '.$suffix));
		$sub_array[] =  ucwords(strtolower($row["sex_Name"]));
		$sub_array[] =  ucwords(strtolower($row["marital_Name"]));
		$sub_array[] =  $reg;
		$sub_array[] = '
		<div class="btn-group">
		  <button class="btn btn-info btn-sm view"  id="'.$row["tcd_ID"].'"><i class="icon-eye" style="font-size: 20px;"></i></button>
		  <button class="btn btn-primary btn-sm edit"  id="'.$row["tcd_ID"].'"><i class="icon-database-edit2" style="font-size: 20px;"></i></button>
		  '.$btnrg.'
		</div>
		';
		// <div class="dropdown-divider"></div>
		 // <a class="dropdown-item delete" id="'.$row["tcd_ID"].'">Delete</a>
	$data[] = $sub_array;
}

$q = "SELECT * FROM `record_teacher_details`";
$filtered_rec = $account->get_total_all_records($q);

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	$filtered_rec,
	"data"				=>	$data
);
echo json_encode($output);



?>



        
