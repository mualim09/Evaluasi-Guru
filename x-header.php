<?php 
require_once("class.user.php");

  
$header = new USER();
?>
<header class=" fixed-bottom ">
  <nav class="navbar navbar-expand-md navbar-light bg-light ">
    <a class="navbar-brand" href="index"><img src="assets/img/logo/alulod_logo.png" width="20%" style="max-width:80px; margin-top: -7px; padding: 0px;"> Alulod-TES</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
       <ul class="navbar-nav mr-auto">
        <li class="nav-item <?php echo $active_ul_product?>">
          <a class="nav-link" data-toggle="modal" data-target="#overview">Overview</a>
        </li>
      </ul>
      <?php 
        if ($header->is_loggedin() !="") {

           
        }
        else{
          ?>
          <div class="btn-group">
          <a class="btn btn-primary  my-2 my-sm-0 text-white btn-sm"  data-toggle="modal" data-target="#login"><i class="fas fa-person"></i> Sign In</a>
        </div>
          <?php
        }
      ?>
      	
    </div>

  </nav>
  	<div class="w-100 bg-dark text-center">
  		<center class="text-white">
          ALULOD - TEACHERS EVALUATION SYSTEM<br>
All Rights Reserved<br>Copyright &copy; 2019 <?php 
												if (date('Y') !== "2019") 
												{
													echo " - " . date('Y');
												}
												else 
												{
												
												}
											?>
      </center>
  	</div>
</header>