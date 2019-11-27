<?php 
include('../session.php');


require_once("../class.user.php");

  
$auth_user = new USER();
// $page_level = 3;
// $auth_user->check_accesslevel($page_level);
$pageTitle = "Manage Visitor";
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
        <h1 class="h2"  style="font-size:16px;">Manage Visitor Record</h1>
        
      </div>
      <nav aria-label="breadcrumb" >
        <ol class="breadcrumb bcrum">
          <li class="breadcrumb-item "><a href="index" class="bcrum_i_a">Dashboard</a></li>
          <li class="breadcrumb-item  active bcrum_i_ac" aria-current="page">Visitor Record Management</li>
        </ol>
      </nav>
      <div class="table-responsive">
          <button type="button" class="btn btn-sm btn-primary add" >
            Add 
          </button>
         <br><br>
        <table class="table table-striped table-sm" id="visitor_data">
          <thead>
            <tr>
              <th>#</th>
              <th>Government ID</th>
              <th>Name</th>
              <th>Sex</th>
              <th>Marital</th>
              <th>Account Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            
     
          </tbody>
        </table>


<!--modal student -->
<div class="modal fade" id="visitor_modal" tabindex="-1" role="dialog" aria-labelledby="visitor_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="visitor_modal_title">Add Visitor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" id="visitor_form" enctype="multipart/form-data">
      <div class="modal-body" id="product_modal_content">
            <div class="form-row">
               
                <div class="form-group col-md-4">
                  <img id="s_img" src="../assets/img/users/default.jpg" alt="Student Image"  runat="server"  height="125" width="125" class="img-thumbnail" style="border:1px solid; border-color: #4caf50; min-width:125px; min-height:125px; max-width:125px; max-height:125px; background-size:cover;"/>
                  <br><br>
                  <input type="file" class="form-control" id="visitor_img" name="visitor_img" placeholder="" value="" >
                </div>
                <div class="form-group col-md-4">
                  
                </div>
                <div class="form-group col-md-4">
                  <label for="visitor_schID">Government ID<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="visitor_schID" name="visitor_schID" placeholder="" value=""  onkeypress="return isNumberKey(event)" maxlength="7" required="">
                </div>
                <div class="form-group col-md-3">
                  <label for="visitor_fname">First Name<span class="text-danger">*</span></label>
                  <input type="text" class="uctext  form-control" id="visitor_fname" name="visitor_fname" placeholder="" value="" required="">
                </div>
                <div class="form-group col-md-3">
                  <label for="visitor_mname">Middle Name<span class="text-danger">*</span></label>
                  <input type="text" class="uctext  form-control" id="visitor_mname" name="visitor_mname" placeholder="" value="" required="">
                </div>
                <div class="form-group col-md-3">
                  <label for="visitor_lname">Last Name<span class="text-danger">*</span></label>
                  <input type="text" class="uctext  form-control" id="visitor_lname" name="visitor_lname" placeholder="" value="" required="">
                </div>
                  <div class="form-group col-md-3">
                  <label for="visitor_suffix">Suffix<span class="text-danger">*</span></label>
                  <select class="form-control" id="visitor_suffix" name="visitor_suffix">
                  <?php 
                   $auth_user->user_suffix_option();
                  ?>
                </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="visitor_bday">Birthday<span class="text-danger">*</span></label>
                  <input type="date" class="form-control" id="visitor_bday" name="visitor_bday" placeholder="" value="" required="">
                </div>
                <div class="form-group col-md-4">
                  <label for="visitor_sex">Sex<span class="text-danger">*</span></label>
                  <select class="form-control" id="visitor_sex" name="visitor_sex" required="">
                  <?php 
                   $auth_user->user_sex_option();
                  ?>
                </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="visitor_marital">Marital<span class="text-danger">*</span></label>
                  <select class="form-control" id="visitor_marital" name="visitor_marital" required="">
                  <?php 
                   $auth_user->user_marital_option();
                  ?>
                </select>
                </div>
                 <div class="form-group col-md-12">
                  <label for="visitor_email">Email<span class="text-danger">*</span></label>
                  <input type="email" class="form-control" id="visitor_email" name="visitor_email" placeholder="" value="" required="">
                </div>
                <div class="form-group col-md-12">
                  <label for="visitor_address">Address<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="visitor_address" name="visitor_address" placeholder="" value="" required="">
                </div>
                   <div class="form-group col-md-12">
                  <label for="staff_position">Position<span class="text-danger">*</span></label>
                  <select class="form-control" id="staff_position" name="staff_position">
                  <?php 
                   $auth_user->ref_position();
                  ?>
                </select>
                </div>
            
      </div>
      </div>
      <div class="modal-footer">
          <input type="hidden" name="visitor_ID" id="visitor_ID" />
          <input type="hidden" name="operation" id="operation" />
        <div class="" id='sbtng'>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary submit" id="submit_input" value="submit_visitor">Submit</button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
