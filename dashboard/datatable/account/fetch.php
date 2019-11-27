<?php
require_once('../class.function.php');
$student = new DTFunction();  		 // Create new connection by passing in your configuration array


$query = '';
$output = array();
$query .= " 
SELECT 
*,
(case  
 
when (ua.lvl_ID = 1) 
then (SELECT UPPER(CONCAT(vsd.vsd_LName,', ',vsd.vsd_FName,' ',RIGHT(vsd.vsd_MName,1),'. ',
                          
                          (SELECT IF(rsn.suffix = 'NA',rsn.suffix,''))
                         
                         )) 
      FROM record_visitor_details vsd 
	  LEFT JOIN ref_suffixname rsn  ON rsn.suffix_ID = vsd.suffix_ID
      WHERE vsd.user_ID = ua.user_ID)
 
when (ua.lvl_ID = 2)  
then (SELECT UPPER(CONCAT(tcd.tcd_LName,', ',tcd.tcd_FName,' ',RIGHT(tcd.tcd_MName,1),'. ',
                          
                          (SELECT IF(rsn.suffix = 'NA',rsn.suffix,''))
                         
                         )) 
      FROM record_teacher_details tcd 
	  LEFT JOIN ref_suffixname rsn  ON rsn.suffix_ID = tcd.suffix_ID
      WHERE tcd.user_ID = ua.user_ID)
 
when (ua.lvl_ID = 3)  
then (SELECT UPPER(CONCAT(prd.prd_LName,', ',prd.prd_FName,' ',RIGHT(prd.prd_MName,1),'. ',
                          
                          (SELECT IF(rsn.suffix = 'NA',rsn.suffix,''))
                         
                         )) 
      FROM record_principal_details prd 
	  LEFT JOIN ref_suffixname rsn  ON rsn.suffix_ID = prd.suffix_ID
      WHERE prd.user_ID = ua.user_ID
     )
when (ua.lvl_ID = 4)  
then (SELECT UPPER(CONCAT(rad.rad_LName,', ',rad.rad_FName,' ',RIGHT(rad.rad_MName,1),'. ',
                          
                          (SELECT IF(rsn.suffix = 'NA',rsn.suffix,''))
                         
                         )) 
      FROM record_admin_details rad 
	  LEFT JOIN ref_suffixname rsn  ON rsn.suffix_ID = rad.suffix_ID
      WHERE rad.user_ID = ua.user_ID
     )
 
end)  fullname


";
$query .= " FROM `user_account`ua
LEFT JOIN `user_level` `ul` ON `ul`.`lvl_ID` = `ua`.`lvl_ID`";
if(isset($_POST["search"]["value"]))
{
 $query .= 'WHERE user_ID LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR user_Name LIKE "%'.$_POST["search"]["value"].'%" ';
}


if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY user_ID DESC ';
}
if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $student->runQuery($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach($result as $row)
{
	


	$sub_array = array();
	
		$status_ID =  $row["status_ID"];
		if($status_ID == 1){
			$sxs = '<button type="button" class="btn btn-danger btn-sm acc_deactive"    id="'.$row["user_ID"].'">Disable</button>';
			$sx = '<span class="badge badge-success">Activated</span>';
		}
		else{
			$sxs = '<button type="button" class="btn btn-success btn-sm acc_active"    id="'.$row["user_ID"].'">Enable</button>';
			$sx = '<span class="badge badge-danger">Disabled</span>';

		}
		$sub_array[] = $row["user_ID"];
		$sub_array[] =  addslashes(ucwords(strtolower(htmlspecialchars($row["fullname"]))));
		$sub_array[] =  $row["user_Name"];
		$sub_array[] =  $row["lvl_Name"];
		$sub_array[] =  $row["user_Registered"];
		$sub_array[] =  $sx;

		$sub_array[] = '
		<div class="btn-group" role="group" aria-label="Basic example">
		  '.$sxs.'
		  <button type="button" class="btn btn-primary btn-sm change"    id="'.$row["user_ID"].'">Change Pass</button>
		</div>
		';
		// <div class="dropdown-divider"></div>
		 // <a class="dropdown-item delete" id="'.$row["rad_ID"].'">Delete</a>
	$data[] = $sub_array;
}

$q = "SELECT * FROM `user_account`";
$filtered_rec = $student->get_total_all_records($q);

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	$filtered_rec,
	"data"				=>	$data
);
echo json_encode($output);



?>



        
