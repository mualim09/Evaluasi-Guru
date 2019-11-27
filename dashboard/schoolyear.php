<?php 
include('../session.php');


require_once("../class.user.php");

  
$auth_user = new USER();
// $page_level = 3;
// $auth_user->check_accesslevel($page_level);
$pageTitle = "Manage School Year";
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
        <h1 class="h2">Manage School Year</h1>
        
      </div>

      <div class="table-responsive">

          <?php 
          $aus = $auth_user->semester();
          if (sizeof($aus) <= 0){
            ?>
                     <button type="button" class="btn btn-sm btn-success add" >
            Add 
          </button>
            <?php
          }
          foreach($aus as $row)
          {
            $sem_startx = $row["sem_start"];
            $sem_endx = $row["sem_end"];
          }
      
          $sem_startx = strtotime($sem_startx);
          $sem_endx = strtotime($sem_endx);
          $sem_startx_Y = date("Y",$sem_startx);
          $sem_startx_M = date("m",$sem_startx);
          $sem_startx_D = date("d",$sem_startx);

          $sem_endx_Y = date("Y",$sem_endx);
          $sem_endx_M = date("m",$sem_endx);
          $sem_endx_D = date("d",$sem_endx);

          $nayear_s = $sem_startx_Y+1;  
          $nayear_e = $sem_endx_Y+1;  

          $nayear_s = date_create("$nayear_s-$sem_startx_M-$sem_startx_D");
          $nayear_e = date_create("$nayear_e-$sem_startx_M-$sem_startx_D");


          $nayear_s = date_format($nayear_s,"Y/m/d");
          $nayear_e = date_format($nayear_e,"Y/m/d");

           $datenow = date("Y");
          if ( $datenow >=$sem_endx_Y)
          { 
            $s1x = "UPDATE `ref_semester` SET `stat_ID` = '0'";
            $st1x = $auth_user->runQuery($s1x);
            $rs1x = $st1x->execute();

            $sql = "INSERT INTO `ref_semester` (`sem_ID`, `sem_start`, `sem_end`, `stat_ID`) 
            VALUES (NULL, '$nayear_s', '$nayear_e', 1);";
              $statementx = $auth_user->runQuery($sql);
                
              $resultx = $statementx->execute();
          }



          ?>
         <br><br>
        <table class="table table-striped table-sm" id="section_data">
          <thead>
            <tr>
              <th>#</th>
              <th>School Year</th>
              <!-- <th>Status</th> -->
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            
     
          </tbody>
        </table>


<div class="modal fade" id="semester_modal" tabindex="-1" role="dialog" aria-labelledby="product_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="semester_modal_title">Add Academic Year</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="product_modal_content">
    
      <form method="post" id="semester_form" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="semester_start">Start<span class="text-danger">*</span></label>
                  <input type="date" class="form-control" id="semester_start" name="semester_start" placeholder="" value="" required="">
                </div>
                <div class="form-group col-md-4">
                  <label for="semester_end">End<span class="text-danger">*</span></label>
                  <input type="date" class="form-control" id="semester_end" name="semester_end" placeholder="" value="" required="">
                </div>
                  <div class="form-group col-md-4">
                  <label for="semester_stat">Status<span class="text-danger">*</span></label>
                  <select class="form-control" id="semester_stat" name="semester_stat">
                  <option value="1">Activate</option>
                  <option value="0">Deactivate</option>
                </select>
                </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="semester_ID" id="semester_ID" />
        <input type="hidden" name="operation" id="operation" />
        <div class="">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary submit" id="submit_input" value="submit_semester">Submit</button>
        </div>
      </div>
       </form>
    </div>
  </div>
</div>


      </div>

