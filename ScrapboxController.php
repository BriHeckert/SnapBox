<?php
include "Database.php";
class ScrapboxController{
    //Create Command Variable
    private $command;
    private $db;

    //Set the command for this instance of the controller to be the command passed by index
    public function __construct($command) {
        $this->command = $command;
        $this->db = new Database();
    }

    public function run(){
        switch($this->command){
            case "CreateAccount":
                $this->createAccount();
                break;
            case "AddMember":
                $this->addMember();
                break;
            case "RemoveMember":
                $this->removeMember();
                break;
            case "AddMemberG":
                $this->addMemberG();
                break;
            case "RemoveMemberG":
                $this->removeMemberG();
                break;
            case "AddActivity":
                $this->addActivity();
                break;
            case "RemoveActivity":
                $this->removeActivity();
                break;
            case "NewGroupActivityT":
                $this->addGroupActivT();
                break;
            case "NewGroupActivityR":
                $this->addGroupActivR();
                break;
            case "AddActivityG":
                $this->addActivityG();
                break;
            case "RemoveActivityG":
                $this->removeActivityG();
                break;
            case "GoToGroup":
                $this->GoToGroup();
                break;
            case "Profile":
                $this->profile();
                break;
            case "Trending":
                $this->trending();
                break;
            case "Recommended":
                $this->recommended();
                break;
            case "login":
            default:
                $this->login();
                break;
        }
    }


    //Handles Existing Users Logging In
    private function login() {
        //Check to see if password is in database
        if (isset($_POST["Email"])) {
            $data = $this->db->query("select * from scrapbox_users where Email = ?;", "s", $_POST["Email"]);
            if ($data === false) {
                $error_msg = "Error checking for user";
            } 
            else if (!empty($data)) {
                if (password_verify($_POST["Password"], $data[0]["Password"])) {
                    $_SESSION["Name"] = $_POST["Name"];
                    $_SESSION["Email"] = $_POST["Email"];
                    header("Location: ?command=Trending");
                } 
            } 
        }
        include("loginPage.php");
    }

    //Creates a New Account
    private function createAccount(){
        //If Create Account Submit was Hit
        if(isset($_POST["PhoneNumber"])){
            //Set Session Variables
            $_SESSION["Name"] = $_POST["Name"];
            $_SESSION["Email"] = $_POST["Email"];

            //Add User to Scrapbox_Users
            $insert = $this->db->query("insert into scrapbox_users (Name, Email, PhoneNumber, Password, Picture, Tags, Memberships) values (?, ?, ?, ?, ?,?,?);", "sssssss", $_POST["Name"], $_POST["Email"], $_POST["PhoneNumber"],
                password_hash($_POST["Password"], PASSWORD_DEFAULT), $_POST["ProfilePicture"], $_POST["Tags"], 
                $_SESSION["Name"] . "s Group" );

            //Check to make sure Trending and Recommended are populated, if they aren't, give them the defaults
            $trendingData = $this->db->query("select * from Trending_Activities");
            if(count($trendingData) === 0){
                $insert = $this->db->query("insert into trending_activities (Name, Address, Tags, Website, Picture) values (?, ?, ?, ?, ?);", 
                    "sssss", "Humpback Rock Hike", "Milepost 5.8 Blue Ridge Parkway Lyndhurst VA 22952", 
                    "Hiking Outdoors Nature Views", "https://www.nps.gov/blri/planyourvisit/humpback-rocks-trails.htm", "Humpback2.jpg");

                $insert = $this->db->query("insert into trending_activities (Name, Address, Tags, Website, Picture) values (?, ?, ?, ?, ?);", 
                    "sssss", "Asados", "1327 W Main St Charlottesville VA 22903", 
                    "Bar Restaurant Food Drinking Nightlife", "https://asadocville.com/", "asados.jpeg");

                $insert = $this->db->query("insert into Recommended_Activities (Name, Address, Tags, Website, Picture) values (?, ?, ?, ?, ?);", 
                    "sssss", "Quirk Hotel", "499 W Main St Charlottesville VA 22903", 
                    "Hotel Bar Dining View", 
                    "https://www.quirkhotels.com/?utm_source=google&utm_medium=organic&utm_campaign=business_listing", "quirk.jpg");

                $insert = $this->db->query("insert into Recommended_Activities (Name, Address, Tags, Website, Picture) values (?, ?, ?, ?, ?);", 
                    "sssss", "Asados", "1327 W Main St Charlottesville VA 22903", 
                    "Bar Restaurant Food Drinking Nightlife", "https://asadocville.com/", "asados.jpeg");
            }

            //Create the User's own default table in all tables
            $insert = $this->db->query("insert into all_table_info (Name, Members, Activities, ToDo) values (?,?,?,?);", "ssss", $_SESSION["Name"] . "s Group", $_SESSION["Name"], "", "");

            //Take the User to the trending page
            header("Location: ?command=Trending");

        }
        include("CreateAccount.php");
    }

