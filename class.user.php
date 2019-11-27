<?php
require_once('dbconfig.php');


class USER
{	

	private $conn;
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;

    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	//log in function 
	public function doLogin($login_user,$login_password)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT user_ID, lvl_ID ,user_Name, user_Pass,user_Img FROM user_account WHERE user_Name=:user_Name AND status_ID = 1");
			$stmt->execute(array(':user_Name'=>$login_user));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				
				if(password_verify($login_password, $userRow['user_Pass']))
				{
					$_SESSION['lvl_ID'] = $userRow['lvl_ID'];
					$_SESSION['user_ID'] = $userRow['user_ID'];
					$_SESSION['user_Name'] = $userRow['user_Name'];
					if (!empty($userRow['user_Img'])) {
					 $s_img = 'data:image/jpeg;base64,'.base64_encode($userRow['user_Img']);
					}
					else{
					  $s_img = "../assets/img/users/default.jpg";
					}
					 $_SESSION['user_Img'] = $s_img;
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	// register function
	public function register($user_Name,$user_Pass)
	{
		try
		{	$user_ID = 1;
			$new_password = password_hash($ua_password, PASSWORD_DEFAULT);
			$stmt = $this->conn->prepare("INSERT INTO user_account(user_ID,user_Name,user_Pass) 
		                                               VALUES( :user_ID,:user_Name, :user_Pass)");
					
			$stmt->bindparam(":user_ID", $user_ID);	  
			$stmt->bindparam(":user_Name", $user_Name);
			$stmt->bindparam(":user_Pass", $new_password);	
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}

	
	public function is_loggedin()
	{
		if(isset($_SESSION['user_ID']))
		{
			return true;
		}
	}
	public function check_accesslevel($page_level){

		if (isset($_SESSION['lvl_ID'])) {

			if ($_SESSION['lvl_ID'] !=  $page_level) {
			    header('Location: ../error');
			}
		}
	}
	public function redirect_dashboard(){

		if (isset($_SESSION['lvl_ID'])) {
			header("Location: dashboard");
			
		}

	}


	
	public function redirect($url)
	{
		header("Location: $url");
	}
	
	public function doLogout()
	{
		session_destroy();
		unset($_SESSION['user_ID']);
		return true;
	}
	public function parseUrl()
	{
		if(isset($_GET['url'])){

			$url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));

			return $url;

		}

	}
	public function getUsername(){
		echo $_SESSION['user_Name'];
	}
	public function getUserPic(){
		echo $_SESSION['user_Img'] ;
	}
	public function page_url(){
		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		return $url;
	}


	public function close()
	{
		
		return mysql_close();
			
	}
	//ACCOUNT PAGE
	public function user_level_option()
	{
		$query ="SELECT * FROM `user_level`";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			echo '<option value="'.$row["lvl_ID"].'">'.$row["lvl_Name"].'</option>';
		}
		
	}
	public function ref_status()
	{
		$query ="SELECT * FROM `ref_status`";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			echo '<option value="'.$row["status_ID"].'">'.$row["status_Name"].'</option>';
		}
		
	}
	public function ref_year_level()
	{
		$query ="SELECT * FROM `ref_year_level`";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			echo '<option value="'.$row["yl_ID"].'">'.$row["yl_Name"].'</option>';
		}
		
	}
	
		public function ref_position()
	{
		$query ="SELECT * FROM `ref_position`";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			echo '<option value="'.$row["pos_ID"].'">'.$row["pos_Name"].'</option>';
		}
		
	}
		public function ref_section()
	{
		$query ="SELECT * FROM `ref_section`";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			echo '<option value="'.$row["section_ID"].'">'.$row["section_Name"].'</option>';
		}
		
	}
		public function ref_semester()
	{
		$query ="SELECT *,CONCAT(YEAR(sem_start),' - ',YEAR(sem_end)) sem_year FROM `ref_semester`";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			$stat_ID = $row["stat_ID"];
			if($stat_ID == "1")
			{
				$stat = " (Active)";
			}
			else{
				$stat = " (Deactivate)";
			}
			echo '<option value="'.$row["sem_ID"].'">'.$row["sem_year"].$stat.'</option>';
		}
		
	}
		public function ref_semester1($id_name)
	{
		$query ="SELECT *,CONCAT(YEAR(sem_start),' - ',YEAR(sem_end)) sem_year FROM `ref_semester` WHERE stat_ID = 1 ";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			$stat_ID = $row["stat_ID"];
			// if($stat_ID == "1")
			// {
			// 	$stat = " (Active)";
			// }
			// else{
			// 	$stat = " (Deactivate)";
			// }
			echo '<input type="hidden" value="'.$row["sem_ID"].'" id="'.$id_name.'" name="'.$id_name.'">';
			// echo $row["sem_year"];
		}


		
	}

	public function semester()
	{
		$query ="SELECT *,CONCAT(YEAR(sem_start),' - ',YEAR(sem_end)) sem_year FROM `ref_semester`";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		return $result;
		
	}
		public function ref_subject()
	{
		$query ="SELECT * FROM `ref_subject`";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			echo '<option value="'.$row["subject_ID"].'">'.$row["subject_Title"].'</option>';
		}
		
	}
	

	public function ref_sex()
	{
		$query ="SELECT * FROM `ref_sex`";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			echo '<option value="'.$row["sex_ID"].'">'.$row["sex_Name"].'</option>';
		}
		
	}
	public function ref_test_type()
	{
		$query ="SELECT * FROM `ref_test_type`";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			echo '<option value="'.$row["tstt_ID"].'">'.$row["tstt_Name"].'</option>';
		}
	}
	public function user_suffix_option()
	{
		$query ="SELECT * FROM `ref_suffixname`";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			echo '<option value="'.$row["suffix_ID"].'">'.$row["suffix"].'</option>';
		}
		
	}
	public function get_suffix($suffix_ID)
	{
		$query ="SELECT * FROM `ref_suffixname` WHERE suffix_ID = $suffix_ID";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			if ($row["suffix"] == "N/A")
			{
				$suffix = "";
			}
			else
			{
				$suffix =  $row["suffix"];
			}
		}
		
	}

	public function get_sex($sex_ID)
	{
		$query ="SELECT * FROM `ref_sex` WHERE sex_ID = $sex_ID";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			$sex_Name =  $row["sex_Name"];
			
		}
		return $sex_Name;
	}
	public function user_sex_option()
	{
		$query ="SELECT * FROM `ref_sex`";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			echo '<option value="'.$row["sex_ID"].'">'.$row["sex_Name"].'</option>';
		}
		
	}
	
	public function user_marital_option()
	{
		$query ="SELECT * FROM `ref_marital`";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			echo '<option value="'.$row["marital_ID"].'">'.$row["marital_Name"].'</option>';
		}
		
	}

	//SCHOOL YEAR PAGE
	public function schoolyear_status_option()
	{
		$query ="SELECT * FROM `status`";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			echo '<option value="'.$row["status_ID"].'">'.$row["status_Name"].'</option>';
		}
		
	}
	public function profile_email()
	{
		$user_type = "";
		$user_type_acro = "";
				if ($_SESSION['lvl_ID'] == "1")
		{
			$user_type = "visitor";
			$user_type_acro = "vsd";
		}
		if ($_SESSION['lvl_ID'] == "2")
		{
			$user_type = "teacher";
			$user_type_acro = "tcd";
		}
		if ($_SESSION['lvl_ID'] == "3")
		{
			$user_type = "principal";
			$user_type_acro = "prd";
		}
		if ($_SESSION['lvl_ID'] == "4")
		{
			$user_type = "admin";
			$user_type_acro = "rad";
		}
		$query ="SELECT ".$user_type_acro."_Email FROM `record_".$user_type."_details` WHERE user_ID = ".$_SESSION['user_ID'];
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
	
		if($stmt->rowCount() == 1)
		{
			foreach($result as $row)
			{
				echo $row[$user_type_acro."_Email"];
			}
		}
		else{
			echo "Empty";
		}
	}
	public function profile_address()
	{
		$user_type = "";
		$user_type_acro = "";
					if ($_SESSION['lvl_ID'] == "1")
		{
			$user_type = "visitor";
			$user_type_acro = "vsd";
		}
		if ($_SESSION['lvl_ID'] == "2")
		{
			$user_type = "teacher";
			$user_type_acro = "tcd";
		}
		if ($_SESSION['lvl_ID'] == "3")
		{
			$user_type = "principal";
			$user_type_acro = "prd";
		}
		if ($_SESSION['lvl_ID'] == "4")
		{
			$user_type = "admin";
			$user_type_acro = "rad";
		}
		$query ="SELECT ".$user_type_acro."_Address FROM `record_".$user_type."_details` WHERE user_ID = ".$_SESSION['user_ID'];
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if($stmt->rowCount() == 1)
		{
			foreach($result as $row)
			{
				echo $row[$user_type_acro."_Address"];
			}
		}
		else{
			echo "Empty";
		}	
	}
	public function profile_name()
	{
		$user_type = "";
		$user_type_acro = "";
	

			if ($_SESSION['lvl_ID'] == "1")
		{
			$user_type = "visitor";
			$user_type_acro = "vsd";
		}
		if ($_SESSION['lvl_ID'] == "2")
		{
			$user_type = "teacher";
			$user_type_acro = "tcd";
		}
		if ($_SESSION['lvl_ID'] == "3")
		{
			$user_type = "principal";
			$user_type_acro = "prd";
		}
		if ($_SESSION['lvl_ID'] == "4")
		{
			$user_type = "admin";
			$user_type_acro = "rad";
		}
		$query ="SELECT ".$user_type_acro."_FName,".$user_type_acro."_MName,".$user_type_acro."_LName, suffix_ID FROM `record_".$user_type."_details` WHERE user_ID = ".$_SESSION['user_ID'];
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if($stmt->rowCount() == 1)
		{
			foreach($result as $row)
			{
				if($row[$user_type_acro."_MName"] ==" " || 	$row[$user_type_acro."_MName"] == NULL || empty($row[$user_type_acro."_MName"]) )
				{
					$mname = " ";
				}
				else
				{
					$mname = $row[$user_type_acro."_MName"].'. ';
				}
				$full_name = "";
				$full_name .= $row[$user_type_acro."_LName"].", ";
				$full_name .= $row[$user_type_acro."_FName"]." ";
				$full_name .= $mname;
				$full_name .= $this->get_suffix($row["suffix_ID"]);

			}
				echo $full_name;
		}
		else{
			echo "Empty";
		}	
	}
	public function profile_school_id()
	{
		$user_type = "";
		$user_type_acro = "";
		if ($_SESSION['lvl_ID'] == "1")
		{
			$user_type = "visitor";
			$id_type = "vsd_SchID";
		}
		if ($_SESSION['lvl_ID'] == "2")
		{
			$user_type = "teacher";
			$id_type = "tcd_SchID";
		}
		if ($_SESSION['lvl_ID'] == "3")
		{
			$user_type = "principal";
			$id_type = "prd_SchID";
		}
		if ($_SESSION['lvl_ID'] == "4")
		{
			$user_type = "admin";
			$id_type = "rad_SchID";
		}
		$query ="SELECT ".$id_type." FROM `record_".$user_type."_details` WHERE user_ID = ".$_SESSION['user_ID'];
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if($stmt->rowCount() == 1)
		{
			foreach($result as $row)
			{
				echo $row[$id_type];
			}
		}
		else{
			echo "Empty";
		}	
	}
		public function profile_sex()
	{
		$user_type = "";
		$user_type_acro = "";
	

		if ($_SESSION['lvl_ID'] == "1")
		{
			$user_type = "visitor";
			$id_type = "vsd";
		}
		if ($_SESSION['lvl_ID'] == "2")
		{
			$user_type = "teacher";
			$id_type = "tcd";
		}
		if ($_SESSION['lvl_ID'] == "3")
		{
			$user_type = "principal";
			$id_type = "prd";
		}
		if ($_SESSION['lvl_ID'] == "4")
		{
			$user_type = "admin";
			$id_type = "rad";
		}
		$query ="SELECT sex_Name FROM `record_".$user_type."_details`  ".$id_type."
				LEFT JOIN ref_sex sex ON sex.sex_ID = ".$id_type.".sex_ID
				WHERE ".$id_type.".user_ID = ".$_SESSION['user_ID'];
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if($stmt->rowCount() == 1)
		{
			foreach($result as $row)
			{
				echo $row["sex_Name"];
			}
		}
		else{
			echo "Empty";
		}	
	}
		public function profile_dob()
	{
		$user_type = "";
		$user_type_acro = "";
	

		if ($_SESSION['lvl_ID'] == "1")
		{
			$user_type = "visitor";
			$id_type = "vsd";
		}
		if ($_SESSION['lvl_ID'] == "2")
		{
			$user_type = "teacher";
			$id_type = "tcd";
		}
		if ($_SESSION['lvl_ID'] == "3")
		{
			$user_type = "principal";
			$id_type = "prd";
		}
		if ($_SESSION['lvl_ID'] == "4")
		{
			$user_type = "admin";
			$id_type = "rad";
		}
		$query ="SELECT ".$id_type."_Bday FROM `record_".$user_type."_details`  ".$id_type."
				WHERE ".$id_type.".user_ID = ".$_SESSION['user_ID'];
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if($stmt->rowCount() == 1)
		{
			foreach($result as $row)
			{
				echo $row[$id_type."_Bday"];
			}
		}
		else{
			echo "Empty";
		}	
	}
		public function profile_age()
	{
		$user_type = "";
		$user_type_acro = "";
	

		if ($_SESSION['lvl_ID'] == "1")
		{
			$user_type = "visitor";
			$id_type = "vsd";
		}
		if ($_SESSION['lvl_ID'] == "2")
		{
			$user_type = "teacher";
			$id_type = "tcd";
		}
		if ($_SESSION['lvl_ID'] == "3")
		{
			$user_type = "principal";
			$id_type = "prd";
		}
		if ($_SESSION['lvl_ID'] == "4")
		{
			$user_type = "admin";
			$id_type = "rad";
		}
		$query ="SELECT 
		TIMESTAMPDIFF(YEAR,".$id_type."_Bday,CURDATE()) AS Age
		FROM `record_".$user_type."_details`  ".$id_type."
				WHERE ".$id_type.".user_ID = ".$_SESSION['user_ID'];
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if($stmt->rowCount() == 1)
		{
			foreach($result as $row)
			{
				echo $row["Age"];
			}
		}
		else{
			echo "Empty";
		}	
	}

	
	public function  visitor_level()
	{
		if ($_SESSION['lvl_ID'] == "1")
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function  teacher_level()
	{
		if ($_SESSION['lvl_ID'] == "2")
		{
			return true;
		}
		else
		{
			return false;
		}	
	}
		public function  principal_level()
	{
		if ($_SESSION['lvl_ID'] == "3")
		{
			return true;
		}
		else
		{
			return false;
		}	
	}
	public function  admin_level()
	{
		if ($_SESSION['lvl_ID'] == "4")
		{
			return true;
		}
		else
		{
			return false;
		}
	}
		
	public function get_active_sem(){
		
		$query ="SELECT *,CONCAT(YEAR(sem_start),' - ',YEAR(sem_end)) sem_year FROM `ref_semester` WHERE stat_ID = 1 LIMIT 1";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		return $result;
	}




    	public function notification(){


		$query = "SELECT * FROM `notification` WHERE user_ID = ".$_SESSION['user_ID']." 
		ORDER BY `notification`.`notif_Date`  DESC LIMIT 25";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if($stmt->rowCount() > 0){
			foreach($result as $row){


			    $ndate = strtotime($row["notif_Date"]);
				$ndate =  date("Y-m-d h:i:sa",$ndate);
			?>
			<div class="p-2 bd-highlight border-bottom">
                  <small class=""><?php echo $row["notif_Msg"]?></small>
                  <br>
                  <small class="text-muted float-right"><?php echo  $ndate?></small>
            </div>
			<?php
			}
		}
		else{
			?>
			<div class="p-2 bd-highlight border-bottom"><small>No Notification Available</small></div>
			<?php


		}
		
		
		
	}



	public function getSidenavUserInfo()
	{
		 // $_SESSION['user_Name'];
		$uID = $_SESSION['user_ID'];
		$sql = "SELECT 
				(case  
				 when (ua.lvl_ID = 1) then (SELECT CONCAT(vsd.vsd_FName,' ',LEFT(vsd.vsd_MName, 1),'. ',vsd.vsd_LName) FROM record_visitor_details vsd WHERE vsd.user_ID = ua.user_ID)
				when (ua.lvl_ID = 2)  then (SELECT CONCAT(tcd.tcd_FName,' ',LEFT(tcd.tcd_MName, 1),'. ',tcd.tcd_LName) FROM record_teacher_details tcd WHERE tcd.user_ID = ua.user_ID)
				when (ua.lvl_ID = 3)  then (SELECT CONCAT(prd.prd_FName,' ',LEFT(prd.prd_MName, 1),'. ',prd.prd_LName) FROM record_principal_details prd WHERE prd.user_ID = ua.user_ID)
				when (ua.lvl_ID = 4)  then (SELECT CONCAT(rad.rad_FName,' ',LEFT(rad.rad_MName, 1),'. ',rad.rad_LName) FROM record_admin_details rad WHERE rad.user_ID = ua.user_ID)
				end) fullname
				FROM `user_account` ua WHERE ua.user_ID = $uID LIMIT 1";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
		foreach($result as $row)
		{
			$fullname = ucwords($row["fullname"]);
			$_SESSION["fullname"] = ucwords($row["fullname"]);
		}
		echo $fullname;
		if($this->visitor_level() ){
			echo "<br><small>(Visitor)</small>";
		}
		if($this->teacher_level() ){
			echo "<br><small>(Teacher)</small>";
		}
		if($this->principal_level() ){
			echo "<br><small>(Principal)</small>";
		}
		if($this->admin_level() ){
			echo "<br><small>(Admin)</small>";
		}
		
	}






	

	



	
}