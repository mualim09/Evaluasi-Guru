<?php
require_once('../class.function.php');
$account = new DTFunction();  		 // Create new connection by passing in your configuration array

session_start();
$query = '';
$output = array();
$query .= " 
SELECT * ,
(case  
 when (ua.lvl_ID = 1) then (SELECT CONCAT(vsd.vsd_FName,' ',vsd.vsd_MName,'. ',vsd.vsd_LName) FROM record_visitor_details vsd WHERE vsd.user_ID = ua.user_ID)
when (ua.lvl_ID = 2)  then (SELECT CONCAT(tcd.tcd_FName,' ',tcd.tcd_MName,'. ',tcd.tcd_LName) FROM record_teacher_details tcd WHERE tcd.user_ID = ua.user_ID)
when (ua.lvl_ID = 3)  then (SELECT CONCAT(prd.prd_FName,' ',prd.prd_MName,'. ',prd.prd_LName) FROM record_principal_details prd WHERE prd.user_ID = ua.user_ID)
 when (ua.lvl_ID = 4)  then (SELECT CONCAT(rad.rad_FName,' ',rad.rad_MName,'. ',rad.rad_LName) FROM record_admin_details rad WHERE rad.user_ID = ua.user_ID)
end)  Observer_Name,
ua.lvl_ID

";
$query .= "FROM `forms_rating` fr

LEFT JOIN ref_period  rp ON rp.period_ID = fr.period_ID
LEFT JOIN user_account ua ON ua.user_ID = fr.user_ID
LEFT JOIN academic_staff acs ON acs.acs_ID = fr.acs_ID
LEFT JOIN record_teacher_details tcd ON tcd.tcd_ID  = acs.tcd_ID
";
if (isset($_REQUEST["staff_ID"])){
	$query .= ' WHERE fr.acs_ID =  '.$_REQUEST["staff_ID"]." AND ua.lvl_ID = 3 AND ";
}

else{
	$query .= ' WHERE tcd.user_ID =  '.$_SESSION["user_ID"]." AND ua.lvl_ID = 3 AND ";
}



if(isset($_POST["search"]["value"]))
{
 $query .= '(fr.fr_ID LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR fr.fr_Date LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR rp.period_Name LIKE "%'.$_POST["search"]["value"].'%" )';
}


if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY fr.fr_ID DESC ';
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
	
		
		$sub_array[] = $row["fr_ID"];
		$sub_array[] = $row["Observer_Name"];
		$sub_array[] = $row["fr_Date"];
		$sub_array[] = $row["period_Name"];
		$sub_array[] = '
		<div class="btn-group">
		  <a class="btn btn-primary btn-sm view" href="print/print?report=rating-sheet&fr_ID='.$row["fr_ID"].'" target="_BLANK"  id="'.$row["fr_ID"].'"><i class="icon-printer" style="font-size: 20px;"></i></a>
		</div>
		';
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



        
