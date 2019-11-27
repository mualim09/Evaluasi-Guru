<?php 
/**
 * 
 */
require_once('../../dbconfig.php');

class PrntFunction
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

    public function getIndivualRating($a,$b){
       try{
             $sql = "SELECT * FROM `forms_indivual_performance` fip 
                LEFT JOIN forms f ON f.form_ID = fip.form_ID
                WHERE f.sem_ID = 7 AND fip.acs_ID='".$a."' AND fip.status = 1";
                $statement =  $stmt = $this->conn->prepare($sql);
                $statement->execute();
                $result = $statement->fetchAll();
                $c ="";
                foreach($result as $row)
                {
                    $rating = json_decode($row["rating"]);
                }
                if($b == "rating"){
                    if(isset($rating->rating)){
                        $c = $rating->rating;
                    }
                    
                }
                 if($b == "adjrating"){
                    if(isset($rating->adjrating)){
                        $c = $rating->adjrating;
                    }
                }
                return  $c;
            }
         catch(PDOException $e)
        {
            
        } 
       

    }
    public function getRating($a,$b,$increment){ 
        try{
        $sql = "SELECT rp.period_Name,fr.fr_Rating FROM `forms_rating` fr 
        LEFT JOIN ref_period rp ON rp.period_ID  = fr.period_ID
        WHERE fr.acs_ID = '".$a."'";
        $statement =  $stmt = $this->conn->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $fo = array();
        foreach($result as $row){
           $rspid = $row["period_Name"];
           $rsfrr = json_decode($row["fr_Rating"]);
           foreach($rsfrr as $ro1){
              $fo[$rspid][] = $ro1;
           }
         } 
        // $fr_first = "";
        // $fr_second = "";
        // $fr_third = "";
        // $fr_fourth = "";
        // if(isset($fo["First"])){
        //     $fr_first = $fo["First"][$ixz-1];
        //  }
        //  if(isset($fo["Second"])){
        //     $fr_second = $fo["Second"][$ixz-1];
        //  }
        //  if(isset($fo["Third"])){
        //     $fr_third = $fo["Third"][$ixz-1];
        //  }
        //  if(isset($fo["Fourth"])){
        //     $fr_fourth = $fo["Fourth"][$ixz-1];
        //  }
         $d = "";
        if ($b == "First"){
            if (isset($fo["First"][$increment-1])){
                $d = $fo["First"][$increment-1];
            }
            
        }
        if ($b == "Second"){
           if (isset($fo["Second"][$increment-1])){
                $d = $fo["Second"][$increment-1];
            }
        }
        if ($b == "Third"){
           if (isset($fo["Third"][$increment-1])){
                $d = $fo["Third"][$increment-1];
            }
        }
        if ($b == "Fourth"){
           if (isset($fo["Fourth"][$increment-1])){
                $d = $fo["Fourth"][$increment-1];
            }
        }
        return $d;
        }
         catch(PDOException $e)
       {
           
       } 


    }
    public function getInterRating($a,$b,$increment){ 
        try{
        $sql = "
        SELECT rp.period_Name,fir.ifr_Rating FROM `forms_inter_rating` fir 
        LEFT JOIN ref_period rp ON rp.period_ID  = fir.period_ID
        WHERE fir.acs_ID =  '".$a."'";
        $statement =  $stmt = $this->conn->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $fo = array();
        foreach($result as $row){
           $rspid = $row["period_Name"];
           $rsfrr = json_decode($row["ifr_Rating"]);
           foreach($rsfrr as $ro1){
              $fo[$rspid][] = $ro1;
           }
         } 
         $d = "";
        if ($b == "First"){
            if (isset($fo["First"][$increment-1])){
                $d = $fo["First"][$increment-1];
            }
            
        }
        if ($b == "Second"){
           if (isset($fo["Second"][$increment-1])){
                $d = $fo["Second"][$increment-1];
            }
        }
        if ($b == "Third"){
           if (isset($fo["Third"][$increment-1])){
                $d = $fo["Third"][$increment-1];
            }
        }
        if ($b == "Fourth"){
           if (isset($fo["Fourth"][$increment-1])){
                $d = $fo["Fourth"][$increment-1];
            }
        }
        return $d;
        }
         catch(PDOException $e)
       {
           
       } 


    }


    

}



?>