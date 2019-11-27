<?php 
include('../session.php');


require_once("../class.user.php");

  
$auth_user = new USER();
// $page_level = 3;
// $auth_user->check_accesslevel($page_level);
$pageTitle = "Manage Principal";
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
        <h1 class="h2"  style="font-size:16px;">Manage Principal Record</h1>
        
      </div>
      <nav aria-label="breadcrumb" >
        <ol class="breadcrumb bcrum">
          <li class="breadcrumb-item "><a href="index" class="bcrum_i_a">Dashboard</a></li>
          <li class="breadcrumb-item  active bcrum_i_ac" aria-current="page">Principal Record Management</li>
        </ol>
      </nav>
      <div class="table-responsive">
          <button type="button" class="btn btn-sm btn-primary add" >
            Add 
          </button>
         <br><br>
        <table class="table table-striped table-sm" id="principal_data">
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
<div class="modal fade" id="principal_modal" tabindex="-1" role="dialog" aria-labelledby="principal_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="principal_modal_title">Add Principal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" id="principal_form" enctype="multipart/form-data">
      <div class="modal-body" id="product_modal_content">
            <div class="form-row">
               
                <div class="form-group col-md-4">
                  <img id="s_img" src="../assets/img/users/default.jpg" alt="Student Image"  runat="server"  height="125" width="125" class="img-thumbnail" style="border:1px solid; border-color: #4caf50; min-width:125px; min-height:125px; max-width:125px; max-height:125px; background-size:cover;"/>
                  <br><br>
                  <input type="file" class="form-control" id="principal_img" name="principal_img" placeholder="" value="" >
                </div>
                <div class="form-group col-md-4">
                  
                </div>
                <div class="form-group col-md-4">
                  <label for="principal_schID">Government ID<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="principal_schID" name="principal_schID" placeholder="" value="" onkeypress="return isNumberKey(event)" maxlength="7" required="">
                </div>
                <div class="form-group col-md-3">
                  <label for="principal_fname">First Name<span class="text-danger">*</span></label>
                  <input type="text" class="uctext  form-control" id="principal_fname" name="principal_fname" placeholder="" value="" required="">
                </div>
                <div class="form-group col-md-3">
                  <label for="principal_mname">Middle Name<span class="text-danger">*</span></label>
                  <input type="text" class="uctext  form-control" id="principal_mname" name="principal_mname" placeholder="" value="" required="">
                </div>
                <div class="form-group col-md-3">
                  <label for="principal_lname">Last Name<span class="text-danger">*</span></label>
                  <input type="text" class="uctext  form-control" id="principal_lname" name="principal_lname" placeholder="" value="" required="">
                </div>
                  <div class="form-group col-md-3">
                  <label for="principal_suffix">Suffix<span class="text-danger">*</span></label>
                  <select class="form-control" id="principal_suffix" name="principal_suffix">
                  <?php 
                   $auth_user->user_suffix_option();
                  ?>
                </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="principal_bday">Birthday<span class="text-danger">*</span></label>
                  <input type="date" class="form-control" id="principal_bday" name="principal_bday" placeholder="" value="" required="">
                </div>
                <div class="form-group col-md-4">
                  <label for="principal_sex">Sex<span class="text-danger">*</span></label>
                  <select class="form-control" id="principal_sex" name="principal_sex" required="">
                  <?php 
                   $auth_user->user_sex_option();
                  ?>
                </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="principal_marital">Marital<span class="text-danger">*</span></label>
                  <select class="form-control" id="principal_marital" name="principal_marital" required="">
                  <?php 
                   $auth_user->user_marital_option();
                  ?>
                </select>
                </div>
                 <div class="form-group col-md-12">
                  <label for="principal_email">Email<span class="text-danger">*</span></label>
                  <input type="email" class="form-control" id="principal_email" name="principal_email" placeholder="" value="" required="">
                </div>
                <div class="form-group col-md-12">
                  <label for="principal_address">Address<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="principal_address" name="principal_address" placeholder="" value="" required="">
                </div>
            
      </div>
      </div>
      <div class="modal-footer">
          <input type="hidden" name="principal_ID" id="principal_ID" />
          <input type="hidden" name="operation" id="operation" />
        <div class="" id='sbtng'>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary submit" id="submit_input" value="submit_principal">Submit</button>
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
          $(document).on('onkeyup change', $("#principal_schID"), function(el) {
         
            pad($(el.target).val(),7,"#principal_schID");
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

          $("#principal_img").change(function() {
           readURL(this);
          });
          $(document).ready(function() {
             
            var principal_dataTable = $('#principal_data').DataTable({
            "processing":true,
            "serverSide":true,
            "ordering":false,
            "ajax":{
              url:"datatable/principal/fetch.php",
              type:"POST"
            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],

          });



          $(document).on('submit', '#principal_form', function(event){
            event.preventDefault();

              $.ajax({
                url:"datatable/principal/insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                  alertify.alert(data).setHeader('Principal Record');
                  $('#principal_form')[0].reset();
                  $('#principal_modal').modal('hide');
                  principal_dataTable.ajax.reload();
                }
              });
           
          });

          $(document).on('click', '.add', function(){
            $('#principal_modal_title').text('Add New Principal');
            $('#principal_modal').modal('show');
            $('#principal_form')[0].reset();

            // var btng = document.getElementById("sbtng");
            // btng.className = btng.className.replace(/\btng_null\b/g, "");
            // btng.classList.add("btn-group");

            $('#s_img').attr('src', "../assets/img/users/default.jpg");
            $("#principal_schID").prop("disabled", false);
            $("#principal_fname").prop("disabled", false);
            $("#principal_mname").prop("disabled", false);
            $("#principal_lname").prop("disabled", false);
            $("#principal_suffix").prop("disabled", false);
            $("#principal_bday").prop("disabled", false);
            $("#principal_sex").prop("disabled", false);
            $("#principal_marital").prop("disabled", false);
            $("#principal_email").prop("disabled", false);
            $("#principal_address").prop("disabled", false);


            $("#principal_img").show();
            $('#submit_input').show();

            $('#submit_input').text('Submit');
            $('#submit_input').val('submit_principal');
            $('#operation').val("submit_principal");
          });

          $(document).on('click', '.view', function(){
            var principal_ID = $(this).attr("id");
            $('#principal_modal_title').text('View Principal');
            $('#principal_modal').modal('show');
            

            $('#submit_input').hide();
            // var btng = document.getElementById("sbtng");
            // btng.className = btng.className.replace(/\bbtn-group\b/g, "");
            // btng.classList.add("btng_null");

                
                $("#principal_img").hide();
                
             $.ajax({
                url:"datatable/principal/fetch_single.php",
                method:'POST',
                data:{action:"principal_view",principal_ID:principal_ID},
                dataType    :   'json',
                success:function(data)
                {
                  $("#principal_schID").prop("disabled", true);
                  $("#principal_fname").prop("disabled", true);
                  $("#principal_mname").prop("disabled", true);
                  $("#principal_lname").prop("disabled", true);
                  $("#principal_suffix").prop("disabled", true);
                  $("#principal_bday").prop("disabled", true);
                  $("#principal_sex").prop("disabled", true);
                  $("#principal_marital").prop("disabled", true);
                  $("#principal_email").prop("disabled", true);
                  $("#principal_address").prop("disabled", true);
                  

                  $('#s_img').attr('src', data.principal_img);
                  $('#principal_schID').val(data.principal_schID);
                  $('#principal_fname').val(data.principal_fname);
                  $('#principal_mname').val(data.principal_mname);
                  $('#principal_lname').val(data.principal_lname);
                  $('#principal_suffix').val(data.principal_suffix).change();
                  $('#principal_bday').val(data.principal_bday);
                  $('#principal_sex').val(data.principal_sex).change();
                  $('#principal_marital').val(data.principal_marital).change();
                  $('#principal_email').val(data.principal_email);
                  $('#principal_address').val(data.principal_address);

                  $('#submit_input').hide();
                  $('#principal_ID').val(principal_ID);
                  $('#submit_input').text('Update');
                  $('#submit_input').val('principal_view');
                  $('#operation').val("principal_view");
                  
                }
              });


            });


            $(document).on('click', '.edit', function(){
            var principal_ID = $(this).attr("id");
            $('#principal_modal_title').text('Edit Principal');
            $('#principal_modal').modal('show');
            

            // var btng = document.getElementById("sbtng");
            // btng.className = btng.className.replace(/\btng_null\b/g, "");
            // btng.classList.add("btn-group");

                
                $("#principal_img").show();
                
             $.ajax({
                url:"datatable/principal/fetch_single.php",
                method:'POST',
                data:{action:"principal_update",principal_ID:principal_ID},
                dataType    :   'json',
                success:function(data)
                {
                  $("#principal_schID").prop("disabled", false);
                  $("#principal_fname").prop("disabled", false);
                  $("#principal_mname").prop("disabled", false);
                  $("#principal_lname").prop("disabled", false);
                  $("#principal_suffix").prop("disabled", false);
                  $("#principal_bday").prop("disabled", false);
                  $("#principal_sex").prop("disabled", false);
                  $("#principal_marital").prop("disabled", false);
                  $("#principal_email").prop("disabled", false);
                  $("#principal_address").prop("disabled", false);
                  

                  $('#s_img').attr('src', data.principal_img);
                  $('#principal_schID').val(data.principal_schID);
                  $('#principal_fname').val(data.principal_fname);
                  $('#principal_mname').val(data.principal_mname);
                  $('#principal_lname').val(data.principal_lname);
                  $('#principal_suffix').val(data.principal_suffix).change();
                  $('#principal_bday').val(data.principal_bday);
                  $('#principal_sex').val(data.principal_sex).change();
                  $('#principal_marital').val(data.principal_marital).change();
                  $('#principal_email').val(data.principal_email);
                  $('#principal_address').val(data.principal_address);

                  $('#submit_input').show();
                  $('#principal_ID').val(principal_ID);
                  $('#submit_input').text('Update');
                  $('#submit_input').val('principal_update');
                  $('#operation').val("principal_update");
                  
                }
              });


            });
   
            $(document).on('click', '.delete', function(){
            var principal_ID = $(this).attr("id");
             $('#delprincipal_modal').modal('show');
             // $('.submit').hide();
             
             $('#principal_ID').val(principal_ID);
            });

           


          $(document).on('click', '#principal_delform', function(event){
             var principal_ID =  $('#principal_ID').val();
            $.ajax({
             type        :   'POST',
             url:"datatable/principal/insert.php",
             data        :   {operation:"delete_principal",principal_ID:principal_ID},
             dataType    :   'json',
             complete     :   function(data) {
               $('#delprincipal_modal').modal('hide');
               alertify.alert(data.responseText).setHeader('Delete this Principal');
               principal_dataTable.ajax.reload();
                
             }
            })
           
          });

          $(document).on('click', '.gen_account', function(event){
             var principal_ID = $(this).attr("id");
             alertify.confirm('Are you sure you want to create this person account?', 
            function(){
              $.ajax({
               type        :   'POST',
               url:"datatable/principal/insert.php",
               data        :   {operation:"gen_account",principal_ID:principal_ID},
               dataType    :   'json',
               complete     :   function(data) {
                 alertify.alert(data.responseText).setHeader('Generated Account');
                 principal_dataTable.ajax.reload();
                  
               }
              })

               principal_dataTable.ajax.reload();
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
