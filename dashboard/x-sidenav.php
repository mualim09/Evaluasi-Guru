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
require_once("../class.user.php");

  
$sidenav = new USER();

?>
<nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <div style="height: 120px;" class="text-center">
           <img id="c_img" src="<?php $sidenav->getUserPic();?>" alt="Profile Image"  runat="server"  height="85" width="85" class="rounded-circle" style="border:1px solid;"/>
           <br>
           <h6><?php $sidenav->getUsername();?></h6>
        </div>
        <ul class="nav flex-column">
          <?php 
          navlist($pagefile_name,"Dashboard","index","home");
          navlist($pagefile_name,"Account","account","users");
          // navlist($pagefile_name,"Savings","harvest","file");
          navlist($pagefile_name,"Schoolyear","service","file");
          navlist($pagefile_name,"Forms","cost","view_list");
           
          ?>
        </ul>
      </div>
    </nav>