<?php 
/**
 * 
 */
require_once('../../../dbconfig.php');

class DTFunction
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


    public function get_total_all_records($q)
    {
        try
        { 
            $statement =  $stmt = $this->conn->prepare("$q");
            $statement->execute();
            $result = $statement->fetchAll();

            return $statement->rowCount(); 
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        } 
    }

    public function check_user_level($var)
    {
        try
        { 
            $statement =  $stmt = $this->conn->prepare("SELECT * FROM `user_level` WHERE `lvl_ID` = $var");
            $statement->execute();
            $result = $statement->fetchAll();

            foreach($result as $row)
            {
                $level_name = $row["lvl_Name"];
            }

            return $level_name; 
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        } 
    }
    public function get_visitorName($ob_ID){
    $sql = "SELECT 
    UPPER(CONCAT(vsd.vsd_LName,', ',vsd.vsd_FName,' ',RIGHT(vsd.vsd_MName,1),'. ',
                              
                              (SELECT IF(rsn.suffix = 'NA',rsn.suffix,''))
                             
                             )) Visitor_Name
    FROM `record_visitor_details` vsd
    LEFT JOIN ref_suffixname rsn  ON rsn.suffix_ID = vsd.suffix_ID
    WHERE vsd.vsd_ID = ".$ob_ID;
        $statement =  $stmt = $this->conn->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();

        foreach($result as $row)
        {
            $Visitor_Name = $row["Visitor_Name"];
        }

        return $Visitor_Name; 
    }

    public function generate_account($id,$user_type){
        try{
        $user_type_acro = "";

        if ($user_type == "visitor")
        {
            $user_type_acro = "vsd";
             $sc_id = "vsd_SchID";
             $slvl = 1;
        }
        if ($user_type == "teacher")
        {
            $user_type_acro = "tcd";
            $sc_id = "tcd_SchID";
            $slvl = 2;
        }
        if ($user_type == "principal")
        {
            $user_type_acro = "prd";
            $sc_id = "prd_SchID";
            $slvl = 3;

        }
          if ($user_type == "admin")
        {
            $user_type_acro = "rad";
            $sc_id = "rad_SchID";
            $slvl = 4;

        }
            $q1 ="SELECT * FROM `record_".$user_type."_details` WHERE ".$user_type_acro."_ID = '$id'";

            $stmt1 = $this->conn->prepare($q1);
            $stmt1->execute();
            $result1 = $stmt1->fetchAll();
            

            foreach($result1 as $row)
            {
                $lastname = $row[$user_type_acro."_LName"];
                $sc_id = $row[$sc_id];

            }
            $ac_user = $sc_id;
            $ac_pass = strtolower($lastname).'123';


            $n_pass = password_hash($ac_pass, PASSWORD_DEFAULT);

            $q2 ="INSERT INTO `user_account` (`user_ID`, `lvl_ID`, `user_Img`, `user_Name`, `user_Pass`, `user_Registered`) VALUES (NULL, '$slvl', NULL, '$ac_user', '$n_pass', CURRENT_TIMESTAMP);";
            $stmt2 = $this->conn->prepare($q2);
            $stmt2->execute();
            $last_id = $this->conn->lastInsertId();



            $q3  = "UPDATE `record_".$user_type."_details` SET `user_ID` = '$last_id' WHERE `".$user_type_acro."_ID` = '$id'";
            $stmt3 = $this->conn->prepare($q3);
            $r3 = $stmt3->execute();

            if(!empty($r3))
            {
                echo '<div class="text-center"><strong>Username:</strong>'.$ac_user.'<br>';
                echo '<strong>Password:</strong>'.$ac_pass.'<br>';
                echo 'Account Successfully Created</div>';
            }
            

        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        } 

    }




}



?>