<?php
?>
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
   <title>Trending</title>
 </head>
 <body class = "container-fluid">
   <!--SideBar-->
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
                  echo "<a href='?command=GoToGroup' class='nav-link active border-bottom'>";
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
     <!--End SideBar-->

     <!-- Trending and Recommended -->
     <div class="col-10" style="margin-top:10px">
       <div class="row justify-content-center">
         <div class="col-5 text-end">
           <a href="?command=Trending" ><button type="button" class="btn btn-dark TR-Toggle" id="TR-LEFT">Trending</button></a>
         </div>
         <div class="col-5 text-start">
           <a href="?command=Recommended" ><button type="button" class="btn btn-dark TR-Toggle" id="TR-LEFT">Recommended</button></a>
         </div>
       </div>

       <!-- Activities -->
       <?php
       $data = $this->db->query("select * from Trending_Activities;");
       echo "<div class='row justify-content-center p-3'>
              <ul class='col'>";
       foreach($data as $activity){
          echo "<li>
               <div class='row Activity-Entry'>
                 <div class='col-4'>
                   <img class='img-fluid' src='";echo $activity["Picture"];echo "' alt=''>
                 </div>
                 <div class='col-8 Activity-Info' style='color:white;''>
                   <div class='row'>
                     <h3>";echo $activity["Name"];echo"</h3>
                       <p>";echo $activity["Address"];echo"</p>
                       <p>";echo $activity["Tags"];echo"</p>
                     <a href=";echo $activity["Website"];echo">Learn More</a>
                   </div>
                   <div class='row'>
                       <div class='Dropdown p-2'>
                         <button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'>
                             Add To Group
                         </button>
                         <ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'>
                          <form action='?command=NewGroupActivityT' method='post'>
                            <input name = 'UserName' type='hidden' id='UserName' name='UserName' value='" . $_SESSION["Name"] . "'/>
                            <input name = 'ActivityName' type='hidden' id='ActivityName' value='";echo $activity["Name"];echo"'/>
                            <input name = 'ActivityAddress' type='hidden' id='ActivityAddress' value='";echo $activity["Address"];echo"'/>
                            <input name = 'ActivityTags' type='hidden' id='ActivityTags' value='";echo $activity["Tags"];echo"'/>
                            <input name = 'ActivityWebsite' type='hidden' id='ActivityWebsite' value='";echo $activity["Website"];echo"'/>
                            <input name = 'ActivityPicture' type='hidden' id='ActivityPicture' value='";echo $activity["Picture"];echo"'/>";
                            $allGroups = $this->db->query('select * from scrapbox_users where Name = ?;', 's', $_SESSION["Name"]);
                            $allGroups = $allGroups[0]["Memberships"];
                            $groupArray = explode(", ", $allGroups);
                            foreach($groupArray as $groupName){
                              echo " <li><button class='dropdown-item' name='groupAdded' type='submit' value='";echo$groupName;echo"'>Add To ";echo$groupName;echo"</button></li>";
                            }
                            echo "
                          </form>
                         </ul>
                       </div>
                   </form>
                   </div>
                 </div>
               </div>
             </li>";
       }

       ?>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/less@4" ></script>
 </body>