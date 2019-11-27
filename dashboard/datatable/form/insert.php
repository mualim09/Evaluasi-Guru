<?php
require_once('../class.function.php');
$visitor = new DTFunction(); 

ini_set('display_errors', 1);
ini_set('error_reporting', E_ERROR);

if(isset($_POST["operation"]))
{

	if($_POST["operation"] == "submit_form")
	{
		$form_Name = $_POST["form_Name"];
		$form_Desc = $_POST["form_Desc"];
		$form_SY = $_POST["form_SY"];

		$sqlx = "SELECT * FROM `forms` WHERE sem_ID = ".$form_SY."";
		$statementx = $visitor->runQuery($sqlx);
		$resultx = $statementx->execute();
		
		if ($statementx->rowCount() > 0){
			echo 'You can\'t add new rating in this school year';
		}
		else{
			$sql = "INSERT INTO `forms` (`form_ID`, `form_Name`, `sem_ID`) 
			VALUES (NULL, :form_Name, :form_SY);";
			$statement = $visitor->runQuery($sql);
							
			$result = $statement->execute(
			array(

					':form_Name'		=>	$form_Name ,
					':form_SY'			=>	$form_SY ,
				)
			);
			if(!empty($result))
			{
				echo 'Successfully Added';
			}
		}

	
	}
	if($_POST["operation"] == "edit_form")
	{
		$form_Name = $_POST["form_Name"];
		$form_Desc = $_POST["form_Desc"];
		$form_ID = $_POST["form_ID"];

		

		$sql = "UPDATE `forms` 
		SET 
		`form_Name` = :form_Name,
		`form_Desc` = :form_Desc'
		WHERE `forms`.`form_ID` = :form_ID;";
		$statement = $visitor->runQuery($sql);
						
		$result = $statement->execute(
		array(

				':form_ID'		=>	$form_ID ,
				':form_Name'		=>	$form_Name ,
				':form_Desc'		=>	$form_Desc ,
			)
		);
		if(!empty($result))
		{
			echo 'Successfully Updated';
		}
		
	}



	if($_POST["operation"] == "submit_formcontent")
	{

		$form_ID = $_POST["form_ID"];
		$form_Name = $_POST["rform_Name"];
		$sql = "INSERT INTO `forms_content` (`fc_ID`, `fc_Desc`, `form_ID`) VALUES (NULL, :form_Name, :form_ID);";
		$statement = $visitor->runQuery($sql);
						
		$result = $statement->execute(
		array(

				':form_ID'		=>	$form_ID ,
				':form_Name'		=>	$form_Name ,
			)
		);
		if(!empty($result))
		{
			echo 'Successfully Added';
		}


	}


	if($_POST["operation"] == "update_formcontent")
	{
		$fc_ID = $_POST["fc_ID"];
		$form_ID = $_POST["form_ID"];
		$rform_Name = $_POST["rform_Name"];

		$sql = "UPDATE `forms_content` SET `fc_Desc` = :rform_Name WHERE `forms_content`.`fc_ID` = :fc_ID";
		$statement = $visitor->runQuery($sql);
						
		$result = $statement->execute(
		array(

				':fc_ID'		=>	$fc_ID ,
				':rform_Name'		=>	$rform_Name ,
			)
		);
		if(!empty($result))
		{
			echo 'Successfully Updated';
		}

	}
	if($_POST["operation"] == "delete_formcontent")
	{
		
		$fc_ID = $_POST["fc_ID"];
		$sql = "DELETE FROM `forms_content` WHERE `forms_content`.`fc_ID` = :fc_ID";
		$statement = $visitor->runQuery($sql);
						
		$result = $statement->execute(
		array(

				':fc_ID'		=>	$fc_ID ,
			)
		);
		if(!empty($result))
		{
			echo 'Successfully Deleted';
		}

	}


	

	


}
?>

