<?php 
echo $current_url = $_SERVER['REQUEST_URI'];
$url_explde = explode('/', $current_url);
$pagefile_name = $url_explde[3];

function navlist($pagefile_name,$name,$link,$icon){
 
  if ($pagefile_name == $link) {
    $active_ul_snav = "active";
    $active_ul_snav_span = '<span class="sr-only">(current)</span>';
    
  }
  else{
     $active_ul_snav = '';
      $active_ul_snav_span = '';
  }
  ?>
   <li class="nav-item">
            <a class="nav-link <?php echo $active_ul_snav;?>" href="<?php echo $link;?>">
              <span data-feather="<?php echo $icon;?>"></span>
              <?php echo $name.' '.$active_ul_snav_span; ?>
            </a>
          </li>
  <?php
}


?>
<style>
  .nav-link{
      color:white !important; 
  }
  svg {
    color:white !important; 
  }
  .nav-link:hover{
    background-color:#272b30;
  }


    ul ul a {
       
        padding-left: 50px !important;
     
    }
    ul ul a:hover {
        background: #eee;
        padding-left: 50px !important;
     
    }
    </style>
<nav class="col-md-2 d-none d-md-block bg-light sidebar" style="background: #6c757d !important;
        background: -webkit-linear-gradient(to right, #b4b4b4, #f0f0f0)  !important;
        /*background: linear-gradient(to right, #b4b4b4, #f0f0f0)  !important;  */
        color: black" >
      <div class="sidebar-sticky" style="overflow-x: hidden;
    overflow-y: auto;">
        <div style="height: 130px;" class="text-center">
           <img id="c_img" src="<?php $auth_user->getUserPic();?>" alt="Profile Image"  runat="server"  height="85" width="85" class="rounded-circle" style="border:1px solid;"/>
           <br>
           <h6 style=" color:white;"><?php $auth_user->getSidenavUserInfo();?></h6>
        </div>

        <ul class="nav flex-column">
             <div style="background: #383d41;
    font-size: 12px;
    font-weight: 600;
    padding: 8px 16px; color:white;">MAIN NAVIGATION</div>

          <?php 
          
          navlist($pagefile_name,"Dashboard","index",'home');
          if($auth_user->admin_level()) { 
          navlist($pagefile_name,"Account Management","account","users");
          navlist($pagefile_name,"Academic Staff","staff","users");
          navlist($pagefile_name,"Admin Management","admin","users");
          navlist($pagefile_name,"Principal Management","principal","users");
          navlist($pagefile_name,"Teacher Management","teacher","users");
          navlist($pagefile_name,"Visitor Management","visitor","users");
          // navlist($pagefile_name,"Schoolyear","schoolyear","clipboard");
          navlist($pagefile_name,"Forms","form","file");
          // navlist($pagefile_name,"Subject List","schoolyear","database");
          // navlist($pagefile_name,"Year Level","schoolyear","clipboard");
          // navlist($pagefile_name,"Grade Level ","schoolyear","clipboard");
          ?>
          <li class="nav-item">
            <a class="nav-link " data-toggle="modal" data-target="#database_modal">
              <span data-feather="database"></span>
              Database
            </a>
          </li>
        </ul>
        <?php } ?>
        <!-- <div class="text-center">Alulod Teacher Evaluation System</div> -->
        
      </div>

    </nav>
