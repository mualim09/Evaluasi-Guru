<?php 
include('../session.php');


require_once("../class.user.php");

  
$auth_user = new USER();
// $page_level = 3;
// $auth_user->check_accesslevel($page_level);
$pageTitle = "Dashboard";

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
        <!-- <h1 class="h2">Dashboard</h1> -->
      </div>
            <div class="row">
              <?php 
              if($auth_user->admin_level()){
              ?>
                <div class="col-sm-12 text-center " style="min-height: 100px;">
                    <H3 >ALULOD TEACHER EVALUATION SYSTEM</H3>
                </div>
              <?php
              }
              ?>
            </div>
            <div class="row">
              
               <?php 
              if($auth_user->admin_level()){
                ?>
                <div class="col-6 col-sm-6">
                <div class="card " style="border:solid 0.9px ;">
                  <div class="card-header text-center" style=" border-bottom: 5px solid ;">
                   <strong>MISSION</strong>
                  </div>
                  <div class="card-body text-justify"  style="min-height: 350px">
                    <p>
                        To protect and promote the right of every Filipino to quality, equitable, culture-based, and complete basic education where:<br>
                        <ul class="text-justify">
                            <li>Students learn in child-friendly, gender-sensitive safe and motivating environment.</li>
                            <li>Teachers facilitate learning and constantly nurture every learner.</li>
                            <li>Administrators and staff, as stewards of the institution, ensure an enabling and supportive environment for effective learning to happen.</li>
                        </ul>
                        Family, community and other Stakeholders are actively engaged and share responsibility for developing life-long learners.
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-6 col-sm-6">
                <div class="card " style="border:solid 0.9px ;">
                  <div class="card-header text-center" style=" border-bottom: 5px solid ;">
                    <strong>VISION</strong>
                  </div>
                  <div class="card-body text-justify"  style="min-height: 350px">
                    <p>
                        We dream of Filipinos who passionately love their country and whose and competencies enable them to realize their full potential and contribute meaningfully to building the nation. As a learner-centered public institution, the Department of Education continuously improves itself to better serve its stakeholders.
                    </p>
                  </div>
                </div>
              </div>
       
                <?php
              }

              ?>
              <?php 
              if($auth_user->principal_level()){
                $vquery = "SELECT *,
                CONCAT(YEAR(`rsem`.`sem_start`),' - ',YEAR(`rsem`.`sem_end`)) `sem_year`,
                LEFT(rtd.tcd_MName, 1) tcd_MNamex  FROM `academic_staff` `acs` 
                LEFT JOIN `record_teacher_details` `rtd` ON `rtd`.`tcd_ID` = `acs`.`tcd_ID`
                LEFT JOIN `ref_suffixname` `rsn` ON `rsn`.`suffix_ID` = `rtd`.`suffix_ID`
                LEFT JOIN `ref_subject` `rsub` ON `rsub`.`subject_ID` = `acs`.`subject_ID`
                LEFT JOIN `ref_year_level` `ryl` ON `ryl`.`yl_ID` = `acs`.`yl_ID`
                LEFT JOIN `ref_position` `rpos` ON `rpos`.`pos_ID` = `acs`.`pos_ID`
                LEFT JOIN `ref_semester` `rsem` ON `rsem`.`sem_ID` = `acs`.`sem_ID` WHERE `acs`.`sem_ID` = ".$active_sem_ID." ";
                $statementv = $auth_user->runQuery($vquery);
                $statementv->execute();
                $resultv = $statementv->fetchAll();

                $yquery = "SELECT * ,CONCAT(YEAR(`sem_start`),' - ',YEAR(`sem_end`)) `sem_year` FROM `ref_semester`";
                $statementy = $auth_user->runQuery($yquery);
                $statementy->execute();
                $resulty = $statementy->fetchAll();


                $sqlc  = "SELECT *
                FROM `forms_indivual_performance` fip
                LEFT JOIN forms f ON f.form_ID = fip.form_ID
                WHERE f.sem_ID =  7 AND fip.status is NULL OR fip.status = 0";
                $statementc = $auth_user->runQuery($sqlc);
                $statementc->execute();
                $icp_count = $statementc->rowCount();

                if(isset($_REQUEST["page"])){
                    ?>
                    <div class="col-6 col-sm-6">
                      <div class="card " style="border:solid 0.9px ;">
                        <div class="card-header text-center" style=" border-bottom: 5px solid ;">
                         <strong>MISSION</strong>
                        </div>
                        <div class="card-body text-justify"  style="min-height: 350px">
                          <p>
                              To protect and promote the right of every Filipino to quality, equitable, culture-based, and complete basic education where:<br>
                              <ul class="text-justify">
                                  <li>Students learn in child-friendly, gender-sensitive safe and motivating environment.</li>
                                  <li>Teachers facilitate learning and constantly nurture every learner.</li>
                                  <li>Administrators and staff, as stewards of the institution, ensure an enabling and supportive environment for effective learning to happen.</li>
                              </ul>
                              Family, community and other Stakeholders are actively engaged and share responsibility for developing life-long learners.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 col-sm-6">
                      <div class="card " style="border:solid 0.9px ;">
                        <div class="card-header text-center" style=" border-bottom: 5px solid ;">
                          <strong>VISION</strong>
                        </div>
                        <div class="card-body text-justify"  style="min-height: 350px">
                          <p>
                              We dream of Filipinos who passionately love their country and whose and competencies enable them to realize their full potential and contribute meaningfully to building the nation. As a learner-centered public institution, the Department of Education continuously improves itself to better serve its stakeholders.
                          </p>
                        </div>
                      </div>
                    </div>
                    <?php
                }
                else{
                  ?>
 <div class="col-12 col-sm-12">
        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-teacerlist-tab" data-toggle="tab" href="#nav-teacerlist" role="tab" aria-controls="nav-teacerlist" aria-selected="true">Teacher list</a>
            <a class="nav-item nav-link" id="nav-summaryreport-tab" data-toggle="tab" href="#nav-summaryreport" role="tab" aria-controls="nav-summaryreport" aria-selected="false">Overall Report</a>
            <a class="nav-item nav-link" id="nav-individualp-tab" data-toggle="tab" href="#nav-individualp" role="tab" aria-controls="nav-individualp" aria-selected="false">Individual Performance <label class="badge badge-danger"><?php echo $icp_count?></label></a>
          </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">

          <div class="tab-pane fade show active" id="nav-teacerlist" role="tabpanel" aria-labelledby="nav-teacerlist-tab">
            <br>
            <div class="row">
                   <?php 
                foreach($resultv as $row){
                  if($row["suffix"] =="N/A")
                  {
                    $suffix = "";
                  }
                  else
                  {
                    $suffix = $row["suffix"];
                  }

                  if (!empty($row['user_Img'])) {
                   $vimg = 'data:image/jpeg;base64,'.base64_encode($row['user_Img']);
                  }
                  else{
                    $vimg = "../assets/img/users/default.jpg";
                  }
                  ?>
                  <div class="col-4">
                  <div class="card " style="border:solid 0.9px ;">
                    <div class="card-header text-center" style=" border-bottom: 5px solid ;">
                      <strong><?php echo ucwords(strtolower($row["tcd_LName"].', '.$row["tcd_FName"].' '.$row["tcd_MNamex"].'. '.$suffix));?></strong>
                    </div>
                    <div class="card-body text-center"  style="min-height: 250px">
                      
                      <img id="p_img" src="<?php echo $vimg?>" alt="<?php echo ucwords(strtolower($row["tcd_LName"].', '.$row["tcd_FName"].' '.$row["tcd_MNamex"].'. '.$suffix));?> Image"  runat="server"  height="125" width="125" class="" style="border:1px solid; border-color:#383d41;"/>
                      <br><ul class="list-group list-group-flush">
                          <li class="list-group-item"> <?php echo $row["subject_Title"];?></li>
                          <li class="list-group-item"> <?php echo $row["pos_Name"];?></li>
                          <li class="list-group-item"> <a class="btn btn-primary" href="teacher_view.php?staff_ID=<?php echo $row["acs_ID"];?>" target="_BLANK">View</a> </li>
                        </ul>
                        
                    </div>
                  </div>
                  </div>
                <?php }?>
                </div>
          </div>

          <div class="tab-pane fade" id="nav-summaryreport" role="tabpanel" aria-labelledby="nav-summaryreport-tab">
            <section class="row">
              <?php 
                foreach($resulty as $row){
                  ?>
             <section class="col-md-12 " >
                 <div  style="text-decoration: none;" >
                     <section class="card rounded-0 hover-effect my-3" style="background-color:#7d6c6c">
                         <section class="card-body">
                             <h5 class="display-5 text-white"><img src="../assets/img/Icons/report (1).png" class="img-fluid"><span class="lead float-right">SY:<?php echo $row["sem_year"]?></span></h5>
                             <div class="btn-group float-right">
                            <!--  <a class="btn btn-primary btn-sm " href="print/print?report=summary&academic_year=<?php echo $row["sem_ID"]?>" target="_BLANK">Summary</a>   -->                                      
                             <a class="btn btn-primary btn-sm " href="print/print?report=overall&academic_year=<?php echo $row["sem_ID"]?>" target="_BLANK"><i class="icon-printer" style="font-size: 20px;"></i></a>
                             </div> 
                         </section>
                     </section>
                 </div>
             </section>
             <?php }?>
            </section>
            
          </div>
           <div class="tab-pane fade" id="nav-individualp" role="tabpanel" aria-labelledby="nav-individualp-tab">
            <table class="table table-striped table-sm" id="individualperformance_data">
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
               
<!-- Modal -->
<div class="modal fade" id="individual_performance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document" style="min-width:1350px !important;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Individual Performance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body table-responsive">
        <div class="text-center">
          <H3>INDIVIDUAL PERFORMANCE COMMITMENT AND REVIEW FORM</H3>  <button type="button" class="btn btn-primary btn-sm float-right">PRINT</button>
          <h4 id="fetch_individual_schoolyear"></h4>
        </div>
        <br>
        <table class="table table-bordered">
  <thead>
  </thead>
  <tbody>
    <tr>
      <td >Name of Teacher:</td>
      <td ><input type="text" class="form-control"  name="fetch_teacher_name"  id="fetch_teacher_name" value="" readonly></td>
      <td >Name of Rater:</td>
      <td ><input type="text" class="form-control" name="fetch_rater_name"  id="fetch_rater_name" value="<?php echo strtoupper($_SESSION["fullname"])?>" readonly></td>
    </tr>

    <tr>
      <td >Position:</td>
      <td ><input type="text" class="form-control"></td>
      <td >Position:</td>
      <td ><input type="text" class="form-control"></td>
    </tr>

    <tr>
      <td >Division:</td>
      <td ><input type="text" class="form-control"></td>
      <td >Date of Review:</td>
      <td ><input type="text" class="form-control" value="<?php echo date('m/d/Y')?>" readonly></td>
    </tr>
    <tr>
      <td >Rating Period:</td>
      <td ><input type="text" class="form-control"></td>
      <td ></td>
      <td ></td>
    </tr>
  </tbody>
</table>
                      <table class="table table-bordered">
  <thead>
    <tr>
      <th   rowspan="2">MFO</th>
      <th   rowspan="2">KRAs</th>
      <th   rowspan="2">OBJECTIVES</th>
      <th   rowspan="2">MOVs</th>
      <th   rowspan="2">TIMELINE</th>
      <th   rowspan="2">WEIGHT</th>
      <th   rowspan="2">PERFORMANCE INDICATORS</th>
      <th   colspan="3">ACTUAL RESULTS</th>
      <th   rowspan="2">AVE.</th>
      <th   rowspan="2">RATING </th>
      <th   rowspan="2">SCORE</th>
    </tr>
    <tr >
      <th >Q</th>
      <th >T</th>
      <th >E</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td rowspan="31">BASIC EDUCATION SERVICES</td>
      <td rowspan="6">Teaching-Learning Process     (30 %)</td>
      <td rowspan="3">Prepare lesson plan/ lesson log based on the prescribed curriculum guide</td>
      <td rowspan="3"><input type="text" class="form-control" ></td>
      <td rowspan="15"><input type="text" class="form-control" ></td>
      <td rowspan="3">15%</td>
      <td rowspan="1">Complete and up-to-date lesson plan/lesson log was submitted.  (Q)</td>
      <td rowspan="1"><input type="text" class="form-control" style="min-width:52px;"></td>
      <td rowspan="1"><input type="text" class="form-control" style="min-width:52px;"></td>
      <td rowspan="1"><input type="text" class="form-control" style="min-width:52px;"></td>
      <td rowspan="3"><input type="text" class="form-control" style="min-width:52px;"></td>
      <td rowspan="3"><input type="text" class="form-control" style="min-width:52px;"></td>
      <td rowspan="3"><input type="text" class="form-control" style="min-width:52px;"></td>
     
    </tr>
   <tr>
     <td rowspan="1">Lesson plan/lesson log showed utilization of adequate and appropriate instructional materials. (E)</td>
    <td rowspan="1"><input type="text" class="form-control" ></td>
    <td rowspan="1"><input type="text" class="form-control" ></td>
    <td rowspan="1"><input type="text" class="form-control" ></td>
   </tr>
   
   <tr>
     <td rowspan="1">Utilization of technology resources at least once a week or twice a month was indicated in the lesson plan/lesson log. (T)</td>
    <td rowspan="1"><input type="text" class="form-control" ></td>
    <td rowspan="1"><input type="text" class="form-control" ></td>
    <td rowspan="1"><input type="text" class="form-control" ></td>
   </tr>

    <tr> 
      <td rowspan="3">Ensure attainment of learning targets</td>
      <td rowspan="3">Activities/ Instructional materials, rubrics,summary report</td>
      <td rowspan="3">15%</td>
      <td rowspan="1">Differentiated group tasks or activities were employed to maximize learning. (E)</td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="3"><input type="text" class="form-control"></td>
      <td rowspan="3"><input type="text" class="form-control"></td>
      <td rowspan="3"><input type="text" class="form-control"></td>
    </tr>
    <tr>
     <td rowspan="1">Processing of outputs or performance was executed through prompt and constructive feedbacks to students. (T)</td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
   </tr>
   
   <tr>
     <td rowspan="1">Formative and summative tests results were utilized to address students’ needs and weaknesses. (Q)</td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
   </tr>

    <tr>
       <td rowspan="9"> Pupils  Outcome  ( 40% )</td>
       <td rowspan="3">Monitor pupils daily attendance everyday within the rating period</td>
       <td rowspan="3">Updated Sf1 and Sf2</td>
       <td rowspan="3"> 10%</td>
       <td rowspan="1">Pupils attendance were monitored based on school policy. (Q )</td>
       <td rowspan="1"><input type="text" class="form-control"></td>
       <td rowspan="1"><input type="text" class="form-control"></td>
       <td rowspan="1"><input type="text" class="form-control"></td>
       <td rowspan="3"><input type="text" class="form-control"></td>
       <td rowspan="3"><input type="text" class="form-control"></td>
       <td rowspan="3"><input type="text" class="form-control"></td>
    </tr>
  <tr>
    <td rowspan="1">Accurate and reliable pu[pils attendance were monitored and encoded daily using Sf2.  (E )</td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
   </tr>
   <tr>
    <td rowspan="1">Attendance monitoring was done daily and encoded in Sf2 and submitted on time. (T)</td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
   </tr>

  <tr>
    <td rowspan="3">Undertake activities to improve pupil performance</td>
    <td rowspan="1">Peer tuittoring</td>
    <td rowspan="3"> 10%</td>
    <td rowspan="1">Peer tutoring and cooperative learning were used in the classroom to assist students with learning difficulties. (E)</td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="3"><input type="text" class="form-control"></td>
    <td rowspan="3"><input type="text" class="form-control"></td>
    <td rowspan="3"><input type="text" class="form-control"></td>
  </tr>

  <tr>
    <td rowspan="1">Intervention</td>
    <td rowspan="1">Intervention materials (workbooks, SIMs, etc.) were provided to enhance or improve learning. (Q)</td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
  </tr>
  <tr>
    <td rowspan="1">Progress report card</td>
    <td rowspan="1">Monthly or quarterly record of progress was used to evaluate student performance. (T)</td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
  </tr>
  <tr>
    <td rowspan="3">Maintain updated pupils' school records and reports by department </td>
    <td rowspan="1">SF5</td>
    <td rowspan="3">20%</td>
    <td rowspan="1">Complete, accurate, and updated school records (grading sheets, report cards, transcript of record) were submitted and checked  quarterly.  (Q)</td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="3"><input type="text" class="form-control"></td>
    <td rowspan="3"><input type="text" class="form-control"></td>
    <td rowspan="3"><input type="text" class="form-control"></td>
    
  </tr>

  <tr>
    <td rowspan="1">ECCD SUMMARY REPORT</td>
    <td rowspan="1">Report on tracking student performance (quarterly assessment, test results utilization, proficiency, and related performance indicators) were accomplished and </td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
  </tr>
  <tr>
    <td rowspan="1">Progress report card</td>
    <td rowspan="1">Monthly/quarterly reports were properly documented and published. (E)</td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
  </tr>

  <tr>
    <td rowspan="7">Community Involvement        (10%)</td>
    <td rowspan="3">Participate in activities of governmental and non-governmental organizations</td>
    <td rowspan="1">earthquake drill</td>
    <td rowspan="7"><input type="text" class="form-control" ></td>
    <td rowspan="3">5%</td>
    <td rowspan="1">Active participation in all school programs and activities within the school year was done. (Q)</td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="3"><input type="text" class="form-control"></td>
    <td rowspan="3"><input type="text" class="form-control"></td>
    <td rowspan="3"><input type="text" class="form-control"></td>
    
  </tr>

  <tr>
    <td rowspan="1">brigada eskwela</td>
    <td rowspan="1">One community activity was participated with complete attendance. (E )</td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
  </tr>
  
  <tr>
    <td rowspan="1"></td>
    <td rowspan="1">Attendance in  community-related activities was noted within the school year. (T)</td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
  </tr>
   <tr>
    <td rowspan="4">Involve the community in sharing accountability for learners’ achievement</td>
    <td rowspan="1">Linggo ng Wika</td>
    <td rowspan="4">5%</td>
    <td rowspan="1">School programs that promote students’ learning progress was participated in by the community. (E)</td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="4"><input type="text" class="form-control"></td>
    <td rowspan="4"><input type="text" class="form-control"></td>
    <td rowspan="4"><input type="text" class="form-control"></td>
    </tr>
    <tr>
      <td rowspan="1">RECORDS & DOCUMENTATION</td>
      <td rowspan="1">Home visitation to parents of students needing follow-up was conducted every grading period. (T)</td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
    </tr>
    <tr>
      <td rowspan="1">PTC - ATTENDANCE & DOCUMENTATION</td>
      <td rowspan="1">Conference/meeting with parents or guardians of learners with school-related problems was done. (Q)</td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
    </tr>
    <tr>
      <td rowspan="1">Harmonious relationship with colleagues, documentation</td>
      <td rowspan="1">Cooperative working relationship between teachers and parents was established. (Q)</td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
    </tr>
    <tr>
      <td rowspan="9">Professional Growth & Development and Ethics (10 %)</td>
      <td rowspan="4">Get involved in professional organizations or groups and other agencies that can improve teaching practice</td>
      <td rowspan="1">Registration Form. Compre result</td>
      <td rowspan="9"><input type="text" class="form-control" ></td>
      <td rowspan="4">5%</td>
      <td rowspan="1">Earned at least 6 MA units within a year (Q)</td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="4"><input type="text" class="form-control"></td>
      <td rowspan="4"><input type="text" class="form-control"></td>
      <td rowspan="4"><input type="text" class="form-control"></td>
    </tr>
    <tr>
      <td rowspan="1">Certificates of appearance, documentations</td>
      <td rowspan="1">Active participation in at least two seminars and trainings (school-based, division, and regional) (Q) </td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
    </tr>
    <tr>
      <td rowspan="1"></td>
      <td rowspan="1">Membership in at least one professional organization or association (E)</td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
    </tr>
    <tr>
      <td rowspan="1">documentation</td>
      <td rowspan="1">Observed punctuality in all meetings and activities attended (T)</td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
    </tr>
    <tr>
      <td rowspan="4">Support to personel administration </td> 
      <td rowspan="1">logbook, dtr</td>
      <td rowspan="4">5%</td>
      <td rowspan="1">Submitted  DTR/CSC Form 48 in a school year without error . (T )</td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="4"><input type="text" class="form-control"></td>
      <td rowspan="4"><input type="text" class="form-control"></td>
      <td rowspan="4"><input type="text" class="form-control"></td>
    </tr>

    <tr>
      <td rowspan="1">proper decorum form,documentation</td>
      <td rowspan="1">Dressed in accordance with proper decorum and or prescribed rules and regulation and is neat in appearance at all times. ( Q.)</td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
    </tr>
    <tr>
      <td rowspan="1">decorum form</td>
      <td rowspan="1">Manifest positive attitude towards constructive comments, suggestions and recommendation. (Q)</td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
    </tr>
    <tr>
      <td rowspan="2">documentation</td>
      <td rowspan="1">Timeline on all school activities was strictly followed. (E) </td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"></td>
    </tr> 
    <tr>
      <td rowspan="1"> Plus Factor</td>
      <td rowspan="1"> 10%</td>
      <td rowspan="1"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      
    </tr>
  </tbody>
</table>
<i>*To get the score, the rating is multiplied by the weight assigned</i>
<div class="text-center">
  <table class="table table-borderless">
  <thead>
    <tr>
      <th >Ratee:</th>
      <th></th>
      <th >Rater:</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td ><input type="text" class="form-control" name="fetch_ratee_name"  id="fetch_ratee_name" value="" readonly></td>
      <td ></td> 
      <td ><input type="text" class="form-control" name="fetch_rater_name"  id="fetch_rater_name" value="<?php echo $_SESSION["fullname"]?>" readonly></td>
    </tr>
    <tr>
      <td >Teacher I</td>
      <td ></td>
      <td >Principal II</td>
    </tr>
  </tbody>
</table>
</div>
<h3>PART III:  SUMMARY OF RATING FOR DISCUSSION</h3>
<table class="table table-bordered">
  <thead>
    <tr>
      <th >Final Performance Results</th>
      <th>Rating</th>
      <th >Adjectival Rating</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td >Accomplishment of KRAs and Objectives</td>
      <td ><input type="text" class="form-control"></td>
      <td >
        <select class="form-control">
        <option>Outstanding</option>
        <option>Very Satisfactory</option>
        <option>Satisfactory</option>
        <option>Unsatisfactory</option>
        <option>Poor</option>
      </select>
    </td>
    </tr>
  </tbody>
</table>
</div>
<strong>Rater – Ratee Agreement</strong>
The signatures below confirm that the employee and his/her superior have agreed to the content of this appraisal form and the performance rating
<table class="table table-bordered">
  <thead>
  </thead>
  <tbody>
    <tr>
      <td >Name of Employee:</td>
      <td ><input type="text" class="form-control"></td>
      <td >Name of Employee:</td>
      <td ><input type="text" class="form-control"></td>
    </tr>

    <tr>
      <td >Signature:</td>
      <td ></td>
      <td >Signature:</td>
      <td ></td>
    </tr>

    <tr>
      <td >Date:</td>
      <td ><input type="date" class="form-control"></td>
      <td >Date:</td>
      <td ><input type="date" class="form-control"></td>
    </tr>
  </tbody>
</table>
                  
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </div>
              </div>
                  <?php
                }//ELSE MV PRINCIPAL

                
                ?>

             
               
       
                 <?php
              }//END OF PRINCIPAL

              ?>
              <?php 
              if($auth_user->teacher_level()){
                    if(isset($_REQUEST["page"])){
                ?>
     <div class="col-6 col-sm-6">
                <div class="card " style="border:solid 0.9px ;">
                  <div class="card-header text-center" style=" border-bottom: 5px solid ;">
                   <strong>MISSION</strong>
                  </div>
                  <div class="card-body text-justify"  style="min-height: 350px">
                    <p>
                        To protect and promote the right of every Filipino to quality, equitable, culture-based, and complete basic education where:<br>
                        <ul class="text-justify">
                            <li>Students learn in child-friendly, gender-sensitive safe and motivating environment.</li>
                            <li>Teachers facilitate learning and constantly nurture every learner.</li>
                            <li>Administrators and staff, as stewards of the institution, ensure an enabling and supportive environment for effective learning to happen.</li>
                        </ul>
                        Family, community and other Stakeholders are actively engaged and share responsibility for developing life-long learners.
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-6 col-sm-6">
                <div class="card " style="border:solid 0.9px ;">
                  <div class="card-header text-center" style=" border-bottom: 5px solid ;">
                    <strong>VISION</strong>
                  </div>
                  <div class="card-body text-justify"  style="min-height: 350px">
                    <p>
                        We dream of Filipinos who passionately love their country and whose and competencies enable them to realize their full potential and contribute meaningfully to building the nation. As a learner-centered public institution, the Department of Education continuously improves itself to better serve its stakeholders.
                    </p>
                  </div>
                </div>
              </div>
              <?php 
            }
            else{
              ?>
                  <div class="col-12 col-sm-12">
                <div class="text-center">
               <h4 class="display-4 text-center text-muted">Quick Access</h4>
                </div>
                <section class="row my-3 text-center">
                  <section class="col-sm-4 my-4">
                      <img src="../assets/img/Icons/teacher.png" class="img-fluid zoom"  data-toggle="modal" data-target="#mycoteachers">
                      <p class="lead text-muted my-2">My Co-Teachers</p>
                  </section>
                  <section class="col-sm-4 my-4">
                      <img src="../assets/img/Icons/evaluation_result.png" class="img-fluid" data-toggle="modal" data-target="#myevaluation">  
                      <p class="lead text-muted my-2">My Evaluation Results</p> 
                  </section>
                  <section class="col-sm-4 my-4">
                      <img src="../assets/img/Icons/file.png" class="img-fluid zoom" data-toggle="modal" data-target="#individual_performance_teacher">  
                      <p class="lead text-muted my-2">Individual Performance <span hidden="true" class="badge badge-danger">0</span></p>
                  </section>
              </section>
              </div>
              <?php
            }
              ?>
          


              <!-- Modal -->
              <div class="modal fade" id="myevaluation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                               <table class="table table-striped table-sm" id="myratingsheet_data_teacher">
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
                              <table class="table table-striped table-sm" id="myratingsheet_ob_data_teacher">
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
                         <table class="table table-striped table-sm" id="myratingsheet_data_visitor">
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
              <div class="modal fade" id="mycoteachers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Teachers</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                       <table class="table table-striped table-sm" id="teacher_data">
                            <thead>
                              <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
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
              <div class="modal fade" id="individual_performance_teacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document" style="min-width:1450px !important;">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Individual Performance</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                     <form method="post" id="individual_performance_form" enctype="multipart/form-data">
                    <div class="modal-body table-responsive">
                      <div class="text-center">
                        <H3>INDIVIDUAL PERFORMANCE COMMITMENT AND REVIEW FORM</H3>

                        <h4><?php echo $active_sem_year?></h4>
                      </div>
                      <br>
                      <table class="table table-bordered">
  <thead>
  </thead>
  <tbody>
    <tr>
      <td >Name of Teacher:</td>
      <td ><input type="text" class="form-control" name="ind_form_teacherName" id="ind_form_teacherName"></td>
      <td >Name of Rater:</td>
      <td ><input type="text" class="form-control" name="ind_form_raterName" id="ind_form_raterName"></td>
    </tr>

    <tr>
      <td >Position:</td>
      <td ><input type="text" class="form-control" name="ind_form_teacherNamePos" id="ind_form_teacherNamePos"></td>
      <td >Position:</td>
      <td ><input type="text" class="form-control"  name="ind_form_raterNamePos" id="ind_form_raterNamePos"></td>
    </tr>

    <tr>
      <td >Division:</td>
      <td ><input type="text" class="form-control" name="ind_form_division" id="ind_form_division"></td>
      <td >Date of Review:</td>
      <td ><input type="date" class="form-control" name="ind_form_date_review" id="ind_form_date_review"></td>
    </tr>
    <tr>
      <td >Rating Period:</td>
      <td ><input type="text" class="form-control" name="ind_form_ratingperiod" id="ind_form_ratingperiod"></td>
      <td ></td>
      <td ></td>
    </tr>
  </tbody>
</table>
                      <table class="table table-bordered">
  <thead>
    <tr>
      <th   rowspan="2">MFO</th>
      <th   rowspan="2">KRAs</th>
      <th   rowspan="2">OBJECTIVES</th>
      <th   rowspan="2">MOVs</th>
      <th   rowspan="2">TIMELINE</th>
      <th   rowspan="2">WEIGHT</th>
      <th   rowspan="2">PERFORMANCE INDICATORS</th>
      <th   colspan="3">ACTUAL RESULTS</th>
      <th   rowspan="2">AVE.</th>
      <th   rowspan="2">RATING </th>
      <th   rowspan="2">SCORE</th>
    </tr>
    <tr >
      <th >Q</th>
      <th >T</th>
      <th >E</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td rowspan="31">BASIC EDUCATION SERVICES</td>
      <td rowspan="6">Teaching-Learning Process     (30 %)</td>
      <td rowspan="3">Prepare lesson plan/ lesson log based on the prescribed curriculum guide</td>
      <td rowspan="3"><input type="text" class="form-control" id="ind_form_mov1" name="ind_form_mov1" ></td>
      <td rowspan="15"><input type="text" class="form-control" id="ind_form_timeline1" name="ind_form_timeline1"></td>
      <td rowspan="3">15%</td>
      <td rowspan="1">Complete and up-to-date lesson plan/lesson log was submitted.  (Q)</td>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_q1" name="ind_form_q1" style="min-width:52px;"></td>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_t1" name="ind_form_t1" style="min-width:52px;"></td>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_e1" name="ind_form_e1" style="min-width:52px;"></td>
      <td rowspan="3"><input type="text" class="form-control" id="ind_form_ave1" name="ind_form_ave1" style="min-width:52px;" ></td>
      <td rowspan="3"><input type="text" class="form-control" id="ind_form_rating1" name="ind_form_rating1" style="min-width:52px;" ></td>
      <td rowspan="3"><input type="text" class="form-control ind_form_score" id="ind_form_score1" name="ind_form_score1" style="min-width:52px;" ></td>
     
    </tr>
   <tr>
     <td rowspan="1">Lesson plan/lesson log showed utilization of adequate and appropriate instructional materials. (E)</td>
    <td rowspan="1"><input type="text" class="form-control" ></td>
    <td rowspan="1"><input type="text" class="form-control" ></td>
    <td rowspan="1"><input type="text" class="form-control" ></td>
   </tr>
   
   <tr>
     <td rowspan="1">Utilization of technology resources at least once a week or twice a month was indicated in the lesson plan/lesson log. (T)</td>
    <td rowspan="1"><input type="text" class="form-control" ></td>
    <td rowspan="1"><input type="text" class="form-control" ></td>
    <td rowspan="1"><input type="text" class="form-control" ></td>
   </tr>

    <tr> 
      <td rowspan="3">Ensure attainment of learning targets</td>
      <td rowspan="3"><input type="text" class="form-control" id="ind_form_mov2" name="ind_form_mov2" ></td>
      <td rowspan="3">15%</td>
      <td rowspan="1">Differentiated group tasks or activities were employed to maximize learning. (E)</td>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_q2" name="ind_form_q2"></td>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_t2" name="ind_form_t2"></td>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_e2" name="ind_form_e2"></td>
      <td rowspan="3"><input type="text" class="form-control" id="ind_form_ave2" name="ind_form_ave2" ></td>
      <td rowspan="3"><input type="text" class="form-control" id="ind_form_rating2" name="ind_form_rating2"  ></td>
      <td rowspan="3"><input type="text" class="form-control ind_form_score" id="ind_form_score2" name="ind_form_score2"  ></td>
    </tr>
    <tr>
     <td rowspan="1">Processing of outputs or performance was executed through prompt and constructive feedbacks to students. (T)</td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
   </tr>
   
   <tr>
     <td rowspan="1">Formative and summative tests results were utilized to address students’ needs and weaknesses. (Q)</td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
   </tr>

    <tr>
       <td rowspan="9"> Pupils  Outcome  ( 40% )</td>
       <td rowspan="3">Monitor pupils daily attendance everyday within the rating period</td>
       <td rowspan="3"><input type="text" class="form-control" id="ind_form_mov3" name="ind_form_mov3" ></td>
       <td rowspan="3"> 10%</td>
       <td rowspan="1">Pupils attendance were monitored based on school policy. (Q )</td> 
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_q3" name="ind_form_q3"></td>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_t3" name="ind_form_t3"></td>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_e3" name="ind_form_e3"></td>
      <td rowspan="3"><input type="text" class="form-control" id="ind_form_ave3" name="ind_form_ave3" ></td>
      <td rowspan="3"><input type="text" class="form-control" id="ind_form_rating3" name="ind_form_rating3"></td>
      <td rowspan="3"><input type="text" class="form-control ind_form_score" id="ind_form_score3" name="ind_form_score3" ></td>
    </tr>
  <tr>
    <td rowspan="1">Accurate and reliable pu[pils attendance were monitored and encoded daily using Sf2.  (E )</td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
   </tr>
   <tr>
    <td rowspan="1">Attendance monitoring was done daily and encoded in Sf2 and submitted on time. (T)</td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
   </tr>

  <tr>
    <td rowspan="3">Undertake activities to improve pupil performance</td>
    <td rowspan="1"><input type="text" class="form-control" id="ind_form_mov4" name="ind_form_mov4" ></td>
    <td rowspan="3"> 10%</td>
    <td rowspan="1">Peer tutoring and cooperative learning were used in the classroom to assist students with learning difficulties. (E)</td>
    <td rowspan="1"><input type="text" class="form-control" id="ind_form_q4" name="ind_form_q4"></td>
    <td rowspan="1"><input type="text" class="form-control" id="ind_form_t4" name="ind_form_t4"></td>
    <td rowspan="1"><input type="text" class="form-control" id="ind_form_e4" name="ind_form_e4"></td>
    <td rowspan="3"><input type="text" class="form-control" id="ind_form_ave4" name="ind_form_ave4" ></td>
    <td rowspan="3"><input type="text" class="form-control" id="ind_form_rating4" name="ind_form_rating4"></td>
    <td rowspan="3"><input type="text" class="form-control ind_form_score" id="ind_form_score4" name="ind_form_score4" ></td>
  </tr>

  <tr>
    <td rowspan="1"><input type="text" class="form-control" id="ind_form_mov4" name="ind_form_mov4" ></td>
    <td rowspan="1">Intervention materials (workbooks, SIMs, etc.) were provided to enhance or improve learning. (Q)</td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
  </tr>
  <tr>
    <td rowspan="1"><input type="text" class="form-control" id="ind_form_mov6" name="ind_form_mov6" ></td>
    <td rowspan="1">Monthly or quarterly record of progress was used to evaluate student performance. (T)</td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
  </tr>
  <tr>
    <td rowspan="3">Maintain updated pupils' school records and reports by department </td>
    <td rowspan="1"><input type="text" class="form-control" id="ind_form_mov7" name="ind_form_mov7" ></td>
    <td rowspan="3">20%</td>
    <td rowspan="1">Complete, accurate, and updated school records (grading sheets, report cards, transcript of record) were submitted and checked  quarterly.  (Q)</td>
    <td rowspan="1"><input type="text" class="form-control" id="ind_form_q5" name="ind_form_q5"></td>
    <td rowspan="1"><input type="text" class="form-control" id="ind_form_t5" name="ind_form_t5"></td>
    <td rowspan="1"><input type="text" class="form-control" id="ind_form_e5" name="ind_form_e5"></td>
    <td rowspan="3"><input type="text" class="form-control" id="ind_form_ave5" name="ind_form_ave5" ></td>
    <td rowspan="3"><input type="text" class="form-control" id="ind_form_rating5" name="ind_form_rating5"></td>
    <td rowspan="3"><input type="text" class="form-control ind_form_score" id="ind_form_score5" name="ind_form_score5" ></td>
    
  </tr>

  <tr>
    <td rowspan="1"><input type="text" class="form-control" id="ind_form_mov8" name="ind_form_mov8" ></td>
    <td rowspan="1">Report on tracking student performance (quarterly assessment, test results utilization, proficiency, and related performance indicators) were accomplished and </td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
  </tr>
  <tr>
    <td rowspan="1"><input type="text" class="form-control" id="ind_form_mov9" name="ind_form_mov9" ></td>
    <td rowspan="1">Monthly/quarterly reports were properly documented and published. (E)</td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
  </tr>

  <tr>
    <td rowspan="7">Community Involvement        (10%)</td>
    <td rowspan="3">Participate in activities of governmental and non-governmental organizations</td>
    <td rowspan="1"><input type="text" class="form-control" id="ind_form_mov10" name="ind_form_mov10" ></td>
    <td rowspan="7"><input type="text" class="form-control" id="ind_form_timeline2" name="ind_form_timeline2" ></td>
    <td rowspan="3">5%</td>
    <td rowspan="1">Active participation in all school programs and activities within the school year was done. (Q)</td>
    <td rowspan="1"><input type="text" class="form-control" id="ind_form_q6" name="ind_form_q6"></td>
    <td rowspan="1"><input type="text" class="form-control" id="ind_form_t6" name="ind_form_t6"></td>
    <td rowspan="1"><input type="text" class="form-control" id="ind_form_e6" name="ind_form_e6"></td>
    <td rowspan="3"><input type="text" class="form-control" id="ind_form_ave6" name="ind_form_ave6"></td>
    <td rowspan="3"><input type="text" class="form-control" id="ind_form_rating6" name="ind_form_rating6"></td>
    <td rowspan="3"><input type="text" class="form-control ind_form_score" id="ind_form_score6" name="ind_form_score6" ></td>
    
  </tr>

  <tr>
    <td rowspan="1"><input type="text" class="form-control" id="ind_form_mov11" name="ind_form_mov11" ></td>
    <td rowspan="1">One community activity was participated with complete attendance. (E )</td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
  </tr>
  
  <tr>
    <td rowspan="1"></td>
    <td rowspan="1">Attendance in  community-related activities was noted within the school year. (T)</td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
    <td rowspan="1"><input type="text" class="form-control"></td>
  </tr>
   <tr>
    <td rowspan="4">Involve the community in sharing accountability for learners’ achievement</td>
    <td rowspan="1"><input type="text" class="form-control" id="ind_form_mov12" name="ind_form_mov12" ></td>
    <td rowspan="4">5%</td>
    <td rowspan="1">School programs that promote students’ learning progress was participated in by the community. (E)</td>
    <td rowspan="1"><input type="text" class="form-control" id="ind_form_q7" name="ind_form_q7"></td>
    <td rowspan="1"><input type="text" class="form-control" id="ind_form_t7" name="ind_form_t7"></td>
    <td rowspan="1"><input type="text" class="form-control" id="ind_form_e7" name="ind_form_e7"></td>
    <td rowspan="4"><input type="text" class="form-control" id="ind_form_ave7" name="ind_form_ave7" ></td>
    <td rowspan="4"><input type="text" class="form-control" id="ind_form_rating7" name="ind_form_rating7" ></td>
    <td rowspan="4"><input type="text" class="form-control ind_form_score" id="ind_form_score7" name="ind_form_score7" ></td>
    </tr>
    <tr>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_mov13" name="ind_form_mov13" ></td>
      <td rowspan="1">Home visitation to parents of students needing follow-up was conducted every grading period. (T)</td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
    </tr>
    <tr>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_mov14" name="ind_form_mov14" ></td>
      <td rowspan="1">Conference/meeting with parents or guardians of learners with school-related problems was done. (Q)</td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
    </tr>
    <tr>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_mov15" name="ind_form_mov15" ></td>
      <td rowspan="1">Cooperative working relationship between teachers and parents was established. (Q)</td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
    </tr>
    <tr>
      <td rowspan="9">Professional Growth & Development and Ethics (10 %)</td>
      <td rowspan="4">Get involved in professional organizations or groups and other agencies that can improve teaching practice</td>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_mov16" name="ind_form_mov16" ></td>
      <td rowspan="9"><input type="text" class="form-control" id="ind_form_timeline3" name="ind_form_timeline3" ></td>
      <td rowspan="4">5%</td>
      <td rowspan="1">Earned at least 6 MA units within a year (Q)</td>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_q8" name="ind_form_q8"></td>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_t8" name="ind_form_t8"></td>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_e8" name="ind_form_e8"></td>
    <td rowspan="4"><input type="text" class="form-control" id="ind_form_ave8" name="ind_form_ave8" ></td>
    <td rowspan="4"><input type="text" class="form-control" id="ind_form_rating8" name="ind_form_rating8" ></td>
    <td rowspan="4"><input type="text" class="form-control ind_form_score" id="ind_form_score8" name="ind_form_score8" ></td>
    </tr>
    <tr>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_mov17" name="ind_form_mov17" ></td>
      <td rowspan="1">Active participation in at least two seminars and trainings (school-based, division, and regional) (Q) </td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
    </tr>
    <tr>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_mov18" name="ind_form_mov18" ></td>
      <td rowspan="1">Membership in at least one professional organization or association (E)</td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
    </tr>
    <tr>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_mov19" name="ind_form_mov19" ></td>
      <td rowspan="1">Observed punctuality in all meetings and activities attended (T)</td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
    </tr>
    <tr>
      <td rowspan="4">Support to personel administration </td> 
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_mov20" name="ind_form_mov20" ></td>
      <td rowspan="4">5%</td>
      <td rowspan="1">Submitted  DTR/CSC Form 48 in a school year without error . (T )</td>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_q9" name="ind_form_q9"></td>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_t9" name="ind_form_t9"></td>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_e9" name="ind_form_e9"></td>
      <td rowspan="4"><input type="text" class="form-control" id="ind_form_ave9" name="ind_form_ave9" ></td>
      <td rowspan="4"><input type="text" class="form-control" id="ind_form_rating9" name="ind_form_rating9" ></td>
      <td rowspan="4"><input type="text" class="form-control ind_form_score" id="ind_form_score9" name="ind_form_score9" ></td>
    </tr>

    <tr>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_mov21" name="ind_form_mov21" ></td>
      <td rowspan="1">Dressed in accordance with proper decorum and or prescribed rules and regulation and is neat in appearance at all times. ( Q.)</td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
    </tr>
    <tr>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_mov22" name="ind_form_mov22" ></td>
      <td rowspan="1">Manifest positive attitude towards constructive comments, suggestions and recommendation. (Q)</td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
    </tr>
    <tr>
      <td rowspan="2"><input type="text" class="form-control" id="ind_form_mov23" name="ind_form_mov23" ></td>
      <td rowspan="1">Timeline on all school activities was strictly followed. (E) </td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"><input type="text" class="form-control"></td>
      <td rowspan="1"></td>
    </tr> 
    <tr>
      <td rowspan="1"> Plus Factor</td>
      <td rowspan="1"> 10%</td>
      <td rowspan="1"></td>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_q10" name="ind_form_q10"></td>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_t10" name="ind_form_t10"></td>
      <td rowspan="1"><input type="text" class="form-control" id="ind_form_e10" name="ind_form_e10"></td>
      <td rowspan="4"><input type="text" class="form-control" id="ind_form_ave10" name="ind_form_ave10" ></td>
      <td rowspan="4"><input type="text" class="form-control" id="ind_form_rating10" name="ind_form_rating10" ></td>
      <td rowspan="4"><input type="text" class="form-control ind_form_score" id="ind_form_score10" name="ind_form_score10" ></td>

      
    </tr>
  </tbody>
</table>
<i>*To get the score, the rating is multiplied by the weight assigned</i>
<div class="text-center">
  <table class="table table-borderless">
  <thead>
    <tr>
      <th >Ratee:</th>
      <th></th>
      <th >Rater:</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td ><input type="text" class="form-control" id="ind_form_raterName1" name="ind_form_raterName1" ></td>
      <td ></td>
      <td ><input type="text" class="form-control" id="ind_form_raterName1" name="ind_form_raterName1" ></td>
    </tr>
    <tr>
      <td >Teacher I</td>
      <td ></td>
      <td >Principal II</td>
    </tr>
  </tbody>
</table>
</div>
<h3>PART III:  SUMMARY OF RATING FOR DISCUSSION</h3>
<table class="table table-bordered">
  <thead>
    <tr>
      <th >Final Performance Results</th>
      <th>Rating</th>
      <th >Adjectival Rating</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td >Accomplishment of KRAs and Objectives</td>
      <td ><input type="text" class="form-control"  id="ind_form_akra_rating" name="ind_form_akra_rating"    readonly></td>
      <td ><input type="text" class="form-control" name="ind_form_akra_ratingAdjRating"  id="ind_form_akra_ratingAdjRating" value="" readonly>
    </td>
    </tr>
  </tbody>
</table>
</div>
<strong>Rater – Ratee Agreement</strong>
The signatures below confirm that the employee and his/her superior have agreed to the content of this appraisal form and the performance rating
<table class="table table-bordered">
  <thead>
  </thead>
  <tbody>
    <tr>
      <td >Name of Employee:</td>
      <td ><input type="text" class="form-control"  name="ind_form_akra_rra_emp1"  id="ind_form_akra_rra_emp1"></td>
      <td >Name of Employee:</td>
      <td ><input type="text" class="form-control"  name="ind_form_akra_rra_emp2"  id="ind_form_akra_rra_emp2"></td>
    </tr>

    <tr>
      <td >Signature:</td>
      <td ></td>
      <td >Signature:</td>
      <td ></td>
    </tr>

    <tr>
      <td >Date:</td>
      <td ><input type="date" class="form-control" name="ind_form_akra_rrad_emp1"  id="ind_form_akra_rrad_emp1"></td>
      <td >Date:</td>
      <td ><input type="date" class="form-control" name="ind_form_akra_rrad_emp2"  id="ind_form_akra_rrad_emp2"></td>
    </tr>
  </tbody>
</table>
                  
                    <div class="modal-footer">
                      <input type="hidden" name="operation" id="operation" value="individual_performance_submit">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary" name="ind_form_submit" id="ind_form_submit">Submit</button>
                      <!-- <input type="hidden" name="ind_form_acs_ID" id="ind_form_acs_ID" value="<?php echo $active_sem_ID ?>"> -->
                      <input type="hidden" name="ind_form_sem_ID" id="ind_form_sem_ID" value="<?php echo $active_sem_ID ?>">
                    </div>

                  </form><!-- //indidual performance submit  -->
                  </div>
                </div>
              </div>
                <?php
              }

              ?>
              <?php 
              if($auth_user->visitor_level()){

                $vquery = "SELECT *,
                CONCAT(YEAR(`rsem`.`sem_start`),' - ',YEAR(`rsem`.`sem_end`)) `sem_year`,
                LEFT(rtd.tcd_MName, 1) tcd_MNamex  FROM `academic_staff` `acs` 
                LEFT JOIN `record_teacher_details` `rtd` ON `rtd`.`tcd_ID` = `acs`.`tcd_ID`
                LEFT JOIN `ref_suffixname` `rsn` ON `rsn`.`suffix_ID` = `rtd`.`suffix_ID`
                LEFT JOIN `ref_subject` `rsub` ON `rsub`.`subject_ID` = `acs`.`subject_ID`
                LEFT JOIN `ref_year_level` `ryl` ON `ryl`.`yl_ID` = `acs`.`yl_ID`
                LEFT JOIN `ref_position` `rpos` ON `rpos`.`pos_ID` = `acs`.`pos_ID`
                LEFT JOIN `ref_semester` `rsem` ON `rsem`.`sem_ID` = `acs`.`sem_ID` WHERE `acs`.`sem_ID` = ".$active_sem_ID." ";
                $statementv = $auth_user->runQuery($vquery);
                $statementv->execute();
                $resultv = $statementv->fetchAll();
                

                if(isset($_REQUEST["page"])){
                    ?>
                    <div class="col-6 col-sm-6">
                      <div class="card " style="border:solid 0.9px ;">
                        <div class="card-header text-center" style=" border-bottom: 5px solid ;">
                         <strong>MISSION</strong>
                        </div>
                        <div class="card-body text-justify"  style="min-height: 350px">
                          <p>
                              To protect and promote the right of every Filipino to quality, equitable, culture-based, and complete basic education where:<br>
                              <ul class="text-justify">
                                  <li>Students learn in child-friendly, gender-sensitive safe and motivating environment.</li>
                                  <li>Teachers facilitate learning and constantly nurture every learner.</li>
                                  <li>Administrators and staff, as stewards of the institution, ensure an enabling and supportive environment for effective learning to happen.</li>
                              </ul>
                              Family, community and other Stakeholders are actively engaged and share responsibility for developing life-long learners.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 col-sm-6">
                      <div class="card " style="border:solid 0.9px ;">
                        <div class="card-header text-center" style=" border-bottom: 5px solid ;">
                          <strong>VISION</strong>
                        </div>
                        <div class="card-body text-justify"  style="min-height: 350px">
                          <p>
                              We dream of Filipinos who passionately love their country and whose and competencies enable them to realize their full potential and contribute meaningfully to building the nation. As a learner-centered public institution, the Department of Education continuously improves itself to better serve its stakeholders.
                          </p>
                        </div>
                      </div>
                    </div>
                    <?php
                }
                else{
                  ?>

                  <div class="col-12 col-sm-12">
                    <div class="text-center">
                    <h2 >List of Teachers (<?php echo $active_sem_year?>)</h2>
                    </div>
                      </div>
                    <?php 
                    foreach($resultv as $row){
                      if($row["suffix"] =="N/A")
                      {
                        $suffix = "";
                      }
                      else
                      {
                        $suffix = $row["suffix"];
                      }

                      if (!empty($row['user_Img'])) {
                       $vimg = 'data:image/jpeg;base64,'.base64_encode($row['user_Img']);
                      }
                      else{
                        $vimg = "../assets/img/users/default.jpg";
                      }
                      ?>
                      <div class="col-4">
                      <div class="card " style="border:solid 0.9px ;">
                        <div class="card-header text-center" style=" border-bottom: 5px solid ;">
                          <strong><?php echo ucwords(strtolower($row["tcd_LName"].', '.$row["tcd_FName"].' '.$row["tcd_MNamex"].'. '.$suffix));?></strong>
                        </div>
                        <div class="card-body text-center"  style="min-height: 250px">
                          
                          <img id="p_img" src="<?php echo $vimg?>" alt="<?php echo ucwords(strtolower($row["tcd_LName"].', '.$row["tcd_FName"].' '.$row["tcd_MNamex"].'. '.$suffix));?> Image"  runat="server"  height="125" width="125" class="" style="border:1px solid; border-color:#383d41;"/>
                          <br><ul class="list-group list-group-flush">
                              <li class="list-group-item"> <?php echo $row["subject_Title"];?></li>
                              <li class="list-group-item"> <?php echo $row["pos_Name"];?></li>
                              <li class="list-group-item"> <a class="btn btn-primary" href="teacher_view.php?staff_ID=<?php echo $row["acs_ID"];?>" target="_BLANK">View</a> </li>
                            </ul>
                            
                        </div>
                      </div>
                      </div>
                      <?php
                    }
                    ?>
                    
                
                    <?php
                  }

                  ?> 
                </div>
                  <?php

                }
                ?>



    </main>
  </div>
</div>
<?php 
include('x-script.php');
if($auth_user->teacher_level()){

     $szlq  ="SELECT * FROM `record_teacher_details` WHERE user_ID = ".$_SESSION["user_ID"]."";
   

    $statementxzz = $auth_user->runQuery($szlq);
    $statementxzz->execute();
    $resultvx = $statementxzz->fetchAll();
    foreach($resultvx as $row)
    {
     $tcd_ID = $row["tcd_ID"];
    }

?>

 <script > 
  $(document).ready(function() {
             
            var myratingsheet_data_teacher_dataTable = $('#myratingsheet_data_teacher').DataTable({
            "processing":true,
            "serverSide":true,
            "ordering":false,
            "bAutoWidth": false,
            "ajax":{
              url:"datatable/evaluation/fetch_ratingsheet_teacher.php",
              type:"POST"
            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],

          });

            var myratingsheet_ob_data_teacher_dataTable = $('#myratingsheet_ob_data_teacher').DataTable({
            "processing":true,
            "serverSide":true,
            "ordering":false,
            "bAutoWidth": false,
            "ajax":{
              url:"datatable/evaluation/fetch_ratingsheet_teacher_note.php?",
              type:"POST"
            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],

          });

             var myratingsheet_data_visitor_dataTable = $('#myratingsheet_data_visitor').DataTable({
            "processing":true,
            "serverSide":true,
            "ordering":false,
            "bAutoWidth": false,
            "searching": false,
            "paging":     false,
            "ajax":{
              url:"datatable/evaluation/fetch_inter_observe_visitor.php",
              type:"POST"
            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],

          });

       
             

            
            var teacher_data_dataTable = $('#teacher_data').DataTable({
            "processing":true,
            "serverSide":true,
            "ordering":false,
            "bAutoWidth": false,
            "ajax":{
              url:"datatable/academicstaff/fetch_coteacher.php?sem_ID="+<?php echo $active_sem_ID;?>,
              type:"POST"
            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],

          });

            
        
  });
  </script>
  <?php  } ?>
  <script>
    $(document).ready(function() {

    // });
       var individualperformance_dataTable = $('#individualperformance_data').DataTable({
            "processing":true,
            "serverSide":true,
            "ordering":false,
            "bAutoWidth": false,
            "searching": false,
            "paging":     false,
            "ajax":{
              url:"datatable/evaluation/fetch_individual_performance.php",
              type:"POST"
            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],

          });

       
         $(document).on('click', '.individual_approval', function(event){
             var type = $(this).attr("data-id");
             var fip_ID = $(this).attr("id");
             var alertmsg;
             var op;
             if (type == 0 || type == null){
              alertmsg = "Are you sure you want to approve this individual performance?";
              op  = "interrating_approve";
             }
             else if (type == 1){
              alertmsg = "Are you sure you want to disapprove this individual performance?";
              op  = "interrating_disapprove";
             }
             else{
              alertmsg = "Are you sure you want to approve this individual performance?";
              op  = "interrating_approve";
             }
             alertify.confirm(alertmsg, 
            function(){
              $.ajax({
               type        :   'POST',
               url:"datatable/evaluation/insert.php",
               data        :   {operation:op,fip_ID:fip_ID},
               dataType    :   'json',
               complete     :   function(data) {
                 alertify.alert(data.responseText).setHeader('Individual Performance Form');
                 individualperformance_dataTable.ajax.reload();
                  
               }
              })

               alertify.success('Ok') 
             },
            function(){ 
              alertify.error('Cancel')
            }).setHeader('Individual Performance Form');
           
          });

       $(document).on('click', '.review', function(event){
         var fip_ID = $(this).attr("id");
           $.ajax({
                  url:"datatable/evaluation/fetch_single.php",
                  method:'POST',
                  data:{action:"interrating_fecth",fip_ID:fip_ID},
                  dataType    :   'json',
                  success:function(data)
                  {

                    $('#fetch_teacher_name').val(data.ratee_Name);
                    $('#fetch_ratee_name').val(data.ratee_Name);
                    $('#fetch_individual_schoolyear').html(data.shoolyear);
                   
                    
                  }
                });

           
        });

        function checkrating(rating){
            if(rating >=4.500 & rating <=5.000){
              $('#ind_form_akra_ratingAdjRating').val('Outstanding');
            }
            if (rating >=3.500 & rating <=4.499){
              
              $('#ind_form_akra_ratingAdjRating').val('Very Satisfactory');
            }
            if (rating >=2.500 & rating <=3.499){
              
              $('#ind_form_akra_ratingAdjRating').val('Satisfactory');
            }
            if (rating >=1.500 & rating <=2.499){
              
              $('#ind_form_akra_ratingAdjRating').val('Unsatisfactory');
            }
            if (rating <=1.499){
              
              $('#ind_form_akra_ratingAdjRating').val('Poor');
            }
        }



        $(document).on('submit', '#individual_performance_form', function(event){
          event.preventDefault();
         $.ajax({
            url:"datatable/evaluation/insert.php",
            method:'POST',
            data:new FormData(this),
            contentType:false,
            processData:false,
            success:function(data)
            {
              alertify.alert(data).setHeader('Individual Performance Form');
              $('#individual_performance_teacher').modal('hide');
            }
          });
        
       
         });
        $(document).on('onkeyup change', '.ind_form_score', function(event){
      
          var sc1 =  $('#ind_form_score1').val();
          var sc2 =  $('#ind_form_score2').val();
          var sc3 =  $('#ind_form_score3').val();
          var sc4 =  $('#ind_form_score4').val();
          var sc5 =  $('#ind_form_score5').val();
          var sc6 =  $('#ind_form_score6').val();
          var sc7 =  $('#ind_form_score7').val();
          var sc8 =  $('#ind_form_score8').val();
          var sc9 =  $('#ind_form_score9').val();
          var sc10 = $('#ind_form_score10').val();
          if (sc1 == ""){ sc1 = 0; }
          if (sc2 == ""){ sc2 = 0; }
          if (sc3 == ""){ sc3 = 0; }
          if (sc4 == ""){ sc4 = 0; }
          if (sc5 == ""){ sc5 = 0; }
          if (sc6 == ""){ sc6 = 0; }
          if (sc7 == ""){ sc7 = 0; }
          if (sc8 == ""){ sc8 = 0; }
          if (sc9 == ""){ sc9 = 0; }
          if (sc10 == ""){ sc10 = 0; }
          var sc1  = parseFloat(sc1, 10)  ;
          var sc2  = parseFloat(sc2, 10)  ;
          var sc3  = parseFloat(sc3, 10)  ;
          var sc4  = parseFloat(sc4, 10)  ;
          var sc5  = parseFloat(sc5, 10)  ;
          var sc6  = parseFloat(sc6, 10)  ;
          var sc7  = parseFloat(sc7, 10)  ;
          var sc8  = parseFloat(sc8, 10)  ;
          var sc9  = parseFloat(sc9, 10)  ;
          var sc10 = parseFloat(sc10, 10) ;
          var sum = eval(sc1+sc2 +
                    sc3 +
                    sc4 +
                    sc5 +
                    sc6 +
                    sc7 +
                    sc8 +
                    sc9 +
                    sc10);
          $('#ind_form_akra_rating').val(sum);

         
          checkrating(sum);
       
         });



           
        });
         
         
  </script>
  </body>

      
      
</html>
