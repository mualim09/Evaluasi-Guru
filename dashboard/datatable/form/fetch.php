<?php
require_once('../class.function.php');
$account = new DTFunction();  		 // Create new connection by passing in your configuration array


$query = '';
$output = array();
$query .= "SELECT *,CONCAT(YEAR(`rsem`.`sem_start`),' - ',YEAR(`rsem`.`sem_end`)) acadyear
";
$query .= " FROM `forms` fr
LEFT JOIN  `ref_semester` `rsem` ON `rsem`.`sem_ID` = `fr`.`sem_ID`
";
if(isset($_POST["search"]["value"]))
{
 $query .= 'WHERE form_ID LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR form_Name LIKE "%'.$_POST["search"]["value"].'%" ';
}


if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY form_ID DESC ';
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
	



	$sub_array = array();
	
		$sub_array[] = $row["form_ID"];
		$sub_array[] = $row["form_Name"];
		$sub_array[] = $row["acadyear"];
		$sub_array[] = '
		<div class="btn-group">
		<button class="btn btn-info btn-sm view_form"  id="'.$row["form_ID"].'">View Evaluation</button>
	
		  <button class="btn btn-primary btn-sm edit"  id="'.$row["form_ID"].'"><i class="icon-database-edit2" style="font-size: 20px;"></i></button>
		 
		</div>
		';
		// <div class="dropdown-divider"></div>
		 // <a class="dropdown-item delete" id="'.$row["form_ID"].'">Delete</a>
	$data[] = $sub_array;
}

$q = "SELECT * FROM `forms`";
$filtered_rec = $account->get_total_all_records($q);

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	$filtered_rec,
	"data"				=>	$data
);
echo json_encode($output);



?>



        
