<?php 
require_once("db_idea.php");

echo $_POST['justification'];
$idea = getInfoReg($db, $_POST['iid'], 'ideas');
if($idea['status'] == 'rejected'){
	$_SESSION["danger"] = "This Idea is already rejected";
	header('Location: viewidea.php');
}else{
if(setRejected($db, $_POST['iid'], $_POST['justification'])){
	$_SESSION["success"] = "This Idea was successfully set to Rejected!";
    $emailmessage = sendEmail($idea['id'], $idea['name'], 'rejected', 'Idea');
    $_SESSION["success"] = $_SESSION["success"]." ".$emailmessage;
	header('Location: viewidea.php');
}else{
	$_SESSION["danger"] = $_SESSION["danger"] ? $_SESSION["danger"] : "Idea could not be rejected. Please talk to administrator!";
	header('Location: viewidea.php');
}
}

 ?>