<?php
require_once('../class.function.php');
$admin = new DTFunction(); 

ini_set('display_errors', 1);
ini_set('error_reporting', E_ERROR);

if(isset($_POST["operation"]))
{


	if($_POST["operation"] == "change_password")
	{
		$account_ID = $_POST["account_ID"];
		$update_password_new = $_POST["update_password_new"];
		$update_password_newconfirm = $_POST["update_password_newconfirm"];
		if($update_password_new === $update_password_newconfirm)
		{
			$new_password = password_hash($update_password_newconfirm, PASSWORD_DEFAULT);
			try
			{
				$stmt = $admin->runQuery("UPDATE `user_account` SET `user_Pass` = :user_Pass WHERE `user_account`.`user_ID` = :user_ID");
				$stmt->bindparam(":user_ID", $account_ID);	
				$stmt->bindparam(":user_Pass", $new_password);	
				$stmt->execute();	
				echo "Password successfully change";
			}
			catch (PDOException $e)
			{
			    echo "There is some problem in connection: " . $e->getMessage();
			}
			
		}
		else
		{
			echo "Password not match";
		}


	}
	if($_POST["operation"] == "activate_acc")
	{
		try
			{
				$acc_ID = $_POST["acc_ID"];
				$sql = "UPDATE `user_account` SET `status_ID` = '1' WHERE `user_account`.`user_ID` = :acc_ID;";
				$stmt = $admin->runQuery($sql);
				$stmt->bindparam(":acc_ID", $acc_ID);	
				$stmt->execute();	
				echo "Account Activate";
			}
			catch (PDOException $e)
			{
			    echo "There is some problem in connection: " . $e->getMessage();
			}

	}
	if($_POST["operation"] == "deactivate_acc")
	{
		
		try
			{
				$acc_ID = $_POST["acc_ID"];
				$sql = "UPDATE `user_account` SET `status_ID` = '0' WHERE `user_account`.`user_ID` = :acc_ID;";
				$stmt = $admin->runQuery($sql);
				$stmt->bindparam(":acc_ID", $acc_ID);	
				$stmt->execute();	
				echo "Account Deactivate";
			}
			catch (PDOException $e)
			{
			    echo "There is some problem in connection: " . $e->getMessage();
			}
	}

	

	
	
}
?>

