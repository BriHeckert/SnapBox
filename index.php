<?php
session_start();
include "ScrapboxController.php"; 
//Determines what the user is trying to do, defaults to log in

$command = "login";
if (isset($_GET["command"]))
    $command = $_GET["command"];

//Handles the case of a user trying to see a page besides log in without being logged in
if (!isset($_SESSION["Email"]) && $command != "CreateAccount") {
    // Needs to go to log in page
    $command = "login";
}

//Runs our controller with the given command to show the user something
$Controller = new ScrapboxController($command);
$Controller->run();
?>