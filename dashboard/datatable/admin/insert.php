<?php
require_once('../class.function.php');
$visitor = new DTFunction(); 

ini_set('display_errors', 1);
ini_set('error_reporting', E_ERROR);

if(isset($_POST["operation"]))
{

	if($_POST["operation"] == "submit_admin")
	{	
		$admin_schID = $_POST["admin_schID"];
		$admin_fname = $_POST["admin_fname"];
		$admin_mname = $_POST["admin_mname"];
		$admin_lname = $_POST["admin_lname"];
		$admin_bday = $_POST["admin_bday"];
		$admin_suffix = $_POST["admin_suffix"];
		$admin_sex = $_POST["admin_sex"];
		$admin_marital = $_POST["admin_marital"];
		$admin_email = addslashes($_POST["admin_email"]);
		$admin_address = addslashes($_POST["admin_address"]);



		if (isset($_FILES['admin_img']['tmp_name'])) 
		{
			$new_img = addslashes(file_get_contents($_FILES['admin_img']['tmp_name']));
			
		}
		else{
			$new_img = '';
		}


		
		$stmt1 = $visitor->runQuery("SELECT rad_SchID FROM `record_admin_details` WHERE rad_SchID = '$admin_schID' LIMIT 1");
		$stmt1->execute();
		$rs = $stmt1->fetchAll();
		if($stmt1->rowCount() > 0){
			echo "School ID Already Used";
		}
		else{
			try{
				$stmt = $visitor->runQuery("INSERT INTO `record_admin_details` 
					(
					`rad_ID`,
					 `rad_Img`,
					  `user_ID`,
					   `rad_SchID`,
					    `rad_FName`,
					     `rad_MName`,
					      `rad_LName`,
					       `suffix_ID`,
					        `sex_ID`,
					         `marital_ID`,
					          `rad_Email`,
					           `rad_Bday`,
					            `rad_Address`) 
					VALUES (
					NULL,
					 '$new_img',
					  NULL,
					  '$admin_schID',
					   '$admin_fname',
					    '$admin_mname',
					     '$admin_lname',
					      '$admin_suffix',
					       '$admin_sex',
					        '$admin_marital',
					         '$admin_email',
					          '$admin_bday',
					            '$admin_address');");

				$result = $stmt->execute();
				if(!empty($result))
				{
				    echo  "Admin Record Succesfully Updated";  
				    
				}
			} 
			catch (PDOException $e)
			{
			    echo "There is some problem in connection: " . $e->getMessage();
			}

		}

		
		
	}

	if($_POST["operation"] == "admin_update")
	{
		
		
		$admin_ID = $_POST["admin_ID"];
		$admin_schID = $_POST["admin_schID"];
		$admin_fname = $_POST["admin_fname"];
		$admin_mname = $_POST["admin_mname"];
		$admin_lname = $_POST["admin_lname"];
		$admin_bday = $_POST["admin_bday"];
		$admin_suffix = $_POST["admin_suffix"];
		$admin_sex = $_POST["admin_sex"];
		$admin_marital = $_POST["admin_marital"];
		$admin_email = addslashes($_POST["admin_email"]);
		$admin_address = addslashes($_POST["admin_address"]);

		if (isset($_FILES['admin_img']['tmp_name'])) 
		{
			$new_img = addslashes(file_get_contents($_FILES['admin_img']['tmp_name']));
			$set_img = "`rad_Img` = '$new_img' ,";
			
		}
		else{
			$new_img = '';
			$set_img = '';
		}

		try{

		
			$stmt = $visitor->runQuery("UPDATE 
				`record_admin_details` 
				SET 
				".$set_img."
				`rad_SchID` = '$admin_schID' ,
				`rad_FName` = '$admin_fname' ,
				`rad_MName` = '$admin_mname' ,
				`rad_LName` = '$admin_lname' ,
				`suffix_ID` = '$admin_suffix' ,
				`sex_ID` = '$admin_sex' ,
				`marital_ID` = '$admin_marital' ,
				`rad_Email` = '$admin_email' ,
				`rad_Bday` = '$admin_bday' ,
				`rad_Address` = '$admin_address' 
				WHERE `record_admin_details`.`rad_ID` = $admin_ID;");

			$result = $stmt->execute();
			if(!empty($result))
			{
			    echo  "Admin Record Succesfully Updated";  
			    
			}
		} 
		catch (PDOException $e)
		{
		    echo "There is some problem in connection: " . $e->getMessage();
		}

	
	}

	if($_POST["operation"] == "admin_delete")
	{
		$statement = $visitor->runQuery(
			"DELETE FROM `record_admin_details` WHERE `rad_ID` = :admin_ID"
		);
		$result = $statement->execute(
			array(
				':admin_ID'	=>	$_POST["admin_ID"]
			)
		);
		
		if(!empty($result))
		{
			echo 'Successfully Deleted';
		}
		
	
	}
		if($_POST["operation"] == "gen_account")
	{
		$admin_ID = $_POST["admin_ID"];

		$visitor->generate_account($admin_ID,"admin");

	}
}
?>

