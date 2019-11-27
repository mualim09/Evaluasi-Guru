<?php
require_once('../class.function.php');
$student = new DTFunction(); 
session_start();
if (isset($_POST['action'])) {
	// ratingsheet_check
	

	$output = array();

	if($_POST['action'] == "ratingsheet_check"){
			$stmt = $student->runQuery("SELECT * FROM `forms_rating`  fr
		LEFT JOIN ref_period rp ON rp.period_ID = fr.period_ID
		WHERE fr.form_ID = '".$_POST["form_ID"]."' AND fr.user_ID = '".$_SESSION["user_ID"]."' AND fr.acs_ID  = '".$_POST["acs_ID"]."' 
					");
			$stmt->execute();
			$result = $stmt->fetchAll();
			$output["rating_period_name"] = "First";
			$output["rating_period_ID"] = "1";
			foreach($result as $row)
			{
				
				$output["fr_ID"] = $row["fr_ID"];
				$output["rating_period_name"] = $row["period_Name"];
				$output["rating_period_ID"] = $row["period_ID"];
				
			
			}
			$count_rating = $stmt->rowCount();
			if($count_rating == 1)
			{
				$output["rating_period_name"] = "Second";
				$output["rating_period_ID"] = "2";
			}
			if($count_rating == 2)
			{
				$output["rating_period_name"] = "Third";
				$output["rating_period_ID"] = "3";
			}
			if($count_rating == 3)
			{
				$output["rating_period_name"] = "Fourth";
				$output["rating_period_ID"] = "4";
			}
			if($count_rating == 4)
			{
				$output["rating_period_name"] = "Maximum Rating";
				$output["rating_period_ID"] = "5";
			}
	}
	if($_POST['action'] == "ratingsheet_notecheck"){
			$stmt = $student->runQuery("SELECT * FROM `observation_notes` obn
		LEFT JOIN ref_period rp ON rp.period_ID = obn.period_ID
		WHERE obn.form_ID = '".$_POST["form_ID"]."' AND obn.user_ID = '".$_SESSION["user_ID"]."' AND obn.acs_ID  = '".$_POST["acs_ID"]."' 
					");
			$stmt->execute();
			$result = $stmt->fetchAll();
			$output["ratingnote_period_name"] = "First";
			$output["ratingnote_period_ID"] = "1";
			foreach($result as $row)
			{
				
				$output["obn_ID"] = $row["obn_ID"];
				$output["ratingnote_period_name"] = $row["period_Name"];
				$output["ratingnote_period_ID"] = $row["period_ID"];
				
			
			}
			$count_rating = $stmt->rowCount();
			if($count_rating == 1)
			{
				$output["ratingnote_period_name"] = "Second";
				$output["ratingnote_period_ID"] = "2";
			}
			if($count_rating == 2)
			{
				$output["ratingnote_period_name"] = "Third";
				$output["ratingnote_period_ID"] = "3";
			}
			if($count_rating == 3)
			{
				$output["ratingnote_period_name"] = "Fourth";
				$output["ratingnote_period_ID"] = "4";
			}
			if($count_rating == 4)
			{
				$output["ratingnote_period_name"] = "Maximum Rating";
				$output["ratingnote_period_ID"] = "5";
			}

	}
	if($_POST['action'] == "interrating_check"){

		$stmt = $student->runQuery("SELECT * FROM `forms_inter_rating` fir
		LEFT JOIN ref_period rp ON rp.period_ID = fir.period_ID
		WHERE fir.form_ID = '".$_POST["form_ID"]."' AND fir.user_ID = '".$_SESSION["user_ID"]."' AND fir.acs_ID  = '".$_POST["acs_ID"]."' 
					");
			$stmt->execute();
			$result = $stmt->fetchAll();
			$output["interrating_period_name"] = "First";
			$output["interrating_period_ID"] = "1";

			foreach($result as $row)
			{
				
				$output["ifr_ID"] = $row["ifr_ID"];
				$output["interrating_period_name"] = $row["period_Name"];
				$output["interrating_period_ID"] = $row["period_ID"];
				
			
			}
			$count_rating = $stmt->rowCount();
			if($count_rating == 1)
			{
				$output["interrating_period_name"] = "Second";
				$output["interrating_period_ID"] = "2";
			}
			if($count_rating == 2)
			{
				$output["interrating_period_name"] = "Third";
				$output["interrating_period_ID"] = "3";
			}
			if($count_rating == 3)
			{
				$output["interrating_period_name"] = "Fourth";
				$output["interrating_period_ID"] = "4";
			}
			if($count_rating == 4)
			{
				$output["interrating_period_name"] = "Maximum Rating";
				$output["interrating_period_ID"] = "5";
			}
	}
	if($_POST['action'] == "interrating_fecth"){
		$stmt = $student->runQuery("SELECT *,
		CONCAT(YEAR(rsm.sem_start),' - ',YEAR(rsm.sem_end)) semyear ,
		(SELECT UPPER(CONCAT(tcd_LName,', ',tcd_FName,' ',RIGHT(tcd_MName,1)))) fullname
		FROM `forms_indivual_performance` fip
		LEFT JOIN academic_staff acs ON acs.acs_ID = fip.acs_ID
		LEFT JOIN forms f ON f.form_ID = fip.form_ID
		LEFT JOIN ref_semester rsm ON rsm.sem_ID = f.sem_ID
		LEFT JOIN record_teacher_details tcd ON tcd.tcd_ID = acs.tcd_ID
		WHERE   fip.fip_ID  = '".$_POST["fip_ID"]."' 
					");
			$stmt->execute();
			$result = $stmt->fetchAll();
		foreach($result as $row)
		{
			
			$output["fip_ID"] = $row["fip_ID"];
			$output["ratee_Name"] = $row["fullname"];
			$output["shoolyear"] = $row["semyear"];
			
			
		
		}
	}
	echo json_encode($output);
	
}









 

?>