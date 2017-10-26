<?php 
require_once("db_ci.php");

if(isset($_SESSION['ciid'])){unset($_SESSION['ciid']);}
$name = $_POST['title'];

if(AddCi($db, $name)){
	$ciid = getCiId($db);
	$_SESSION['ciid'] = $ciid;
	$msg_id = $ciid ? $_SESSION["success"] = "CI successfully added! Edit your CI" : "";
	header('Location: editci.php');
} else {
	$_SESSION["danger"] = $_SESSION["danger"] ? $_SESSION["danger"] : "CI could not be addded. Please talk to administrator!";
	header('Location: addci.php');
}
?>