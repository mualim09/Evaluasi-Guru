<?php
require_once('../class.function.php');
$account = new DTFunction(); 
if(isset($_POST["operation"]))
{

	if($_POST["operation"] == "submit_subject")
	{	
		try
		{

			function check ($array,$search){
			    //IF FOUND
			    if (in_array($search, $array)) {

			        $search = intval($search);
			                //+1 In Original Value If Found
			        $search += 1;

			        return check($array,$search);
			    }
			    //IF NOTFOUND RETURN ORIGINAL INPUT
			    else{
			        return $search;
			    }

			}

			$subject_title = $_POST["subject_title"];
			$subject_abbreviation = $_POST["subject_abbreviation"];

			$last_id = $account->insert_subject($subject_title,$subject_abbreviation);
			$y = date("Y");
	        $m = date("m");
	        $d = date("d");
	        $subject_Code = $y.$m."0".$d+$last_id;

	        $sql ="SELECT * FROM `ref_subject`";
	        $smtp = $account->runQuery($sql);
			$smtp->execute();
			$chk_result = $smtp->fetchAll();
			$sCode = array();
			foreach($chk_result as $row)
			{
				$sCode[] = $row["subject_Code"];

			}
			$unique_value = check($sCode,$subject_Code);
		
			
			$sql = "UPDATE `ref_subject` SET `subject_Code` = '".$unique_value."' WHERE `ref_subject`.`subject_ID` =".$last_id;
			$smtp1 = $account->runQuery($sql);
			$update_result = $smtp1->execute();
			if(!empty($update_result))
			{
				echo 'Successfully Added';
			}
			

		}
		catch (PDOException $e)
		{
		    echo "There is some problem in connection: " . $e->getMessage();
		}
		
	}

	if($_POST["operation"] == "subject_update")
	{
		
		

		$subject_title = $_POST["subject_title"];
		$subject_abbreviation = $_POST["subject_abbreviation"];

		$sql = "UPDATE `ref_subject` SET `subject_Title` = :subject_title,`Abbreviation` = :subject_abbreviation WHERE `subject_ID` =  :subject_ID;";
		$statement = $account->runQuery($sql);
			
		$result = $statement->execute(
		array(
				':subject_ID'	=>	$_POST["subject_ID"],
				':subject_title'		=>	$subject_title ,
				':subject_abbreviation'	=>	$subject_abbreviation ,
			)
		);
		if(!empty($result))
		{
			echo 'Successfully Updated';
		}
	
	}

	if($_POST["operation"] == "delete_subject")
	{
		$statement = $account->runQuery(
			"DELETE FROM `ref_subject` WHERE `subject_ID` = :subject_ID"
		);
		$result = $statement->execute(
			array(
				':subject_ID'	=>	$_POST["subject_ID"]
			)
		);
		
		if(!empty($result))
		{
			echo 'Successfully Deleted';
		}
		
	
	}
}
?>

