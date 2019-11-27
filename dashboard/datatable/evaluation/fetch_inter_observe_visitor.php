<?php
require_once('../class.function.php');
$account = new DTFunction();  		 // Create new connection by passing in your configuration array
session_start();

$query = '';
$output = array();
$query .= "SELECT * ,
(case  
 when (ua.lvl_ID = 1) then (SELECT UPPER(CONCAT(vsd.vsd_LName,', ',vsd.vsd_FName,' ',RIGHT(vsd.vsd_MName,1),'. ')) FROM record_visitor_details vsd WHERE vsd.user_ID = ua.user_ID)
when (ua.lvl_ID = 2)  then (SELECT CONCAT(tcd.tcd_FName,' ',tcd.tcd_MName,'. ',tcd.tcd_LName) FROM record_teacher_details tcd WHERE tcd.user_ID = ua.user_ID)
when (ua.lvl_ID = 3)  then (SELECT CONCAT(prd.prd_FName,' ',prd.prd_MName,'. ',prd.prd_LName) FROM record_principal_details prd WHERE prd.user_ID = ua.user_ID)
 when (ua.lvl_ID = 4)  then (SELECT CONCAT(rad.rad_FName,' ',rad.rad_MName,'. ',rad.rad_LName) FROM record_admin_details rad WHERE rad.user_ID = ua.user_ID)
end)  Observer_Name

";
$query .= " FROM `forms_inter_rating`  fir
LEFT JOIN ref_period  rp ON rp.period_ID = fir.period_ID
LEFT JOIN user_account ua ON ua.user_ID = fir.user_ID

LEFT JOIN academic_staff acs ON acs.acs_ID = fir.acs_ID
LEFT JOIN record_teacher_details tcd ON tcd.tcd_ID  = acs.tcd_ID
";

// if (isset($_REQUEST['acs_ID'])) {
// 	$acs_ID = $_REQUEST['acs_ID'];
//  	$query .= ' WHERE acs_ID ='.$acs_ID.' AND ';
// }
if (isset($_REQUEST['staff_ID'])) {
	$staff_ID = $_REQUEST['staff_ID'];
 	$query .= ' WHERE fir.acs_ID ='.$staff_ID.' AND ';
}


else{
	$query .= ' WHERE tcd.user_ID =  '.$_SESSION["user_ID"]." AND ";
}
if(isset($_POST["search"]["value"]))
{
 $query .= '(ifr_ID LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR ifr_Date LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR period_Name LIKE "%'.$_POST["search"]["value"].'%" )';
}


if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY ifr_ID DESC ';
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
	
    $ifr_Date = date('M. d, Y', strtotime($row["ifr_Date"]));
    $observer_IDs = json_decode($row["observer_IDs"]);
	$sub_array = array();
	
	
		$sub_array[] = '<section class="card rounded-0 my-3 bg-white">
                    <section class="card-body py-3 px-3">
                        <p class="lead" style="margin-top: -5px; margin-bottom: -5px;"><b>Date conducted :</b> '.$ifr_Date.' <br>
                        	<b>Period:</b> '.$row["period_Name"].'<br>
                        	<b>Observers :</b> '.$row["Observer_Name"].', '.$account->get_visitorName($observer_IDs->ob1).', '.$account->get_visitorName($observer_IDs->ob2).'
                        </p>

                       <Br>
                        
                        <a class="btn btn-primary btn-sm float-right" href="print/print?report=inter-observer-sheet&ifr_ID='.$row["ifr_ID"].'" target="_BLANK"  id="'.$row["ifr_ID"].'"><i class="icon-printer" style="font-size: 20px;"></i></a>
                    </section>
                </section>';
                // <button class="btn btn-primary btn-sm float-left viewmore_inter"   id="'.$row["ifr_ID"].'">View More</button>
	$data[] = $sub_array;
}
if (isset($_REQUEST['acs_ID'])) {
	$acs_ID = $_REQUEST['acs_ID'];
 	$q = "SELECT * FROM `forms_inter_rating` WHERE acs_ID =".$acs_ID;
}
if (isset($_REQUEST['staff_ID'])) {
	$staff_ID = $_REQUEST['staff_ID'];
 	$q = "SELECT * FROM `forms_inter_rating` WHERE acs_ID =".$staff_ID;
}
else{
	$q = "SELECT * FROM `forms_inter_rating`";
}

$filtered_rec = $account->get_total_all_records($q);

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	$filtered_rec,
	"data"				=>	$data
);
echo json_encode($output);



?>



        
