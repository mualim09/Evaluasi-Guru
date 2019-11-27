<?php
require_once('../class.function.php');
$visitor = new DTFunction(); 

ini_set('display_errors', 1);
ini_set('error_reporting', E_ERROR);

if(isset($_POST["operation"]))
{

	if($_POST["operation"] == "submit_visitor")
	{	
		$visitor_schID = $_POST["visitor_schID"];
		$visitor_fname = $_POST["visitor_fname"];
		$visitor_mname = $_POST["visitor_mname"];
		$visitor_lname = $_POST["visitor_lname"];
		$visitor_bday = $_POST["visitor_bday"];
		$visitor_suffix = $_POST["visitor_suffix"];
		$visitor_sex = $_POST["visitor_sex"];
		$visitor_marital = $_POST["visitor_marital"];
		$visitor_email = addslashes($_POST["visitor_email"]);
		$visitor_address = addslashes($_POST["visitor_address"]);



		if (isset($_FILES['visitor_img']['tmp_name'])) 
		{
			$new_img = addslashes(file_get_contents($_FILES['visitor_img']['tmp_name']));
			
		}
		else{
			$new_img = '';
		}


		
		$stmt1 = $visitor->runQuery("SELECT vsd_SchID FROM `record_visitor_details` WHERE vsd_SchID = '$visitor_schID' LIMIT 1");
		$stmt1->execute();
		$rs = $stmt1->fetchAll();
		if($stmt1->rowCount() > 0){
			echo "School ID Already Used";
		}
		else{
			try{
				$stmt = $visitor->runQuery("INSERT INTO `record_visitor_details` 
					(
					`vsd_ID`,
					 `vsd_Img`,
					  `user_ID`,
					   `vsd_SchID`,
					    `vsd_FName`,
					     `vsd_MName`,
					      `vsd_LName`,
					       `suffix_ID`,
					        `sex_ID`,
					         `marital_ID`,
					          `vsd_Email`,
					           `vsd_Bday`,
					            `vsd_Address`) 
					VALUES (
					NULL,
					 '$new_img',
					  NULL,
					  '$visitor_schID',
					   '$visitor_fname',
					    '$visitor_mname',
					     '$visitor_lname',
					      '$visitor_suffix',
					       '$visitor_sex',
					        '$visitor_marital',
					         '$visitor_email',
					          '$visitor_bday',
					            '$visitor_address');");

				$result = $stmt->execute();
				if(!empty($result))
				{
				    echo  "Visitor Record Succesfully Updated";  
				    
				}
			} 
			catch (PDOException $e)
			{
			    echo "There is some problem in connection: " . $e->getMessage();
			}

		}

		
		
	}

	if($_POST["operation"] == "visitor_update")
	{
		
		
		$visitor_ID = $_POST["visitor_ID"];
		$visitor_schID = $_POST["visitor_schID"];
		$visitor_fname = $_POST["visitor_fname"];
		$visitor_mname = $_POST["visitor_mname"];
		$visitor_lname = $_POST["visitor_lname"];
		$visitor_bday = $_POST["visitor_bday"];
		$visitor_suffix = $_POST["visitor_suffix"];
		$visitor_sex = $_POST["visitor_sex"];
		$visitor_marital = $_POST["visitor_marital"];
		$visitor_email = addslashes($_POST["visitor_email"]);
		$visitor_address = addslashes($_POST["visitor_address"]);

		if (isset($_FILES['visitor_img']['tmp_name'])) 
		{
			$new_img = addslashes(file_get_contents($_FILES['visitor_img']['tmp_name']));
			$set_img = "`vsd_Img` = '$new_img' ,";
			
		}
		else{
			$new_img = '';
			$set_img = '';
		}

		try{

		
			$stmt = $visitor->runQuery("UPDATE 
				`record_visitor_details` 
				SET 
				".$set_img."
				`vsd_SchID` = '$visitor_schID' ,
				`vsd_FName` = '$visitor_fname' ,
				`vsd_MName` = '$visitor_mname' ,
				`vsd_LName` = '$visitor_lname' ,
				`suffix_ID` = '$visitor_suffix' ,
				`sex_ID` = '$visitor_sex' ,
				`marital_ID` = '$visitor_marital' ,
				`vsd_Email` = '$visitor_email' ,
				`vsd_Bday` = '$visitor_bday' ,
				`vsd_Address` = '$visitor_address' 
				WHERE `record_visitor_details`.`vsd_ID` = $visitor_ID;");

			$result = $stmt->execute();
			if(!empty($result))
			{
			    echo  "Visitor Record Succesfully Updated";  
			    
			}
		} 
		catch (PDOException $e)
		{
		    echo "There is some problem in connection: " . $e->getMessage();
		}

	
	}

	if($_POST["operation"] == "visitor_delete")
	{
		$statement = $visitor->runQuery(
			"DELETE FROM `record_visitor_details` WHERE `vsd_ID` = :visitor_ID"
		);
		$result = $statement->execute(
			array(
				':visitor_ID'	=>	$_POST["visitor_ID"]
			)
		);
		
		if(!empty($result))
		{
			echo 'Successfully Deleted';
		}
		
	
	}
		if($_POST["operation"] == "gen_account")
	{
		$visitor_ID = $_POST["visitor_ID"];

		$visitor->generate_account($visitor_ID,"visitor");

	}
}
?>

