<?php
require_once('../class.function.php');
$service = new DTFunction(); 
if(isset($_POST["operation"]))
{

	if($_POST["operation"] == "submit_service")
	{	
		try
		{

			$service_Title = $_POST["service_Title"];
			$service_Description = $_POST["service_Description"];
			$service_Repository = $_POST["service_Repository"];
			$service_Amount = $_POST["service_Amount"];


			$sql = "INSERT INTO `service` (`service_ID`, `service_Title`, `service_Description`, `service_Repository`, `service_Amount`, `service_Date`) VALUES (NULL, :service_Title, :service_Description, :service_Repository, :service_Amount, CURRENT_TIMESTAMP);";
			$statement = $service->runQuery($sql);
				
			$result = $statement->execute(
			array(

					':service_Title'		=>	$service_Title ,
					':service_Description'		=>	$service_Description ,
					':service_Repository'			=>	$service_Repository ,
					':service_Amount'		=>	$service_Amount ,
				)
			);
			if(!empty($result))
			{
				echo 'Successfully Added';
			}
			

		}
		catch (PDOException $e)
		{
		    echo "There is some problem in connection: " . $e->getMessage();
		}
		
	}

	if($_POST["operation"] == "service_edit")
	{
		
		
		try
		{	
			$service_ID = $_POST["service_ID"];
			$service_Title = $_POST["service_Title"];
			$service_Description = $_POST["service_Description"];
			$service_Repository = $_POST["service_Repository"];
			$service_Amount = $_POST["service_Amount"];

			
			$sql = "UPDATE `service` SET `service_Title` = :service_Title,  `service_Description` = :service_Description, `service_Repository` = :service_Repository, `service_Amount` = :service_Amount WHERE `service`.`service_ID` = :service_ID;";
			$statement = $service->runQuery($sql);
				
			$result = $statement->execute(
			array(
					':service_ID'		=>	$service_ID ,
					':service_Title'		=>	$service_Title ,
					':service_Description'		=>	$service_Description ,
					':service_Repository'			=>	$service_Repository ,
					':service_Amount'		=>	$service_Amount ,
				)
			);

			if(!empty($result))
			{
				echo 'Successfully Updated';
			}
			
		}
		catch (PDOException $e)
		{
		    echo "There is some problem in connection: " . $e->getMessage();
		}

		
	
	}

	if($_POST["operation"] == "delete_service")
	{
		try
		{
			$statement = $service->runQuery(
				"DELETE FROM `service` WHERE `service`.`service_ID` = :service_ID"
			);
			$result = $statement->execute(
				array(
					':service_ID'	=>	$_POST["service_ID"]
				)
			);
			
			if(!empty($result))
			{
				echo 'Successfully Deleted';
			}

		
		}
		catch (PDOException $e)
		{
		    echo "There is some problem in connection: " . $e->getMessage();
		}
		
	
	}
}
?>

