<?php
$groupData = $this->db->query('select * from scrapbox_users where Name = ?;', 's', $_SESSION['Name']);
$groupData = $groupData[0];
$groupsToCreate = explode(", ", $groupData["Memberships"]);
foreach($groupsToCreate as $groupName){
  echo"
   <html lang='en'>
   <head>
     <meta charset='utf-8'>
     <meta http-equiv='X-UA-Compatible' content='IE=edge'>
     <meta name='viewport' content='width=device-width, initial-scale=1'>
     <meta name='author' content='Brianna Heckert, Kane Aldrich'>
     <meta name='description' content='login page'>
     <meta name='keywords' content='ScrapBox, ScrapBox login'>
     <link rel='stylesheet' href='main.css'>
     <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU' crossorigin='anonymous'>
     <link rel='stylesheet/less' type='text/css' href='styles.less' />
     <title>GroupPage</title>
   </head>
   <body class = 'container-fluid'>
   ";
     //SideBar
    echo"
    <div class='row'>
        <div class='col-1 float-left'>
          <div class='flex-column bg-dark row justify-content-center customnav'>
           <a href='?command=Profile' class='link-dark text-decoration-none text-center' title='' data-bs-toggle='tooltip' data-bs-placement='center' data-bs-original-title='Icon-only'style='color:white'>
           Profile
           </a>
           <ul class='nav nav-flush flex-column mb-auto text-center'>
             <li class='nav-item'>
               <a href='?command=Trending' class='nav-link active border-bottom'>
                 Home
               </a>
             </li>
           </ul>
           <ul class='nav nav-flush flex-column mb-auto text-center'>";
            echo "'<li class='nav-item'>'";
              echo "<a href='?command=GoToGroup' class='nav-link active border-bottom'>";
                echo $groupName;
              echo"</a>";
            echo "</li>";
            echo "
              <li class='nav-item'>
               <a href='?command=logout' class='nav-link active border-bottom'>
                 Log Out
               </a>
              </li>
            </ul>
           <div class='dropdown border-top'>
             <a href='#' class='d-flex align-items-center justify-content-center p-3 link-dark text-decoration-none' id='dropdownUser3' data-bs-toggle='dropdown' aria-expanded='false'>
               <img src='https://github.com/mdo.png' alt='mdo' width='24' height='24' class='rounded-circle'>
             </a>
           </div>
          </div>
        </div>
       ";
       //End SideBar
  echo "
     <!--First Row (Pictures)-->
       <div class='col-10 p-3'>
           <h1 class='text-start'>";echo $groupName; echo "</h1>
           <div class='row Activity-Entry'>
             <div class='col'>
                 <div id='carouselExampleControls' class='carousel slide' data-bs-ride='carousel'>
                   <div class='carousel-inner'>
                     <div class='carousel-item carousel-item1 active'style='height:206px'>
                     </div>
                     <div class='carousel-item carousel-item2'style='height:206px'>
                     </div>
                   </div>
                   <button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleControls' data-bs-slide='prev'>
                     <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                     <span class='visually-hidden'>Previous</span>
                   </button>
                   <button class='carousel-control-next' type='button' data-bs-target='#carouselExampleControls' data-bs-slide='next'>
                     <span class='carousel-control-next-icon' aria-hidden='true'></span>
                     <span class='visually-hidden'>Next</span>
                   </button>
                 </div>
             </div>
           </div>

            <div class='row Activity-Entry'>
              <div class='col-sm-4 col-12'>
                <img src='calendar.png' class='img-fluid' alt='calendar'>
              </div>
             <div class='col-sm-4 col-12 members'>
               <h2>Group Members:</h2>";
               //This is for creating member list
               $MemData = $this->db->query('select * from all_table_info where Name = ?;', 's', $groupName);
               $MemData = $MemData[0];
               $MemberArray = explode(", ", $MemData["Members"]);
               echo "<ul style='color:white'>";
               foreach($MemberArray as $Member){
                echo '<li>';echo $Member;echo'</li>';
               }
               echo '</ul>';
               echo "
               <form action='?command=AddMember' method='post'>
                <button class='btn btn-outline-light btn-lg px-5' id='groupAdded' name='groupAdded' type='submit' style='margin-bottom:10px' value='";echo$groupName;echo"'>Add Member</button>
               </form>
               <form action='?command=RemoveMember' method='post'>
                <button class='btn btn-outline-light btn-lg px-5' id='groupAdded' name='groupAdded' type='submit' style='margin-bottom:10px' value='";echo$groupName;echo"'>Remove Member</button>
               </form>
              </div>
              <div class='col-sm-4 col-12'>
                 <h2>To-Do-List</h2>";
                 //This is for the todo data
                 $ToDoData = $this->db->query('select * from all_table_info where Name=?;', 's', $groupName);
                 $ToDoData = $ToDoData[0]["ToDo"];
                 if(strlen($ToDoData) === 0){
                  echo "Nothing to Do, add an Activity!";
                 }else{
                    $ToDoArray = explode(", ", $ToDoData);
                    echo "<ol style='color:white'>";
                      foreach($ToDoArray as $ToDo){
                        echo '<li>';echo $ToDo;echo'</li>';
                      }
                    echo '</ol>';
                 }
                 echo "
              </div>
            </div>
           ";
           //Activities
             $data = $this->db->query('select * from all_table_info where Name = ?;', 's', $groupName);
             $data = $data[0];
             if(strlen($data["Activities"]) === 0){
                echo "<span style='color:white'>"; echo 'You have no activities, add some from Recommended or Trending!';echo "</span>";
             }
             else{
              $activityData = explode("; ", $data["Activities"]);
              foreach($activityData as $activity){
                $thisActivityData = explode(", ", $activity);
                 echo "<div class='row justify-content-center p-3>
                        <ul class='col'>";
                  echo "<li>
                          <div class='row Activity-Entry'>
                            <div class='col-4'>
                              <img class='img-fluid' src='";echo$thisActivityData[4];echo"' alt=''>
                            </div>
                          <div class='col-8 Activity-Info' style='color:white;>
                            <div class='row'>
                              <h3>";echo $thisActivityData[0];echo"</h3>
                              <p>";echo $thisActivityData[1];echo"</p>
                              <p>";echo $thisActivityData[3];echo"</p>
                              <a href=";echo $thisActivityData[2];echo">Learn More</a>
                            </div>
                          </div>
                        </li>";
               }
             }
        echo "
        <form action='?command=RemoveActivity' method='post'>
        <div style='text-align:center'>";
        echo " <button class='btn btn-outline-light btn-lg px-5' id='groupAdded' name='groupAdded' type='submit' style='margin-bottom:10px' value='";echo$groupName;echo"'>Remove Activity</button>";
        echo "</form><form action='?command=AddActivity' method='post'>";
        echo " <button class='btn btn-outline-light btn-lg px-5' id='groupAdded' name='groupAdded' type='submit' value='";echo$groupName;echo"'>Add Activity</button>";
        echo"</form>

        </div>
     <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js' integrity='sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ' crossorigin='anonymous'></script>
     <script src='https://cdn.jsdelivr.net/npm/less@4'></script>
   </body>
   </html>
   ";
}