<?php
require_once('../class.function.php');
$services = new DTFunction();  		 // Create new connection by passing in your configuration array


$query = '';
$output = array();
$query .= "SELECT *";
$query .= "FROM `service`";
if(isset($_POST["search"]["value"]))
{
 $query .= 'WHERE service_ID LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR service_Title LIKE "%'.$_POST["search"]["value"].'%" ';
}


if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY service_ID DESC ';
}
if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $services->runQuery($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach($result as $row)
{
	

	$sub_array = array();
	$sub_array[] = $row["service_ID"];
	$sub_array[] = $row["service_Title"];
	$sub_array[] = $row["service_Amount"];
	$sub_array[] = $row["service_Date"];

		$sub_array[] = '
<div class="btn-group">
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action
  </button>
  <div class="dropdown-menu">
    <a class="dropdown-item view"  id="'.$row["service_ID"].'">View</a>
    <a class="dropdown-item edit"  id="'.$row["service_ID"].'">Edit</a>
     <div class="dropdown-divider"></div>
    <a class="dropdown-item delete" id="'.$row["service_ID"].'">Delete</a>
  </div>
</div>';
	$data[] = $sub_array;
}

$q = "SELECT * FROM `service`";
$filtered_rec = $services->get_total_all_records($q);

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	$filtered_rec,
	"data"				=>	$data
);
echo json_encode($output);



?>



        
