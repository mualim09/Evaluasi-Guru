<?php
require_once('../class.function.php');
$visitor = new DTFunction(); 
session_start();
ini_set('display_errors', 1);
ini_set('error_reporting', E_ERROR);
date_default_timezone_set("Asia/Manila");
if(isset($_POST["operation"]))
{

	if($_POST["operation"] == "submit_ratingsheet")
	{	
		$postSize  = sizeof($_POST)-5;
		$rating = array();
		for($i = 1; $i <= $postSize; $i++){
			$rating["rating".$i]  = $_POST["rating".$i];
		
		}
		$rating_formID = $_POST["rating_formID"];
		$rating_period = $_POST["rating_period"];
		$rating_teacherID = $_POST["rating_teacher"];
		$rating_comment = $_POST["rating_comment"];

		$timenow = date("Y-m-d");
		$check_sql = "SELECT * FROM `forms_rating` WHERE fr_Date LIKE '%".$timenow."%'";
		$cstmt = $visitor->runQuery($check_sql);
		$cresult = $cstmt->execute();
		 $cstmt->rowCount();
		if($cstmt->rowCount() > 0){
			 echo  "You already submited evaluation today, 1 entry per day.";  
		}
		else{
			$fr_rating = json_encode($rating);
			$sql = "INSERT INTO `forms_rating` (`fr_ID`, `form_ID`, `period_ID`, `fr_Date`, `fr_Rating`, `user_ID`, `acs_ID`,`fr_comment`) 
			VALUES (NULL, '$rating_formID', '$rating_period', CURRENT_TIMESTAMP, '$fr_rating', ".$_SESSION['user_ID'].", '$rating_teacherID','$rating_comment');";
			$stmt = $visitor->runQuery($sql);
			$result = $stmt->execute();
			if(!empty($result))
			{
			    echo  "Ratingsheet Succesfully Submited";  
			    
			}
		}
	
		// print_r(array_count_values($rating));
	}
	if($_POST["operation"] == "submit_ratingsheetnote")
	{
		$rating_formID = $_POST["rating_formID"];
		$ratingnote_period = $_POST["ratingnote_period"];
		$rating_teacher = $_POST["rating_teacher"];
		$ratingnote_desc = $_POST["ratingnote_desc"];

		$timenow = date("Y-m-d");
		$check_sql = "SELECT * FROM `observation_notes` WHERE obn_Date LIKE '%".$timenow."%'";
		$cstmt = $visitor->runQuery($check_sql);
		$cresult = $cstmt->execute();
		 $cstmt->rowCount();
		if($cstmt->rowCount() > 0){
			 echo  "You already submited observation note today, 1 entry per day.";  
		}
		else{
			$sql = "INSERT INTO `observation_notes` (`obn_ID`, `user_ID`, `acs_ID`, `period_ID`, `general_observations`, `sem_ID`, `obn_Date`, `form_ID`) VALUES (NULL, ".$_SESSION['user_ID'].", '".$rating_teacher."', ".$ratingnote_period.", '".$ratingnote_desc."', NULL, CURRENT_TIMESTAMP, ".$rating_formID.");";
			$stmt = $visitor->runQuery($sql);
			$result = $stmt->execute();
			if(!empty($result))
			{
			    echo  "Ratingsheet Note Succesfully Submited"; 
			    
			}
		}
		

	}
	if($_POST["operation"] == "submit_interrating")
	{
		$postSize  = sizeof($_POST)-9;
		$rating = array();
		$observer = array();
		for($i = 1; $i <= $postSize; $i++){
			$rating["interrating".$i]  = $_POST["interrating".$i];
		}

		$observer["ob1"] = $_POST["interrating_ob2_id"];
		$observer["ob2"] = $_POST["interrating_ob3_id"];
		$interrating_formID = $_POST["interrating_formID"];
		$interrating_period = $_POST["interrating_period"];
		$interrating_teacher = $_POST["interrating_teacher"];
		$interratingnote_desc = $_POST["interratingnote_desc"];

		$csql = "SELECT * FROM `forms_inter_rating`  WHERE form_ID = '$interrating_formID' AND acs_ID = '$interrating_teacher'";
		$cstmt = $visitor->runQuery($csql);
		$cresult = $cstmt->execute();
		
		if($cstmt->rowCount() >=4)
		{
			echo  "Inter-Observation Rating Max";  

		}
		else{
			$timenow = date("Y-m-d");
			$xsql = "SELECT * FROM `forms_inter_rating`  WHERE ifr_Date LIKE '%".$timenow."%'";
			$xstmt = $visitor->runQuery($xsql);
			$xresult = $xstmt->execute();
			if($cstmt->rowCount() > 0)
			{
				echo  "It's look like someone has submited inter-observation note today, 1 entry per day.";  
			}
			else{
				$ifr_rating = json_encode($rating);
				$observer_json = json_encode($observer);

				$sql = "INSERT INTO `forms_inter_rating` 
				(`ifr_ID`, `form_ID`, `period_ID`, `ifr_Date`, `ifr_Rating`, `user_ID`, `acs_ID`,`observer_IDs`,`general_observations`) 
				VALUES (NULL, '$interrating_formID', '$interrating_period', CURRENT_TIMESTAMP, '$ifr_rating', ".$_SESSION['user_ID'].", '$interrating_teacher','$observer_json','$interratingnote_desc');";
				$stmt = $visitor->runQuery($sql);
				$result = $stmt->execute();
				if(!empty($result))
				{
				    echo  "Inter-Observer Agreement Succesfully Submited"; 
				    
				}
			}
			

		}

	

		
	}
	if($_POST["operation"] == "interrating_approve")
	{
		$fip_ID = $_POST["fip_ID"];
		$sql = "UPDATE `forms_indivual_performance` SET `status` = '1' WHERE `fip_ID` = ".$fip_ID.";";
		$stmt = $visitor->runQuery($sql);
		$result = $stmt->execute();
		if(!empty($result))
		{
		    echo  "Succesfully Approve"; 
		    
		}

	}
	if($_POST["operation"] == "interrating_disapprove")
	{
		$fip_ID = $_POST["fip_ID"];
		$sql = "UPDATE `forms_indivual_performance` SET `status` = '2' WHERE `fip_ID` = ".$fip_ID.";";
		$stmt = $visitor->runQuery($sql);
		$result = $stmt->execute();
		if(!empty($result))
		{
		    echo  "Succesfully Disapprove"; 
		    
		}
	}
	if($_POST["operation"] == "individual_performance_submit")
	{


		$postSize  = sizeof($_POST)-1;
		$rating = array();
		
			
		 $rating["rating"] =  $_POST["ind_form_akra_rating"];
		 $rating["adjrating"] =  $_POST["ind_form_akra_ratingAdjRating"];
		
		$individual_rating = json_encode($_POST);
		$rating = json_encode($rating);

		$fsql = "SELECT * FROM `forms` WHERE sem_ID = '".$_POST["ind_form_sem_ID"]."'";
		$statementf = $visitor->runQuery($fsql);
        $statementf->execute();
        $resultf = $statementf->fetchAll();
        foreach($resultf as $row){
        	 $form_ID = $row["form_ID"];
        }

        $asql = "SELECT * FROM `academic_staff` acs
			LEFT JOIN record_teacher_details tcd ON tcd.tcd_ID  = acs.tcd_ID
			WHERE tcd.user_ID = '".$_SESSION["user_ID"]."' AND acs.sem_ID = '".$_POST["ind_form_sem_ID"]."'";
		$statementa = $visitor->runQuery($asql);
        $statementa->execute();
        $resulta = $statementa->fetchAll();
        foreach($resulta as $row){
        	 $acs_ID = $row["acs_ID"];
        }

 
        $timenow = date("Y-m-d");
		$xsql = "SELECT * FROM `forms_indivual_performance` WHERE fip_Date LIKE '%".$timenow."%'";
		$xstmt = $visitor->runQuery($xsql);
		$xresult = $xstmt->execute();
        $resultx = $xstmt->fetchAll();
		if($xstmt->rowCount() > 0)
		{
			
			foreach($resultx as $row){
	        	 $status = $row["status"];
	        }
			if(isset($status)){
				echo  "You already have individual performance pending for approval."; 
			}
			else{
				echo  "You already submited individual performance form."; 
			}
		}
		else{
			$sql = "INSERT INTO `forms_indivual_performance` (`fip_ID`, `fip_Eval`, `acs_ID`, `user_ID`, `form_ID`, `rating`, `status`, `fip_Date`) VALUES (NULL, '$individual_rating', '$acs_ID', ".$_SESSION["user_ID"].", '$form_ID', '$rating', NULL, CURRENT_TIMESTAMP);";
			$stmt = $visitor->runQuery($sql);
			$result = $stmt->execute();
			if(!empty($result))
			{
			    echo  "Succesfully Submitted"; 
			    
			}
		}
		
		
	

// ind_form_teacherName
// ind_form_raterName

// ind_form_teacherNamePos
// ind_form_raterNamePos

// ind_form_division
// ind_form_date_review

// ind_form_ave1
// ind_form_rating1
// ind_form_score1
// ind_form_ave2
// ind_form_rating2
// ind_form_score2

// ind_form_ave4
// ind_form_rating4
// ind_form_score4

// ind_form_ave5
// ind_form_rating5
// ind_form_score5

// ind_form_ave6
// ind_form_rating6
// ind_form_score6

// hanggang

// ind_form_ave10
// ind_form_rating10
// ind_form_score10

// ind_form_q1
// ind_form_t1
// ind_form_e1
// ---
// ind_form_q10
// ind_form_t10
// ind_form_e10

// ind_form_mov1
// ind_form_timeline1

// ind_form_ratingperiod


// ind_form_akra_rating
// ind_form_akra_ratingAdjRating 	


// ind_form_akra_rra_emp1
// ind_form_akra_rra_emp2
// ind_form_akra_rrad_emp1
// ind_form_akra_rrad_emp2








	}



	
}
