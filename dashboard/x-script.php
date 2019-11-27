<!-- Modal -->
<div class="modal fade" id="database_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Backup And Restore Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <section class="row text-center">
                        <section class="col-md-6">
                            <a href="action/database.php?action=export" target="_BLANK"><img src="../assets/img/Icons/download_data.png" class="zoom" alt="Export logo" style="cursor: pointer;"></a><br>
                            <label class="lead mt-2">Export Database</label>
                        </section>
                        <section class="col-md-6">
                            <form action=""  id="import_db" method="post" enctype="multipart/form-data">
                                <section class="image-upload">
                                    <label for="file-input">
                                        <img src="../assets/img/Icons/upload_data.png" class="zoom" alt="Import logo" style="cursor: pointer;">
                                    </label>
                                    <input type="file" class="form-control" name="db_file" id="file-input" accept=".sql" required="true">
                                </section>
                                <button type="submit" name="restore_btn" class="btn btn-primary">Import Database</button>
                            </form>
                        </section>
                    </section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="../assets/js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="../assets/js/jquery-slim.min.js"><\/script>')</script>

      <script src="../assets/js/jquery-3.3.1.min.js" ></script>
      <script src="../assets/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
        <script src="../assets/js/feather.min.js"></script>
        <script src="../assets/js/dashboard.js"></script>
        <script type="text/javascript" src="../assets/plugins/datatables/datatables.min.js"></script>
        <script src="../assets/plugins/alertifyjs/alertify.min.js"></script>
   
   <script type="text/javascript">
     	function isNumberKey(evt)
          {
             var charCode = (evt.which) ? evt.which : event.keyCode
             if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
     
             return true;
          }
          function pad(num, size,id){ 
         
            var newval = ('000000000' + num).substr(-size); 
            $(id).val(newval);
          }

        


          $(document).on('submit', '#import_db', function(event){
            event.preventDefault();

              $.ajax({
                url:"action/database.php?action=import",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                type:  'json',
                success:function(data)
                {
                  var newdata = JSON.parse(data);
                  if (newdata.success) {
                      alertify.alert(newdata.success).setHeader('Success Import');
                     
                  }
                  else{
                    alertify.alert(newdata.error).setHeader('Error Import');
                  }
                }
              });
           
          });
     </script>
     $output["msg"]