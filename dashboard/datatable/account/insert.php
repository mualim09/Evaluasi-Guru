<?php
require_once('../class.function.php');
$account = new DTFunction(); 
if(isset($_POST["operation"]))
{

	if($_POST["operation"] == "submit_account")
	{	
		try
		{
			$acc_username = $_POST["acc_username"];
			$acc_name = $_POST["acc_name"];
			$acc_lvl = $_POST["acc_lvl"];
			$acc_email = $_POST["acc_email"];
			$acc_pass = $_POST["acc_pass"];
			$acc_cpass = $_POST["acc_cpass"];
			$acc_address = $_POST["acc_add"];

			if ($acc_pass != $acc_cpass) {
				echo "Password not match";
			}
			else{
				$newpass = $account->encryptIt($acc_pass);
				$sql = "INSERT INTO `user` (
				`user_ID`,
				`lvl_ID`,
				`user_img`,
				`user_Name`,
				`user_Pass`,
				`user_Email`,
				`user_Address`,
				`user_Registered`)
				VALUES (
				NULL,
				:acc_lvl,
				NULL,
				:acc_username,
				:acc_pass,
				:acc_email,
				:acc_address,
				CURRENT_TIMESTAMP);";
				$statement = $account->runQuery($sql);
					
				$result = $statement->execute(
				array(

						':acc_lvl'		=>	$acc_lvl ,
						':acc_username'		=>	$acc_username ,
						':acc_pass'			=>	$newpass ,
						':acc_email'		=>	$acc_email ,
						':acc_address'			=>	$acc_address ,
					)
				);
				if(!empty($result))
				{
					echo 'Successfully Added';
				}
			}

		}
		catch (PDOException $e)
		{
		    echo "There is some problem in connection: " . $e->getMessage();
		}
		
	}

	if($_POST["operation"] == "account_edit")
	{
		
		

		$account_ID = $_POST["account_ID"];
		$acc_name = $_POST["acc_name"];
		$acc_lvl = $_POST["acc_lvl"];
		$acc_email = $_POST["acc_email"];
		$acc_pass = $_POST["acc_pass"];
		$acc_cpass = $_POST["acc_cpass"];
		$acc_address = $_POST["acc_add"];

		if ($acc_pass != $acc_cpass) {
			echo "Password not match";
		}
		else{
			$newpass = $account->encryptIt($acc_pass);
			$sql = "UPDATE `user` SET `lvl_ID` = :acc_lvl,  `user_Pass` = :acc_pass, `user_Email` = :acc_email, `user_Address` = :acc_address WHERE `user`.`user_ID` = :account_ID;";
			$statement = $account->runQuery($sql);
				
			$result = $statement->execute(
			array(

					':account_ID'		=>	$account_ID ,
					':acc_lvl'		=>	$acc_lvl ,
					':acc_email'		=>	$acc_email ,
					':acc_pass'			=>	$newpass ,
					':acc_address'			=>	$acc_address ,
				)
			);
			if(!empty($result))
			{
				echo 'Successfully Updated';
			}
		}
	
	}

	if($_POST["operation"] == "delete_account")
	{
		$statement = $account->runQuery(
			"DELETE FROM `user` WHERE `user`.`user_ID` = :user_ID"
		);
		$result = $statement->execute(
			array(
				':user_ID'	=>	$_POST["account_ID"]
			)
		);
		
		if(!empty($result))
		{
			echo 'Successfully Deleted';
		}
		
	
	}
}
?>

