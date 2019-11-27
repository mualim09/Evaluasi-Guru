 <nav class="navbar  navbar-expand-lg  navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow" >
     <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Alulod - TES <img src="../assets/img/logo/alulod_logo.png" alt="Alulod Logo" style="width: 30px; margin-left: 5px;"></a>

    <ul class="navbar-nav px-3 ml-auto">
      <?php    if($auth_user->admin_level()) { }
      else{
        ?>
         <li class="nav-item  dropdown" id="drophover">
        <a class="nav-link " href="index?page=mv" id="navbarDropdown" role="button" >
          Mission & Vision
        </a>
       </li>
        <?php
      }?>
      
       <li class="nav-item  dropdown" id="drophover">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php $auth_user->getUsername();?>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" >
          <a class="dropdown-item" href="profile">Profile</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="../logout?logout=true">Log Out</a>
        </div>
      </li>
    </ul>
    
  </nav>


