<?php 
require_once("db_idea.php");

if(isset($_SESSION['iid'])){unset($_SESSION['iid']);}
$name = $_POST['title'];

if(AddIdea($db, $name)){
	$iid = getIdeaId($db);
	$_SESSION['iid'] = $iid;
	$msg_id = $iid ? $_SESSION["success"] = "Idea successfully added! Edit your Idea" : "";
	header('Location: editidea.php');
} else {
	$_SESSION["danger"] = $_SESSION["danger"] ? $_SESSION["danger"] : "Idea could not be addded. Please talk to administrator!";
	header('Location: addidea.php');
}
?>