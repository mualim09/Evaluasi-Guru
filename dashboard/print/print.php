<?php


//include pdf_mc_table.php, not fpdf17/fpdf.php

require_once('class.function.php');
include('pdf_mc_table.php');


//make new object
$pdf = new PDF_MC_Table();
$print = new PrntFunction(); 

//add page, set font

if (isset($_REQUEST["report"])) 
{
  $report = $_REQUEST["report"];

  if ($report == "overall") {
    $pdf->AddPage('L','Legal');
  }
  else{
    $pdf->AddPage();
  }

}
$pdf->SetFont('Arial','',14);

//set width for each column (6 columns)
if (isset($_REQUEST["report"])) 
{
   
    
    if ($report == "rating-sheet") {
        $pdf->SetWidths(Array(120,10,10,10,10,10,25));
    }
    if ($report == "rating-sheet-note") {
        $pdf->SetWidths(Array(120,10,10,10,10,10,25));
    } 
    if ($report == "inter-observer-sheet") {
        $pdf->SetWidths(Array(120,10,10,10,10,10,25));
    }
    if ($report == "overall") {
        $pdf->SetWidths(Array(30,30,60,16.25,16.25,16.25,16.25,16.25,16.25,16.25,16.25,32.5,32.5));
    }
}

//set alignment
//$pdf->SetAligns(Array('','R','C','','',''));

//set line height. This is the height of each lines, not rows.
$pdf->SetLineHeight(5);

//load json data
if (isset($_REQUEST["filter"])) 
{
    $filter = $_REQUEST["filter"];
}







