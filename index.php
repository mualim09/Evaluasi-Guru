<?php 
session_start();
require_once("class.user.php");
$auth_user = new USER();

//if user's logged in redirect to dashboard
if ($auth_user->is_loggedin() !="") {

   $auth_user->redirect_dashboard();
}
?>
<!doctype html>
<html lang="en">
<?php 
  include ('x-head.php')
?>
  <body>
     <?php 
 include('x-header.php');
 ?>


  <div class="container">
    <div class="row">

      <div class="col-sm-9 col-md-7 col-lg-6 mx-auto">
        <div class="text-center msg text-white">
            <img src="assets/img/logo/alulod_logo.png" alt="School Logo" style="width: 150px;">
            <h2>Alulod Elementary School</h2>
            <h5>Teachers Evaluation System</h5>    
        </div>
      </div>
    </div>
  </div>

</body>
<?php 
include('x-script.php');
?>
<!-- LOGIN MODAL -->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  " role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: 0px ;">
        <h5 class="modal-title" id="exampleModalLabel">Sign In</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body" style="background-color: #f5f5f5; border-radius: 0px 0px 5px 5px; ">
          <div class="text-center msg">
               <img src="assets/img/logo/alulod_logo.png" alt="HyperXService Logo" style="width: 100px;">
             
                <h5>Teachers Evaluation System</h5>   
              
              <small>Enter your username and password</small>
          </div>  

          <form class="form-signin" id="login_form" method="POST">
          <div class="form-label-group">
            <input type="text" id="inputUsername" class="form-control" placeholder="Username" name="login_user" required autofocus>
            <label for="inputUsername">Username</label>
          </div>

          <div class="form-label-group">
            <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="login_password" required>
            <label for="inputPassword">Password</label>
          </div>

          <div class="checkbox mb-3">
            <label>
              <input type="checkbox" value="remember-me" onclick="viewPassword()"> Show Password
            </label>
          </div>

          <input type="hidden" name="operation" value="submit_login">
          <button class="btn btn-primary btn-block" type="submit" style="background-color: #1d8f1d" name="submit_login">Sign in</button>
         
            </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
/**
 function pad(num, size,id){ 
         
            var newval = ('000000000' + num).substr(-size); 
            $(id).val(newval);
          }
$(document).on('onkeyup change', $("#inputUsername"), function(el) {
         
            pad($(el.target).val(),7,"#inputUsername");
          });
**/
 function viewPassword() {
            var x = document.getElementById("inputPassword");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
   $(document).on('submit', '#login_form', function(event){
            event.preventDefault();

              $.ajax({
                url:"data-login.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                type:  'html',
                success:function(data)
                {
                  var newdata = JSON.parse(data);
                  if (newdata.success) {
                      alertify.alert(newdata.success).setHeader('Login Success');
                     window.location.assign("dashboard/");
                  }
                  else{
                    alertify.alert(newdata.error).setHeader('Error Login');
                  }
                }
              });
           
          });

</script>
</html>