    private function trending(){
        include("Trending.php");
    }

    private function recommended(){
        include("Recommended.php");
    }

    private function addActivity(){
        include("AddActivity.php");
    }

    private function removeActivity(){
        include("RemoveActivity.php");
    }

    private function addMember(){
        include("AddMember.php");
    }

    private function removeMember(){
        include("RemoveMember.php");
    }

    private function profile(){
        include "Profile.php"; 
    }

    private function GoToGroup(){
        include("GroupTemplate.php");
    }

    private function addGroupActivT(){
        $data = $this->db->query("select * from all_table_info where Name = ?;", "s", $_POST["groupAdded"]);
        print_r($data);
        $curActivities = $data[0]["Activities"];
        echo "<br>" . "Current Activities: " . $curActivities . "<br>";
        $curToDo = $data[0]["ToDo"];
        echo "Current ToDo: " . $curToDo . "<br>";


        if(strlen($curActivities) == 0){
            $Activities = $_POST["ActivityName"] . ", " . $_POST["ActivityAddress"] . ", " . $_POST["ActivityWebsite"] . ", " . 
        $_POST["ActivityTags"] . ", " . $_POST["ActivityPicture"];
        }
        else{
            $Activities = $curActivities . "; " . $_POST["ActivityName"] . ", " . $_POST["ActivityAddress"] . ", " . $_POST["ActivityWebsite"] . ", " . 
        $_POST["ActivityTags"] . ", " . $_POST["ActivityPicture"];
        }
        echo "New Activities: " . $Activities . "<br>";

        if(strlen($curToDo) == 0){
            $ToDo = $_POST["ActivityName"];
        }
        else{
            echo "2";
            $ToDo = $curToDo . ", " . $_POST["ActivityName"];
        }
        echo "New ToDo: " . $ToDo . "<br>";

        $this->db->query("UPDATE `all_table_info` SET `Activities`='{$Activities}',`ToDo`='{$ToDo}'");
        header("Location: ?command=Trending");
    }

    private function addGroupActivR(){
        $data = $this->db->query("select * from all_table_info where Name = ?;", "s", $_POST["groupAdded"]);
        print_r($data);
        $curActivities = $data[0]["Activities"];
        echo "<br>" . "Current Activities: " . $curActivities . "<br>";
        $curToDo = $data[0]["ToDo"];
        echo "Current ToDo: " . $curToDo . "<br>";


        if(strlen($curActivities) == 0){
            $Activities = $_POST["ActivityName"] . ", " . $_POST["ActivityAddress"] . ", " . $_POST["ActivityWebsite"] . ", " . 
        $_POST["ActivityTags"] . ", " . $_POST["ActivityPicture"];
        }
        else{
            $Activities = $curActivities . "; " . $_POST["ActivityName"] . ", " . $_POST["ActivityAddress"] . ", " . $_POST["ActivityWebsite"] . ", " . 
        $_POST["ActivityTags"] . ", " . $_POST["ActivityPicture"];
        }
        echo "New Activities: " . $Activities . "<br>";

        if(strlen($curToDo) == 0){
            $ToDo = $_POST["ActivityName"];
        }
        else{
            echo "2";
            $ToDo = $curToDo . ", " . $_POST["ActivityName"];
        }
        echo "New ToDo: " . $ToDo . "<br>";


        $this->db->query("UPDATE `all_table_info` SET `Activities`='{$Activities}',`ToDo`='{$ToDo}'");
        header("Location: ?command=Recommended");
    }

