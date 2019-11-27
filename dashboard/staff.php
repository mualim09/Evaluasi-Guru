<?php 
include('../session.php');


require_once("../class.user.php");

  
$auth_user = new USER();
// $page_level = 3;
// $auth_user->check_accesslevel($page_level);
$pageTitle = "Manage Staff";
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
        <h1 class="h2">Manage Staff</h1>
        
      </div>

      <div class="table-responsive">
         <button type="button" class="btn btn-sm btn-primary add" >
            Add 
          </button>
         <br><br>
        <table class="table table-striped table-sm" id="staff_data">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Subject</th>
              <th>Position</th>
              <th>Grade Level</th>
              <th>Schoolyear</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            
     
          </tbody>
        </table>


<div class="modal fade" id="staff_modal" tabindex="-1" role="dialog" aria-labelledby="staff_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staff_modal_title">Add Staff</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="staff_modal_content">
        
      <form method="post" id="staff_form" enctype="multipart/form-data">
            <div class="form-row">

                <div class="form-group col-md-12">
                  <button type="button" class="float-right btn btn-sm btn-success" data-toggle="modal" data-target="#browse_teacher_modal" id="btn_browse_teacher">
                    BROWSE 
                  </button>
                  <br>
                  <label for="staff_name">Name<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="staff_name" name="staff_name" placeholder="" value="" disabled>
                </div>
                  <div class="form-group col-md-12">
                  <!-- <label for="staff_semester">School Year<span class="text-danger">*</span></label> -->
                 <!--  <select class="form-control" id="staff_semester" name="staff_semester">
                  <?php 
                   $auth_user->ref_semester();
                  ?>
                </select> -->
                 <!-- <div class="form-control" > -->
                   <?php 
                   $auth_user->ref_semester1("staff_semester");
                  ?>
                <!-- </div> -->
                </div>
                  <div class="form-group col-md-12">
                  <label for="staff_subject">Subject<span class="text-danger">*</span></label>
                  <select class="form-control" id="staff_subject" name="staff_subject">
                  <?php 
                   $auth_user->ref_subject();
                  ?>
                </select>
                </div>
                  <div class="form-group col-md-12">
                  <label for="staff_position">Position<span class="text-danger">*</span></label>
                  <select class="form-control" id="staff_position" name="staff_position">
                  <?php 
                   $auth_user->ref_position();
                  ?>
                </select>
                </div>
                 <div class="form-group col-md-12">
                  <label for="staff_glvl">Grade Level<span class="text-danger">*</span></label>
                  <select class="form-control" id="staff_glvl" name="staff_glvl">
                  <?php 
                   $auth_user->ref_year_level();
                  ?>
                </select>
                </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="teacher_ID" id="teacher_ID" />
        <input type="hidden" name="staff_ID" id="staff_ID" />
        <input type="hidden" name="operation" id="operation" />
        <div class="">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary submit" id="submit_input" value="submit_staff">Submit</button>
        </div>
      </div>
       </form>
    </div>
  </div>
</div>


      </div>

<div class="modal fade" id="delstaff_modal" tabindex="-1" role="dialog" aria-labelledby="staff_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staff_modal_title">Delete this Section</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center">
        <div class="btn-group">
        <button type="submit" class="btn btn-danger" id="staff_delform">Delete</button>
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