<div class="modal fade" id="delsemester_modal" tabindex="-1" role="dialog" aria-labelledby="product_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="semester_modal_title">Delete this Section</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center">
        <div class="btn-group">
        <button type="submit" class="btn btn-danger" id="Section_delform">Delete</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
   


          $(document).ready(function() {
             
            var dataTable = $('#section_data').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
              url:"datatable/academicyear/fetch.php",
              type:"POST"
            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],

          });



          $(document).on('submit', '#semester_form', function(event){
            event.preventDefault();

              $.ajax({
                url:"datatable/academicyear/insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                  alertify.alert(data).setHeader('Section');
                  $('#semester_form')[0].reset();
                  $('#semester_modal').modal('hide');
                  dataTable.ajax.reload();
                }
              });
           
          });

          $(document).on('click', '.add', function(){
            $('#semester_modal_title').text('Add Academic Year');
            $("#semester_start").prop("disabled", false);
            $("#semester_end").prop("disabled", false);
            $("#semester_stat").prop("disabled", false);
            $('#semester_form')[0].reset();
            $('#semester_modal').modal('show');
            $('#submit_input').show();
            $('#submit_input').text('Submit');
            $('#submit_input').val('submit_semester');
            $('#operation').val("submit_semester");
          });

          $(document).on('click', '.view', function(){
            var semester_ID = $(this).attr("id");
            $('#semester_modal_title').text('View Academic Year');
            $('#semester_modal').modal('show');
            $("#submit_input").hide();
            
             $.ajax({
                url:"datatable/academicyear/fetch_single.php",
                method:'POST',
                data:{action:"semester_view",semester_ID:semester_ID},
                dataType    :   'json',
                success:function(data)
                {

                  $("#semester_start").prop("disabled", true);
                  $("#semester_end").prop("disabled", true);
                  $("#semester_stat").prop("disabled", true);

                  $('#semester_start').val(data.sem_start);
                  $('#semester_end').val(data.sem_end);
                  $('#semester_stat').val(data.stat_ID).change();

                  $('#submit_input').hide();
                  $('#semester_ID').val(semester_ID);
                  $('#submit_input').text('View');
                  $('#submit_input').val('semester_view');
                  $('#operation').val("semester_view");
                  
                }
              });


            });
          $(document).on('click', '.edit', function(){
            var semester_ID = $(this).attr("id");
            $('#semester_modal_title').text('Edit Academic Year');
            $('#semester_modal').modal('show');
            $("#submit_input").show();

            
             $.ajax({
                url:"datatable/academicyear/fetch_single.php",
                method:'POST',
                data:{action:"semester_edit",semester_ID:semester_ID},
                dataType    :   'json',
                success:function(data)
                {

                  
                
                  $("#semester_start").prop("disabled", false);
                  $("#semester_end").prop("disabled", false);
                  $("#semester_stat").prop("disabled", false);

                  
                  $('#semester_start').val(data.sem_start);
                  $('#semester_end').val(data.sem_end);
                  $('#semester_stat').val(data.stat_ID).change();

                  $('#submit_input').show();
                  $('#semester_ID').val(semester_ID);
                  $('#submit_input').text('Update');
                  $('#submit_input').val('semester_update');
                  $('#operation').val("semester_edit");
                  
                }
              });


            });
            $(document).on('click', '.delete', function(){
            var semester_ID = $(this).attr("id");
             $('#delsemester_modal').modal('show');
             $('.submit').hide();
             
             $('#semester_ID').val(semester_ID);
            });

           


          $(document).on('click', '#Section_delform', function(event){
             var semester_ID =  $('#semester_ID').val();
            $.ajax({
             type        :   'POST',
             url:"datatable/academicyear/insert.php",
             data        :   {operation:"delete_section",semester_ID:semester_ID},
             dataType    :   'json',
             complete     :   function(data) {
               $('#delsemester_modal').modal('hide');
               alertify.alert(data.responseText).setHeader('Delete this Section');
               dataTable.ajax.reload();
               dataTable_product_data.ajax.reload();
                
             }
            })
           
          });
          
          } );


        </script>
        </body>

</html>
