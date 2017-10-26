<?php 
require_once("db_idea.php");

if(isset($_SESSION['iid'])){unset($_SESSION['iid']);}
$status = isset($_POST['review']) ? 'review' : 'draft';
$iid = $_SESSION['iid'] = $_POST['iid'];
$name = $_SESSION['title'] = $_POST['title'];
$team = $_SESSION['team'] = $_POST['team'];
$idea = $_SESSION['idea'] = $_POST['idea'];
echo $iid;


if(EditIdea($db, $iid, $name, $idea, $team, $status)){
		if($status == 'review'){
		$msg_id = $iid ? $_SESSION["success"] = "Your Idea #".$iid. " was successfully submitted for review!" : "";
		}else{
		$msg_id = $iid ? $_SESSION["success"] = "Your Idea #".$iid. " is saved as draft!" : "";
		}
	if($status == 'review'){
    $emailmessage = sendEmail($iid, $name, $status, 'Idea');
    $_SESSION["success"] = $_SESSION["success"]." ".$emailmessage;
}
	header('Location: viewidea.php');
} else {
	$_SESSION["danger"] = $_SESSION["danger"] ? $_SESSION["danger"] : "Idea could not be addded. Please talk to administrator!";
	header('Location: editidea.php');
}