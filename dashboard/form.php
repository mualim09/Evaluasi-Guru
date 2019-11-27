<?php 
include('../session.php');


require_once("../class.user.php");

  
$auth_user = new USER();
// $page_level = 3;
// $auth_user->check_accesslevel($page_level);
$pageTitle = "Manage Evaluation Forms";
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
        <h1 class="h2"  style="font-size:16px;">Manage Evaluation Forms</h1>
        
      </div>
      <nav aria-label="breadcrumb" >
        <ol class="breadcrumb bcrum">
          <li class="breadcrumb-item "><a href="index" class="bcrum_i_a">Dashboard</a></li>
          <li class="breadcrumb-item  active bcrum_i_ac" aria-current="page">Evaluation Forms</li>
        </ol>
      </nav>
      <div class="table-responsive">
          <button type="button" class="btn btn-sm btn-primary add" >
            Add 
          </button>
         <br><br>
        <table class="table table-striped table-sm" id="form_data">
          <thead>
            <tr>
              <th>#</th>
              <th>Form Name</th>
              <th>School Year</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            
     
          </tbody>
        </table>


<!--modal student -->
<div class="modal fade" id="form_modal" tabindex="-1" role="dialog" aria-labelledby="form_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="form_modal_title">Add Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" id="modified_form" enctype="multipart/form-data">
      <div class="modal-body" id="product_modal_content">

      <div class="form-row">
        <div class="form-group col-md-12">
           <label for="form_Name">Name<span class="text-danger">*</span></label>
           <input type="text" class="form-control" id="form_Name" name="form_Name" placeholder="" value="" required="">
        </div>
        <!-- <div class="form-group col-md-12">
           <label for="form_Desc">Instruction <i>(HTML Format Supported)</i></label>
           <textarea  class="form-control" id="form_Desc" name="form_Desc" placeholder="" value="" style="min-height:250px;"></textarea>
        </div> -->
         <?php $auth_user->ref_semester1("form_SY");?>
      </div>
      </div>
      <div class="modal-footer">
          <input type="hidden" name="form_ID" id="form_ID" />
          <input type="hidden" name="operation" id="operation" />
        <div class="" id='sbtng'>
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-outline-primary submit" id="submit_input" value="submit_form">Submit</button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
<!--/modal student -->