<!--/modal student -->




      </div>
    </main>
  </div>
</div>

<?php 
include('x-script.php');
?>
        <script type="text/javascript">
          $(document).on('onkeyup change', $("#visitor_schID"), function(el) {
         
            pad($(el.target).val(),7,"#visitor_schID");
          });
          function readURL(input) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
              $('#s_img').attr('src', e.target.result);
            }
          
            reader.readAsDataURL(input.files[0]);
          }
         }

          $("#visitor_img").change(function() {
           readURL(this);
          });
          $(document).ready(function() {
             
            var visitor_dataTable = $('#visitor_data').DataTable({
            "processing":true,
            "serverSide":true,
            "ordering":false,
            "ajax":{
              url:"datatable/visitor/fetch.php",
              type:"POST"
            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],

          });



          $(document).on('submit', '#visitor_form', function(event){
            event.preventDefault();

              $.ajax({
                url:"datatable/visitor/insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                  alertify.alert(data).setHeader('Visitor Record');
                  $('#visitor_form')[0].reset();
                  $('#visitor_modal').modal('hide');
                  visitor_dataTable.ajax.reload();
                }
              });
           
          });

          $(document).on('click', '.add', function(){
            $('#visitor_modal_title').text('Add New Visitor');
            $('#visitor_modal').modal('show');
            $('#visitor_form')[0].reset();

            // var btng = document.getElementById("sbtng");
            // btng.className = btng.className.replace(/\btng_null\b/g, "");
            // btng.classList.add("btn-group");

            $('#s_img').attr('src', "../assets/img/users/default.jpg");
            $("#visitor_schID").prop("disabled", false);
            $("#visitor_fname").prop("disabled", false);
            $("#visitor_mname").prop("disabled", false);
            $("#visitor_lname").prop("disabled", false);
            $("#visitor_suffix").prop("disabled", false);
            $("#visitor_bday").prop("disabled", false);
            $("#visitor_sex").prop("disabled", false);
            $("#visitor_marital").prop("disabled", false);
            $("#visitor_email").prop("disabled", false);
            $("#visitor_address").prop("disabled", false);


            $("#visitor_img").show();
            $('#submit_input').show();

            $('#submit_input').text('Submit');
            $('#submit_input').val('submit_visitor');
            $('#operation').val("submit_visitor");
          });

          $(document).on('click', '.view', function(){
            var visitor_ID = $(this).attr("id");
            $('#visitor_modal_title').text('View Visitor');
            $('#visitor_modal').modal('show');
            

            $('#submit_input').hide();
            // var btng = document.getElementById("sbtng");
            // btng.className = btng.className.replace(/\bbtn-group\b/g, "");
            // btng.classList.add("btng_null");

                
                $("#visitor_img").hide();
                
             $.ajax({
                url:"datatable/visitor/fetch_single.php",
                method:'POST',
                data:{action:"visitor_view",visitor_ID:visitor_ID},
                dataType    :   'json',
                success:function(data)
                {
                  $("#visitor_schID").prop("disabled", true);
                  $("#visitor_fname").prop("disabled", true);
                  $("#visitor_mname").prop("disabled", true);
                  $("#visitor_lname").prop("disabled", true);
                  $("#visitor_suffix").prop("disabled", true);
                  $("#visitor_bday").prop("disabled", true);
                  $("#visitor_sex").prop("disabled", true);
                  $("#visitor_marital").prop("disabled", true);
                  $("#visitor_email").prop("disabled", true);
                  $("#visitor_address").prop("disabled", true);
                  

                  $('#s_img').attr('src', data.visitor_img);
                  $('#visitor_schID').val(data.visitor_schID);
                  $('#visitor_fname').val(data.visitor_fname);
                  $('#visitor_mname').val(data.visitor_mname);
                  $('#visitor_lname').val(data.visitor_lname);
                  $('#visitor_suffix').val(data.visitor_suffix).change();
                  $('#visitor_bday').val(data.visitor_bday);
                  $('#visitor_sex').val(data.visitor_sex).change();
                  $('#visitor_marital').val(data.visitor_marital).change();
                  $('#visitor_email').val(data.visitor_email);
                  $('#visitor_address').val(data.visitor_address);

                  $('#submit_input').hide();
                  $('#visitor_ID').val(visitor_ID);
                  $('#submit_input').text('Update');
                  $('#submit_input').val('visitor_view');
                  $('#operation').val("visitor_view");
                  
                }
              });


            });


            $(document).on('click', '.edit', function(){
            var visitor_ID = $(this).attr("id");
            $('#visitor_modal_title').text('Edit Visitor');
            $('#visitor_modal').modal('show');
            

            // var btng = document.getElementById("sbtng");
            // btng.className = btng.className.replace(/\btng_null\b/g, "");
            // btng.classList.add("btn-group");

                
                $("#visitor_img").show();
                
             $.ajax({
                url:"datatable/visitor/fetch_single.php",
                method:'POST',
                data:{action:"visitor_update",visitor_ID:visitor_ID},
                dataType    :   'json',
                success:function(data)
                {
                  $("#visitor_schID").prop("disabled", false);
                  $("#visitor_fname").prop("disabled", false);
                  $("#visitor_mname").prop("disabled", false);
                  $("#visitor_lname").prop("disabled", false);
                  $("#visitor_suffix").prop("disabled", false);
                  $("#visitor_bday").prop("disabled", false);
                  $("#visitor_sex").prop("disabled", false);
                  $("#visitor_marital").prop("disabled", false);
                  $("#visitor_email").prop("disabled", false);
                  $("#visitor_address").prop("disabled", false);
                  

                  $('#s_img').attr('src', data.visitor_img);
                  $('#visitor_schID').val(data.visitor_schID);
                  $('#visitor_fname').val(data.visitor_fname);
                  $('#visitor_mname').val(data.visitor_mname);
                  $('#visitor_lname').val(data.visitor_lname);
                  $('#visitor_suffix').val(data.visitor_suffix).change();
                  $('#visitor_bday').val(data.visitor_bday);
                  $('#visitor_sex').val(data.visitor_sex).change();
                  $('#visitor_marital').val(data.visitor_marital).change();
                  $('#visitor_email').val(data.visitor_email);
                  $('#visitor_address').val(data.visitor_address);

                  $('#submit_input').show();
                  $('#visitor_ID').val(visitor_ID);
                  $('#submit_input').text('Update');
                  $('#submit_input').val('visitor_update');
                  $('#operation').val("visitor_update");
                  
                }
              });


            });
   
            $(document).on('click', '.delete', function(){
            var visitor_ID = $(this).attr("id");
             $('#delvisitor_modal').modal('show');
             // $('.submit').hide();
             
             $('#visitor_ID').val(visitor_ID);
            });

           


          $(document).on('click', '#visitor_delform', function(event){
             var visitor_ID =  $('#visitor_ID').val();
            $.ajax({
             type        :   'POST',
             url:"datatable/visitor/insert.php",
             data        :   {operation:"delete_visitor",visitor_ID:visitor_ID},
             dataType    :   'json',
             complete     :   function(data) {
               $('#delvisitor_modal').modal('hide');
               alertify.alert(data.responseText).setHeader('Delete this Visitor');
               visitor_dataTable.ajax.reload();
                
             }
            })
           
          });

          $(document).on('click', '.gen_account', function(event){
             var visitor_ID = $(this).attr("id");
             alertify.confirm('Are you sure you want to create this person account?', 
            function(){
              $.ajax({
               type        :   'POST',
               url:"datatable/visitor/insert.php",
               data        :   {operation:"gen_account",visitor_ID:visitor_ID},
               dataType    :   'json',
               complete     :   function(data) {
                 alertify.alert(data.responseText).setHeader('Generated Account');
                 visitor_dataTable.ajax.reload();
                  
               }
              })

               visitor_dataTable.ajax.reload();
               alertify.success('Ok') 
             },
            function(){ 
              alertify.error('Cancel')
            }).setHeader('Generate Account');
           
          });
          
          } );


        </script>
        </body>

</html>
