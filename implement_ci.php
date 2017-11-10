<?php 
require_once("db_ci.php");
require_once("user_logic.php");

checkUser();

$ciid = $_SESSION['ciid'] = $_POST['ciid'];
$user = Whois();
$customer_code = $_POST['customer'];
$saving = $_POST['saving'];
$comment = $_POST['comment'];

if(!RepeatedImplementedCIs($db, $ciid, $customer_code)){
if(InsertImplementedCis($db, $ciid, $user, $customer_code, $saving, $comment)){
		$msg_id = $ciid ? $_SESSION["success"] = "CI #".$ciid. " successfully implemented on ".$customer_code." account!" : "";
	header('Location: viewci.php');
}else{
	$_SESSION["danger"] = $_SESSION["danger"] ? $_SESSION["danger"] : "Something went wrong. Please talk to  administrator!";
	header('Location: viewci.php');
    }
}else{
    $_SESSION["danger"] = "This CI is already implemented on ".$customer_code."!";
    header('Location: viewci.php');
}

?>