<!-- Modal -->
<div class="modal fade" id="view_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formcontent_modal_title">View Rating Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="form_instruction"></div>
         <div class="table-responsive">
            <button type="button" class="btn btn-sm btn-primary add_frc" >
              Add 
            </button>
           <br><br>
          <table class="table table-striped table-sm" id="formcontent_data">
            <thead>
              <tr>
                <th>#</th>
                <th>Rating</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              
       
            </tbody>
          </table>
        </div>

      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="formrating" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Form Rating</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form method="post" id="modified_formcontent" enctype="multipart/form-data">
        
      <div class="modal-body">
        <div class="form-row">
        <div class="form-group col-md-12">
           <label for="rform_Name">Description<span class="text-danger">*</span></label>
           
           <textarea class="form-control" id="rform_Name" name="rform_Name" placeholder="" value="" required=""></textarea>
        </div>
        
      </div>
      </div>
      <div class="modal-footer">
          <input type="hidden" name="form_ID" id="xform_ID" />
          <input type="hidden" name="fc_ID" id="xfc_ID" />
          <input type="hidden" name="operation" id="zoperation" value="submit_formcontent"/>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-outline-primary submit" id="submit_inputz" value="submit_formcontent">Submit</button>
      </div>
      </form>
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
             
            var form_dataTable = $('#form_data').DataTable({
            "processing":true,
            "serverSide":true,
            "ordering":false,
            "ajax":{
              url:"datatable/form/fetch.php",
              type:"POST"
            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],

          });
            function form_content(form_ID){
                 var formcontent_dataTable = $('#formcontent_data').DataTable({
                "processing":true,
                "serverSide":true,
                "ordering":false,
                "bAutoWidth": false,
                "searching": false,
              "paging":     false,
                "ajax":{
                  url:"datatable/form/fetch_content.php?form_ID="+form_ID,
                  type:"POST"
                },
                "columnDefs":[
                  {
                    "targets":[0],
                    "orderable":false,
                  },
                ],

              });

            }
            
            



          $(document).on('submit', '#modified_form', function(event){
            event.preventDefault();

              $.ajax({
                url:"datatable/form/insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                  alertify.alert(data).setHeader('Evaluation Forms');
                  $('#modified_form')[0].reset();
                  $('#form_modal').modal('hide');
                  formcontent_dataTable.ajax.reload();
                }
              });
           
          });

          $(document).on('submit', '#modified_formcontent', function(event){
            event.preventDefault();
              var xform_ID = $('#xform_ID').val();
              $.ajax({
                url:"datatable/form/insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                  alertify.alert(data).setHeader('Evaluation Forms');
                  $('#modified_formcontent')[0].reset();
                  $('#formrating').modal('hide');
                  
                  form_content(xform_ID);
                  $('#formcontent_data').DataTable().destroy();
                }
              });
           
          });

          

          $(document).on('click', '.add', function(){
            $('#form_modal_title').text('Add New Evaluation Form');
            $('#form_modal').modal('show');
            $('#modified_form')[0].reset();

            $("#form_Name").prop("disabled", false);
            // $("#form_Desc").prop("disabled", false);


           
            $('#submit_input').show();

            $('#submit_input').text('Submit');
            $('#submit_input').val('submit_form');
            $('#operation').val("submit_form");
          });

          $(document).on('click', '.view', function(){
            var form_ID = $(this).attr("id");
            $('#form_modal_title').text('View Evaluation Form');
            $('#form_modal').modal('show');
            

            $('#submit_input').hide();

                
        
                
             $.ajax({
                url:"datatable/form/fetch_single.php",
                method:'POST',
                data:{action:"form_view",form_ID:form_ID},
                dataType    :   'json',
                success:function(data)
                {
                 
                  $("#form_Name").prop("disabled", true);
                  // $("#form_Desc").prop("disabled", true);
                  

                  $('#form_Name').val(data.form_Name);
                  // $('#form_Desc').val(data.form_Desc);

                  $('#submit_input').hide();
                  $('#form_ID').val(form_ID);
                  $('#submit_input').text('Update');
                  $('#submit_input').val('form_view');
                  $('#operation').val("form_view");
                  
                }
              });


            });


            $(document).on('click', '.edit', function(){
            var form_ID = $(this).attr("id");
            $('#form_modal_title').text('Edit Evaluation Form');
            $('#form_modal').modal('show');
            

         
                
             $.ajax({
                url:"datatable/form/fetch_single.php",
                method:'POST',
                data:{action:"form_update",form_ID:form_ID},
                dataType    :   'json',
                success:function(data)
                {
                  $("#form_Name").prop("disabled", false);
                  // $("#form_Desc").prop("disabled", false);
                  

                  $('#form_Name').val(data.form_Name);
                  // $('#form_Desc').val(data.form_Desc);

                  $('#submit_input').show();
                  $('#form_ID').val(form_ID);
                  $('#submit_input').text('Update');
                  $('#submit_input').val('form_update');
                  $('#operation').val("form_update");
                  
                }
              });


            });
   
            $(document).on('click', '.delete', function(){
            var form_ID = $(this).attr("id");
             $('#delform_modal').modal('show');
             // $('.submit').hide();
             
             $('#form_ID').val(form_ID);
            });

           


          $(document).on('click', '#form_delform', function(event){
             var form_ID =  $('#form_ID').val();
            $.ajax({
             type        :   'POST',
             url:"datatable/form/insert.php",
             data        :   {operation:"delete_form",form_ID:form_ID},
             dataType    :   'json',
             complete     :   function(data) {
               $('#delform_modal').modal('hide');
               alertify.alert(data.responseText).setHeader('Delete this Evaluation Form');
               form_dataTable.ajax.reload();
                
             }
            })
           
          });
         $(document).on('click', '.view_form', function(event){
          var form_ID =  $(this).attr("id");
          	$('#view_form').modal('show');
              $.ajax({
                url:"datatable/form/fetch_single.php",
                method:'POST',
                data:{action:"form_view",form_ID:form_ID},
                dataType    :   'json',
                success:function(data)
                {
                  $("#form_Name").prop("disabled", false);
                  // $("#form_Desc").prop("disabled", false);
                  
                  $('#form_ID').val(form_ID);
                  $('#formcontent_modal_title').html("VIEW "+data.form_Name);
                  // $('#form_instruction').html(data.form_Desc);
                  form_content(form_ID);
                  $('#formcontent_data').DataTable().destroy();
                  
                }
              });
          });

           $(document).on('click', '.add_frc', function(event){
            
            $('#formrating').modal('show');
            var form_ID = $('#form_ID').val();
            

            $('#zoperation').val("submit_formcontent");
            $('#submit_inputz').text("Submit");
            $('#xform_ID').val(form_ID);
            
            });


           $(document).on('click', '.frc_edit', function(event){
            var form_ID = $(this).attr("data-id");
            var fc_ID = $(this).attr("id");
            $('#formrating').modal('show');

            $('#xform_ID').val(form_ID);

              $.ajax({
                url:"datatable/form/fetch_single.php",
                method:'POST',
                data:{action:"formcontent_view",fc_ID:fc_ID},
                dataType    :   'json',
                success:function(data)
                {
                  $('#rform_Name').val(data.rform_Name);
                  $('#xfc_ID').val(fc_ID);

                  $('#zoperation').val("update_formcontent");
                  $('#submit_inputz').text("Update");
                  
                }
              });
            
            });

          $(document).on('click', '.frc_delete', function(event){
             var form_ID = $(this).attr("data-id");
                 var fc_ID = $(this).attr("id");
                 alertify.confirm('Are you sure you want to delete this rating?', 
                function(){
                  $.ajax({
                   type        :   'POST',
                   url:"datatable/form/insert.php",
                   data        :   {operation:"delete_formcontent",fc_ID:fc_ID},
                   dataType    :   'json',
                   complete     :   function(data) {
                     alertify.alert(data.responseText).setHeader('Form Rating');
                      form_content(form_ID);
                      $('#formcontent_data').DataTable().destroy();
                      
                   }
                  })

                   alertify.success('Ok') 
                 },
                function(){ 
                  alertify.error('Cancel')
                }).setHeader('Form Rating');
               
              });
         

        

           
         

   
          
          } );


        </script>
        </body>

</html>
