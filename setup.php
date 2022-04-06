<?php 
include "Config.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$db = new mysqli(Config::$db["host"], Config::$db["user"], 
				Config::$db["pass"], Config::$db["database"]);

$db->query("drop table if exists scrapbox_users");
$db->query("create table scrapbox_users (
    		id int not null auto_increment,
    		Name text not null,
    		Email text not null,
    		Password text not null,
    		Tags text,
    		Picture text,
    		PhoneNumber text,
    		Memberships text not null,
    		primary key (id)
			);");

$db->query("drop table if exists trending_activities");
$db->query("create table trending_activities (
			id int not null auto_increment,
			Name text not null,
			Address text not null,
			Tags text not null,
			Website text not null,
			Picture text not null,
			primary key (id)
			);");

$db->query("drop table if exists Recommended_Activities");
$db->query("create table Recommended_Activities (
			id int not null auto_increment,
			Name text not null,
			Address text not null,
			Tags text not null,
			Website text not null,
			Picture text not null,
			primary key (id)
			);");


$db->query("drop table if exists All_Table_Info");
$db->query("create table All_Table_Info (
			id int not null auto_increment,
			Name text not null,
			Members text not null,
			Activities text,
			ToDo text,
			primary key (id)
			);");