    private function addActivityG(){
        echo $_POST["groupAdded"];
        $data = $this->db->query("select * from all_table_info where Name = ?;", "s", $_POST["groupAdded"]);
        print_r($data);
        $curActivities = $data[0]["Activities"];
        echo "<br>" . "Current Activities: " . $curActivities . "<br>";
        $curToDo = $data[0]["ToDo"];
        echo "Current ToDo: " . $curToDo . "<br>";


        if(strlen($curActivities) == 0){
            $Activities = $_POST["ActivityName"] . ", " . $_POST["ActivityAddress"] . ", " . $_POST["ActivityWebsite"] . ", " . 
        $_POST["ActivityTags"] . ", " . $_POST["ActivityPicture"];
        }
        else{
            $Activities = $curActivities . "; " . $_POST["ActivityName"] . ", " . $_POST["ActivityAddress"] . ", " . $_POST["ActivityWebsite"] . ", " . 
        $_POST["ActivityTags"] . ", " . $_POST["ActivityPicture"];
        }
        echo "New Activities: " . $Activities . "<br>";

        if(strlen($curToDo) == 0){
            $ToDo = $_POST["ActivityName"];
        }
        else{
            echo "2";
            $ToDo = $curToDo . ", " . $_POST["ActivityName"];
        }
        echo "New ToDo: " . $ToDo . "<br>";


        $this->db->query("UPDATE `all_table_info` SET `Activities`='{$Activities}',`ToDo`='{$ToDo}'");
        header("Location: ?command=GoToGroup");
    }
    private function removeActivityG(){
        $data = $this->db->query("select * from all_table_info where Name = ?;", "s", $_POST["groupAdded"]);
        $nameLength = strlen($_POST["ActivityName"]);
        $dataActivities = $data[0]["Activities"];
        $dataArray = explode("; ", $dataActivities);
        $newDataArray = array();
        foreach($dataArray as $activityEntry){
            if(substr($activityEntry, 0, $nameLength) === $_POST["ActivityName"]){
                $index = array_search($activityEntry, $dataArray);
                unset($dataArray[$index]);
            }
            else{
                $activityEntry = preg_replace("/, /", " ", $activityEntry);
            }
        }
        $newActivityString = implode("; ", $dataArray);


        $Todo = $data[0]["ToDo"];
        $TodoArray = explode(", ", $Todo);
        $index = array_search($_POST["ActivityName"], $TodoArray);
        unset($TodoArray[$index]);
        $newToDo = implode(", ", $TodoArray);
        echo $newToDo;


        $this->db->query("UPDATE `all_table_info` SET `Activities`='{$newActivityString}',`ToDo`='{$newToDo}'");
        header("Location: ?command=GoToGroup");
    }

    private function addMemberG(){
        $data = $this->db->query("select * from all_table_info where Name = ?;", "s", $_POST["groupAdded"]);
        $memberData = $data[0]["Members"];
        $memberData = $memberData . ", " . $_POST["MemberName"];
        $this->db->query("UPDATE `all_table_info` SET `Members`='{$memberData}' where 'Name'='{$_POST['groupAdded']}'");
        header("Location: ?command=GoToGroup");
    }

    private function removeMemberG(){
        $data = $this->db->query("select * from all_table_info where Name = ?;", "s", $_POST["groupAdded"]);
        $memberData = $data[0]["Members"];
        $memberArray = explode(", ", $memberData);
        $index = array_search($_POST["MemberName"], $memberArray);
        unset($memberArray[$index]);
        $newMembers = implode(", ", $memberArray);
        $groupName = $_POST["groupAdded"];
        $this->db->query("UPDATE `all_table_info` SET `Members`='{$newMembers}' where 'Name'='{$groupName}'");
        header("Location: ?command=GoToGroup");
    }
}
?>