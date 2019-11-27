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
        <li class="nav-item <?php echo $active_ul_product?>">
          <a class="nav-link" data-toggle="modal" data-target="#mission">Mission</a>
        </li>
        <li class="nav-item <?php echo $active_ul_product?>">
          <a class="nav-link" data-toggle="modal" data-target="#vission">Vission</a>
        </li>
        <li class="nav-item <?php echo $active_ul_product?>">
          <a class="nav-link" data-toggle="modal" data-target="#history">History</a>
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

  <!-- Modal -->
<div class="modal fade" id="vission" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" id="modal_header">
        <h5 class="modal-title" id="ActionModalLabel">Vission</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <p>
           We dream of Filipinos who passionately love their country and whose and competencies enable them to realize their full potential and contribute meaningfully to building the nation. As a learner-centered public institution, the Department of Education continuously improves itself to better serve its stakeholders.
       </p>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
  <!-- Modal -->
<div class="modal fade" id="mission" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" id="modal_header">
        <h5 class="modal-title" id="ActionModalLabel">Mission</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" i>
        <p>
            To protect and promote the right of every Filipino to quality, equitable, culture-based, and complete basic education where:<br>
            <ul class="text-justify">
                <li>Students learn in child-friendly, gender-sensitive safe and motivating environment.</li>
                <li>Teachers facilitate learning and constantly nurture every learner.</li>
                <li>Administrators and staff, as stewards of the institution, ensure an enabling and supportive environment for effective learning to happen.</li>
            </ul>
            Family, community and other Stakeholders are actively engaged and share responsibility for developing life-long learners.
        </p>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
  <!-- Modal -->
<div class="modal fade" id="history" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" id="modal_header">
        <h5 class="modal-title" id="ActionModalLabel">History</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
       <img src="assets/img/background/indang_map.png" class="img-fluid py-2">
                    <p class="tab">Barangay Alulod was established in 1857 by Governadorcillo Don Alejandro de Ocampo. It is located at the northern part of the town of Indang with distance of 1.5 km. The total land area of the barangay was 139 hectares.</p>
                    <p class="tab">The popular name of barrio Alulod was derived from a part of the barrio which formed the junction to a nearby sitios or barrio. Ludlod, the people of the locality termed it. The sitios of the barrio were formerly Patillo, Limbon, and Mataas na Lupa. Due to increase of population, Mataas na Lupa and Limbon became barangays while Patillo remained as a sitio of alulod as of now.</p>
                    <p class="tab">Now, Alulod was divided into six (6) Purok with a total population of 3,587 people and 885 families. So far, it has cemented road, Barangay Hall, Day Care Center, chapels for the Roman Catholic, Praise the Lord and Iglesia ni Cristo. It also has a complete public and private school.</p>
                    <img src="assets/img/background/SLIDE-3.jpg" class="img-fluid py-2">
                    <p class="tab">As early as 1964, a primary school was established. Alulod Primary School with Mrs. Dojinia, as the School Head and offering Grade I-IV classes. It became complete elementary school last 1964. It has a total land area of 7,027 sq.m.</p>
                    <p class="tab">The first School Head was Mrs. Dojinia, she served form 1934-1935. The next was Mr. Memo Jaciel, served as School Head from 1935-1937, followed by Mr. Jose Bernardo, served from 1937-1941. Then Mr. Teddy Arevalo served from 1941-1943, then, followed by Mrs. Anita Lubag and served from 1943-1946, Mr. Feliciano Buhay served from 1946-1947, then, followed by Mrs. Concepcion Mojica, Mrs Teodoro Alano, served as School Head for only a year, 1957. Mrs. Basilisa Liveta served last 1957-1982, then, Mrs. Natalia Destura from 1982-1992, then, Mrs. Pastora M. Tibayan from 1993 to 1998, followed by Mrs. Antonia Arias, served as principal from 1998 to 2003, Mrs. sectionina A. Rosarda served as principal from 2003 to 2005, then followed by Mrs. Lerma Pena, served from 2005 – 2006, followed by DR. Marcos I. Ramos, served from 2006 – 2008, followed by Mrs. Cresencia Mercado from 2008 – 2010. Next to them was Mr. Epifanio A. Deguzman as Principal II from 2010 – 2013, followed by Mrs. Rosena A. Rozul, served from 2013 – August 2018.</p>
                    <p class="tab">At present it is headed by Belen E. Lontoc and has a total enrolment of 478 and 15 teaching force.</p>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>