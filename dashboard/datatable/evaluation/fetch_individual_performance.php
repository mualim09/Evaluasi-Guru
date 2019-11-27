<?php
require_once('../class.function.php');
$account = new DTFunction();  		 // Create new connection by passing in your configuration array

session_start();
$query = '';
$output = array();
$query .= "SELECT *,
CONCAT(YEAR(rsm.sem_start),' - ',YEAR(rsm.sem_end)) semyear ,
(SELECT UPPER(CONCAT(tcd_LName,', ',tcd_FName,' ',RIGHT(tcd_MName,1)))) fullname

";
$query .= "FROM `forms_indivual_performance` fip
LEFT JOIN academic_staff acs ON acs.acs_ID = fip.acs_ID
LEFT JOIN forms f ON f.form_ID = fip.form_ID
LEFT JOIN ref_semester rsm ON rsm.sem_ID = f.sem_ID
LEFT JOIN record_teacher_details tcd ON tcd.tcd_ID = acs.tcd_ID
";

$query .= ' WHERE ';



if(isset($_POST["search"]["value"]))
{
 $query .= '(fip.fip_ID LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR fip.status LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR fip.form_ID LIKE "%'.$_POST["search"]["value"].'%" )';
}


if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY fip.fip_ID DESC ';
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
		$status_ID = $row["status"];
		if($status_ID == NULL || $status_ID == 0){
			$sxs = '<button class="btn btn-warning btn-sm individual_approval" data-id="0" id="'.$row['fip_ID'].'">PENDING</button>';
		
		}
		else if($status_ID == 1)
		{
			$sxs = '<button type="button" class="btn btn-success btn-sm individual_approval" data-id="1"   id="'.$row["fip_ID"].'">APPROVE</button>';
			
		}
		else{
			$sxs = '<button class="btn btn-danger btn-sm individual_approval" data-id="2" id="'.$row['fip_ID'].'">DISAPPROVE</button>';
			
			
		}

        $fip_Date = date('M. d, Y', strtotime($row["fip_Date"]));
		$sub_array[] = '
		<div class="card">
		  <div class="card-body">
		    '.$row["fullname"].'
		    <br>
		    <b>Date Submitted:</b> '.$fip_Date.'
		    
		    <div class="btn btn-group float-right">
		   	'.$sxs.'
		   	<button class="btn btn-primary btn-sm review" data-toggle="modal" data-target="#individual_performance" id="'.$row['fip_ID'].'">REVIEW</button>
		   </div>
		  </div>
		</div>
		';
		// 
	$data[] = $sub_array;
}

$q = "SELECT * FROM `forms_indivual_performance`";
$filtered_rec = $account->get_total_all_records($q);

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	$filtered_rec,
	"data"				=>	$data
);
echo json_encode($output);



?>



        