if ($report == "rating-sheet") {
 
 $pdf->SetTitle("Rating Sheet Report");
$sqlx = "SELECT 
* ,

(case  
 
when (ua.lvl_ID = 1) 
then (SELECT UPPER(CONCAT(vsd.vsd_LName,', ',vsd.vsd_FName,' ',RIGHT(vsd.vsd_MName,1),'. ',
                          
                          (SELECT IF(rsn.suffix = 'NA',rsn.suffix,''))
                         
                         )) 
      FROM record_visitor_details vsd 
      LEFT JOIN ref_suffixname rsn  ON rsn.suffix_ID = vsd.suffix_ID
      WHERE vsd.user_ID = ua.user_ID)
 
when (ua.lvl_ID = 2)  
then (SELECT UPPER(CONCAT(tcd.tcd_LName,', ',tcd.tcd_FName,' ',RIGHT(tcd.tcd_MName,1),'. ',
                          
                          (SELECT IF(rsn.suffix = 'NA',rsn.suffix,''))
                         
                         )) 
      FROM record_teacher_details tcd 
      LEFT JOIN ref_suffixname rsn  ON rsn.suffix_ID = tcd.suffix_ID
      WHERE tcd.user_ID = ua.user_ID)
 
when (ua.lvl_ID = 3)  
then (SELECT UPPER(CONCAT(prd.prd_LName,', ',prd.prd_FName,' ',RIGHT(prd.prd_MName,1),'. ',
                          
                          (SELECT IF(rsn.suffix = 'NA',rsn.suffix,''))
                         
                         )) 
      FROM record_principal_details prd 
      LEFT JOIN ref_suffixname rsn  ON rsn.suffix_ID = prd.suffix_ID
      WHERE prd.user_ID = ua.user_ID
     )
when (ua.lvl_ID = 4)  
then (SELECT UPPER(CONCAT(rad.rad_LName,', ',rad.rad_FName,' ',RIGHT(rad.rad_MName,1),'. ',
                          
                          (SELECT IF(rsn.suffix = 'NA',rsn.suffix,''))
                         
                         )) 
      FROM record_admin_details rad 
      LEFT JOIN ref_suffixname rsn  ON rsn.suffix_ID = rad.suffix_ID
      WHERE rad.user_ID = ua.user_ID
     )
 
end)  observer
,
CONCAT(rtd.tcd_FName,' ',LEFT(rtd.tcd_MName,1),'. ',rtd.tcd_LName,' ',(SELECT IF(rsn.suffix = 'NA',rsn.suffix,'')) ) obseved,
CONCAT(rsub.subject_Title,' ',ryl.yl_Name) subject_level
FROM 
`forms_rating` fr
LEFT JOIN academic_staff acs ON acs.acs_ID = fr.acs_ID
LEFT JOIN record_teacher_details rtd ON rtd.tcd_ID = acs.tcd_ID
LEFT JOIN ref_subject rsub ON rsub.subject_ID = acs.subject_ID
LEFT JOIN ref_suffixname rsn ON rsn.suffix_ID = rtd.suffix_ID
LEFT JOIN ref_period rp ON rp.period_ID = fr.period_ID
LEFT JOIN ref_year_level ryl ON ryl.yl_ID = acs.yl_ID
LEFT JOIN user_account ua ON ua.user_ID = fr.user_ID
WHERE fr.fr_ID = ".$_REQUEST["fr_ID"];
        
        $stmtx = $print->runQuery($sqlx);
        $stmtx->execute();
        $resultx = $stmtx->fetchAll();
         foreach($resultx as $row)
        {
            $observer = $row["observer"];
            $obseved = $row["obseved"];
            $subject_level = $row["subject_level"];
            $rating = $row["fr_Rating"];
            $period_Name = $row["period_Name"];
            $fr_Date = date('M. d, Y', strtotime($row["fr_Date"]));
            $form_ID = $row["form_ID"];
            $fr_comment = $row["fr_comment"];
        }

    $sql = " SELECT * FROM `forms_content` WHERE form_ID = ".$form_ID;
        
    $stmt = $print->runQuery($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();


    foreach($result as $row){
        $myArray[] = $row;
        
    }
    $rating = json_decode($rating);
    $wx = 1;
    $tempContainer = array();
     $result = $stmt->fetchAll();
    foreach($rating as $row){
        $tempContainer["rating".$wx] =  $row;
        $row;
        $wx++;
    }
    // echo "<pre>";
    // print_r(array_count_values($tempContainer));
    $acvtc = array_count_values($tempContainer);
    $acvtc_min =  min($acvtc);
    $acvtc_max =  max($acvtc);
    $min_label = array_search($acvtc_min,$acvtc);
    $max_label =array_search($acvtc_max,$acvtc);

    if(empty($myArray)) {
        $if_has_content = 0;
    }
    else{
        // $json = file_get_contents('MOCK_DATA.json');
        $json = json_encode($myArray);
        $data = json_decode($json,true);
        $if_has_content = 1;
    }

     $pdf->Image('../../assets/img/logo/header.png',1,1,208);
     $pdf->SetFont('Times','B',12);
     $pdf->Cell(80);
    $pdf->Cell(120,35,"",0,1,'');
    $pdf->Cell(0,5,"ALULOD ELEMENTARY SCHOOL",0,1,'C');
    $pdf->Cell(0,5,"COT-RPMS",0,1,'C');
    $pdf->Cell(0,5,"TEACHER I-III",0,1,'C');
    $pdf->Cell(0,5,"RATING SHEET",0,1,'C');
    $pdf->Cell(145,5,"OBSERVER: ",0,0,'');
    $pdf->Cell(0,5,"DATE: ",0,1,'');
    $pdf->Cell(0,5,"TEACHER OBSERVED: ",0,1,'');
    $pdf->Cell(0,5,"SUBJECT AND GRADE LEVEL TAUGHT: ",0,1,'');
    $pdf->Cell(0,5,"OBSERVATION: ",0,1,'');
    $pdf->Cell(0,5,"DIRECTIONS FOR THE OBSERVER: ",0,1,'');

    $pdf->Cell(0,-25,"",0,1,'');
    $pdf->SetFont('Times','',9);
    $pdf->Cell(35);
    $pdf->Cell(125,5,strtoupper($observer),0,0,'');
    $pdf->Cell(0,5,$fr_Date,0,1,'');
    $pdf->Cell(50);
    $pdf->Cell(0,5,strtoupper($obseved),0,1,'');
     $pdf->Cell(85);
    $pdf->Cell(0,5,strtoupper($subject_level),0,1,'');
     $pdf->Cell(38);
    $pdf->Cell(0,5,$period_Name,0,1,'');
    $pdf->Cell(0,5,"",0,1,'');
    $pdf->Cell(0,5,"1. Rate each item on the checklist according to how well the teacher performed during the classroom observation. ",0,1,'');
    $pdf->Cell(0,5,"2. Each indicator is assessed on an individual basis, regardless of its relationship to other indicators. ",0,1,'');
    $pdf->Cell(0,5,"3. Attached your observation Notes Form to the completed rating sheet.",0,1,'');
    $pdf->SetFont('Times','B',9);
    $pdf->Cell(40,5,"HIGHEST SCORE: ",0,0,'');
    $pdf->Cell(0,5,"LOWEST SCORE: ",0,1,'');
     $pdf->SetFont('Times','',9);
    $pdf->Cell(0,-5,"",0,1,'');
    $pdf->Cell(30);
    $pdf->Cell(40,5,$max_label,0,0,'');
    $pdf->Cell(0,5,$min_label,0,1,'');
    $pdf->Cell(0,5," ",0,1,'');

    $pdf->SetFont('Times','',9);
    $pdf->Cell(120,5,"THE TEACHER",1,0,'');
    $pdf->Cell(10,5,"3",1,0,'C');
    $pdf->Cell(10,5,"4",1,0,'C');
    $pdf->Cell(10,5,"5",1,0,'C');
    $pdf->Cell(10,5,"6",1,0,'C');
    $pdf->Cell(10,5,"7",1,0,'C');
    $pdf->Cell(25,5,"No Observed",1,0,'C');
    $pdf->Ln();
    //reset font
    $pdf->SetFont('Arial','',9);


    $ixz = 1;
    function rating_check($increment,$position,$rating_content){
        if($rating_content["rating".$increment] == $position){
            $a = " / ";
        }
        else{
            $a = " ";
        }
        return $a;
    }

    if ($if_has_content != 0) {
        //loop the data
        foreach($data as $item){
            //write data using Row() method containing array of values.
            $pdf->Row(Array(
                $ixz.".) ".$item['fc_Desc'],
                rating_check($ixz,"3",$tempContainer),
                rating_check($ixz,"4",$tempContainer),
                rating_check($ixz,"5",$tempContainer),
                rating_check($ixz,"6",$tempContainer),
                rating_check($ixz,"7",$tempContainer),
                rating_check($ixz,"NO",$tempContainer),
            ));
            $ixz++;
        }
    }

    $pdf->Cell(195,5,"OTHER COMMENTS",1,1,''); 
    $pdf->Cell(195,5,$fr_comment,1,1,'');
    $pdf->Cell(0,15,"",0,1,'');
    $pdf->Cell(90,5,strtoupper($observer),0,0,'C');
    $pdf->Cell(0,5,strtoupper($obseved),0,1,'C');
    $pdf->Cell(90,-3,"______________________________________",0,0,'C');
    $pdf->Cell(0,-3,"______________________________________ ",0,1,'C');
    $pdf->Cell(90,3,"",0,0,'C');
    $pdf->Cell(0,3,"",0,1,'C');

    $pdf->Cell(90,5,"Signature over Printed Name of the Observer",0,0,'C');
    $pdf->Cell(0,5,"Signature over Printed Name of the Observer",0,1,'C');
  
}//if ($report == "rating-sheet") 

if ($report == "rating-sheet-note") {
 $pdf->SetTitle("Rating Sheet Note Report");
 
        $sqlx = "SELECT 
* ,

(case  
 
when (ua.lvl_ID = 1) 
then (SELECT UPPER(CONCAT(vsd.vsd_LName,', ',vsd.vsd_FName,' ',RIGHT(vsd.vsd_MName,1),'. ',
                          
                          (SELECT IF(rsn.suffix = 'NA',rsn.suffix,''))
                         
                         )) 
      FROM record_visitor_details vsd 
      LEFT JOIN ref_suffixname rsn  ON rsn.suffix_ID = vsd.suffix_ID
      WHERE vsd.user_ID = ua.user_ID)
 
when (ua.lvl_ID = 2)  
then (SELECT UPPER(CONCAT(tcd.tcd_LName,', ',tcd.tcd_FName,' ',RIGHT(tcd.tcd_MName,1),'. ',
                          
                          (SELECT IF(rsn.suffix = 'NA',rsn.suffix,''))
                         
                         )) 
      FROM record_teacher_details tcd 
      LEFT JOIN ref_suffixname rsn  ON rsn.suffix_ID = tcd.suffix_ID
      WHERE tcd.user_ID = ua.user_ID)
 
when (ua.lvl_ID = 3)  
then (SELECT UPPER(CONCAT(prd.prd_LName,', ',prd.prd_FName,' ',RIGHT(prd.prd_MName,1),'. ',
                          
                          (SELECT IF(rsn.suffix = 'NA',rsn.suffix,''))
                         
                         )) 
      FROM record_principal_details prd 
      LEFT JOIN ref_suffixname rsn  ON rsn.suffix_ID = prd.suffix_ID
      WHERE prd.user_ID = ua.user_ID
     )
when (ua.lvl_ID = 4)  
then (SELECT UPPER(CONCAT(rad.rad_LName,', ',rad.rad_FName,' ',RIGHT(rad.rad_MName,1),'. ',
                          
                          (SELECT IF(rsn.suffix = 'NA',rsn.suffix,''))
                         
                         )) 
      FROM record_admin_details rad 
      LEFT JOIN ref_suffixname rsn  ON rsn.suffix_ID = rad.suffix_ID
      WHERE rad.user_ID = ua.user_ID
     )
 
end)  observer
,
CONCAT(rtd.tcd_FName,' ',LEFT(rtd.tcd_MName,1),'. ',rtd.tcd_LName,' ',(SELECT IF(rsn.suffix = 'NA',rsn.suffix,'')) ) obseved,
CONCAT(rsub.subject_Title,' ',ryl.yl_Name) subject_level
FROM 
`observation_notes` obn
LEFT JOIN academic_staff acs ON acs.acs_ID = obn.acs_ID
LEFT JOIN record_teacher_details rtd ON rtd.tcd_ID = acs.tcd_ID
LEFT JOIN ref_subject rsub ON rsub.subject_ID = acs.subject_ID
LEFT JOIN ref_suffixname rsn ON rsn.suffix_ID = rtd.suffix_ID
LEFT JOIN ref_period rp ON rp.period_ID = obn.period_ID
LEFT JOIN ref_year_level ryl ON ryl.yl_ID = acs.yl_ID
LEFT JOIN user_account ua ON ua.user_ID = obn.user_ID
WHERE obn.obn_ID = ".$_REQUEST["obn_ID"];
        
        $stmtx = $print->runQuery($sqlx);
        $stmtx->execute();
        $resultx = $stmtx->fetchAll();
         foreach($resultx as $row)
        {
            $observer = $row["observer"];
            $obseved = $row["obseved"];
            $subject_level = $row["subject_level"];
            $period_Name = $row["period_Name"];
         
            $obn_Date = date('M. d, Y', strtotime($row["obn_Date"]));
            $form_ID = $row["form_ID"];
            $general_observations = $row["general_observations"];
        }

    $sql = " SELECT * FROM `forms_content` WHERE form_ID = ".$form_ID;
        
    $stmt = $print->runQuery($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();


    foreach($result as $row){
        $myArray[] = $row;
        
    }
    $result = $stmt->fetchAll();
 

    if(empty($myArray)) {
        $if_has_content = 0;
    }
    else{
        // $json = file_get_contents('MOCK_DATA.json');
        $json = json_encode($myArray);
        $data = json_decode($json,true);
        $if_has_content = 1;
    }

     $pdf->Image('../../assets/img/logo/header.png',1,1,208);
     $pdf->SetFont('Times','B',12);
     $pdf->Cell(80);
    $pdf->Cell(120,35,"",0,1,'');
    $pdf->Cell(0,5,"ALULOD ELEMENTARY SCHOOL",0,1,'C');
    $pdf->Cell(0,5,"COT-RPMS",0,1,'C');
    $pdf->Cell(0,5,"TEACHER I-III",0,1,'C');
    $pdf->Cell(0,5,"OBSERVATION NOTES FORM",0,1,'C');
    $pdf->Cell(145,5,"OBSERVER: ",0,0,'');
    $pdf->Cell(0,5,"DATE: ",0,1,'');
    $pdf->Cell(0,5,"TEACHER OBSERVED: ",0,1,'');
    $pdf->Cell(0,5,"SUBJECT AND GRADE LEVEL TAUGHT: ",0,1,'');
    $pdf->Cell(0,5,"OBSERVATION: ",0,1,'');
    $pdf->Cell(0,5,"",0,1,'');

    $pdf->Cell(0,-25,"",0,1,'');
    $pdf->SetFont('Times','',9);
    $pdf->Cell(35);
    $pdf->Cell(125,5,strtoupper($observer),0,0,'');
    $pdf->Cell(0,5,$obn_Date,0,1,'');
    $pdf->Cell(50);
    $pdf->Cell(0,5,strtoupper($obseved),0,1,'');
    $pdf->Cell(85);
    $pdf->Cell(0,5,strtoupper($subject_level),0,1,'');
    $pdf->Cell(38);
    $pdf->Cell(0,5,$period_Name,0,1,'');
    $pdf->Cell(0,5,"",0,1,'');
    $pdf->Cell(0,5,"GENERAL OBSERVATION",1,1,'');
    $pdf->Cell(0,150,"",1,1,'');
    $pdf->Cell(0,5,"",0,1,'C');
    $pdf->Cell(0,5,strtoupper($observer),0,1,'C');
    $pdf->Cell(0,-3,"",0,1,'');
    $pdf->Cell(0,5,"____________________________________________",0,1,'C');
    $pdf->Cell(0,5,"Signature over Printed Name of the Observer",0,1,'C');
    $pdf->Cell(0,-160,"",0,1,'');
    $pdf->Cell(0,5,$general_observations,0,1,'');
  
}// rating-sheet-note

if ($report == "inter-observer-sheet") {
 $pdf->SetTitle("Inter-Observer Agreement Report");  

$sqlx = "SELECT 
* ,

(case  
 
when (ua.lvl_ID = 1) 
then (SELECT UPPER(CONCAT(vsd.vsd_LName,', ',vsd.vsd_FName,' ',RIGHT(vsd.vsd_MName,1),'. ',
                          
                          (SELECT IF(rsn.suffix = 'NA',rsn.suffix,''))
                         
                         )) 
      FROM record_visitor_details vsd 
      LEFT JOIN ref_suffixname rsn  ON rsn.suffix_ID = vsd.suffix_ID
      WHERE vsd.user_ID = ua.user_ID)
 
when (ua.lvl_ID = 2)  
then (SELECT UPPER(CONCAT(tcd.tcd_LName,', ',tcd.tcd_FName,' ',RIGHT(tcd.tcd_MName,1),'. ',
                          
                          (SELECT IF(rsn.suffix = 'NA',rsn.suffix,''))
                         
                         )) 
      FROM record_teacher_details tcd 
      LEFT JOIN ref_suffixname rsn  ON rsn.suffix_ID = tcd.suffix_ID
      WHERE tcd.user_ID = ua.user_ID)
 
when (ua.lvl_ID = 3)  
then (SELECT UPPER(CONCAT(prd.prd_LName,', ',prd.prd_FName,' ',RIGHT(prd.prd_MName,1),'. ',
                          
                          (SELECT IF(rsn.suffix = 'NA',rsn.suffix,''))
                         
                         )) 
      FROM record_principal_details prd 
      LEFT JOIN ref_suffixname rsn  ON rsn.suffix_ID = prd.suffix_ID
      WHERE prd.user_ID = ua.user_ID
     )
when (ua.lvl_ID = 4)  
then (SELECT UPPER(CONCAT(rad.rad_LName,', ',rad.rad_FName,' ',RIGHT(rad.rad_MName,1),'. ',
                          
                          (SELECT IF(rsn.suffix = 'NA',rsn.suffix,''))
                         
                         )) 
      FROM record_admin_details rad 
      LEFT JOIN ref_suffixname rsn  ON rsn.suffix_ID = rad.suffix_ID
      WHERE rad.user_ID = ua.user_ID
     )
 
end)  observer
,
CONCAT(rtd.tcd_FName,' ',LEFT(rtd.tcd_MName,1),'. ',rtd.tcd_LName,' ',(SELECT IF(rsn.suffix = 'NA',rsn.suffix,'')) ) obseved,
CONCAT(rsub.subject_Title,' ',ryl.yl_Name) subject_level
FROM `forms_inter_rating`  fir
LEFT JOIN academic_staff acs ON acs.acs_ID = fir.acs_ID
LEFT JOIN record_teacher_details rtd ON rtd.tcd_ID = acs.tcd_ID
LEFT JOIN ref_subject rsub ON rsub.subject_ID = acs.subject_ID
LEFT JOIN ref_suffixname rsn ON rsn.suffix_ID = rtd.suffix_ID
LEFT JOIN ref_period rp ON rp.period_ID = fir.period_ID
LEFT JOIN ref_year_level ryl ON ryl.yl_ID = acs.yl_ID
LEFT JOIN user_account ua ON ua.user_ID = fir.user_ID
WHERE fir.ifr_ID = ".$_REQUEST["ifr_ID"];
        
        $stmtx = $print->runQuery($sqlx);
        $stmtx->execute();
        $resultx = $stmtx->fetchAll();
         foreach($resultx as $row)
        {
          $form_ID = $row["form_ID"];
          $observer = $row["observer"];
          $obseved = $row["obseved"];  
          $if_rating = $row["ifr_Rating"];
          $subject_level = $row["subject_level"];
          $period_Name = $row["period_Name"];
          $general_observations = $row["general_observations"];
          
          $ifr_Date = date('M. d, Y', strtotime($row["ifr_Date"]));
          $observer_IDs = json_decode($row["observer_IDs"]);
        }
    $sql = " SELECT * FROM `forms_content` WHERE form_ID = ".$form_ID;
        
    $stmt = $print->runQuery($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();


    foreach($result as $row){
        $myArray[] = $row;
        
    }
    $if_rating = json_decode($if_rating);
    $wx = 1;
    $tempContainer = array();
     $result = $stmt->fetchAll();
    foreach($if_rating as $row){
        $tempContainer["interrating".$wx] =  $row;
        $row;
        $wx++;
    }
    // echo "<pre>";
    // print_r(array_count_values($tempContainer));
    $acvtc = array_count_values($tempContainer);
    $acvtc_min =  min($acvtc);
    $acvtc_max =  max($acvtc);
    $min_label = array_search($acvtc_min,$acvtc);
    $max_label =array_search($acvtc_max,$acvtc);
 

    if(empty($myArray)) {
        $if_has_content = 0;
    }
    else{
        // $json = file_get_contents('MOCK_DATA.json');
        $json = json_encode($myArray);
        $data = json_decode($json,true);
        $if_has_content = 1;
    }

     $pdf->Image('../../assets/img/logo/header.png',1,1,208);
     $pdf->SetFont('Times','B',12);
     $pdf->Cell(80);
    $pdf->Cell(120,35,"",0,1,'');
    $pdf->Cell(0,5,"ALULOD ELEMENTARY SCHOOL",0,1,'C');
    $pdf->Cell(0,5,"COT-RPMS",0,1,'C');
    $pdf->Cell(0,5,"TEACHER I-III",0,1,'C');
    $pdf->Cell(0,5,"INTER-OBSERVER AGREEMENT FORM",0,1,'C');
    $pdf->Cell(145,5,"OBSERVER 1: ",0,0,'');
    $pdf->Cell(0,5,"DATE: ",0,1,'');
    $pdf->Cell(0,5,"OBSERVER 2: ",0,1,'');
    $pdf->Cell(0,5,"OBSERVER 3: ",0,1,'');
    $pdf->Cell(0,5,"TEACHER OBSERVED: ",0,1,'');
    $pdf->Cell(0,5,"SUBJECT AND GRADE LEVEL TAUGHT: ",0,1,'');
    $pdf->Cell(0,5,"OBSERVATION: ",0,1,'');
    $pdf->Cell(0,5,"DIRECTIONS FOR THE OBSERVER: ",0,1,'');

    $pdf->Cell(0,-35,"",0,1,'');
    $pdf->SetFont('Times','',9);
    $pdf->Cell(35);
    $pdf->Cell(125,5,$observer,0,0,'');
    $pdf->Cell(0,5,strtoupper($ifr_Date),0,1,'');
    $pdf->Cell(35);
    $pdf->Cell(0,5,$print->get_visitorName($observer_IDs->ob1),0,1,''); 
    $pdf->Cell(35);
    $pdf->Cell(0,5,$print->get_visitorName($observer_IDs->ob2),0,1,''); 
    $pdf->Cell(50);
    $pdf->Cell(0,5,strtoupper($obseved),0,1,'');
    $pdf->Cell(85);
    $pdf->Cell(0,5,strtoupper($subject_level),0,1,'');
    $pdf->Cell(38);
    $pdf->Cell(0,5,strtoupper($period_Name),0,1,'');
    $pdf->Cell(0,5,"",0,1,'');
    $pdf->Cell(0,5,"1. Indicate your individual rating for each indicator.",0,1,'');
    $pdf->Cell(0,5,"2. Discuss with in the group your reason(s) for such rating. In case of different ratings, the observers
must resolve the differences and ",0,1,'');$pdf->Cell(4);
     $pdf->Cell(0,5,"come up with an agreed rating.  The final rating is not an average; it
is a final rating based on reasoned and consensual judgement.",0,1,'');
    $pdf->Cell(0,5,"3. Attach all Individual Rating Sheets to this Inter-observer Agreement Form.",0,1,'');
    $pdf->SetFont('Times','B',9);
    $pdf->Cell(40,5,"HIGHEST SCORE: ",0,0,'');
    $pdf->Cell(0,5,"LOWEST SCORE: ",0,1,'');
     $pdf->SetFont('Times','',9);
    $pdf->Cell(0,-5,"",0,1,'');
    $pdf->Cell(30);
    $pdf->Cell(40,5,$max_label,0,0,'');
    $pdf->Cell(0,5,$min_label,0,1,'');
    $pdf->Cell(0,5," ",0,1,'');

    $pdf->SetFont('Times','',9);
    $pdf->Cell(120,5,"THE TEACHER",1,0,'');
    $pdf->Cell(10,5,"3",1,0,'C');
    $pdf->Cell(10,5,"4",1,0,'C');
    $pdf->Cell(10,5,"5",1,0,'C');
    $pdf->Cell(10,5,"6",1,0,'C');
    $pdf->Cell(10,5,"7",1,0,'C');
    $pdf->Cell(25,5,"No Observed",1,0,'C');
    $pdf->Ln();
    $pdf->SetFont('Arial','',9);


    $ixz = 1;
    function rating_check($increment,$position,$rating_content){
        if($rating_content["interrating".$increment] == $position){
            $a = " / ";
        }
        else{
            $a = " ";
        }
        return $a;
    }

    if ($if_has_content != 0) {
        //loop the data
        foreach($data as $item){
            //write data using Row() method containing array of values.
            $pdf->Row(Array(
                $ixz.".) ".$item['fc_Desc'],
                rating_check($ixz,"3",$tempContainer),
                rating_check($ixz,"4",$tempContainer),
                rating_check($ixz,"5",$tempContainer),
                rating_check($ixz,"6",$tempContainer),
                rating_check($ixz,"7",$tempContainer),
                rating_check($ixz,"NO",$tempContainer),
            ));
            $ixz++;
        }
    }
    $pdf->Cell(0,15,"",0,1,'');
    $pdf->Cell(22,5,"",0,0,'C');
    $pdf->Cell(45,5,strtoupper($observer),0,0,'C');
    $pdf->Cell(5,5,"",0,0,'C');
    $pdf->Cell(45,5,$print->get_visitorName($observer_IDs->ob1),0,0,'C');
    $pdf->Cell(5,5,"",0,0,'C');
    $pdf->Cell(45,5,$print->get_visitorName($observer_IDs->ob2),0,1,'C');
    $pdf->Cell(22,-3,"",0,0,'C');
    $pdf->Cell(45,-3,"_____________________",0,0,'C');
    $pdf->Cell(5,-3,"",0,0,'C');
    $pdf->Cell(45,-3,"_____________________",0,0,'C');
    $pdf->Cell(5,-3,"",0,0,'C');
    $pdf->Cell(45,-3,"_____________________",0,1,'C');
    $pdf->Cell(90,3,"",0,0,'C');
    $pdf->Cell(90,3,"",0,1,'C');
    $pdf->Cell(0,3,"",0,1,'C');
    $pdf->Cell(22,5,"",0,0,'C');
    $pdf->Cell(45,5,"Signature over Printed Name",0,0,'C');
    $pdf->Cell(5,5,"",0,0,'C');
    $pdf->Cell(45,5,"Signature over Printed Name",0,0,'C');
    $pdf->Cell(5,5,"",0,0,'C');
    $pdf->Cell(45,5,"Signature over Printed Name",0,1,'C');
    $pdf->Cell(22,5,"",0,0,'C');
    $pdf->Cell(45,5,"of Observer 1 ",0,0,'C');
    $pdf->Cell(5,5,"",0,0,'C');
    $pdf->Cell(45,5,"of Observer 2 ",0,0,'C');
    $pdf->Cell(5,5,"",0,0,'C');
    $pdf->Cell(45,5,"of Observer 3 ",0,1,'C');

    $pdf->Cell(0,5,"",0,1,'C');
    $pdf->Cell(0,5,strtoupper($obseved),0,1,'C');
    $pdf->Cell(0,-3,"_____________________",0,1,'C');
    $pdf->Cell(0,5,"",0,1,'C');
    $pdf->Cell(0,5,"Signature over Printed Name of the Teacher ",0,1,'C');

    $pdf->AddPage();
    $pdf->Image('../../assets/img/logo/header.png',1,1,208);
    $pdf->SetFont('Times','B',12);
    $pdf->Cell(80);
    $pdf->Cell(120,35,"",0,1,'');
    $pdf->Cell(0,5,"ALULOD ELEMENTARY SCHOOL",0,1,'C');
    $pdf->Cell(0,5,"COT-RPMS",0,1,'C');
    $pdf->Cell(0,5,"TEACHER I-III",0,1,'C');
    $pdf->Cell(0,5,"OVSERVATION NOTE",0,1,'C');
    $pdf->Cell(145,5,"OBSERVER 1: ",0,0,'');
    $pdf->Cell(0,5,"DATE: ",0,1,'');
    $pdf->Cell(0,5,"OBSERVER 2: ",0,1,'');
    $pdf->Cell(0,5,"OBSERVER 3: ",0,1,'');
    $pdf->Cell(0,5,"TEACHER OBSERVED: ",0,1,'');
    $pdf->Cell(0,5,"SUBJECT AND GRADE LEVEL TAUGHT: ",0,1,'');
    $pdf->Cell(0,5,"OBSERVATION: ",0,1,'');
    $pdf->Cell(0,5,"DIRECTIONS FOR THE OBSERVER: ",0,1,'');

    $pdf->Cell(0,-35,"",0,1,'');
    $pdf->SetFont('Times','',9);
    $pdf->Cell(35);
    $pdf->Cell(125,5,$observer,0,0,'');
    $pdf->Cell(0,5,strtoupper($ifr_Date),0,1,'');
    $pdf->Cell(35);
    $pdf->Cell(0,5,$print->get_visitorName($observer_IDs->ob1),0,1,''); 
    $pdf->Cell(35);
    $pdf->Cell(0,5,$print->get_visitorName($observer_IDs->ob2),0,1,''); 
    $pdf->Cell(50);
    $pdf->Cell(0,5,strtoupper($obseved),0,1,'');
    $pdf->Cell(85);
    $pdf->Cell(0,5,strtoupper($subject_level),0,1,'');
    $pdf->Cell(38);
    $pdf->Cell(0,5,strtoupper($period_Name),0,1,'');
    $pdf->Cell(0,5,"",0,1,'');
    $pdf->Cell(0,5,"GENERAL OBSERVATION",1,1,'');
    $pdf->Cell(0,115,"",1,1,'');

   $pdf->Cell(0,15,"",0,1,'');
    $pdf->Cell(22,5,"",0,0,'C');
    $pdf->Cell(45,5,strtoupper($observer),0,0,'C');
    $pdf->Cell(5,5,"",0,0,'C');
    $pdf->Cell(45,5,$print->get_visitorName($observer_IDs->ob1),0,0,'C');
    $pdf->Cell(5,5,"",0,0,'C');
    $pdf->Cell(45,5,$print->get_visitorName($observer_IDs->ob2),0,1,'C');
    $pdf->Cell(22,-3,"",0,0,'C');
    $pdf->Cell(45,-3,"_____________________",0,0,'C');
    $pdf->Cell(5,-3,"",0,0,'C');
    $pdf->Cell(45,-3,"_____________________",0,0,'C');
    $pdf->Cell(5,-3,"",0,0,'C');
    $pdf->Cell(45,-3,"_____________________",0,1,'C');
    $pdf->Cell(90,3,"",0,0,'C');
    $pdf->Cell(90,3,"",0,1,'C');
    $pdf->Cell(0,3,"",0,1,'C');
    $pdf->Cell(22,5,"",0,0,'C');
    $pdf->Cell(45,5,"Signature over Printed Name",0,0,'C');
    $pdf->Cell(5,5,"",0,0,'C');
    $pdf->Cell(45,5,"Signature over Printed Name",0,0,'C');
    $pdf->Cell(5,5,"",0,0,'C');
    $pdf->Cell(45,5,"Signature over Printed Name",0,1,'C');
    $pdf->Cell(22,5,"",0,0,'C');
    $pdf->Cell(45,5,"of Observer 1 ",0,0,'C');
    $pdf->Cell(5,5,"",0,0,'C');
    $pdf->Cell(45,5,"of Observer 2 ",0,0,'C');
    $pdf->Cell(5,5,"",0,0,'C');
    $pdf->Cell(45,5,"of Observer 3 ",0,1,'C');
     $pdf->Cell(0,5,"",0,1,'C');
    $pdf->Cell(0,5,strtoupper($obseved),0,1,'C');
    $pdf->Cell(0,-3,"_____________________",0,1,'C');
    $pdf->Cell(0,5,"",0,1,'C');
    $pdf->Cell(0,5,"Signature over Printed Name of the Teacher ",0,1,'C');
    $pdf->Cell(0,-155,"",0,1,'C');
    $pdf->Cell(0,5,$general_observations,0,1,'');
  
}//if ($report == "inter-observer-sheet")

if ($report == "overall"){

    $pdf->SetTitle("Overall Report");  
    $sqlx = "SELECT * FROM `academic_staff` WHERE sem_ID = ".$_REQUEST["academic_year"];
    $stmtx = $print->runQuery($sqlx);
    $stmtx->execute();
    $resultx = $stmtx->fetchAll();

    $sql = " SELECT * FROM `forms_content` frc
    LEFT JOIN forms f ON f.form_ID = frc.form_ID  WHERE f.sem_ID = '".$_REQUEST["academic_year"]."'";
        
    $stmt = $print->runQuery($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();


 


    foreach($result as $row){
        $myArray[] = $row;
        
    }
   
  
 

    if(empty($myArray)) {
        $if_has_content = 0;
    }
    else{
        // $json = file_get_contents('MOCK_DATA.json');
        $json = json_encode($myArray);
        $data = json_decode($json,true);
        $if_has_content = 1;
    }
    
    $pdf->SetFont('Times','B',12);
    $pdf->Cell(0,5,"SUMMARY OF TEACHERS ANNUAL EVALUATIONS",0,1,'C');
    $pdf->SetFont('Times','',7);
    $pdf->Cell(30,10," ",0,1,'C');
    $pdf->Cell(30,25," ",1,0,'C');
    $pdf->Cell(30,25," ",1,0,'C');
    $pdf->Cell(60,25," ",1,0,'C');
    $pdf->Cell(65,25," ",1,0,'C');
    $pdf->Cell(65,25," ",1,0,'C');
    $pdf->Cell(65,25," ",1,1,'C');

    $pdf->Cell(30,-40,"TEACHERS NAME",0,0,'C');
    $pdf->Cell(30,-40,"GOVERNMENT ID",0,0,'C');
    $pdf->Cell(60,-40,"THE TEACHER",0,0,'C');
    $pdf->Cell(65,-40,"PRINCIPAL'S EVALUATION ",0,0,'C');
    $pdf->Cell(65,-40,"VISITOR'S EVALUATION ",0,0,'C');
    $pdf->Cell(65,-40,"INDIVIDUAL PERFORMANCE EVALUATION",0,1,'C');

    $pdf->Cell(65,40," ",0,1,'C');
    $pdf->Cell(30,25," ",0,0,'C');
    $pdf->Cell(30,25," ",0,0,'C');
    $pdf->Cell(60,25," ",0,0,'C');
    $pdf->Cell(16.25,-15,"", 1,0,'C');
    $pdf->Cell(16.25,-15," ",1,0,'C');
    $pdf->Cell(16.25,-15," ",1,0,'C');
    $pdf->Cell(16.25,-15," ",1,0,'C');
    $pdf->Cell(16.25,-15," ",1,0,'C');
    $pdf->Cell(16.25,-15," ",1,0,'C');
    $pdf->Cell(16.25,-15," ",1,0,'C');
    $pdf->Cell(16.25,-15,"",1,0,'C');
    $pdf->Cell(32.5,-15," ",1,0,'C');
    $pdf->Cell(32.5,-15," ",1,1,'C');
    $pdf->Cell(65,15," ",0,1,'C');



    $pdf->Cell(65,-5," ",0,1,'C');
    $pdf->Cell(30,-5," ",0,0,'C');
    $pdf->Cell(30,-5," ",0,0,'C');
    $pdf->Cell(60,-5," ",0,0,'C');
    $pdf->CellFitSpace(16.25,-5,"OBSERVATION",0,0,'C');
    $pdf->CellFitSpace(16.25,-5,"OBSERVATION",0,0,'C');
    $pdf->CellFitSpace(16.25,-5,"OBSERVATION",0,0,'C');
    $pdf->CellFitSpace(16.25,-5,"OBSERVATION",0,0,'C');
    $pdf->CellFitSpace(16.25,-5,"OBSERVATION",0,0,'C');
    $pdf->CellFitSpace(16.25,-5,"OBSERVATION",0,0,'C');
    $pdf->CellFitSpace(16.25,-5,"OBSERVATION",0,0,'C');
    $pdf->CellFitSpace(16.25,-5,"OBSERVATION",0,0,'C');
    $pdf->Cell(32.5,-5,"",0,0,'C');
    $pdf->Cell(32.5,-5,"",0,1,'C');

    $pdf->Cell(65,0," ",0,1,'C');
    $pdf->Cell(30,0," ",0,0,'C');
    $pdf->Cell(30,0," ",0,0,'C');
    $pdf->Cell(60,0," ",0,0,'C');
    $pdf->Cell(16.25,0,"FIRST",0,0,'C');
    $pdf->Cell(16.25,0,"SECOND",0,0,'C');
    $pdf->Cell(16.25,0,"THIRD",0,0,'C');
    $pdf->Cell(16.25,0,"FOURTH",0,0,'C');
    $pdf->Cell(16.25,0,"FIRST",0,0,'C');
    $pdf->Cell(16.25,0,"SECOND",0,0,'C');
    $pdf->Cell(16.25,0,"THIRD",0,0,'C');
    $pdf->Cell(16.25,0,"FOURTH",0,0,'C');
    $pdf->Cell(32.5,0,"RATING",0,0,'C');
    $pdf->Cell(32.5,0,"ADJECTIVAL RATING",0,1,'C');

    $pdf->Cell(65,5," ",0,1,'C');
    $pdf->Cell(30,5," ",0,0,'C');
    $pdf->Cell(30,5," ",0,0,'C');
    $pdf->Cell(60,5," ",0,0,'C');
    $pdf->Cell(16.25,5,"Score",1,0,'C');
    $pdf->Cell(16.25,5,"Score ",1,0,'C');
    $pdf->Cell(16.25,5,"Score ",1,0,'C');
    $pdf->Cell(16.25,5,"Score ",1,0,'C');
    $pdf->Cell(16.25,5,"Score ",1,0,'C');
    $pdf->Cell(16.25,5,"Score ",1,0,'C');
    $pdf->Cell(16.25,5,"Score ",1,0,'C');
    $pdf->Cell(16.25,5,"Score ",1,0,'C');
    $pdf->Cell(32.5,5," ",0,0,'C');
    $pdf->Cell(32.5,5," ",0,1,'C');
    $pdf->Cell(32.5,5," ",0,1,'C');

      // $pdf->Cell(65,0," ",0,1,'C');
    $pdf->Cell(30,-5," ",0,0,'C');
    $pdf->Cell(30,-5," ",0,0,'C');
    $pdf->Cell(60,-5," ",0,0,'C');
    $pdf->Cell(16.25,-5,"",0,0,'C');
    $pdf->Cell(16.25,-5,"",0,0,'C');
    $pdf->Cell(16.25,-5,"",0,0,'C');
    $pdf->Cell(16.25,-5,"",0,0,'C');
    $pdf->Cell(16.25,-5,"",0,0,'C');
    $pdf->Cell(16.25,-5,"",0,0,'C');
    $pdf->Cell(16.25,-5,"",0,0,'C');
    $pdf->Cell(16.25,-5,"",0,0,'C');
    $pdf->Cell(32.5,-5,"",0,0,'C');
    $pdf->Cell(32.5,-5," ",0,1,'C');
     $sql = "SELECT 
CONCAT(rtd.tcd_LName,', ',rtd.tcd_FName,' ',LEFT(rtd.tcd_MName,1),'. ',(SELECT IF(rsn.suffix = 'NA',rsn.suffix,'')) ) teachername,
rtd.tcd_SchID,
acs.acs_ID
FROM `academic_staff` acs 
LEFT JOIN record_teacher_details rtd ON rtd.tcd_ID = acs.tcd_ID
LEFT JOIN ref_subject rsub ON rsub.subject_ID = acs.subject_ID
LEFT JOIN ref_suffixname rsn ON rsn.suffix_ID = rtd.suffix_ID
LEFT JOIN ref_year_level ryl ON ryl.yl_ID = acs.yl_ID
WHERE acs.sem_ID = '".$_REQUEST["academic_year"]."'";
$stmtzd = $print->runQuery($sql);
$stmtzd->execute();
$resultzd = $stmtzd->fetchAll();
$stmtCount = $stmtzd->rowCount();
$i = 1;
$fo= array();
foreach($resultzd as $row){



        
       
        $ixz = 1;
        $pdf->Cell(30,5,strtoupper($row["teachername"]),0,0,'C');
        $pdf->Cell(30,5,$row["tcd_SchID"],0,0,'C');
        $pdf->Cell(190,5,"",0,0,'C');//a
        $pdf->Cell(32.5,5,$print->getIndivualRating($row["acs_ID"],"rating"),0,0,'C');
        $pdf->Cell(32.5,5,$print->getIndivualRating($row["acs_ID"],"adjrating"),0,1,'C');

        $pdf->Cell(0,-5," ",0,1,'C');
        if ($if_has_content != 0) {
            //loop the data
            foreach($data as $item){
               // $pdf->Cell(60);
              
                $Fr_First = $print->getRating($row["acs_ID"],"First",$ixz);
                $Fr_Second = $print->getRating($row["acs_ID"],"Second",$ixz);
                $Fr_Third = $print->getRating($row["acs_ID"],"Third",$ixz);
                $Fr_Fourth = $print->getRating($row["acs_ID"],"Fourth",$ixz);


                $Ifr_First = $print->getInterRating($row["acs_ID"],"First",$ixz);
                $Ifr_Second = $print->getInterRating($row["acs_ID"],"Second",$ixz);
                $Ifr_Third = $print->getInterRating($row["acs_ID"],"Third",$ixz);
                $Ifr_Fourth = $print->getInterRating($row["acs_ID"],"Fourth",$ixz);

                $pdf->Row(Array(
                  
                    "",
                    "",
                    $ixz.".) ".$item['fc_Desc'],
                    $Fr_First,
                    $Fr_Second,
                    $Fr_Third,
                    $Fr_Fourth,
                    $Ifr_First,
                    $Ifr_Second,
                    $Ifr_Third,
                    $Ifr_Fourth,
                    "",
                    "",
                ));




                $ixz++;
            }
        }
        if($i < $stmtCount){
          
          $pdf->AddPage('L','Legal');
    $pdf->SetFont('Times','B',12);
    $pdf->Cell(0,5,"SUMMARY OF TEACHERS ANNUAL EVALUATIONS",0,1,'C');
    $pdf->SetFont('Times','',7);
    $pdf->Cell(30,10," ",0,1,'C');
        }
       
        $i++;
}


    // $ixz = 1;
    //   $xh = 5;

    // foreach($data as $item){

    //  $pdf->CellFitCustom(60,5,$ixz.".) ".$item['fc_Desc'],1,1);
    
    // }
      
         
      
     

  // 

}//if ($report == "overall")
 

// echo "<pre>";
// print_r($item);
//output the pdf
$pdf->Output();






