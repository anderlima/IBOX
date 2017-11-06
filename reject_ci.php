<?php 
require_once("db_ci.php");

echo $_POST['justification'];
$ci = getInfoReg($db, $_POST['ciid'], 'cis');
if($ci['status'] == 'rejected'){
	$_SESSION["danger"] = "This CI is already rejected";
	header('Location: viewci.php');
}else{
if(setRejected($db, $_POST['ciid'], $_POST['justification'])){
	$_SESSION["success"] = "This CI was successfully set to Rejected!";
    $emailmessage = sendEmail($db, $ci['id'], $ci['name'], 'rejected', 'CI');
    $_SESSION["success"] = $_SESSION["success"]." ".$emailmessage;
	header('Location: viewci.php');
}else{
	$_SESSION["danger"] = $_SESSION["danger"] ? $_SESSION["danger"] : "CI could not be rejected. Please talk to administrator!";
	header('Location: viewci.php');
}
}

 ?>