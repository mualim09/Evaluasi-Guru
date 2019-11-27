<?php
require_once('../class.function.php');
$visitor = new DTFunction(); 

ini_set('display_errors', 1);
ini_set('error_reporting', E_ERROR);

if(isset($_POST["operation"]))
{

	if($_POST["operation"] == "submit_teacher")
	{	
		$teacher_schID = $_POST["teacher_schID"];
		$teacher_fname = $_POST["teacher_fname"];
		$teacher_mname = $_POST["teacher_mname"];
		$teacher_lname = $_POST["teacher_lname"];
		$teacher_bday = $_POST["teacher_bday"];
		$teacher_suffix = $_POST["teacher_suffix"];
		$teacher_sex = $_POST["teacher_sex"];
		$teacher_marital = $_POST["teacher_marital"];
		$teacher_email = addslashes($_POST["teacher_email"]);
		$teacher_address = addslashes($_POST["teacher_address"]);



		if (isset($_FILES['teacher_img']['tmp_name'])) 
		{
			$new_img = addslashes(file_get_contents($_FILES['teacher_img']['tmp_name']));
			
		}
		else{
			$new_img = '';
		}


		
		$stmt1 = $visitor->runQuery("SELECT tcd_SchID FROM `record_teacher_details` WHERE tcd_SchID = '$teacher_schID' LIMIT 1");
		$stmt1->execute();
		$rs = $stmt1->fetchAll();
		if($stmt1->rowCount() > 0){
			echo "School ID Already Used";
		}
		else{
			try{
				$stmt = $visitor->runQuery("INSERT INTO `record_teacher_details` 
					(
					`tcd_ID`,
					 `tcd_Img`,
					  `user_ID`,
					   `tcd_SchID`,
					    `tcd_FName`,
					     `tcd_MName`,
					      `tcd_LName`,
					       `suffix_ID`,
					        `sex_ID`,
					         `marital_ID`,
					          `tcd_Email`,
					           `tcd_Bday`,
					            `tcd_Address`) 
					VALUES (
					NULL,
					 '$new_img',
					  NULL,
					  '$teacher_schID',
					   '$teacher_fname',
					    '$teacher_mname',
					     '$teacher_lname',
					      '$teacher_suffix',
					       '$teacher_sex',
					        '$teacher_marital',
					         '$teacher_email',
					          '$teacher_bday',
					            '$teacher_address');");

				$result = $stmt->execute();
				if(!empty($result))
				{
				    echo  "Teacher Record Succesfully Updated";  
				    
				}
			} 
			catch (PDOException $e)
			{
			    echo "There is some problem in connection: " . $e->getMessage();
			}

		}

		
		
	}

	if($_POST["operation"] == "teacher_update")
	{
		
		
		$teacher_ID = $_POST["teacher_ID"];
		$teacher_schID = $_POST["teacher_schID"];
		$teacher_fname = $_POST["teacher_fname"];
		$teacher_mname = $_POST["teacher_mname"];
		$teacher_lname = $_POST["teacher_lname"];
		$teacher_bday = $_POST["teacher_bday"];
		$teacher_suffix = $_POST["teacher_suffix"];
		$teacher_sex = $_POST["teacher_sex"];
		$teacher_marital = $_POST["teacher_marital"];
		$teacher_email = addslashes($_POST["teacher_email"]);
		$teacher_address = addslashes($_POST["teacher_address"]);

		if (isset($_FILES['teacher_img']['tmp_name'])) 
		{
			$new_img = addslashes(file_get_contents($_FILES['teacher_img']['tmp_name']));
			$set_img = "`tcd_Img` = '$new_img' ,";
			
		}
		else{
			$new_img = '';
			$set_img = '';
		}

		try{

		
			$stmt = $visitor->runQuery("UPDATE 
				`record_teacher_details` 
				SET 
				".$set_img."
				`tcd_SchID` = '$teacher_schID' ,
				`tcd_FName` = '$teacher_fname' ,
				`tcd_MName` = '$teacher_mname' ,
				`tcd_LName` = '$teacher_lname' ,
				`suffix_ID` = '$teacher_suffix' ,
				`sex_ID` = '$teacher_sex' ,
				`marital_ID` = '$teacher_marital' ,
				`tcd_Email` = '$teacher_email' ,
				`tcd_Bday` = '$teacher_bday' ,
				`tcd_Address` = '$teacher_address' 
				WHERE `record_teacher_details`.`tcd_ID` = $teacher_ID;");

			$result = $stmt->execute();
			if(!empty($result))
			{
			    echo  "Teacher Record Succesfully Updated";  
			    
			}
		} 
		catch (PDOException $e)
		{
		    echo "There is some problem in connection: " . $e->getMessage();
		}

	
	}

	if($_POST["operation"] == "teacher_delete")
	{
		$statement = $visitor->runQuery(
			"DELETE FROM `record_teacher_details` WHERE `tcd_ID` = :teacher_ID"
		);
		$result = $statement->execute(
			array(
				':teacher_ID'	=>	$_POST["teacher_ID"]
			)
		);
		
		if(!empty($result))
		{
			echo 'Successfully Deleted';
		}
		
	
	}
		if($_POST["operation"] == "gen_account")
	{
		$teacher_ID = $_POST["teacher_ID"];

		$visitor->generate_account($teacher_ID,"teacher");

	}
}
?>

