  <?php 
include('../session.php');


require_once("../class.user.php");

  
$auth_user = new USER();
// $page_level = 3;
// $auth_user->check_accesslevel($page_level);
$pageTitle = "Teacher Information";
$gas = $auth_user->get_active_sem();
foreach($gas as $row){
  $active_sem_ID = $row["sem_ID"];
  $active_sem_year = $row["sem_year"];
}
?>
<!doctype html>
<html lang="en">
  <head>
    <?php 
      include('x-meta.php');
    ?>


  <?php 
  include('x-css.php');
  ?>
 



    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      .nav-tabs .nav-link.active {
         background-color: #6c757d;
       }
       .nav-tabs .nav-link {
         background-color: #383d41;
       }
    </style>
    <!-- Custom styles for this template -->
    <link href="../assets/css/dashboard.css" rel="stylesheet">
  </head>
  <body>
<?php 
include('x-nav.php');
?>

<div class="container-fluid">
  <div class="row">
      <?php 
    include('x-sidenav.php');
    ?>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        
        
      </div>
<?php 

$stmt = $auth_user->runQuery("SELECT 
 *,
  LEFT(tcd_MName,1) tcd_MNamex,
  TIMESTAMPDIFF(YEAR, rtd.tcd_Bday,CURDATE()) AS Age
FROM `academic_staff` `acs` 
LEFT JOIN `record_teacher_details` `rtd` ON `rtd`.`tcd_ID` = `acs`.`tcd_ID`
LEFT JOIN `ref_suffixname` `rsn` ON `rsn`.`suffix_ID` = `rtd`.`suffix_ID`
LEFT JOIN `ref_subject` `rsub` ON `rsub`.`subject_ID` = `acs`.`subject_ID`
LEFT JOIN `ref_year_level` `ryl` ON `ryl`.`yl_ID` = `acs`.`yl_ID`
LEFT JOIN `ref_position` `rpos` ON `rpos`.`pos_ID` = `acs`.`pos_ID`
LEFT JOIN `ref_semester` `rsem` ON `rsem`.`sem_ID` = `acs`.`sem_ID`
LEFT JOIN `ref_marital` `rmar` ON `rmar`.`marital_ID` = `rtd`.`marital_ID`
LEFT JOIN `ref_sex` `s` ON `s`.`sex_ID` = `rtd`.`sex_ID`
 WHERE acs_ID  = '".$_REQUEST["staff_ID"]."' 
      LIMIT 1");
  $stmt->execute();
  $result = $stmt->fetchAll();
  foreach($result as $row)
  {
    
    if($row["suffix"] =="N/A")
    {
      $suffix = "";
    }
    else
    {
      $suffix = $row["suffix"];
    }
    if (!empty($row['tcd_Img'])) {
    $xsimg = 'data:image/jpeg;base64,'.base64_encode($row['tcd_Img']);
   }
   else{
     $xsimg = "../assets/img/users/default.jpg";
   }
    $output['tcd_Img'] = $xsimg;
  
    
    $output["acs_ID"] = $row["acs_ID"];
    $output["tcd_SchID"] = $row["tcd_SchID"];
    $output["staff_name"] =  $row["tcd_LName"].', '.$row["tcd_FName"].' '.$row["tcd_MNamex"].'.  '.$suffix;
    $output["pos_Name"] = $row["pos_Name"];
    $output["subject_Title"] = $row["subject_Title"];
    $output["tcd_Bday"] = $row["tcd_Bday"];
    $output["age"] = $row["Age"];
    $output["marital_Name"] = $row["marital_Name"];
    $output["tcd_Address"] = $row["tcd_Address"];
    $output["yl_Name"] = $row["yl_Name"];
    $output["sex_Name"] = $row["sex_Name"];
    
  
  }
?>
      <div class="table-responsive">
         <div class="container-fluid">
        <div class="row my-1">
            <div class="col-lg-4 my-2">
                <div class="card rounded-0 bg-primary">
                    <div class="card-body text-center">
                        <div class="card rounded-circle" style="max-width: 10rem; margin: auto;">
                            <img src="<?php echo $output['tcd_Img']?>" class="img-fluid rounded-circle" style="height: 10rem;">
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <p class="card-title">Evaluate, <?php echo $output["staff_name"]?> ?</p>
                     
                        <ul class="list-group list-group-flush">
                          <?php if(
                            $auth_user->principal_level() || 
                            $auth_user->teacher_level()){?>
                          <li class="list-group-item rating_sheet"><img src="../assets/img/Icons/evaluate.png" > <small>RATING SHEET</small></li>
                          <li class="list-group-item rating_sheetnote" ><img src="../assets/img/Icons/evaluate.png"> <small>OBSERVATION NOTES</small></li>
                          <?php }?>
                          <?php if($auth_user->visitor_level()){?>
                         <li class="list-group-item interrating_sheet" ><img src="../assets/img/Icons/evaluate.png"> <small>INTER-OBSERVER AGREEMENT</small></li>
                          <?php }?>
                           <?php if($auth_user->principal_level()){?>
                         <li class="list-group-item view_summary" ><img src="../assets/img/Icons/evaluate.png"> <small>VIEW SUMMARY</small></li>
                          <?php }?>
                          <li class="list-group-item pastevaluation" ><img src="../assets/img/Icons/past_evaluation.png"> <small>VIEW PAST EVALUATIONS</small></li>
                          

                        </ul>
                    </div>
                </div>
            
            </div>
            <div class="col-lg-8 my-2">
                <div class="card rounded-0">
                    <div class="card-body">
                        <h4 class="display-4"><?php echo $output["staff_name"]?></h4><hr>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="lead"><b>Government ID : </b><?php echo $output["tcd_SchID"]?></p>
                                <p class="lead"><b>Sex : </b><?php echo $output["sex_Name"]?></p>
                                <p class="lead"><b>Birth Date : </b><?php echo $output["tcd_Bday"]?></p>
                                <p class="lead"><b>Age : </b><?php echo $output["age"]?> years old</p>
                                <p class="lead"><b>Marital Status : </b><?php echo $output["marital_Name"]?></p>
                                <p class="lead"><b>Address : </b><?php echo $output["tcd_Address"]?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="lead"><b>Subject Taught : </b><?php echo $output["subject_Title"]?></p>
                                <p class="lead"><b>Grade Taught : </b><?php echo $output["yl_Name"]?></p>
                                <p class="lead"><b>Position : </b><?php echo $output["pos_Name"]?></p>
                                <!-- <p class="lead"><b>Account Status : </b><?php echo $output["pos_Name"]?></p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




<!-- Modal -->
<div class="modal fade" id="rating_sheet" tabindex="-1" role="dialog" aria-labelledby="rating_sheet" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Rating Sheet</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <B>DIRECTIONS FOR THE OBSERVER:</B>

<li>Rate each item on the checklist according to how well the teacher performed during the classroom observation.</li>
<li>Each indicator is assessed on an individual basis, regardless of its relationship to other indicators.</li>
<li>Attached your observation Notes Form to the completed rating sheet.</li>
<B>OBSERVATION: </B> <div id="rating_period_label">FIRST</div>
    <form method="post" id="ratingsheet_form" enctype="multipart/form-data">
    <table class="table table-bordered">
      <thead>
          <tr>
              <th width="70%">THE TEACHER</th>
              <th class="text-center" width="5%">3</th>
              <th class="text-center" width="5%">4</th>
              <th class="text-center" width="5%">5</th>
              <th class="text-center" width="5%">6</th>
              <th class="text-center" width="5%">7</th>
              <th class="text-center" width="5%">Not Observed</th>
          </tr>
      </thead>
      <tbody>
        <?php 
           $rquery = "SELECT * FROM `forms_content` fc
            LEFT JOIN forms fm ON fm.form_ID = fc.form_ID
            WHERE fm.sem_ID =  ".$active_sem_ID." ";
                $statementr = $auth_user->runQuery($rquery);
                $statementr->execute();
                $resultr = $statementr->fetchAll();
                $x_r = 1;
                foreach($resultr as $row){
                  ?>
                   <tr>
                        <td width="70%"><?php echo $x_r.'.) '.$row["fc_Desc"];?></td>
                        <td width="5%">
                          <div class="form-check ">
                            <input class="form-check-input" type="radio" name="rating<?php echo $x_r?>" id="inlineRadio<?php echo $x_r?>" value="3" required="">
                          </div>
                        </td>
                        <td width="5%">
                          <div class="form-check ">
                            <input class="form-check-input" type="radio" name="rating<?php echo $x_r?>" id="inlineRadio<?php echo $x_r?>" value="4" required="">
                          </div>
                        </td>
                        <td width="5%">
                          <div class="form-check ">
                            <input class="form-check-input" type="radio" name="rating<?php echo $x_r?>" id="inlineRadio<?php echo $x_r?>" value="5" required="">
                          </div>
                        </td>
                        <td width="5%">
                          <div class="form-check ">
                            <input class="form-check-input" type="radio" name="rating<?php echo $x_r?>" id="inlineRadio<?php echo $x_r?>" value="6" required="">
                          </div>
                        </td>
                        <td width="5%">
                          <div class="form-check ">
                            <input class="form-check-input" type="radio" name="rating<?php echo $x_r?>" id="inlineRadio<?php echo $x_r?>" value="7" required="">
                          </div>
                        </td>
                        <td width="5%">
                          <div class="form-check ">
                            <input class="form-check-input" type="radio" name="rating<?php echo $x_r?>" id="inlineRadio<?php echo $x_r?>" value="NO" required="">
                          </div>
                        </td>
                    </tr>
                  <?php

                    $x_r++;
                }

        ?>
        <tr>
          <th  colspan="7">OTHER COMMENTS:</th>
          
        </tr>
        <tr>
          <td  colspan="7">
            <textarea class="form-control" name="rating_comment" id="rating_comment" style="min-height:250px;" required=""></textarea>
          </td>
        </tr>
      </tbody>
    </table>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="rating_formID" id="rating_formID" value="<?php echo $output["form_ID"] = $row["form_ID"]?>">
        <input type="hidden" name="rating_period" id="rating_period" value="1">
        <input type="hidden" name="rating_teacher" id="rating_teacher" value="<?php echo  $output["acs_ID"]?>">
        <input type="hidden" name="operation" id="operation_rating" value="submit_ratingsheet">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary submit_ratingsheet" id="submit_input_rating" value="submit_ratingsheet">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>
    <!-- Modal -->
<div class="modal fade" id="rating_sheet_note" tabindex="-1" role="dialog" aria-labelledby="rating_sheet_note" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Observation Note</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form method="post" id="ratingsheetnote_form" enctype="multipart/form-data">
      <div class="modal-body">
    <B>OBSERVATION: </B> <div id="ratingnote_period_name">FIRST</div>
        <div class="form-row">
          <div class="form-group col-md-12">
              <label for="visitor_mname">GENERAL OBSERVATIONS<span class="text-danger">*</span></label>
              <textarea class="form-control" name="ratingnote_desc" placeholder="Enter general observation here.." style="min-height:250px"></textarea>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="rating_formID" id="ratingnote_formID" value="<?php echo $output["form_ID"]?>">
        <input type="hidden" name="ratingnote_period" id="ratingnote_period" value="1">
        <input type="hidden" name="rating_teacher" id="rating_teacher" value="<?php echo  $output["acs_ID"]?>">
        
        <input type="hidden" name="operation" id="operation_ratingnote" value="submit_ratingsheetnote">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary submit_ratingsheetnote" id="submit_input_ratingnote" value="submit_ratingsheetnote">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="rating_sheet_inter" tabindex="-1" role="dialog" aria-labelledby="rating_sheet_inter" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">INTER-OBSERVER AGREEMENT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <form method="post" id="interrating_form" enctype="multipart/form-data">
      <div class="modal-body">
          <B>DIRECTIONS FOR THE OBSERVER:</B>

<li>Indicate your individual rating to each indicator.</li>
<li>Discuss within the group your reason(s) for such rating. In case of different ratings, the observers must resolve the differences and come up with an agreed rating. The final rating is not an average; it is a final rating based on reasoned and consensual judgement.</li>
<li>Attach all individual Rating Sheets to this Inter-observer Agreement Form.</li>
<B>OBSERVATION: </B> <div id="interrating_period_name">FIRST</div>
<BR>

<B>OBSERVER 2: </B> <div class="col-sm-4 input-group mb-3">
  <input type="text" class="form-control" placeholder="Observer's Name" aria-label="Observer's Name" aria-describedby="basic-addon2" id="interrating_ob2_name" name="interrating_ob2_name"  readonly>
  <input type="hidden" class="form-control"  name="interrating_ob2_id" id="interrating_ob2_id" required="">
  <div class="input-group-append">
    <span class="input-group-text bg-primary text-white browse_observer_2" id="basic-addon2">Browse</span>
  </div>
</div>
<B>OBSERVER 3: </B> 

<div class="col-sm-4 input-group mb-3">
  <input type="text" class="form-control" placeholder="Observer's Name" aria-label="Observer's Name" aria-describedby="basic-addon2" id="interrating_ob3_name" name="interrating_ob3_name"  readonly>
  <input type="hidden" class="form-control"  name="interrating_ob3_id" id="interrating_ob3_id" required="">
  <div class="input-group-append">
    <span class="input-group-text bg-primary text-white browse_observer_3" id="basic-addon2">Browse</span>
  </div>
</div>
    <table class="table table-bordered">
      <thead>
          <tr>
              <th width="70%">THE TEACHER</th>
              <th class="text-center" width="5%">3</th>
              <th class="text-center" width="5%">4</th>
              <th class="text-center" width="5%">5</th>
              <th class="text-center" width="5%">6</th>
              <th class="text-center" width="5%">7</th>
              <th class="text-center" width="5%">Not Observed</th>
          </tr>
      </thead>
      <tbody>
        <?php 
           $rquery = "SELECT * FROM `forms_content` fc
            LEFT JOIN forms fm ON fm.form_ID = fc.form_ID
            WHERE fm.sem_ID =  ".$active_sem_ID." ";
                $statementr = $auth_user->runQuery($rquery);
                $statementr->execute();
                $resultr = $statementr->fetchAll();
                $x_r = 1;
                foreach($resultr as $row){
                  ?>
                   <tr>
                        <td width="70%"><?php echo $x_r.'.) '.$row["fc_Desc"];?></td>
                        <td width="5%">
                          <div class="form-check ">
                            <input class="form-check-input" type="radio" name="interrating<?php echo $x_r?>" id="inlineRadio<?php echo $x_r?>" value="3" required="">
                          </div>
                        </td>
                        <td width="5%">
                          <div class="form-check ">
                            <input class="form-check-input" type="radio" name="interrating<?php echo $x_r?>" id="inlineRadio<?php echo $x_r?>" value="4" required="">
                          </div>
                        </td>
                        <td width="5%">
                          <div class="form-check ">
                            <input class="form-check-input" type="radio" name="interrating<?php echo $x_r?>" id="inlineRadio<?php echo $x_r?>" value="5" required="">
                          </div>
                        </td>
                        <td width="5%">
                          <div class="form-check ">
                            <input class="form-check-input" type="radio" name="interrating<?php echo $x_r?>" id="inlineRadio<?php echo $x_r?>" value="6">
                          </div>
                        </td>
                        <td width="5%">
                          <div class="form-check ">
                            <input class="form-check-input" type="radio" name="interrating<?php echo $x_r?>" id="inlineRadio<?php echo $x_r?>" value="7" required="">
                          </div>
                        </td>
                        <td width="5%">
                          <div class="form-check ">
                            <input class="form-check-input" type="radio" name="interrating<?php echo $x_r?>" id="inlineRadio<?php echo $x_r?>" value="NO" required="">
                          </div>
                        </td>
                    </tr>
                  <?php

                    $x_r++;
                }
        ?>
         
      </tbody>
    </table>
      <div class="form-row">
          <div class="form-group col-md-12">
              <label for="interratingnote_desc">GENERAL OBSERVATIONS<span class="text-danger">*</span></label>
              <textarea class="form-control" name="interratingnote_desc" placeholder="Enter general observation here.." style="min-height:250px"></textarea>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="interrating_formID" id="interrating_formID" value="<?php echo $output["form_ID"] = $row["form_ID"]?>">
        <input type="hidden" name="interrating_period" id="interrating_period" value="1">
        <input type="hidden" name="interrating_teacher" id="interrating_teacher" value="<?php echo  $output["acs_ID"]?>">
        <input type="hidden" name="operation" id="operation_interrating" value="submit_interrating">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary submit_input_interrating" id="submit_input_interrating" value="submit_interrating">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="observer2_modal" tabindex="-1" role="dialog" aria-labelledby="observer2_modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Browse Observer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-striped table-sm" id="observer2_data">
          <thead>
            <tr>
              <th>#</th>
              <th>Government ID</th>
              <th>Name</th>
              <th>Sex</th>
              <th>Marital</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="observer3_modal" tabindex="-1" role="dialog" aria-labelledby="observer3_modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Browse Observer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <table class="table table-striped table-sm" id="observer3_data">
          <thead>
            <tr>
              <th>#</th>
              <th>Government ID</th>
              <th>Name</th>
              <th>Sex</th>
              <th>Marital</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<!-- Past Evaluation Modal -->
<div class="modal fade" id="pastevaluation_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Past Evaluation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
     
        <nav>
        <div class="nav nav-tabs xtabs" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-principal-tab" data-toggle="tab" href="#nav-principal" role="tab" aria-controls="nav-principal" aria-selected="true">Principal</a>
          <a class="nav-item nav-link" id="nav-visitor-tab" data-toggle="tab" href="#nav-visitor" role="tab" aria-controls="nav-visitor" aria-selected="false">Visitor</a>
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">

        <div class="tab-pane fade show active" id="nav-principal" role="tabpanel" aria-labelledby="nav-principal-tab">
          <div class="row">
              <div class="col-md-6">
                <section class="card rounded-0" style="background-color: #74b9ff;">
                    <section class="card-body text-white text-center">
                        <h4 class="display-5">Rating sheet</h4>
                    </section>
                </section>
                <br>
                 <table class="table table-striped table-sm" id="pastratingsheet_data_teacher">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Observer</th>
                        <th>Date</th>
                        <th>Period</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                 
                    </tbody>
                  </table>
              </div>

              <div class="col-md-6">
                <section class="card rounded-0" style="background-color: #ff7675;">
                    <section class="card-body text-white text-center">
                        <h4 class="display-5">Observation notes</h4>
                    </section>
                </section>
                <br>
                <table class="table table-striped table-sm" id="pastratingsheet_ob_data_teacher">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Observer</th>
                        <th>Date</th>
                        <th>Period</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                 
                    </tbody>
                  </table>
              </div>

          </div>
        </div>
        <div class="tab-pane fade" id="nav-visitor" role="tabpanel" aria-labelledby="nav-visitor-tab">
           <table class="table table-borderless table-sm" id="pastinterobserver_data_visitor">
              <thead>
                <tr>
                  <th></th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>

        </div>
        
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="viewmoreinter_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View More Inter-Observation Agreement</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body viewmoreinter_body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="viewsummary_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Summary Report</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body viewsummary_body" style="min-height:350px;">
        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-peval-tab" data-toggle="tab" href="#nav-peval" role="tab" aria-controls="nav-peval" aria-selected="true">Principal Evaluation</a>
            <a class="nav-item nav-link" id="nav-veval-tab" data-toggle="tab" href="#nav-veval" role="tab" aria-controls="nav-profile" aria-selected="false">Visitor Evaluation</a>
            <a class="nav-item nav-link" id="nav-ieval-tab" data-toggle="tab" href="#nav-ieval" role="tab" aria-controls="nav-contact" aria-selected="false">Individual Performance Evaluation</a>
          </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <!-- CONTENT OF PRINCIPAL EVALUATION -->
          <div class="tab-pane fade show active" id="nav-peval" role="tabpanel" aria-labelledby="nav-peval-tab"> 
            <div class="card rounded-0 text-white text-center mt-2" style="background-color: #6c757d;">
                    <div class="card-body">
                        <h5 class="display-5">RATING SHEET</h5>
                    </div>
                </div>
                <br>
            <table class="table table-bordered">
      <thead>
          <tr>
              <th width="70%">THE TEACHER</th>
              <th class="text-center" width="5%">FIRST OBSERVATION</th>
              <th class="text-center" width="5%">SECOND OBSERVATION</th>
              <th class="text-center" width="5%">THIRD OBSERVATION</th>
              <th class="text-center" width="5%">FOURTH OBSERVATION</th>
          </tr>
      </thead>
      <tbody>
        <?php 
           $rquery = "SELECT * FROM `forms_content` fc
            LEFT JOIN forms fm ON fm.form_ID = fc.form_ID
            WHERE fm.sem_ID =  ".$active_sem_ID." ";
                $statementr = $auth_user->runQuery($rquery);
                $statementr->execute();
                $resultr = $statementr->fetchAll();

                $zq1 = "SELECT fr.fr_Rating,pr.period_Name,fr.fr_Comment
                FROM `forms_rating` fr
                LEFT JOIN ref_period pr ON pr.period_ID = fr.period_ID
                WHERE fr.acs_ID = ".$_REQUEST["staff_ID"]." AND fr.form_ID = ".$output["form_ID"]."";
                $statementf = $auth_user->runQuery($zq1);
                $statementf->execute();
                $resultf = $statementf->fetchAll();
                // echo "<pre>";
                $fo = array();
                foreach($resultf as $row){
                  $rspid = $row["period_Name"];
                  
                  $rsfrr = json_decode($row["fr_Rating"]);
                  // echo "comment_".$rspid;
                  $fo["comment_".$rspid] = $row["fr_Comment"];
                  foreach($rsfrr as $ro1){
                     $fo[$rspid][] = $ro1;
                  }
                } 
                // echo "</pre>";
                $x_r = 1;
                foreach($resultr as $row){
                  ?>
                   <tr>
                        <td width="70%"><?php echo $x_r.'.) '.$row["fc_Desc"];?></td>
                        <td width="5%">
                          <div >
                            <?php 
                            if(isset($fo["First"])){
                             echo $fo["First"][$x_r-1];
                            }
                            ?>
                            
                          </div>
                        </td>
                        <td width="5%">
                          <div > 
                            <?php 
                            if(isset($fo["Second"])){
                               echo $fo["Second"][$x_r-1];
                            }
                            ?>
                            
                          </div>
                        </td>
                        <td width="5%">
                          <div >
                             <?php 
                            if(isset($fo["Third"])){
                              echo $fo["Third"][$x_r-1];
                            }
                            ?>
                          </div>
                        </td>
                        <td width="5%">
                          <div >
                             <?php 
                            if(isset($fo["Fourth"])){
                              echo $fo["Fourth"][$x_r-1];
                            }
                            ?>
                          </div>
                        </td>
                    </tr>
                  <?php

                    $x_r++;
                }
        ?>
         
      </tbody>
      <tfoot>
                            <tr>
                                <th colspan="5" class="bg-primary text-white">OTHER COMMENTS</th>
                            </tr>
                            <tr>
                          <th colspan="5" ><div class="text-primary">FIRST OBSERVATION :</div><br>
                                <?php 
                            if(isset($fo["comment_First"])){
                               echo $fo["comment_First"];
                            }
                            ?>
                          </th>
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                            </tr>
                            <tr>
                          <th colspan="5" ><div class="text-primary">SECOND OBSERVATION :</div><br>
                                <?php 
                            if(isset($fo["comment_Second"])){
                               echo $fo["comment_Second"];
                            }
                            ?>
                          </th>
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                            </tr>
                             <th colspan="5" ><div class="text-primary">THIRD OBSERVATION :</div><br>
                                <?php 
                            if(isset($fo["comment_Third"])){
                               echo $fo["comment_Third"];
                            }
                            ?>
                          </th>
                            <tr>
                                <td colspan="5"></td>
                            </tr>
                             <th colspan="5" ><div class="text-primary">FOURTH OBSERVATION :</div><br>
                                <?php 
                            if(isset($fo["comment_Fourth"])){
                               echo $fo["comment_Fourth"];
                            }
                            ?>
                          </th>
                            <tr>
                                <td colspan="5"></td>
                            </tr>
                        </tfoot>
    </table>
<?php
    
  $sql = "SELECT rp.period_Name,obn.general_observations FROM 
  `observation_notes` obn
  LEFT JOIN ref_period rp ON rp.period_ID = obn.period_ID
  WHERE obn.acs_ID = ".$_REQUEST["staff_ID"]." AND obn.form_ID = ".$output["form_ID"]."";

  $statementf = $auth_user->runQuery($sql);
  $statementf->execute();
  $resultf = $statementf->fetchAll();
  // echo "<pre>";
  $fo = array();
  foreach($resultf as $row){
    $obnpid = $row["period_Name"];
    $fo["obnote_".$obnpid] = $row["general_observations"];
   
  } 
?>      <div class="card rounded-0 text-white text-center mt-2" style="background-color: #6c757d;">
                    <div class="card-body">
                        <h5 class="display-5">OBSERVATION NOTES</h5>
                    </div>
                </div>
                <br>
                <div class="card rounded-0 my-3">
                    <div class="card-body">
                        <h5 class="display-5 card-title text-primary">First  Observation Notes</h5><hr>
                        <?php 
                        if(isset($fo["obnote_First"])){
                           echo $fo["obnote_First"];
                        }
                        ?>
                    </div>
                </div>
                <div class="card rounded-0 my-3">
                    <div class="card-body">
                        <h5 class="display-5 card-title text-primary">Second Observation Notes</h5><hr>
                        <?php 
                        if(isset($fo["obnote_Second"])){
                           echo $fo["obnote_Second"];
                        }
                        ?>
                    </div>
                </div>
                <div class="card rounded-0 my-3">
                    <div class="card-body">
                        <h5 class="display-5 card-title text-primary">Third Observation Notes</h5><hr>
                        <?php 
                        if(isset($fo["obnote_Third"])){
                           echo $fo["obnote_Third"];
                        }
                        ?>
                    </div>
                </div>
                <div class="card rounded-0 my-3">
                    <div class="card-body">
                        <h5 class="display-5 card-title text-primary">Fourth Observation Notes</h5><hr>
                        <?php 
                        if(isset($fo["obnote_Fourth"])){
                           echo $fo["obnote_Fourth"];
                        }
                        ?>
                    </div>
                </div>

          </div>
           <!-- CONTENT OF VISITOR EVALUATION -->
          <div class="tab-pane fade" id="nav-veval" role="tabpanel" aria-labelledby="nav-veval-tab">
            <div class="card rounded-0 text-white text-center mt-2" style="background-color: #6c757d;">
                    <div class="card-body">
                        <h5 class="display-5">INTER OBSERVER AGREEMENT</h5>
                    </div>
                </div>
                <br>
             <table class="table table-bordered">
      <thead>
          <tr>
              <th width="70%">THE TEACHER</th>
              <th class="text-center" width="5%">FIRST OBSERVATION</th>
              <th class="text-center" width="5%">SECOND OBSERVATION</th>
              <th class="text-center" width="5%">THIRD OBSERVATION</th>
              <th class="text-center" width="5%">FOURTH OBSERVATION</th>
          </tr>
      </thead>
      <tbody>
         <?php 
           $rquery = "SELECT * FROM `forms_content` fc
            LEFT JOIN forms fm ON fm.form_ID = fc.form_ID
            WHERE fm.sem_ID =  ".$active_sem_ID." ";
                $statementr = $auth_user->runQuery($rquery);
                $statementr->execute();
                $resultr = $statementr->fetchAll();

                $zq1 = "
                SELECT rp.period_Name,fir.ifr_Rating FROM `forms_inter_rating` fir 
                LEFT JOIN ref_period rp ON rp.period_ID  = fir.period_ID
                WHERE fir.acs_ID =  ".$_REQUEST["staff_ID"]." AND fir.form_ID = ".$output["form_ID"]."";
                $statementf = $auth_user->runQuery($zq1);
                $statementf->execute();
                $resultf = $statementf->fetchAll();
                // echo "<pre>";
                $fo = array();
                foreach($resultf as $row){
                  $rspid = $row["period_Name"];
                  $rsfrr = json_decode($row["ifr_Rating"]);
                  foreach($rsfrr as $ro1){
                     $fo[$rspid][] = $ro1;
                  }
                } 
                // echo "</pre>";
                $x_r = 1;
                foreach($resultr as $row){
                  ?>
                   <tr>
                        <td width="70%"><?php echo $x_r.'.) '.$row["fc_Desc"];?></td>
                        <td width="5%">
                          <div >
                            <?php 
                            if(isset($fo["First"])){
                             echo $fo["First"][$x_r-1];
                            }
                            ?>
                            
                          </div>
                        </td>
                        <td width="5%">
                          <div > 
                            <?php 
                            if(isset($fo["Second"])){
                               echo $fo["Second"][$x_r-1];
                            }
                            ?>
                            
                          </div>
                        </td>
                        <td width="5%">
                          <div >
                             <?php 
                            if(isset($fo["Third"])){
                              echo $fo["Third"][$x_r-1];
                            }
                            ?>
                          </div>
                        </td>
                        <td width="5%">
                          <div >
                             <?php 
                            if(isset($fo["Fourth"])){
                              echo $fo["Fourth"][$x_r-1];
                            }
                            ?>
                          </div>
                        </td>
                    </tr>
                  <?php

                    $x_r++;
                }
        ?>
         
         
      </tbody>
    </table>
          </div>
          <!-- CONTENT OF INDIDUAL EVALUATION -->
          <div class="tab-pane fade" id="nav-ieval" role="tabpanel" aria-labelledby="nav-ieval-tab">
            
          </div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>


    </main>
  </div>
</div>

<?php 
include('x-script.php');
?>
        <script type="text/javascript">
   


          // $(document).ready(function() {
  
   $(document).on('submit', '#ratingsheet_form', function(event){
            event.preventDefault();

              $.ajax({
                url:"datatable/evaluation/insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                  alertify.alert(data).setHeader('Rating Sheet Form ');
                  $('#ratingsheet_form')[0].reset();
                  $('#rating_sheet').modal('hide');
                  pastratingsheet_dataTable.ajax.reload();
                  pastratingsheetnote_dataTable.ajax.reload();
                }
              });
           
          });
      $(document).on('submit', '#ratingsheetnote_form', function(event){
         event.preventDefault();
         $.ajax({
                url:"datatable/evaluation/insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                  alertify.alert(data).setHeader('Observation Note ');
                  $('#ratingsheetnote_form')[0].reset();
                  $('#rating_sheet_note').modal('hide');
                  pastratingsheet_dataTable.ajax.reload();
                  pastratingsheetnote_dataTable.ajax.reload();
                }
              });

        });
        $(document).on('submit', '#interrating_form', function(event){
            event.preventDefault();

              var iob2n  = $("#interrating_ob2_name").val();
              var iob3n  = $("#interrating_ob3_name").val();

              if(iob2n == null || iob2n == "")
              {
                alert("You Need to Select Observer");
              } 
              else if(iob3n == null || iob3n == "")
              {
                alert("You Need to Select Observer");
              }
              else{
                $.ajax({
                url:"datatable/evaluation/insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                  alertify.alert(data).setHeader('Inter Rating Sheet Form');
                  $('#interrating_form')[0].reset();
                  $('#rating_sheet_inter').modal('hide');
                }
              });
              }
              
           
          });

   
          
          // } );
          $(document).on('click', '.rating_sheet', function(event){
          
                   $.ajax({
                url:"datatable/evaluation/fetch_single.php",
                method:'POST',
                data:{action:"ratingsheet_check",acs_ID:<?php echo  $output["acs_ID"]?>,form_ID:<?php echo  $output["form_ID"]?>},
                dataType    :   'json',
                success:function(data)
                {

                  $('#rating_period_label').html(data.rating_period_name);
                  $('#rating_period').val(data.rating_period_ID);
                  if(data.rating_period_ID == 5){
                    alert("You already max rating this teacher");
                  }
                  else{
                    $('#rating_sheet').modal('show');
                  }
                  
                }
              });
          } );

           $(document).on('click', '.rating_sheetnote', function(event){
               $.ajax({
                url:"datatable/evaluation/fetch_single.php",
                method:'POST',
                data:{action:"ratingsheet_notecheck",acs_ID:<?php echo  $output["acs_ID"]?>,form_ID:<?php echo  $output["form_ID"]?>},
                dataType    :   'json',
                success:function(data)
                {

                  $('#ratingnote_period_name').html(data.ratingnote_period_name);
                  $('#ratingnote_period').val(data.ratingnote_period_ID);
                  if(data.ratingnote_period_ID == 5){
                    alert("You already max rating this teacher");
                  }
                  else{
                    $('#rating_sheet_note').modal('show');
                  }
                  
                }
              });

            } );

            $(document).on('click', '.interrating_sheet', function(event){
                 $.ajax({
                  url:"datatable/evaluation/fetch_single.php",
                  method:'POST',
                  data:{action:"interrating_check",acs_ID:<?php echo  $output["acs_ID"]?>,form_ID:<?php echo  $output["form_ID"]?>},
                  dataType    :   'json',
                  success:function(data)
                  {

                    $('#interrating_period_name').html(data.interrating_period_name);
                    $('#interrating_period').val(data.interrating_period_ID);
                    if(data.interrating_period_ID == 5){
                      alert("You already max rating this teacher");
                    }
                    else{
                    // $('#rating_sheet_inter').modal('handleUpdate');
                    $('#rating_sheet_inter').modal('show');
                       
                    }
                    
                  }
                });

            } );

             $(document).on('click', '.browse_observer_2', function(event){
              
                $('#observer2_modal').modal('show');
              } );

             $(document).on('click', '.browse_observer_3', function(event){
              $('#observer3_modal').modal('show');
              } );
            
            
               var observer2_dataTable = $('#observer2_data').DataTable({
                  "processing":true,
                  "serverSide":true,
                  "ordering":false,
                "bAutoWidth": false,
                  "ajax":{
                    url:"datatable/observer/fetch.php",
                    type:"POST"
                  },
                  "columnDefs":[
                    {
                      "targets":[0],
                      "orderable":false,
                    },
                  ],

                });
                var observer3_dataTable = $('#observer3_data').DataTable({
                 "processing":true,
                 "serverSide":true,
                 "ordering":false,
                "bAutoWidth": false,
                 "ajax":{
                   url:"datatable/observer/fetch.php",
                   type:"POST"
                 },
                 "columnDefs":[
                   {
                     "targets":[0],
                     "orderable":false,
                   },
                 ],

               });

                //JQUERY FOR SELECTING OBSERVER ID WHEN BROWSING
               //----------------------------------------------------------------
                var observer2_data = '#observer2_data tbody';

                $(observer2_data).on('click', 'tr', function(){
                  
                  var cursor = observer2_dataTable.row($(this));//get the clicked row
                  var data=cursor.data();// this will give you the data in the current row.
                   if(confirm("Are you sure you want to use "+data[2]+"?"))
                  {

                    $('#interrating_form').find("input[name='interrating_ob2_name'][type='text']").val(data[2]);
                    $('#interrating_form').find("input[name='interrating_ob2_id'][type='hidden']").val(data[0]);

                  }
                    else
                  {
                    return false; 
                  }
                    $('#observer2_modal').modal('hide');
                  
                });

                 //JQUERY FOR SELECTING OBSERVER ID WHEN BROWSING
               //----------------------------------------------------------------
                var observer3_data = '#observer3_data tbody';

                $(observer3_data).on('click', 'tr', function(){
                  
                  var cursor = observer3_dataTable.row($(this));//get the clicked row
                  var data=cursor.data();// this will give you the data in the current row.
                   if(confirm("Are you sure you want to use "+data[2]+"?"))
                  {

                    $('#interrating_form').find("input[name='interrating_ob3_name'][type='text']").val(data[2]);
                    $('#interrating_form').find("input[name='interrating_ob3_id'][type='hidden']").val(data[0]);

                  }
                    else
                  {
                    return false; 
                  }
                    $('#observer3_modal').modal('hide');
                  
                });




                var pastratingsheet_dataTable = $('#pastratingsheet_data_teacher').DataTable({
                  "processing":true,
                  "serverSide":true,
                  "ordering":false,
                "bAutoWidth": false,
                  "ajax":{
                    url:"datatable/evaluation/fetch_ratingsheet_teacher.php?staff_ID="+<?php echo $_REQUEST["staff_ID"]?>,
                    type:"POST"
                  },
                  "columnDefs":[
                    {
                      "targets":[0],
                      "orderable":false,
                    },
                  ],

                });

                 var pastratingsheetnote_dataTable = $('#pastratingsheet_ob_data_teacher').DataTable({
                  "processing":true,
                  "serverSide":true,
                  "ordering":false,
                "bAutoWidth": false,
                  "ajax":{
                    url:"datatable/evaluation/fetch_ratingsheet_teacher_note.php?staff_ID="+<?php echo $_REQUEST["staff_ID"]?>,
                    type:"POST"
                  },
                  "columnDefs":[
                    {
                      "targets":[0],
                      "orderable":false,
                    },
                  ],

                });

                var pastinterobserver_dataTable = $('#pastinterobserver_data_visitor').DataTable({
                  "processing":true,
                  "serverSide":true,
                  "ordering":false,
                "bAutoWidth": false,
              "ordering": false,
              "bAutoWidth": false,
              "searching": false,
              "paging":     false,
                  "ajax":{
                    url:"datatable/evaluation/fetch_inter_observe_visitor.php?staff_ID="+<?php echo $_REQUEST["staff_ID"]?>,
                    type:"POST"
                  },
                  "columnDefs":[
                    {
                      "targets":[0],
                      "orderable":false,
                    },
                  ],

                });

                 

                
                $(document).on('click', '.pastevaluation', function(event){
                  $('#pastevaluation_modal').modal('show');
                } );
                $(document).on('click', '.viewmore_inter', function(event){
                  var ifr_ID = $(this).attr("id");
                  $('#viewmoreinter_modal').modal('show');

                  $('.viewmoreinter_body').html(ifr_ID);
                } );



                $(document).on('click', '.view_summary', function(event){
                  $('#viewsummary_modal').modal('show');
                } );

                
                



        </script>
        </body>

</html>
