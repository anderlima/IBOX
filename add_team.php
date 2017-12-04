<?php 
require_once("db_user.php");
require_once("user_logic.php");

$name = $_POST['name'];
$description = $_POST['description'];
$category = $_POST['category'];

echo $name."<br>";
echo $description."<br>";
echo $category."<br>";

if(CheckRepeatedTeam($db, $name)){
    $_SESSION["danger"] = "Team already exist. Please choose another name!";
	header('Location: addteam.php');
}elseif(AddTeam($db, $name, $description, $category, Whois())){
	$_SESSION['team'] = getTeamId($db);
	$_SESSION["success"] = "Team has been successfully added and you are the owner!";
	header('Location: profile.php');
} else {
	$_SESSION["danger"] = $_SESSION["danger"] ? $_SESSION["danger"] : "Team could not be addded. Please check with administrator!";
	header('Location: addteam.php');
}
