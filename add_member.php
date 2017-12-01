<?php 
require_once("db_ci.php");

$teamid = $_POST['teamid'];
$email = $_POST['email'];
$level = $_POST['level'];

echo $teamid."<br>";
echo $email."<br>";
echo $level."<br>";

if($teamid == null){
 $_SESSION["danger"] = "Please select a team first. Check on left panel!";
	header('Location: profile.php');
}elseif(checkRepeatedProfile($db, $teamid, $email)){
    $_SESSION["danger"] = "Member is already part of the team. Please choose another one!";
	header('Location: profile.php');
}elseif(AddProfile($db, $teamid, $email, $level)){
	$_SESSION["success"] = "Member has been successfully added!";
	header('Location: profile.php');
}else{
	$_SESSION["danger"] = $_SESSION["danger"] ? $_SESSION["danger"] : "Member could not be addded. Please check with administrator!";
	header('Location: profile.php');
}
