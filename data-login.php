<?php
/**
 * @package    
 *
 * @copyright  Copyright (C) 2019, All rights reserved.
 * @license    MIT License version or later; see licensing/LICENSE.txt
 */

session_start(); // Starting Session

require_once("class.user.php");

	
$auth_user = new USER();
if (isset($_POST['operation'])) {
	if ($_POST['operation'] == "submit_login") {

		$message = array();

		$login_user = strip_tags($_POST['login_user']);

		$login_password = strip_tags($_POST['login_password']);
			
		if($auth_user->doLogin($login_user,$login_password))
		{
			$message["success"] = "Successfully Login";

		}
		else
		{
		
			$message["error"] = "Error Login" ;

		}
		
	}


	echo json_encode($message,true);
}




?>