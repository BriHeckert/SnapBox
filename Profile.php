<html lang="en">
	 <head>
	   <meta charset="utf-8">
	   <meta http-equiv="X-UA-Compatible" content="IE=edge">
	   <meta name="viewport" content="width=device-width, initial-scale=1">
	   <meta name="author" content="Brianna Heckert, Kane Aldrich">
	   <meta name="description" content="login page">
	   <meta name="keywords" content="ScrapBox, ScrapBox login">
	   <link rel="stylesheet" href="main.css">
	   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
	   <link rel="stylesheet/less" type="text/css" href="styles.less" />
	   <title>Profile</title>
	 </head>
	<body style="text-align: center; font-family:FANGSONG; background-color: #3b3b3b;background-repeat:no-repeat; background-size:cover; color: black;">
		<!--Navbar Start -->
<div class="row">
     <div class="col-1 float-left">
       <div class="flex-column bg-dark row justify-content-center customnav">
           <a href="?command=Profile" class="link-dark text-decoration-none text-center" title="" data-bs-toggle="tooltip" data-bs-placement="center" data-bs-original-title="Icon-only"style="color:white">
              Profile
           </a>
         <ul class="nav nav-flush flex-column mb-auto text-center">
           <li class="nav-item">
             <a href="?command=Trending" class="nav-link active border-bottom">
               Home
             </a>
           </li>
         </ul>
         <ul class="nav nav-flush flex-column mb-auto text-center">
            <!--Need to Link to Table Name From All Tables -->
            <?php
              $tableData = $this->db->query("select * from all_table_info");
              foreach($tableData as $row){
                $memberArray = explode(", ", $row["Members"]);
                if(in_array($_SESSION["Name"], $memberArray)){
                  echo "<a href='?command=logout' class='nav-link active border-bottom'>";
                  echo $row["Name"];
                  echo "</a>";
                }
              }

              echo "<li class='nav-item'>";

              echo "</li>";
            ?>

            <li class="nav-item">
             <a href="?command=logout" class="nav-link active border-bottom">
               Log Out
             </a>
           </li>
         </ul>
         <div class="dropdown border-top">
           <a href="#" class="d-flex align-items-center justify-content-center p-3 link-dark text-decoration-none" id="dropdownUser3" data-bs-toggle="dropdown" aria-expanded="false">
             <img src="https://github.com/mdo.png" alt="mdo" width="24" height="24" class="rounded-circle">
           </a>
         </div>
       </div>
     </div>
	   <!--Navbar End -->
		<?php 
		$profileData = $this->db->query("select * from scrapbox_users where Name = ?;", "s", $_SESSION["Name"]);
		echo "
		<section class='vh-100'>
		  <div class='container py-5 h-100'>
		    <div class='row d-flex justify-content-center align-items-center h-100'>
		      <div class='col col-lg-6 mb-4 mb-lg-0'>
		        <div class='card mb-3' style='border-radius: .5rem;''>
		          <div class='row g-0'>
		            <div class='col-md-4 gradient-custom text-center' style='border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;'>
		              <img
		                src='";echo $profileData[0]["Picture"];echo"'
		                alt='Profile Picture'
		                class='img-fluid my-5'
		                style='width: 120px; margin-bottom:0px!important;'
		              />
		              <h5>";echo $_SESSION["Name"]; echo "</h5>
		            </div>
		            <div class='col-md-8'>
		              <div class='card-body p-4'>
		                <h6>Information</h6>
		                <hr class='mt-0 mb-4'>
		                <div class='row pt-1'>
		                  <div class='col-6 mb-3'>
		                    <h6>Email</h6>
		                    <p class='text-muted'>";echo $profileData[0]["Email"]; echo"</p>
		                  </div>
		                  <div class='col-6 mb-3'>
		                    <h6>Phone</h6>
		                    <p>";echo $profileData[0]["PhoneNumber"];echo"</p>
		                  </div>
		                </div>
		                <h6>Your Tags</h6>
		                <hr class='mt-0 mb-4'>
		                <div class='row pt-1'>";
		                $allTags = explode(",", $profileData[0]["Tags"]);
		                if(count($allTags) === 0){
		                	echo "You have no tags";
		                }
		                else{
		                	foreach($allTags as $tag){
		                		echo "
					                <div class='col-6 mb-3'>
					                	<h6>";echo $tag;echo"</h6>
					                </div>";
		                	}
		                }
		                echo "
		                <br>
		                </div>
		                <div class='d-flex justify-content-start'>
		                  <a href='#!''><i class='fab fa-facebook-f fa-lg me-3'></i></a>
		                  <a href='#!''><i class='fab fa-twitter fa-lg me-3'></i></a>
		                  <a href='#!''><i class='fab fa-instagram fa-lg'></i></a>
		                </div>
		              </div>
		            </div>
		          </div>
		        </div>
		      </div>
		    </div>
		  </div>
		</section>
		"
	?>
	</body>
</html>