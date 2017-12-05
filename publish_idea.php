<?php 
require_once("db_idea.php");
require_once("user_logic.php");

checkUser();

$_SESSION['iid'] = $_POST['iid'];

$idea = getInfoReg($db, $_POST['iid'], 'ideas');
if($idea['status'] == 'published'){
	$_SESSION["danger"] = "This Idea is already published";
	header('Location: viewidea.php');
}else{
if(setPublished($db, $_POST['iid'])){
	$_SESSION["success"] = "This Idea was successfully set to Published!";
	$emailmessage = sendEmail($db, $idea['id'], $idea['name'], 'published', 'Idea');
    $_SESSION["success"] = $_SESSION["success"]." ".$emailmessage;
	header('Location: viewidea.php');
}else{
	$_SESSION["danger"] = $_SESSION["danger"] ? $_SESSION["danger"] : "Idea could not be published. Please talk to administrator!";
	header('Location: viewidea.php');
}
}

 ?>
