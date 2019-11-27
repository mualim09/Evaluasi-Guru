<?php
require_once('../class.function.php');
$visitor = new DTFunction(); 

ini_set('display_errors', 1);
ini_set('error_reporting', E_ERROR);

if(isset($_POST["operation"]))
{

	if($_POST["operation"] == "submit_principal")
	{	
		$principal_schID = $_POST["principal_schID"];
		$principal_fname = $_POST["principal_fname"];
		$principal_mname = $_POST["principal_mname"];
		$principal_lname = $_POST["principal_lname"];
		$principal_bday = $_POST["principal_bday"];
		$principal_suffix = $_POST["principal_suffix"];
		$principal_sex = $_POST["principal_sex"];
		$principal_marital = $_POST["principal_marital"];
		$principal_email = addslashes($_POST["principal_email"]);
		$principal_address = addslashes($_POST["principal_address"]);



		if (isset($_FILES['principal_img']['tmp_name'])) 
		{
			$new_img = addslashes(file_get_contents($_FILES['principal_img']['tmp_name']));
			
		}
		else{
			$new_img = '';
		}


		
		$stmt1 = $visitor->runQuery("SELECT prd_SchID FROM `record_principal_details` WHERE prd_SchID = '$principal_schID' LIMIT 1");
		$stmt1->execute();
		$rs = $stmt1->fetchAll();
		if($stmt1->rowCount() > 0){
			echo "School ID Already Used";
		}
		else{
			try{
				$stmt = $visitor->runQuery("INSERT INTO `record_principal_details` 
					(
					`prd_ID`,
					 `prd_Img`,
					  `user_ID`,
					   `prd_SchID`,
					    `prd_FName`,
					     `prd_MName`,
					      `prd_LName`,
					       `suffix_ID`,
					        `sex_ID`,
					         `marital_ID`,
					          `prd_Email`,
					           `prd_Bday`,
					            `prd_Address`) 
					VALUES (
					NULL,
					 '$new_img',
					  NULL,
					  '$principal_schID',
					   '$principal_fname',
					    '$principal_mname',
					     '$principal_lname',
					      '$principal_suffix',
					       '$principal_sex',
					        '$principal_marital',
					         '$principal_email',
					          '$principal_bday',
					            '$principal_address');");

				$result = $stmt->execute();
				if(!empty($result))
				{
				    echo  "Principal Record Succesfully Updated";  
				    
				}
			} 
			catch (PDOException $e)
			{
			    echo "There is some problem in connection: " . $e->getMessage();
			}

		}

		
		
	}

	if($_POST["operation"] == "principal_update")
	{
		
		
		$principal_ID = $_POST["principal_ID"];
		$principal_schID = $_POST["principal_schID"];
		$principal_fname = $_POST["principal_fname"];
		$principal_mname = $_POST["principal_mname"];
		$principal_lname = $_POST["principal_lname"];
		$principal_bday = $_POST["principal_bday"];
		$principal_suffix = $_POST["principal_suffix"];
		$principal_sex = $_POST["principal_sex"];
		$principal_marital = $_POST["principal_marital"];
		$principal_email = addslashes($_POST["principal_email"]);
		$principal_address = addslashes($_POST["principal_address"]);

		if (isset($_FILES['principal_img']['tmp_name'])) 
		{
			$new_img = addslashes(file_get_contents($_FILES['principal_img']['tmp_name']));
			$set_img = "`prd_Img` = '$new_img' ,";
			
		}
		else{
			$new_img = '';
			$set_img = '';
		}

		try{

		
			$stmt = $visitor->runQuery("UPDATE 
				`record_principal_details` 
				SET 
				".$set_img."
				`prd_SchID` = '$principal_schID' ,
				`prd_FName` = '$principal_fname' ,
				`prd_MName` = '$principal_mname' ,
				`prd_LName` = '$principal_lname' ,
				`suffix_ID` = '$principal_suffix' ,
				`sex_ID` = '$principal_sex' ,
				`marital_ID` = '$principal_marital' ,
				`prd_Email` = '$principal_email' ,
				`prd_Bday` = '$principal_bday' ,
				`prd_Address` = '$principal_address' 
				WHERE `record_principal_details`.`prd_ID` = $principal_ID;");

			$result = $stmt->execute();
			if(!empty($result))
			{
			    echo  "Principal Record Succesfully Updated";  
			    
			}
		} 
		catch (PDOException $e)
		{
		    echo "There is some problem in connection: " . $e->getMessage();
		}

	
	}

	if($_POST["operation"] == "principal_delete")
	{
		$statement = $visitor->runQuery(
			"DELETE FROM `record_principal_details` WHERE `prd_ID` = :principal_ID"
		);
		$result = $statement->execute(
			array(
				':principal_ID'	=>	$_POST["principal_ID"]
			)
		);
		
		if(!empty($result))
		{
			echo 'Successfully Deleted';
		}
		
	
	}
		if($_POST["operation"] == "gen_account")
	{
		$principal_ID = $_POST["principal_ID"];

		$visitor->generate_account($principal_ID,"principal");

	}
}
?>

