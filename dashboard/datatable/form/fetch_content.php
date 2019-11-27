<?php
require_once('../class.function.php');
$account = new DTFunction();  		 // Create new connection by passing in your configuration array


$query = '';
$output = array();
$query .= "SELECT *
";
$query .= "  FROM `forms_content` `frc`";


if (isset($_REQUEST['form_ID'])) {
	$form_ID = $_REQUEST['form_ID'];
 	$query .= ' WHERE `frc`.`form_ID` = '.$form_ID.' AND ';
}
else{
	 $query .= ' WHERE ';
}
if(isset($_POST["search"]["value"]))
{
 $query .= '(fc_ID LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR fc_ID LIKE "%'.$_POST["search"]["value"].'%" )';
}



if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY fc_ID ASC ';
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
$i = 1;
foreach($result as $row)
{
	



	$sub_array = array();
	
		$sub_array[] = $i.". ";
		$sub_array[] = htmlspecialchars($row["fc_Desc"]);
		$sub_array[] = '
		<div class="btn-group">
	
		  <button class="btn btn-primary btn-sm frc_edit"  id="'.$row["fc_ID"].'" data-id="'.$form_ID.'" ><i class="icon-database-edit2" style="font-size: 20px;"></i></button>
		  <button class="btn btn-danger btn-sm frc_delete"  id="'.$row["fc_ID"].'" data-id="'.$form_ID.'" ><i class="icon-cross" style="font-size: 20px;"></i></button>
		 
		</div>
		';
	$data[] = $sub_array;
	$i++;
}

$q = "SELECT * FROM `forms_content`";
$filtered_rec = $account->get_total_all_records($q);

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	$filtered_rec,
	"data"				=>	$data
);
echo json_encode($output);



?>



        