<!-- Modal -->
<div class="modal fade" id="browse_teacher_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Teacher Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-striped table-sm" id="teacher_data">
          <thead>
            <tr>
              <th>#</th>
              <th>Government ID</th>
              <th>Name</th>
            </tr>
          </thead>
          <tbody>
            
     
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
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
             
            var dataTable = $('#staff_data').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
              url:"datatable/academicstaff/fetch.php",
              type:"POST"
            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],

          });
             var dataTableTeacherRecord = $('#teacher_data').DataTable({
            "processing":true,
            "serverSide":true,
     "bAutoWidth": false,
            "order":[],
            "ajax":{
              url:"datatable/teacher/fetch.php",
              type:"POST"
            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],

          });

   //JQUERY FOR SELECTING TEACHER ID WHEN BROWSING
   //----------------------------------------------------------------
    var teacherRec = '#teacher_data tbody';

    $(teacherRec).on('click', 'tr', function(){
      
      var cursor = dataTableTeacherRecord.row($(this));//get the clicked row
      var data=cursor.data();// this will give you the data in the current row.
       if(confirm("Are you sure you want to use "+data[2]+"?"))
    {

      $('#staff_form').find("input[name='teacher_ID'][type='hidden']").val(data[0]);
      $('#staff_form').find("input[name='staff_name'][type='text']").val(data[2]);

    }
      else
    {
      return false; 
    }
      $('#browse_teacher_modal').modal('hide');
      
    });



          $(document).on('submit', '#staff_form', function(event){
            event.preventDefault();

              $.ajax({
                url:"datatable/academicstaff/insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                  alertify.alert(data).setHeader('Staff');
                  $('#staff_form')[0].reset();
                  $('#staff_modal').modal('hide');
                  dataTable.ajax.reload();
                }
              });
           
          });

          $(document).on('click', '.add', function(){
            $('#staff_modal_title').text('Add Staff');
            $("#section_title").prop("disabled", false);
            $("#staff_semester").prop("disabled", false);
            $("#staff_subject").prop("disabled", false);
            $("#staff_position").prop("disabled", false);
            $("#staff_glvl").prop("disabled", false);

            $('#staff_form')[0].reset();
            $('#staff_modal').modal('show');
            $('#btn_browse_teacher').show();
            $('#submit_input').show();
            $('#submit_input').text('Submit');
            $('#submit_input').val('submit_staff');
            $('#operation').val("submit_staff");
          });

          $(document).on('click', '.view', function(){
            var staff_ID = $(this).attr("id");
            $('#staff_modal_title').text('View Staff');
            $('#staff_modal').modal('show');
            $("#submit_input").hide();
            $('#btn_browse_teacher').hide();
            
             $.ajax({
                url:"datatable/academicstaff/fetch_single.php",
                method:'POST',
                data:{action:"staff_view",staff_ID:staff_ID},
                dataType    :   'json',
                success:function(data)
                {

                $("#section_title").prop("disabled", true);
                $("#staff_semester").prop("disabled", true);
                $("#staff_subject").prop("disabled", true);
                $("#staff_position").prop("disabled", true);
                $("#staff_glvl").prop("disabled", true);

                  $('#staff_name').val(data.staff_name);
                  $('#staff_semester').val(data.sem_ID);
                  $('#staff_subject').val(data.subject_ID).change();
                  $('#staff_position').val(data.pos_ID).change();
                  $('#staff_glvl').val(data.yl_ID).change();
                  

                  $('#submit_input').hide();
                  $('#staff_ID').val(staff_ID);
                  $('#submit_input').text('View');
                  $('#submit_input').val('staff_view');
                  $('#operation').val("staff_view");
                  
                }
              });


            });
          $(document).on('click', '.edit', function(){
            var staff_ID = $(this).attr("id");
            $('#staff_modal_title').text('Edit Staff');
            $('#staff_modal').modal('show');
            $("#submit_input").show();
            $('#btn_browse_teacher').hide();
            
             $.ajax({
                url:"datatable/academicstaff/fetch_single.php",
                method:'POST',
                data:{action:"staff_edit",staff_ID:staff_ID},
                dataType    :   'json',
                success:function(data)
                {

                  
                $("#section_title").prop("disabled", false);
                $("#staff_semester").prop("disabled", false);
                $("#staff_subject").prop("disabled", false);
                $("#staff_position").prop("disabled", false);
                $("#staff_glvl").prop("disabled", false);

                  $('#staff_name').val(data.staff_name);
                  $('#staff_semester').val(data.sem_ID);
                  $('#staff_subject').val(data.subject_ID).change();
                  $('#staff_position').val(data.pos_ID).change();
                  $('#staff_glvl').val(data.yl_ID).change();

                  $('#submit_input').show();
                  $('#staff_ID').val(staff_ID);
                  $('#submit_input').text('Update');
                  $('#submit_input').val('staff_update');
                  $('#operation').val("staff_edit");
                  
                }
              });


            });
            $(document).on('click', '.delete', function(){
            var staff_ID = $(this).attr("id");
             $('#delstaff_modal').modal('show');
             $('.submit').hide();
             
             $('#staff_ID').val(staff_ID);
            });

           


          $(document).on('click', '#staff_delform', function(event){
             var staff_ID =  $('#staff_ID').val();
            $.ajax({
             type        :   'POST',
             url:"datatable/academicstaff/insert.php",
             data        :   {operation:"delete_staff",staff_ID:staff_ID},
             dataType    :   'json',
             complete     :   function(data) {
               $('#delstaff_modal').modal('hide');
               alertify.alert(data.responseText).setHeader('Delete this Staff');
               dataTable.ajax.reload();
               dataTable_product_data.ajax.reload();
                
             }
            })
           
          });
          
          } );


        </script>
        </body>

</html>
