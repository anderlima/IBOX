<?php 
require_once("db_user.php");

$profileid = $_POST['profileid'];
$level = $_POST['level'];

$flag = $_POST['alter'] ? 1 : 0;

switch ($flag) {
    case 1:
        if(AlterProfile($db, $profileid, $level)){
	   $_SESSION["success"] = "Member has been successfully altered!";
	   header('Location: profile.php');
        } else {
	   $_SESSION["danger"] = $_SESSION["danger"] ? $_SESSION["danger"] : "Member could not be altered. Please check with administrator!";
	   header('Location: profile.php');
        }  
    break;
    case 0:
        if(RemoveProfile($db, $profileid)){
	   $_SESSION["success"] = "Member has been successfully removed!";
	   header('Location: profile.php');
        } else {
	   $_SESSION["danger"] = $_SESSION["danger"] ? $_SESSION["danger"] : "Member could not be deleted. Please check with administrator!";
	   header('Location: profile.php');
        }  
    break;
    default:
        $cis = $cis;
}

