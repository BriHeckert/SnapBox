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
            case "NewGroupActivityT":
                $this->addGroupActivT();
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
                $_SESSION["Name"] . "'s Group" );

            //Check to make sure Trending and Recommended are populated, if they aren't, give them the defaults
            $trendingData = $this->db->query("select * from Trending_Activities");
            if(count($trendingData) === 0){
                $insert = $this->db->query("insert into trending_activities (Name, Address, Tags, Website, Picture) values (?, ?, ?, ?, ?);", 
                    "sssss", "Humpback Rock Hike", "Milepost 5.8 Blue Ridge Parkway, Lyndhurst, VA 22952", 
                    "Hiking, Outdoors, Nature, Views", "https://www.nps.gov/blri/planyourvisit/humpback-rocks-trails.htm", "Humpback.png");

                $insert = $this->db->query("insert into trending_activities (Name, Address, Tags, Website, Picture) values (?, ?, ?, ?, ?);", 
                    "sssss", "Asados", "1327 W Main St, Charlottesville, VA 22903", 
                    "Bar, Restaurant, Food, Drinking, Nightlife", "https://asadocville.com/", "asados.jpeg");

                $insert = $this->db->query("insert into Recommended_Activities (Name, Address, Tags, Website, Picture) values (?, ?, ?, ?, ?);", 
                    "sssss", "Quirk Hotel", "499 W Main St, Charlottesville, VA 22903", 
                    "Hotel, Bar, Dining, View", 
                    "https://www.quirkhotels.com/?utm_source=google&utm_medium=organic&utm_campaign=business_listing", "quirk.jpg");

                $insert = $this->db->query("insert into Recommended_Activities (Name, Address, Tags, Website, Picture) values (?, ?, ?, ?, ?);", 
                    "sssss", "Asados", "1327 W Main St, Charlottesville, VA 22903", 
                    "Bar, Restaurant, Food, Drinking, Nightlife", "https://asadocville.com/", "asados.jpeg");
            }

            //Create the User's own default table in all tables
            $insert = $this->db->query("insert into all_table_info (Name, Members, Activities, ToDo) values (?,?,?,?);", "ssss", $_SESSION["Name"] . "'s Group", $_SESSION["Name"], "", "");

            //Take the User to the trending page
            header("Location: ?command=Trending");

        }
        include("CreateAccount.php");
    }

    private function trending(){
        include("Trending.php");
    }

    private function profile(){
        include "Profile.php"; 
    }

    private function GoToGroup(){
        include("GroupTemplate.php");
    }

    private function addGroupActivT(){
        
    header("Location: ?command=Trending");
    }
}
?>